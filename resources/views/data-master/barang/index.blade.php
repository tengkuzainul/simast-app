<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('barang.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori Barang</th>
                            <th>Satuan</th>
                            <th>Stok Barang</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($barangs as $barang)
                            <tr id="{{ $barang->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        @if ($barang->foto_barang)
                                            <img src="{{ asset('storage/' . $barang->foto_barang) }}"
                                                alt="Foto Pengguna" class="rounded mb-3 shadow" width="50"
                                                height="50">
                                        @else
                                            <img src="{{ asset('assets/img/default-foto-barang.png') }}"
                                                alt="Foto Pengguna" class="rounded mb-3 shadow" width="50"
                                                height="50" title="Foto Barang Belum Tersedia">
                                        @endif
                                        <p class="badge text-white p-2 bg-dark rounded">{{ $barang->kode_barang }}</p>
                                    </div>
                                </td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>
                                    <span
                                        class="badge text-white p-2 bg-primary rounded">{{ $barang->kategori->nama_kategori }}</span>
                                </td>
                                <td>{{ $barang->satuan }}</td>
                                <td>
                                    <span
                                        class="badge text-white p-2 bg-primary rounded">{{ $barang->stok_final }}</span>
                                </td>
                                <td>
                                    Rp. {{ number_format($barang->harga_beli) }}
                                </td>
                                <td>
                                    Rp. {{ number_format($barang->harga_jual) }}
                                </td>
                                <td>{{ $barang->deskripsi ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                                        <a href="{{ route('barang.edit', $barang->id) }}"
                                            class="btn btn-secondary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('barang.destroy', $barang->id) }}"
                                            class="btn btn-danger btn-sm" data-confirm-delete="true">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Foto Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori Barang</th>
                            <th>Satuan</th>
                            <th>Stok Barang</th>
                            <th>Harga Barang</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
