<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Models\DataMaster\Barang;
use App\Models\DataMaster\Kategori;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('home')],
            ['label' => 'Data Barang']
        ];

        $barangs = Cache::remember('cached_barangs', now()->addMinutes(30), function () {
            return Barang::with('kategori')->get();
        });

        $title = "Hapus Data";
        $text = "Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        return view('data-master.barang.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Barang',
            'barangs' => $barangs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::where('status', 1)->get();
        $kodeBarang = $this->generateKodeBarang();

        return view('data-master.barang.create', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('home')],
                ['label' => 'Data Barang', 'url' => route('barang.index')],
                ['label' => 'Tambah']
            ],
            'title' => 'Tambah Barang',
            'kategoris' => $kategoris,
            'kodeBarang' => $kodeBarang,
        ]);
    }

    protected function generateKodeBarang()
    {
        $lastBarang = Barang::orderBy('created_at', 'desc')->first();
        $lastKodeBarang = $lastBarang ? $lastBarang->kode_barang : null;

        if ($lastKodeBarang) {
            $lastNumber = (int) substr($lastKodeBarang, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            return 'BRG' . date('Ymd') . $newNumber;
        }

        return 'BRG' . date('Ymd') . '001';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'min_stok' => 'required|numeric|max:50',
            'stok_final' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'kategori' => 'required|exists:tb_kategori,id',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_barang')) {
            $fotoPath = $request->file('foto_barang')->store('barang', 'public');
        }

        Barang::create([
            'kode_barang' => $this->generateKodeBarang(),
            'nama_barang' => $request->nama_barang,
            'min_stok' => $request->min_stok,
            'stok_final' => $request->stok_final,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori,
            'foto_barang' => $fotoPath,
            'deskripsi' => $request->deskripsi,
        ]);

        // ✅ Hapus cache agar data baru muncul
        Cache::forget('cached_barangs');

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::where('status', 1)->get();

        return view('data-master.barang.edit', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('home')],
                ['label' => 'Data Barang', 'url' => route('barang.index')],
                ['label' => 'Edit']
            ],
            'title' => 'Edit Barang',
            'barang' => $barang,
            'kategoris' => $kategoris,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'min_stok' => 'required|numeric|max:50',
            'stok_final' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'kategori' => 'required|exists:tb_kategori,id',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $fotoPath = $barang->foto_barang;
        if ($request->hasFile('foto_barang')) {
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto_barang')->store('barang', 'public');
        }

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'min_stok' => $request->min_stok,
            'stok_final' => $request->stok_final,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori,
            'foto_barang' => $fotoPath,
            'deskripsi' => $request->deskripsi,
        ]);

        // ✅ Hapus cache karena data berubah
        Cache::forget('cached_barangs');

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        if ($barang->foto_barang) {
            Storage::disk('public')->delete($barang->foto_barang);
        }

        $barang->delete();

        // ✅ Hapus cache karena data dihapus
        Cache::forget('cached_barangs');

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
