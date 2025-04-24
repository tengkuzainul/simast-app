<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\DataMaster\Kategori;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('home')],
            ['label' => 'Kategori Barang', 'url' => route('kategori.index')],
            ['label' => 'Data']
        ];

        $kategoris = Kategori::all();

        $title = "Hapus Data";
        $text = "Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        return view('data-master.kategori.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Kategori Barang'
        ], compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'namaKategori' => 'required|string|max:50',
            'statusKategori' => 'required|string|boolean',
            'deskripsiKategori' => 'nullable|string|max:255'
        ]);

        $kategori = new Kategori();
        $kategori->nama_kategori = $request->namaKategori;
        $kategori->deskripsi = $request->deskripsiKategori;
        $kategori->status = $request->statusKategori;
        $kategori->save();

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'namaKategori' => 'required|string|max:50|unique:tb_kategori,nama_kategori,' . $kategori->id,
            'statusKategori' => 'required|boolean',
            'deskripsiKategori' => 'nullable|string|max:255'
        ]);

        $kategori->nama_kategori = $request->namaKategori;
        $kategori->deskripsi = $request->deskripsiKategori;
        $kategori->status = $request->statusKategori;
        $kategori->save();

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
