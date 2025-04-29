<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\DataMaster\Pemasok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('home')],
            ['label' => 'Data Pemasok']
        ];

        $pemasok = Cache::remember('cached_pemasoks', now()->addMinutes(30), function () {
            return Pemasok::all();
        });

        $kodePemasok = $this->generateKodePemasok();

        $title = "Hapus Data";
        $text = "Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        return view('data-master.pemasok.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Pemasok',
            'pemasok' => $pemasok,
            'kodePemasok' => $kodePemasok
        ]);
    }

    protected function generateKodePemasok()
    {
        $lastPemasok = Pemasok::orderBy('kode_pemasok', 'desc')->first();
        if ($lastPemasok) {
            $lastKode = (int) substr($lastPemasok->kode_pemasok, 3);
            $newKode = $lastKode + 1;
            return 'SUP' . str_pad($newKode, 3, '0', STR_PAD_LEFT);
        }
        return 'SUP001';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'namaPemasok' => 'required|string',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:255',
        ]);

        $pemasok = new Pemasok();
        $pemasok->kode_pemasok = $this->generateKodePemasok();
        $pemasok->nama_pemasok = $request->namaPemasok;
        $pemasok->alamat = $request->alamat;
        $pemasok->telepon = $request->telepon;
        $pemasok->save();

        // ✅ Hapus cache agar data baru muncul
        Cache::forget('cached_pemasoks');

        return redirect()->back()->with('success', 'Pemasok berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemasok $pemasok)
    {
        $request->validate([
            'namaPemasok' => 'required|string',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:255',
        ]);

        $pemasok->nama_pemasok = $request->namaPemasok;
        $pemasok->alamat = $request->alamat;
        $pemasok->telepon = $request->telepon;
        $pemasok->save();

        // ✅ Hapus cache karena data berubah
        Cache::forget('cached_pemasoks');

        return redirect()->back()->with('success', 'Pemasok berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();

        // ✅ Hapus cache karena data dihapus
        Cache::forget('cached_pemasoks');

        return redirect()->back()->with('success', 'Pemasok berhasil dihapus');
    }
}
