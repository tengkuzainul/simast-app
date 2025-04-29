<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('stok.form') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
            aria-label="Tambah Data">
            <i class="fas fa-plus fa-sm text-white-50"></i> {{ __('Tambah Data') }}
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-4">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                </div>

                <div class="col-md-8">
                    <form method="GET" class="d-flex flex-wrap justify-content-end align-items-center"
                        style="gap: 10px">
                        <label class="m-0 font-weight-bold text-dark mr-2">Filter Data:</label>

                        <select name="barang_id" class="form-control form-control-sm w-auto" aria-label="Filter Barang">
                            <option value="">{{ __('Pilih Barang') }}</option>
                            @foreach (\App\Models\DataMaster\Barang::all() as $barang)
                                <option value="{{ $barang->id }}"
                                    {{ request('barang_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->nama_barang }}
                                </option>
                            @endforeach
                        </select>

                        <select name="tipe_transaksi" class="form-control form-control-sm w-auto"
                            aria-label="Filter Tipe Transaksi">
                            <option value="">{{ __('Pilih Tipe Transaksi') }}</option>
                            <option value="masuk" {{ request('tipe_transaksi') == 'masuk' ? 'selected' : '' }}>Masuk
                            </option>
                            <option value="keluar" {{ request('tipe_transaksi') == 'keluar' ? 'selected' : '' }}>Keluar
                            </option>
                        </select>

                        <button type="submit" class="btn btn-success btn-sm loading-indicator">
                            <i class="fas fa-check fa-sm text-white-100 icon-default"></i>
                            <span class="spinner-border spinner-border-sm spinner-loading" role="status"
                                aria-hidden="true" style="display: none;"></span>
                            <span class="btn-text"> Filter Data</span>
                        </button>

                        @if (request()->has('barang_id') || request()->has('tipe_transaksi'))
                            <a href="{{ route('stok.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times-circle"></i> Hapus Filter
                            </a>
                        @endif
                    </form>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('No') }}</th>
                            <th>{{ __('Kode Transaksi') }}</th>
                            <th>{{ __('Data Barang') }}</th>
                            <th>{{ __('Data Pemasok') }}</th>
                            <th>{{ __('Yang Membuat') }}</th>
                            <th>{{ __('Tipe Transaksi') }}</th>
                            <th>{{ __('Jumlah Barang') }}</th>
                            <th>{{ __('Status Transaksi') }}</th>
                            <th>{{ __('Tanggal Dibuat') }}</th>
                            <th>{{ __('Aksi') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($transaksis as $transaksi)
                            <tr id="{{ $transaksi->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span
                                        class="badge text-white p-2 bg-primary">{{ $transaksi->kode_transaksi }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center" style="gap: 10px">
                                        <img src="{{ asset('storage/' . $transaksi->barang->foto_barang) }}"
                                            alt="{{ $transaksi->barang->kode_barang }}" width="50" height="50"
                                            class="rounded shadow">
                                        <div class="d-flex flex-column">
                                            <span class="font-weight-bold">{{ $transaksi->barang->kode_barang }}</span>
                                            <span>{{ $transaksi->barang->nama_barang }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold">{{ $transaksi->pemasok->kode_pemasok }}</span>
                                        <span>{{ $transaksi->pemasok->nama_pemasok }}</span>
                                    </div>
                                </td>
                                <td>{{ $transaksi->user->name }}</td>
                                <td>
                                    <span class="text-capitalize">{{ $transaksi->tipe_transaksi }}</span>
                                </td>
                                <td>
                                    <span class="badge text-white p-2 bg-dark">{{ $transaksi->jumlah }}</span>

                                </td>
                                <td>
                                    <span
                                        class="badge  p-2 bg-{{ $transaksi->status_transaksi == 'Menunggu' ? 'warning text-dark' : 'success text-white' }}">{{ $transaksi->status_transaksi }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge text-white p-2 bg-primary">{{ \Carbon\Carbon::parse($transaksi->created_at)->translatedFormat('l, d F Y') }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column" style="gap: 10px">
                                        <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                                            <a href="{{ route('stok.edit', $transaksi->id) }}"
                                                class="btn btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('stok.destroy', $transaksi->id) }}"
                                                class="btn btn-danger btn-sm" data-confirm-delete="true">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                        <form action="{{ route('stok.status', $transaksi->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_transaksi" value=""
                                                id="statusInput-{{ $transaksi->id }}">

                                            <div class="d-flex justify-content-center align-items-center"
                                                style="gap: 5px;">
                                                <button type="submit"
                                                    onclick="document.getElementById('statusInput-{{ $transaksi->id }}').value='Disetujui'"
                                                    class="text-success"
                                                    style="background: none; border: none; display: inline-flex; align-items: center; gap: 5px">
                                                    <i class="fas fa-check-circle"></i> Setujui
                                                </button>

                                                <button type="submit"
                                                    onclick="document.getElementById('statusInput-{{ $transaksi->id }}').value='Menunggu'"
                                                    class="text-danger"
                                                    style="background: none; border: none; display: inline-flex; align-items: center; gap: 5px">
                                                    <i class="fas fa-times-circle"></i> Kembalikan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <th>{{ __('No') }}</th>
                        <th>{{ __('Kode Transaksi') }}</th>
                        <th>{{ __('Data Barang') }}</th>
                        <th>{{ __('Data Pemasok') }}</th>
                        <th>{{ __('Yang Membuat') }}</th>
                        <th>{{ __('Tipe Transaksi') }}</th>
                        <th>{{ __('Jumlah Barang') }}</th>
                        <th>{{ __('Status Transaksi') }}</th>
                        <th>{{ __('Tanggal Dibuat') }}</th>
                        <th>{{ __('Aksi') }}</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
