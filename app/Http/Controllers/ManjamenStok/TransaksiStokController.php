<?php

namespace App\Http\Controllers\ManjamenStok;

use App\Http\Controllers\Controller;
use App\Models\DataMaster\Barang;
use App\Models\DataMaster\Pemasok;
use App\Models\DataMaster\StokTransaksi;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TransaksiStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('home')],
            ['label' => 'Transaksi Stok', 'url' => route('stok.index')],
            ['label' => 'Data Transaksi'],
        ];

        $query = StokTransaksi::with(['barang', 'pemasok', 'user']);

        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        if ($request->filled('tipe_transaksi')) {
            $query->where('tipe_transaksi', $request->tipe_transaksi);
        }

        $transaksis = $query->get();

        $title = "Hapus Data";
        $text = "Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        return view('transaksi-stok.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Data Transaksi Stok',
            'transaksis' => $transaksis,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function formTransaksiStok()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('home')],
            ['label' => 'Transaksi Stok', 'url' => route('stok.index')],
            ['label' => 'Form Transaksi Stok']
        ];

        $barangs = Cache::remember('cached_barangs_transaksi', now()->addSecond(60), function () {
            return Barang::select(['id', 'nama_barang', 'kode_barang'])->get();
        });

        $pemasoks = Cache::remember('cached_pemasoks_transaksi', now()->addSecond(60), function () {
            return Pemasok::select(['id', 'nama_pemasok'])->get();
        });

        return view('transaksi-stok.form-transaksi', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Form Transaksi Stok',
            'kodeTransaksi' => $this->generateTransactionCode(),
            'barangs' => $barangs,
            'pemasoks' => $pemasoks,
        ]);
    }

    protected function generateTransactionCode()
    {
        $lastTransaction = StokTransaksi::orderBy('created_at', 'desc')->first();
        $lastKodeTransaction = $lastTransaction ? $lastTransaction->kode_transaksi : null;

        $prefix = 'TRX';
        $datePart = date('Ymd');

        if ($lastKodeTransaction && strpos($lastKodeTransaction, $prefix . $datePart) === 0) {
            $lastNumber = (int) substr($lastKodeTransaction, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $datePart . $newNumber;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function transactionCreate(Request $request)
    {
        $request->validate([
            'barang' => 'required|exists:tb_barang,id',
            'jenisTransaksi' => 'required|string|in:masuk,keluar',
            'pemasok' => 'nullable|exists:tb_pemasok,id',
            'jumlahBarang' => 'required|numeric|min:1',
        ]);

        StokTransaksi::create([
            'kode_transaksi' => $this->generateTransactionCode(),
            'barang_id' => $request->barang,
            'pemasok_id' => $request->pemasok,
            'user_id' => Auth::user()->id,
            'tipe_transaksi' => $request->jenisTransaksi,
            'jumlah' => $request->jumlahBarang,
            'status_transaksi' => 'Menunggu',
        ]);

        $barang = Barang::find($request->barang);
        $currentStock = $barang->stok_final;
        $incrementStock = $request->jenisTransaksi === 'masuk' ? $request->jumlahBarang : -$request->jumlahBarang;
        $barang->stok_final = $currentStock + $incrementStock;
        $barang->save();

        Notifikasi::create([
            'title' => 'Transaksi ' . ucfirst($request->jenisTransaksi) . ' Baru',
            'message' => 'Transaksi ' . $request->jenisTransaksi . ' untuk barang "' . $barang->nama_barang . '" telah dibuat.',
            'status' => 'Unread',
            'target_role' => 'Owner',
        ]);

        Cache::forget('cached_barangs');
        Cache::forget("barang_edit_{$barang->id}");

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(StokTransaksi $transaksi)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('home')],
            ['label' => 'Transaksi Stok', 'url' => route('stok.index')],
            ['label' => 'Edit Transaksi'],
        ];

        $barangs = Cache::remember('cached_barangs_transaksi', now()->addSecond(60), function () {
            return Barang::select(['id', 'nama_barang', 'kode_barang'])->get();
        });

        $pemasoks = Cache::remember('cached_pemasoks_transaksi', now()->addSecond(60), function () {
            return Pemasok::select(['id', 'nama_pemasok'])->get();
        });

        return view('transaksi-stok.edit', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Edit Transaksi Stok ' . $transaksi->kode_transaksi,
            'transaksi' => $transaksi,
            'barangs' => $barangs,
            'pemasoks' => $pemasoks,
            'barang' => $transaksi->barang,
            'pemasok' => $transaksi->pemasok,
        ]);
    }

    public function update(Request $request, StokTransaksi $transaksi)
    {
        $request->validate([
            'barang' => 'required|exists:tb_barang,id',
            'jenisTransaksi' => 'required|string|in:masuk,keluar',
            'pemasok' => 'nullable|exists:tb_pemasok,id',
            'jumlahBarang' => 'required|numeric|min:1',
        ]);

        $oldBarang = Barang::find($transaksi->barang_id);
        $stokAdjustmentLama = $transaksi->tipe_transaksi === 'masuk' ? -$transaksi->jumlah : $transaksi->jumlah;
        $oldBarang->stok_final += $stokAdjustmentLama;
        $oldBarang->save();
        Cache::forget("barang_edit_{$oldBarang->id}");

        $transaksi->update([
            'barang_id' => $request->barang,
            'pemasok_id' => $request->pemasok,
            'user_id' => Auth::id(),
            'tipe_transaksi' => $request->jenisTransaksi,
            'jumlah' => $request->jumlahBarang,
            'status_transaksi' => 'Menunggu',
        ]);

        $newBarang = Barang::find($request->barang);
        $stokAdjustmentBaru = $request->jenisTransaksi === 'masuk' ? $request->jumlahBarang : -$request->jumlahBarang;
        $newBarang->stok_final += $stokAdjustmentBaru;
        $newBarang->save();

        Cache::forget('cached_barangs');
        Cache::forget("barang_edit_{$newBarang->id}");

        return redirect()->route('stok.index')->with('success', 'Transaksi berhasil diubah.');
    }

    public function konfirmasiStatus(Request $request, StokTransaksi $transaksi)
    {
        $request->validate([
            'status_transaksi' => 'required|in:Disetujui,Menunggu',
        ]);

        $transaksi->update(['status_transaksi' => $request->status_transaksi]);

        Notifikasi::create([
            'title' => 'Status Diperbarui - ' . $transaksi->kode_transaksi,
            'message' => 'Status Transaksi ' . $transaksi->kode_transaksi . ' telah diperbarui menjadi ' . $request->status_transaksi,
            'status' => 'Unread',
            'target_role' => 'Op-Gudang',
        ]);

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function destroy(StokTransaksi $transaksi)
    {
        $barang = Barang::find($transaksi->barang_id);
        $currentStock = $barang->stok_final;
        $incrementStock = $transaksi->tipe_transaksi === 'masuk' ? -$transaksi->jumlah : $transaksi->jumlah;
        $barang->stok_final = $currentStock + $incrementStock;
        $barang->save();

        Cache::forget('cached_barangs');
        Cache::forget("barang_edit_{$barang->id}");

        $transaksi->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
