<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="toggleFormButton">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
        </a>
    </div>

    <!-- Card Form -->
    <div class="card shadow mb-4" id="card-form-{{ $title }}" style="display: none;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Kategori</h6>
        </div>
        <div class="card-body">
            <form enctype="multipart/form-data" method="POST" action="{{ route('kategori.store') }}"
                class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label for="namaKategori" class="form-label">Nama Kategori</label>
                        <input type="text" name="namaKategori" value="{{ old('namaKategori') }}"
                            class="form-control @error('namaKategori') is-invalid @enderror" id="namaKategori"
                            aria-describedby="namaKategori" placeholder="Masukkan Nama Kategori">
                        @error('namaKategori')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="statusKategori" class="form-label">Status Kategori</label>
                        <select name="statusKategori" class="form-control @error('statusKategori') is-invalid @enderror"
                            id="statusKategori" aria-label="Default select example">
                            <option selected>Pilih Status</option>
                            <option value="1" {{ old('statusKategori' == 1 ? 'selected' : '') }}>Aktif</option>
                            <option value="0" {{ old('statusKategori' == 0 ? 'selected' : '') }}>Tidak Aktif
                            </option>
                        </select>
                        @error('statusKategori')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 mt-3">
                        <label for="deskripsiKategori" class="form-label">Deksripsi Kategori <span
                                class="text-primary">(Opsional)</span></label>
                        <textarea class="form-control @error('deskripsiKategori') is-invalid @enderror" name="deskripsiKategori"
                            id="deskripsiKategori" rows="3" placeholder="Masukkan Deksripsi Kategori">{{ old('deskripsiKategori') }}</textarea>
                        @error('deskripsiKategori')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check fa-sm text-white-100"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
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
                            <th>Kategori Barang</th>
                            <th>Deskripsi Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($kategoris as $kategori)
                            <tr id="{{ $kategori->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td>{{ $kategori->deskripsi ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge text-white p-2 bg-{{ $kategori->status == 1 ? 'success' : 'warning' }}">{{ $kategori->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                                        <a href="#" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-target="#editModal-{{ $kategori->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('kategori.destroy', $kategori->id) }}"
                                            class="btn btn-danger btn-sm" data-confirm-delete="true">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal-{{ $kategori->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Form Edit Kategori</h5>
                                            <button class="close" type="button" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form enctype="multipart/form-data" method="POST"
                                            action="{{ route('kategori.update', $kategori->id) }}"
                                            class="needs-validation" novalidate>
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="namaKategori" class="form-label">Nama
                                                            Kategori</label>
                                                        <input type="text" name="namaKategori"
                                                            value="{{ old('namaKategori', $kategori->nama_kategori) }}"
                                                            class="form-control @error('namaKategori') is-invalid @enderror"
                                                            id="namaKategori" aria-describedby="namaKategori"
                                                            placeholder="Masukkan Nama Kategori">
                                                        @error('namaKategori')
                                                            <div class="valid-feedback">
                                                                {{ $message }}}}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="statusKategori" class="form-label">Status
                                                            Kategori</label>
                                                        <select name="statusKategori"
                                                            class="form-control @error('statusKategori') is-invalid @enderror"
                                                            id="statusKategori" aria-label="Default select example">
                                                            <option selected>Pilih Status</option>
                                                            <option value="1"
                                                                {{ old('statusKategori', $kategori->status) == 1 ? 'selected' : '' }}>
                                                                Aktif</option>
                                                            <option value="0"
                                                                {{ old('statusKategori', $kategori->status) == 0 ? 'selected' : '' }}>
                                                                Tidak Aktif
                                                            </option>
                                                        </select>
                                                        @error('statusKategori')
                                                            <div class="valid-feedback">
                                                                {{ $message }}}}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-12 mt-3">
                                                        <label for="deskripsiKategori" class="form-label">Deksripsi
                                                            Kategori <span
                                                                class="text-primary">(Opsional)</span></label>
                                                        <textarea class="form-control @error('deskripsiKategori') is-invalid @enderror" name="deskripsiKategori"
                                                            id="deskripsiKategori" rows="3" placeholder="Masukkan Deksripsi Kategori">{{ old('deskripsiKategori', $kategori->deskripsi) }}</textarea>
                                                        @error('deskripsiKategori')
                                                            <div class="valid-feedback">
                                                                {{ $message }}}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-check fa-sm text-white-100"></i> Simpan Data
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Kategori Barang</th>
                            <th>Deskripsi Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleFormButton = document.getElementById('toggleFormButton');
            const cardForm = document.getElementById('card-form-{{ $title }}');

            toggleFormButton.addEventListener('click', function(e) {
                e.preventDefault();
                if (cardForm.style.display === 'none') {
                    cardForm.style.display = 'block';
                } else {
                    cardForm.style.display = 'none';
                }
            });
        });
    </script>
</x-layouts.dashboard>
