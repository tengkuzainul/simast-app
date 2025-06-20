<?php

namespace App\Http\Controllers\DataLaporan;

use App\Http\Controllers\Controller;
use App\Models\DataMaster\Barang;
use App\Models\DataMaster\Pemasok;
use App\Models\DataMaster\StokTransaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getFormLaporan()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('home')],
            ['label' => 'Data Laporan', 'url' => route('stok.index')],
            ['label' => 'Form Buat Laporan']
        ];

        return view('laporan.form-laporan', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Form Laporan',
            'barangs' => Barang::select('id', 'nama_barang', 'kode_barang')->get(),
            'pemasoks' => Pemasok::select('id', 'nama_pemasok', 'kode_pemasok')->get(),
        ]);
    }

    public function rekapLaporan(Request $request)
    {
        $request->validate([
            'tglAwal' => 'required|date',
            'tglAkhir' => 'required|date|after_or_equal:tglAwal',
            'jenisTransaksi' => 'required|in:masuk,keluar',
            'barang' => 'nullable|exists:tb_barang,id',
            'pemasok' => 'nullable|exists:tb_pemasok,id',
        ]);

        $endDate = Carbon::parse($request->tglAkhir)->endOfDay();

        $query = StokTransaksi::with(['barang', 'pemasok', 'user'])
            ->where('tipe_transaksi', $request->jenisTransaksi)
            ->whereBetween('created_at', [$request->tglAwal, $endDate]);

        if ($request->barang) {
            $query->where('barang_id', $request->barang);
        }

        if ($request->pemasok) {
            $query->where('pemasok_id', $request->pemasok);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('laporan.laporan-pdf', [
            'data' => $data,
            'tglAwal' => $request->tglAwal,
            'tglAkhir' => $request->tglAkhir,
            'jenisTransaksi' => $request->jenisTransaksi,
            'namaToko' => 'Rizki Ananda Fashion Store',
            'tanggalCetak' => Carbon::now()->locale('id')->format('d F Y H:i'),
        ])->setPaper('a4', 'landscape')->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
        ]);

        if ($pdf) {
            return $pdf->download('laporan-transaksi.pdf')->withHeaders([
                'Content-Type' => 'application/pdf',
            ]);
        }

        return redirect()->back()->with([
            'success' => 'Laporan berhasil dibuat',
        ]);
    }
}
