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
    public function formTransaksiStok(Request $request)
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

        // Ambil data dari session untuk keranjang transaksi
        $cartItems = session('transaction_cart', []);

        // Ambil jenis transaksi dari query parameter
        $jenisTransaksi = $request->query('jenis');

        return view('transaksi-stok.form-transaksi', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Form Transaksi Stok',
            'kodeTransaksi' => $this->generateTransactionCode(),
            'barangs' => $barangs,
            'pemasoks' => $pemasoks,
            'jenisTransaksi' => $jenisTransaksi,
            'cartItems' => $cartItems,
        ]);
    }

    /**
     * Handle pilih jenis transaksi
     */
    public function pilihJenisTransaksi(Request $request)
    {
        $request->validate([
            'jenisTransaksi' => 'required|string|in:masuk,keluar',
        ]);

        // Redirect kembali ke form dengan query parameter jenis transaksi
        return redirect()->route('stok.form', ['jenis' => $request->jenisTransaksi]);
    }

    /**
     * Tambah item ke keranjang transaksi (session)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'barang' => 'required|exists:tb_barang,id',
            'pemasok' => 'nullable|exists:tb_pemasok,id',
            'jumlahBarang' => 'required|numeric|min:1',
        ]);

        $jenisTransaksi = $request->query('jenis');

        if (!in_array($jenisTransaksi, ['masuk', 'keluar'])) {
            return redirect()->back()->withErrors(['error' => 'Jenis transaksi tidak valid']);
        }

        // Validasi pemasok untuk transaksi masuk
        if ($jenisTransaksi === 'masuk' && !$request->pemasok) {
            return redirect()->back()->withErrors(['pemasok' => 'Pemasok wajib dipilih untuk transaksi masuk']);
        }

        $barang = Barang::find($request->barang);
        $pemasok = $request->pemasok ? Pemasok::find($request->pemasok) : null;

        // Validasi stok untuk transaksi keluar
        if ($jenisTransaksi === 'keluar' && $barang->stok_final < $request->jumlahBarang) {
            return redirect()->back()->withErrors(['jumlahBarang' => 'Stok tidak mencukupi. Stok saat ini: ' . $barang->stok_final]);
        }

        // Ambil cart dari session
        $cart = session('transaction_cart', []);

        // Generate unique key untuk item
        $itemKey = $barang->id . '_' . ($pemasok ? $pemasok->id : 'no_supplier');

        // Jika item sudah ada, update jumlahnya
        if (isset($cart[$itemKey])) {
            $newQuantity = $cart[$itemKey]['jumlah'] + $request->jumlahBarang;

            // Validasi stok total untuk transaksi keluar
            if ($jenisTransaksi === 'keluar' && $barang->stok_final < $newQuantity) {
                return redirect()->back()->withErrors(['jumlahBarang' => 'Total jumlah melebihi stok. Stok saat ini: ' . $barang->stok_final . ', sudah di keranjang: ' . $cart[$itemKey]['jumlah']]);
            }

            $cart[$itemKey]['jumlah'] = $newQuantity;
        } else {
            // Tambah item baru ke cart
            $cart[$itemKey] = [
                'barang_id' => $barang->id,
                'barang_kode' => $barang->kode_barang,
                'barang_nama' => $barang->nama_barang,
                'barang_harga' => $barang->harga_jual ?? 0,
                'pemasok_id' => $pemasok ? $pemasok->id : null,
                'pemasok_nama' => $pemasok ? $pemasok->nama_pemasok : null,
                'jumlah' => $request->jumlahBarang,
                'jenis_transaksi' => $jenisTransaksi,
            ];
        }

        // Simpan cart ke session
        session(['transaction_cart' => $cart]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan ke keranjang');
    }

    /**
     * Hapus item dari keranjang
     */
    public function removeFromCart($itemKey)
    {
        $cart = session('transaction_cart', []);

        if (isset($cart[$itemKey])) {
            unset($cart[$itemKey]);
            session(['transaction_cart' => $cart]);
            return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan');
    }

    /**
     * Bersihkan semua keranjang
     */
    public function clearCart()
    {
        session()->forget('transaction_cart');
        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan');
    }

    /**
     * Generate faktur berdasarkan pemasok
     */
    public function generateFaktur(Request $request)
    {
        $request->validate([
            'pemasok_id' => 'required|exists:tb_pemasok,id'
        ]);

        $pemasok = Pemasok::findOrFail($request->pemasok_id);

        // Ambil semua transaksi masuk dari pemasok ini, diurutkan berdasarkan kode transaksi
        $transaksis = StokTransaksi::with(['barang', 'user'])
            ->where('pemasok_id', $request->pemasok_id)
            ->where('tipe_transaksi', 'masuk')
            ->orderBy('kode_transaksi')
            ->get();

        if ($transaksis->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada transaksi masuk untuk pemasok ini');
        }

        // Calculate totals
        $totalItems = $transaksis->count();
        $totalQuantity = $transaksis->sum('jumlah');
        $totalValue = $transaksis->sum(function ($transaksi) {
            return $transaksi->jumlah * ($transaksi->barang->harga_beli ?? 0);
        });

        // Generate nomor faktur
        $nomorFaktur = 'INV-' . strtoupper($pemasok->kode_pemasok ?? 'SUP') . '-' . date('Ymd') . '-' . str_pad($totalItems, 3, '0', STR_PAD_LEFT);

        return view('transaksi-stok.faktur', [
            'pemasok' => $pemasok,
            'transaksis' => $transaksis,
            'nomorFaktur' => $nomorFaktur,
            'totalItems' => $totalItems,
            'totalQuantity' => $totalQuantity,
            'totalValue' => $totalValue,
            'tanggalCetak' => now(),
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
        // Ambil cart dari session
        $cart = session('transaction_cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang transaksi kosong');
        }

        $jenisTransaksi = null;

        // Proses semua item dalam cart
        foreach ($cart as $item) {
            $jenisTransaksi = $item['jenis_transaksi']; // Ambil jenis transaksi dari item pertama

            StokTransaksi::create([
                'kode_transaksi' => $this->generateTransactionCode(),
                'barang_id' => $item['barang_id'],
                'pemasok_id' => $item['pemasok_id'],
                'user_id' => Auth::user()->id,
                'tipe_transaksi' => $item['jenis_transaksi'],
                'jumlah' => $item['jumlah'],
                'status_transaksi' => 'Menunggu',
            ]);

            // Update stok barang
            $barang = Barang::find($item['barang_id']);
            $currentStock = $barang->stok_final;
            $incrementStock = $item['jenis_transaksi'] === 'masuk' ? $item['jumlah'] : -$item['jumlah'];
            $barang->stok_final = $currentStock + $incrementStock;
            $barang->save();

            // Buat notifikasi
            Notifikasi::create([
                'title' => 'Transaksi ' . ucfirst($item['jenis_transaksi']) . ' Baru',
                'message' => 'Transaksi ' . $item['jenis_transaksi'] . ' untuk barang "' . $item['barang_nama'] . '" telah dibuat.',
                'status' => 'Unread',
                'target_role' => 'Owner',
            ]);

            Cache::forget('cached_barangs');
            Cache::forget("barang_edit_{$barang->id}");
        }

        // Hapus cart dari session setelah berhasil
        session()->forget('transaction_cart');

        return redirect()->route('stok.index')->with('success', 'Semua transaksi berhasil ditambahkan.');
    }

    /**
     * Proses simpan semua transaksi dalam keranjang
     */
    public function processTransaction(Request $request)
    {
        return $this->transactionCreate($request);
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
        // Validasi dasar
        $request->validate([
            'barang' => 'required|exists:tb_barang,id',
            'jenisTransaksi' => 'required|string|in:masuk,keluar',
            'pemasok' => 'nullable|exists:tb_pemasok,id',
            'jumlahBarang' => 'required|numeric|min:1',
        ]);

        // Validasi pemasok untuk transaksi masuk
        if ($request->jenisTransaksi === 'masuk' && !$request->pemasok) {
            return redirect()->back()->withErrors(['pemasok' => 'Pemasok wajib dipilih untuk transaksi masuk']);
        }

        // Validasi stok untuk transaksi keluar (jika berbeda barang atau jumlah bertambah)
        $newBarang = Barang::find($request->barang);
        if ($request->jenisTransaksi === 'keluar') {
            // Hitung stok yang akan tersedia setelah rollback transaksi lama
            $currentStock = $newBarang->stok_final;

            // Jika barang sama, tambahkan kembali stok lama
            if ($transaksi->barang_id == $request->barang && $transaksi->tipe_transaksi === 'keluar') {
                $currentStock += $transaksi->jumlah;
            }

            // Cek apakah stok mencukupi untuk jumlah baru
            if ($currentStock < $request->jumlahBarang) {
                return redirect()->back()->withErrors(['jumlahBarang' => 'Stok tidak mencukupi. Stok tersedia: ' . $currentStock]);
            }
        }

        // Rollback stok barang lama
        $oldBarang = Barang::find($transaksi->barang_id);
        $stokAdjustmentLama = $transaksi->tipe_transaksi === 'masuk' ? -$transaksi->jumlah : $transaksi->jumlah;
        $oldBarang->stok_final += $stokAdjustmentLama;
        $oldBarang->save();
        Cache::forget("barang_edit_{$oldBarang->id}");

        // Update transaksi
        $transaksi->update([
            'barang_id' => $request->barang,
            'pemasok_id' => $request->pemasok,
            'user_id' => Auth::id(),
            'tipe_transaksi' => $request->jenisTransaksi,
            'jumlah' => $request->jumlahBarang,
            'status_transaksi' => 'Menunggu', // Reset status ke menunggu setelah edit
        ]);

        // Apply stok barang baru
        $stokAdjustmentBaru = $request->jenisTransaksi === 'masuk' ? $request->jumlahBarang : -$request->jumlahBarang;
        $newBarang->stok_final += $stokAdjustmentBaru;
        $newBarang->save();

        // Buat notifikasi
        Notifikasi::create([
            'title' => 'Transaksi ' . ucfirst($request->jenisTransaksi) . ' Diperbarui',
            'message' => 'Transaksi ' . $transaksi->kode_transaksi . ' untuk barang "' . $newBarang->nama_barang . '" telah diperbarui.',
            'status' => 'Unread',
            'target_role' => 'Owner',
        ]);

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
