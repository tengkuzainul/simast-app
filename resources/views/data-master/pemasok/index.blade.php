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
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data {{ $title }}</h6>
        </div>
        <div class="card-body">
            <form enctype="multipart/form-data" method="POST" action="{{ route('pemasok.store') }}"
                class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="kodePemasok" class="form-label">Kode Pemasok <span
                                class="ml-3 border rounded text-danger border-danger px-2">Dibuat
                                Otomatis</span></label>
                        <input type="text" name="kodePemasok" value="{{ old('kodePemasok', $kodePemasok) }}"
                            class="form-control @error('kodePemasok') is-invalid @enderror" id="kodePemasok"
                            aria-describedby="kodePemasok" placeholder="Masukkan Kode Pemasok" disabled readonly>
                        @error('kodePemasok')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="namaPemasok" class="form-label">Nama Pemasok <span
                                class="ml-1 text-danger">*</span></label>
                        <input type="text" name="namaPemasok" value="{{ old('namaPemasok') }}"
                            class="form-control @error('namaPemasok') is-invalid @enderror" id="namaPemasok"
                            aria-describedby="namaPemasok" placeholder="Masukkan Nama Pemasok">
                        @error('namaPemasok')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="ml-1 text-danger">*</span></label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}"
                            class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                            aria-describedby="alamat" placeholder="Masukkan Alamat">
                        @error('alamat')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="telepon" class="form-label">Telepon <span class="ml-1 text-danger">*</span></label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}"
                            class="form-control @error('telepon') is-invalid @enderror" id="telepon"
                            aria-describedby="telepon" placeholder="Masukkan Telepon (081234567890)">
                        @error('telepon')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-3">
                    <button type="submit" class="btn btn-success loading-indicator">
                        <i class="fas fa-check fa-sm text-white-100 icon-default"></i>
                        <span class="spinner-border spinner-border-sm spinner-loading" role="status" aria-hidden="true"
                            style="display: none;"></span>
                        <span class="btn-text"> Simpan Data</span>
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
                            <th>Kode Pemasok</th>
                            <th>Nama Pemasok</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pemasok as $data)
                            <tr id="{{ $data->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge text-white p-2 bg-primary">{{ $data->kode_pemasok }}</span>
                                </td>
                                <td>{{ $data->nama_pemasok }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>{{ $data->telepon }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                                        <a href="#" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-target="#editModal-{{ $data->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('pemasok.destroy', $data->id) }}"
                                            class="btn btn-danger btn-sm" data-confirm-delete="true">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1" role="dialog"
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
                                            action="{{ route('pemasok.update', $data->id) }}"
                                            class="needs-validation" novalidate>
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="kodePemasok" class="form-label">Kode
                                                            Pemasok <span class="ml-1 text-danger">*</span><span
                                                                class="ml-3 border rounded text-danger border-danger px-2">Dibuat
                                                                Otomatis</span></label>
                                                        <input type="text" name="kodePemasok"
                                                            value="{{ old('kodePemasok', $data->kode_pemasok) }}"
                                                            class="form-control @error('kodePemasok') is-invalid @enderror"
                                                            id="kodePemasok" aria-describedby="kodePemasok"
                                                            placeholder="Masukkan Kode Pemasok" disabled readonly>
                                                        @error('kodePemasok')
                                                            <div class="valid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="namaPemasok" class="form-label">Nama
                                                            Pemasok <span class="ml-1 text-danger">*</span></label>
                                                        <input type="text" name="namaPemasok"
                                                            value="{{ old('namaPemasok', $data->nama_pemasok) }}"
                                                            class="form-control @error('namaPemasok') is-invalid @enderror"
                                                            id="namaPemasok" aria-describedby="namaPemasok"
                                                            placeholder="Masukkan Nama Pemasok">
                                                        @error('namaPemasok')
                                                            <div class="valid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="alamat" class="form-label">Alamat <span
                                                                class="ml-1 text-danger">*</span></label>
                                                        <input type="text" name="alamat"
                                                            value="{{ old('alamat', $data->alamat) }}"
                                                            class="form-control @error('alamat') is-invalid @enderror"
                                                            id="alamat" aria-describedby="alamat"
                                                            placeholder="Masukkan Alamat">
                                                        @error('alamat')
                                                            <div class="valid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="telepon" class="form-label">Telepon </label>
                                                        <input type="text" name="telepon"
                                                            value="{{ old('telepon', $data->telepon) }}"
                                                            class="form-control @error('telepon') is-invalid @enderror"
                                                            id="telepon" aria-describedby="telepon"
                                                            placeholder="Masukkan Telepon (081234567890)">
                                                        @error('telepon')
                                                            <div class="valid-feedback">
                                                                {{ $message }}
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
                                                <button type="submit" class="btn btn-success loading-indicator">
                                                    <i class="fas fa-check fa-sm text-white-100 icon-default"></i>
                                                    <span class="spinner-border spinner-border-sm spinner-loading"
                                                        role="status" aria-hidden="true"
                                                        style="display: none;"></span>
                                                    <span class="btn-text"> Simpan Data</span>
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
                            <th>Kode Pemasok</th>
                            <th>Nama Pemasok</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
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
