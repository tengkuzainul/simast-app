<?php

namespace App\Http\Controllers;

use App\Models\DataMaster\Barang;
use App\Models\DataMaster\Kategori;
use App\Models\DataMaster\Pemasok;
use App\Models\DataMaster\StokTransaksi;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('home')],
            ['label' => 'Home']
        ];

        $countPengguna = User::count();
        $countPemasok = Pemasok::count();
        $countKatgeoriBarang = Kategori::count();
        $countBarang = Barang::count();
        $countTransaksiMasuk = StokTransaksi::where('tipe_transaksi', 'masuk')->count();
        $countTransaksiKeluar = StokTransaksi::where('tipe_transaksi', 'keluar')->count();


        return view('home', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Dashboard'
        ], compact(
            'countPengguna',
            'countPemasok',
            'countKatgeoriBarang',
            'countBarang',
            'countTransaksiMasuk',
            'countTransaksiKeluar'
        ));
    }
}
