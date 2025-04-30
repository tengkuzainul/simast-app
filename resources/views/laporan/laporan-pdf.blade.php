<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Stok</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
            padding: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        td {
            vertical-align: top;
        }

        .barang-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .barang-container img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        .pemasok-container {
            display: flex;
            flex-direction: column;
        }

        .footer,
        .signature {
            margin-top: 30px;
            width: 100%;
        }

        .signature td {
            border: none;
            text-align: right;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2 style="font-size: 2rem">{{ $namaToko }}</h2>
    <h4 style="font-size: 1.5rem">Laporan Transaksi Stok</h4>
    <p style="text-align: center; font-size: 1rem">Periode:
        {{ \Carbon\Carbon::parse($tglAwal)->translatedFormat('d F Y') }} -
        {{ \Carbon\Carbon::parse($tglAkhir)->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Pemasok</th>
                <th>Jumlah</th>
                <th>Yang Membuat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->kode_transaksi }}</td>
                    <td>{{ $row->created_at->translatedFormat('d F Y') }}</td>
                    <td>
                        <div class="barang-container">
                            <div>
                                <strong>{{ $row->barang->kode_barang ?? '-' }}</strong><br>
                                {{ $row->barang->nama_barang ?? '-' }}
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="pemasok-container">
                            <strong>{{ $row->pemasok->kode_pemasok ?? '-' }}</strong>
                            {{ $row->pemasok->nama_pemasok ?? '-' }}
                        </div>
                    </td>
                    <td>{{ $row->jumlah }}</td>
                    <td>{{ $row->user->name ?? '-' }}</td>
                    <td>{{ ucfirst($row->status_transaksi) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Data tidak ditemukan sesuai filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signature" style="border: none; margin-top: 40px;">
        <tr>
            <td style="border: none; text-align: right;">
                <p>Disetujui oleh,</p>
                <br><br><br>
                <strong style="display: inline-block; margin-bottom: 5px;">____________________</strong><br>
                <small>Owner RA Fashion Store</small>
            </td>
        </tr>
    </table>

    <div class="footer">
        <hr>
        <p>Laporan ini dibuat secara otomatis dan digital pada:
            {{ \Carbon\Carbon::parse($tanggalCetak)->translatedFormat('d F Y') }}</p>
    </div>
</body>

</html>
