<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur - {{ $nomorFaktur }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/faktur.css') }}" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .page-break {
                page-break-before: always;
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        .invoice-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px 10px 0 0;
        }

        .invoice-body {
            background: white;
            border: 2px solid #e3e6f0;
            border-top: none;
            border-radius: 0 0 10px 10px;
        }

        .company-info {
            text-align: center;
            margin-bottom: 30px;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #667eea;
            margin-bottom: 15px;
        }

        .invoice-details {
            background: #f8f9fc;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .table-invoice {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .table-invoice thead th {
            background: #5a5c69;
            color: white;
            font-weight: 600;
            padding: 15px;
            border: none;
        }

        .table-invoice tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e3e6f0;
        }

        .table-invoice tbody tr:hover {
            background-color: #f8f9fc;
        }

        .invoice-summary {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
            color: white;
            padding: 25px;
            border-radius: 8px;
            margin-top: 30px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-success {
            background: #1cc88a;
            color: white;
        }

        .status-warning {
            background: #f6c23e;
            color: #5a5c69;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(0, 0, 0, 0.05);
            z-index: -1;
            font-weight: bold;
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .footer-info {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e3e6f0;
            text-align: center;
            color: #6c757d;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <!-- Watermark -->
    <div class="watermark">SIMAST</div>

    <!-- Print Button -->
    <button class="btn btn-primary btn-lg print-btn no-print" onclick="window.print()">
        <i class="fas fa-print me-2"></i>
        Cetak Faktur
    </button>

    <div class="container my-4">
        <div class="invoice-container">

            <!-- Invoice Header -->
            <div class="invoice-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="company-info text-start">
                            <div class="company-logo">
                                <i class="fas fa-warehouse"></i>
                            </div>
                            <h2 class="mb-1">SIMAST</h2>
                            <p class="mb-0">Sistem Manajemen Stok</p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Jl. Contoh No. 123, Kota</p>
                            <p class="mb-0"><i class="fas fa-phone me-2"></i>+62 123 456 789</p>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <h1 class="display-4 mb-0">FAKTUR</h1>
                        <p class="lead mb-0">Invoice #{{ $nomorFaktur }}</p>
                        <p class="mb-0">{{ $tanggalCetak->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Invoice Body -->
            <div class="invoice-body p-4">

                <!-- Supplier Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-truck me-2"></i>Informasi Pemasok
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title text-dark">{{ $pemasok->nama_pemasok }}</h6>
                                @if ($pemasok->kode_pemasok)
                                    <p class="card-text mb-1">
                                        <strong>Kode:</strong> {{ $pemasok->kode_pemasok }}
                                    </p>
                                @endif
                                @if ($pemasok->alamat)
                                    <p class="card-text mb-1">
                                        <strong>Alamat:</strong> {{ $pemasok->alamat }}
                                    </p>
                                @endif
                                @if ($pemasok->telepon)
                                    <p class="card-text mb-1">
                                        <strong>Telepon:</strong> {{ $pemasok->telepon }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-info-circle me-2"></i>Detail Faktur
                        </h5>
                        <div class="invoice-details">
                            <div class="row">
                                <div class="col-6"><strong>Nomor Faktur:</strong></div>
                                <div class="col-6">{{ $nomorFaktur }}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><strong>Tanggal Cetak:</strong></div>
                                <div class="col-6">{{ $tanggalCetak->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><strong>Total Transaksi:</strong></div>
                                <div class="col-6">{{ $totalItems }} transaksi</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><strong>Periode:</strong></div>
                                <div class="col-6">
                                    {{ $transaksis->min('created_at')->format('d/m/Y') }} -
                                    {{ $transaksis->max('created_at')->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Table -->
                <div class="table-responsive">
                    <table class="table table-invoice">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Kode Transaksi</th>
                                <th width="15%">Kode Barang</th>
                                <th width="25%">Nama Barang</th>
                                <th width="10%">Jumlah</th>
                                <th width="12%">Harga Satuan</th>
                                <th width="12%">Subtotal</th>
                                <th width="8%">Status</th>
                                <th width="10%">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $index => $transaksi)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $transaksi->kode_transaksi }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $transaksi->barang->kode_barang }}</strong>
                                    </td>
                                    <td>{{ $transaksi->barang->nama_barang }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-dark">{{ number_format($transaksi->jumlah) }}</span>
                                    </td>
                                    <td class="text-end">
                                        @if ($transaksi->barang->harga_beli)
                                            Rp {{ number_format($transaksi->barang->harga_beli, 0, ',', '.') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if ($transaksi->barang->harga_beli)
                                            <strong>Rp
                                                {{ number_format($transaksi->jumlah * $transaksi->barang->harga_beli, 0, ',', '.') }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($transaksi->status_transaksi === 'Disetujui')
                                            <span class="status-badge status-success">
                                                <i class="fas fa-check-circle me-1"></i>Disetujui
                                            </span>
                                        @else
                                            <span class="status-badge status-warning">
                                                <i class="fas fa-clock me-1"></i>Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <small>{{ $transaksi->created_at->format('d/m/Y') }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Invoice Summary -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mt-4">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Ringkasan Statistik</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="mb-2">
                                            <i class="fas fa-boxes text-primary fa-2x"></i>
                                        </div>
                                        <h4 class="text-primary">{{ $totalItems }}</h4>
                                        <small class="text-muted">Total Transaksi</small>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-2">
                                            <i class="fas fa-cubes text-success fa-2x"></i>
                                        </div>
                                        <h4 class="text-success">{{ number_format($totalQuantity) }}</h4>
                                        <small class="text-muted">Total Quantity</small>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-2">
                                            <i class="fas fa-check-double text-info fa-2x"></i>
                                        </div>
                                        <h4 class="text-info">
                                            {{ $transaksis->where('status_transaksi', 'Disetujui')->count() }}</h4>
                                        <small class="text-muted">Disetujui</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="invoice-summary">
                            <h5 class="mb-3"><i class="fas fa-calculator me-2"></i>Total Nilai Transaksi</h5>
                            <div class="row">
                                <div class="col-8">
                                    <p class="mb-1">Subtotal:</p>
                                    <p class="mb-1">PPN (11%):</p>
                                    <hr class="my-2">
                                    <h4 class="mb-0">TOTAL:</h4>
                                </div>
                                <div class="col-4 text-end">
                                    <p class="mb-1">Rp {{ number_format($totalValue, 0, ',', '.') }}</p>
                                    <p class="mb-1">Rp {{ number_format($totalValue * 0.11, 0, ',', '.') }}</p>
                                    <hr class="my-2">
                                    <h4 class="mb-0">Rp {{ number_format($totalValue * 1.11, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="signature-section">
                    <div class="signature-box">
                        <p><strong>Pemasok</strong></p>
                        <div class="signature-line">
                            {{ $pemasok->nama_pemasok }}
                        </div>
                    </div>
                    <div class="signature-box">
                        <p><strong>Operator Gudang</strong></p>
                        <div class="signature-line">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                    <div class="signature-box">
                        <p><strong>Manager</strong></p>
                        <div class="signature-line">
                            ________________
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="footer-info">
                    <p class="mb-1">
                        <i class="fas fa-shield-alt me-2"></i>
                        Faktur ini digenerate secara otomatis oleh sistem SIMAST
                    </p>
                    <p class="mb-0">
                        <small>Dicetak pada: {{ $tanggalCetak->format('d F Y, H:i:s') }} WIB</small>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- Back to Index Button -->
    <div class="text-center mt-4 no-print">
        <a href="{{ route('stok.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali ke Daftar Transaksi
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto print functionality
        function autoPrint() {
            if (confirm('Apakah Anda ingin mencetak faktur ini sekarang?')) {
                window.print();
            }
        }

        // Print button functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Optional: Auto-focus print button
            const printBtn = document.querySelector('.print-btn');
            if (printBtn) {
                printBtn.focus();
            }
        });

        // Print event handling
        window.addEventListener('beforeprint', function() {
            console.log('Preparing to print invoice...');
        });

        window.addEventListener('afterprint', function() {
            console.log('Print dialog closed.');
        });
    </script>
</body>

</html>
