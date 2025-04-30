<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('barang.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
            aria-label="Tambah Data">
            <i class="fas fa-plus fa-sm text-white-50"></i> {{ __('Tambah Data') }}
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('No') }}</th>
                            <th>{{ __('Foto Barang') }}</th>
                            <th>{{ __('Nama Barang') }}</th>
                            <th>{{ __('Kategori Barang') }}</th>
                            <th>{{ __('Minimal Stok') }}</th>
                            <th>{{ __('Stok Barang') }}</th>
                            <th>{{ __('Harga Beli') }}</th>
                            <th>{{ __('Harga Jual') }}</th>
                            <th>{{ __('Deskripsi') }}</th>
                            <th>{{ __('Aksi') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($barangs as $barang)
                            @php
                                $isLowStock = $barang->stok_final <= $barang->min_stok;
                                $isOutOfStock = $barang->stok_final == 0;
                            @endphp

                            <tr id="{{ $barang->id }}" class="{{ $isLowStock ? 'text-white' : '' }}"
                                style="background-color: {{ $isLowStock ? 'rgba(216, 64, 64, 0.8)' : '' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        @if ($barang->foto_barang)
                                            <img src="{{ asset('storage/' . $barang->foto_barang) }}"
                                                alt="{{ __('Foto Barang') }}" class="rounded mb-3 shadow"
                                                width="50" height="50">
                                        @else
                                            <img src="{{ asset('assets/img/default-foto-barang.png') }}"
                                                alt="{{ __('Foto Barang Belum Tersedia') }}"
                                                class="rounded mb-3 shadow" width="50" height="50"
                                                title="{{ __('Foto Barang Belum Tersedia') }}">
                                        @endif
                                        <p class="badge text-white p-2 bg-dark rounded">{{ $barang->kode_barang }}</p>
                                    </div>
                                </td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>
                                    <span
                                        class="badge text-white p-2 bg-info rounded">{{ $barang->kategori->nama_kategori }}</span>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge text-white p-2 bg-primary rounded">{{ number_format($barang->min_stok) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <span class="badge text-white p-2 bg-primary rounded mb-3">
                                            {{ number_format($barang->stok_final) }}
                                        </span>
                                        @if ($isOutOfStock)
                                            <span class="badge text-white p-2 bg-danger rounded">
                                                <i class="fas fa-times-circle"></i>
                                                {{ __('Stok Habis') }}
                                            </span>
                                        @elseif ($isLowStock)
                                            <span class="badge text-white p-2 bg-dark rounded">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ __('Stok Hampir Habis') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>Rp. {{ number_format($barang->harga_beli) }}</td>
                                <td>Rp. {{ number_format($barang->harga_jual) }}</td>
                                <td>{{ $barang->deskripsi ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                                        <a href="{{ route('barang.edit', $barang->id) }}"
                                            class="btn btn-secondary btn-sm" aria-label="{{ __('Edit Barang') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @assignRole('Owner')
                                            <a href="{{ route('barang.destroy', $barang->id) }}"
                                                class="btn btn-danger btn-sm" data-confirm-delete="true"
                                                aria-label="{{ __('Hapus Barang') }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endassignRole
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('No') }}</th>
                            <th>{{ __('Foto Barang') }}</th>
                            <th>{{ __('Nama Barang') }}</th>
                            <th>{{ __('Kategori Barang') }}</th>
                            <th>{{ __('Minimal Stok') }}</th>
                            <th>{{ __('Stok Barang') }}</th>
                            <th>{{ __('Harga Beli') }}</th>
                            <th>{{ __('Harga Jual') }}</th>
                            <th>{{ __('Deskripsi') }}</th>
                            <th>{{ __('Aksi') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
