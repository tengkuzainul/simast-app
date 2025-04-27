<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('barang.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> <span class="ml-2">Kembali</span>
        </a>
    </div>

    <div class="card shadow mb-4" id="card-form-{{ $title }}">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form {{ $title }}</h6>
        </div>
        <div class="card-body">
            <form enctype="multipart/form-data" method="POST" action="{{ route('barang.store') }}"
                class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="kodeBarang" class="form-label font-weight-bold">Kode Barang <span
                                class="text-danger border border-danger px-2 rounded">Dibuat Otomatis</span></label>
                        <input type="text" name="kode_barang" value="{{ old('kode_barang', $kodeBarang) }}"
                            class="form-control @error('kode_barang') is-invalid @enderror" id="kodeBarang"
                            placeholder="Masukkan Kode Barang" readonly disabled>
                        @error('kode_barang')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="fotoBarang" class="form-label font-weight-bold">Foto Barang (Opsional)</label>
                        <input type="file" name="foto_barang"
                            class="form-control @error('foto_barang') is-invalid @enderror" id="fotoBarang"
                            onchange="previewImage(event)">
                        @error('foto_barang')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <img id="preview" src="#" alt="Preview Foto Barang" class="img-thumbnail mt-2"
                            style="display: none; max-height: 150px;">
                    </div>

                    <div class="col-6 mb-3">
                        <label for="namaBarang" class="form-label font-weight-bold">Nama Barang <span
                                class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                            class="form-control @error('nama_barang') is-invalid @enderror" id="namaBarang"
                            placeholder="Masukkan Nama Barang">
                        @error('nama_barang')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="satuan" class="form-label font-weight-bold">Satuan <span
                                class="text-danger">*</span></label>
                        <input type="text" name="satuan" value="{{ old('satuan') }}"
                            class="form-control @error('satuan') is-invalid @enderror" id="satuan"
                            placeholder="Masukkan Satuan Barang">
                        @error('satuan')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="stokFinal" class="form-label font-weight-bold">Stok Barang Awal<span
                                class="text-danger">*</span></label>
                        <input type="number" name="stok_final" value="{{ old('stok_final') }}"
                            class="form-control @error('stok_final') is-invalid @enderror" id="stokFinal"
                            placeholder="Masukkan Stok Barang Awal">
                        @error('stok_final')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="hargaBeli" class="form-label font-weight-bold">Harga Beli <span
                                class="text-danger">*</span></label>
                        <input type="number" name="harga_beli" value="{{ old('harga_beli') }}"
                            class="form-control @error('harga_beli') is-invalid @enderror" id="hargaBeli"
                            placeholder="Masukkan Harga Beli">
                        @error('harga_beli')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="hargaJual" class="form-label font-weight-bold">Harga Jual <span
                                class="text-danger">*</span></label>
                        <input type="number" name="harga_jual" value="{{ old('harga_jual') }}"
                            class="form-control @error('harga_jual') is-invalid @enderror" id="hargaJual"
                            placeholder="Masukkan Harga Jual">
                        @error('harga_jual')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="kategori" class="form-label font-weight-bold">Kategori <span
                                class="text-danger">*</span></label>
                        <select name="kategori" class="form-control @error('kategori') is-invalid @enderror"
                            id="kategori">
                            <option selected disabled>Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-2">
                        <label for="deskripsi" class="form-label font-weight-bold">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                            rows="3" placeholder="Masukkan Deskripsi Barang">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
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

            <script>
                function previewImage(event) {
                    const preview = document.getElementById('preview');
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = '#';
                        preview.style.display = 'none';
                    }
                }
            </script>
        </div>
    </div>
</x-layouts.dashboard>
