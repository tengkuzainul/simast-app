<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('user.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> <span class="ml-2">Kembali</span>
        </a>
    </div>

    <div class="card shadow mb-4" id="card-form-{{ $title }}">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form {{ $title }}</h6>
        </div>
        <div class="card-body">
            <form enctype="multipart/form-data" method="POST" action="{{ route('user.update', $user->id) }}"
                class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6 mb-2">
                        <label for="namaPengguna" class="form-label font-weight-bold">Nama Pengguna</label>
                        <input type="text" name="namaPengguna" value="{{ old('namaPengguna', $user->name) }}"
                            class="form-control @error('namaPengguna') is-invalid @enderror" id="namaPengguna"
                            aria-describedby="namaPengguna" placeholder="Masukkan Nama Pengguna">
                        @error('namaPengguna')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-2">
                        <label for="emailPengguna" class="form-label font-weight-bold">Email</label>
                        <input type="email" name="emailPengguna" value="{{ old('emailPengguna', $user->email) }}"
                            class="form-control @error('emailPengguna') is-invalid @enderror" id="emailPengguna"
                            aria-describedby="emailPengguna" placeholder="Masukkan Email">
                        @error('emailPengguna')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-2">
                        <label for="usernamePengguna" class="form-label font-weight-bold">Username</label>
                        <input type="text" name="usernamePengguna"
                            value="{{ old('usernamePengguna', $user->username) }}"
                            class="form-control @error('usernamePengguna') is-invalid @enderror" id="usernamePengguna"
                            aria-describedby="usernamePengguna" placeholder="Masukkan Username">
                        @error('usernamePengguna')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-2">
                        <label for="levelPengguna" class="form-label font-weight-bold">Level Pengguna</label>
                        <select name="levelPengguna" class="form-control @error('levelPengguna') is-invalid @enderror"
                            id="levelPengguna" aria-label="Default select example">
                            <option selected disabled>Pilih Level</option>
                            <option value="Owner"
                                {{ old('levelPengguna', $user->role) == 'Owner' ? 'selected' : '' }}>
                                Owner
                            </option>
                            <option value="Op-Gudang"
                                {{ old('levelPengguna', $user->role) == 'Op-Gudang' ? 'selected' : '' }}>
                                Op-Gudang
                            </option>
                        </select>
                        @error('levelPengguna')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-2">
                        <label for="password" class="form-label font-weight-bold">Password</label>
                        <input type="password" name="password" value="{{ old('password') }}"
                            class="form-control @error('password') is-invalid @enderror" id="password"
                            aria-describedby="password" placeholder="Masukkan Password">
                        @error('password')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-2">
                        <label for="konfirmasiPassword" class="form-label font-weight-bold">Konfirmasi Password</label>
                        <input type="password" name="konfirmasiPassword" value="{{ old('konfirmasiPassword') }}"
                            class="form-control @error('konfirmasiPassword') is-invalid @enderror"
                            id="konfirmasiPassword" aria-describedby="konfirmasiPassword"
                            placeholder="Masukkan Konfirmasi Password">
                        @error('konfirmasiPassword')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button type="reset" class="btn btn-warning">
                        <i class="fas fa-redo fa-sm text-white-100"></i> Reset Form
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check fa-sm text-white-100"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.dashboard>
