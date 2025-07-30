<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>

    <!-- Card Form -->
    <div class="row g-2">
        <div class="col-md-12 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label font-weight-bold">Kode Transaksi</label>
                                <input type="text" class="form-control" value="{{ $transaksi->kode_transaksi }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label font-weight-bold">Jenis Transaksi Saat Ini</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-capitalize"
                                        value="{{ $transaksi->tipe_transaksi }}" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i
                                                class="fas fa-{{ $transaksi->tipe_transaksi === 'masuk' ? 'arrow-down text-success' : 'arrow-up text-danger' }}"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST"
                        action="{{ route('stok.update', $transaksi->id) }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="barang" class="form-label font-weight-bold">Pilih Barang</label>
                                <select name="barang" class="form-control @error('barang') is-invalid @enderror"
                                    id="barang" aria-label="Default select example">
                                    <option selected disabled>Pilih Barang</option>
                                    @forelse ($barangs as $barang)
                                        <option value="{{ $barang->id }}"
                                            {{ old('barang', $transaksi->barang_id) == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                        </option>
                                    @empty
                                        <option disabled>
                                            Barang Belum Ada
                                        </option>
                                    @endforelse
                                </select>
                                @error('barang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="jenisTransaksi" class="form-label font-weight-bold">Jenis Transaksi</label>
                                <select name="jenisTransaksi"
                                    class="form-control @error('jenisTransaksi') is-invalid @enderror"
                                    id="jenisTransaksi" aria-label="Default select example">
                                    <option selected disabled>Pilih Jenis Transaksi</option>
                                    @foreach (['masuk', 'keluar'] as $jenis)
                                        <option value="{{ $jenis }}"
                                            {{ old('jenisTransaksi', $transaksi->tipe_transaksi) == $jenis ? 'selected' : '' }}
                                            class="text-capitalize">
                                            {{ ucfirst($jenis) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenisTransaksi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3" id="pemasokField"
                                style="{{ $transaksi->tipe_transaksi === 'keluar' ? 'display: none;' : '' }}">
                                <label for="pemasok" class="form-label font-weight-bold">Pilih Pemasok
                                    <span
                                        class="border border-success px-2 py-1 ml-2 text-success rounded small font-weight-bold">Wajib
                                        untuk transaksi masuk</span>
                                </label>
                                <select name="pemasok" class="form-control @error('pemasok') is-invalid @enderror"
                                    id="pemasok" aria-label="Default select example">
                                    <option selected disabled>Pilih Pemasok</option>
                                    @forelse ($pemasoks as $pemasok)
                                        <option value="{{ $pemasok->id }}"
                                            {{ old('pemasok', $transaksi->pemasok_id) == $pemasok->id ? 'selected' : '' }}>
                                            {{ $pemasok->nama_pemasok }}
                                        </option>
                                    @empty
                                        <option disabled>
                                            Pemasok Belum Ada
                                        </option>
                                    @endforelse
                                </select>
                                @error('pemasok')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="jumlahBarang" class="form-label font-weight-bold">Jumlah Barang</label>
                                <input type="number" name="jumlahBarang"
                                    value="{{ old('jumlahBarang', $transaksi->jumlah) }}"
                                    class="form-control @error('jumlahBarang') is-invalid @enderror" id="jumlahBarang"
                                    placeholder="Masukkan Jumlah Barang" min="1">
                                @error('jumlahBarang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <a href="{{ route('stok.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left fa-sm"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-success loading-indicator">
                                <i class="fas fa-check fa-sm text-white-100 icon-default"></i>
                                <span class="spinner-border spinner-border-sm spinner-loading" role="status"
                                    aria-hidden="true" style="display: none;"></span>
                                <span class="btn-text"> Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi Saat Ini</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="font-weight-bold text-muted">Barang:</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                @if ($transaksi->barang->foto_barang)
                                    <img src="{{ URL::asset('storage/' . $transaksi->barang->foto_barang) }}"
                                        alt="{{ $transaksi->barang->kode_barang }}" width="40" height="40"
                                        class="rounded shadow mr-2">
                                @else
                                    <img src="{{ URL::asset('assets/img/default-foto-barang.png') }}" alt="No Image"
                                        width="40" height="40" class="rounded shadow mr-2">
                                @endif
                                <div>
                                    <div class="font-weight-bold">{{ $transaksi->barang->kode_barang }}</div>
                                    <small class="text-muted">{{ $transaksi->barang->nama_barang }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($transaksi->pemasok)
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label class="font-weight-bold text-muted">Pemasok:</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="font-weight-bold">{{ $transaksi->pemasok->nama_pemasok }}</div>
                                <small class="text-muted">{{ $transaksi->pemasok->kode_pemasok ?? '' }}</small>
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="font-weight-bold text-muted">Tipe Transaksi:</label>
                        </div>
                        <div class="col-sm-6">
                            <span
                                class="badge badge-{{ $transaksi->tipe_transaksi === 'masuk' ? 'success' : 'danger' }} p-2">
                                <i
                                    class="fas fa-{{ $transaksi->tipe_transaksi === 'masuk' ? 'arrow-down' : 'arrow-up' }}"></i>
                                {{ ucfirst($transaksi->tipe_transaksi) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="font-weight-bold text-muted">Jumlah:</label>
                        </div>
                        <div class="col-sm-6">
                            <span class="badge badge-dark p-2">{{ $transaksi->jumlah }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="font-weight-bold text-muted">Status:</label>
                        </div>
                        <div class="col-sm-6">
                            <span
                                class="badge badge-{{ $transaksi->status_transaksi === 'Disetujui' ? 'success' : 'warning' }} p-2">
                                {{ $transaksi->status_transaksi }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="font-weight-bold text-muted">Stok Saat Ini:</label>
                        </div>
                        <div class="col-sm-6">
                            <span class="badge badge-info p-2">{{ $transaksi->barang->stok_final ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="font-weight-bold text-muted">Dibuat oleh:</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="font-weight-bold">{{ $transaksi->user->name }}</div>
                            <small class="text-muted">{{ $transaksi->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const jenisTransaksiSelect = document.getElementById('jenisTransaksi');
                const pemasokField = document.getElementById('pemasokField');
                const pemasokSelect = document.getElementById('pemasok');

                function togglePemasokField() {
                    const selectedJenis = jenisTransaksiSelect.value;

                    if (selectedJenis === 'masuk') {
                        pemasokField.style.display = 'block';
                        pemasokSelect.required = true;
                    } else if (selectedJenis === 'keluar') {
                        pemasokField.style.display = 'none';
                        pemasokSelect.required = false;
                        pemasokSelect.selectedIndex = 0; // Reset selection
                    }
                }

                jenisTransaksiSelect.addEventListener('change', togglePemasokField);

                // Form validation
                const form = document.querySelector('.needs-validation');
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });

                // Loading indicator
                const loadingButton = document.querySelector('.loading-indicator');
                if (loadingButton) {
                    loadingButton.addEventListener('click', function() {
                        const spinner = this.querySelector('.spinner-loading');
                        const icon = this.querySelector('.icon-default');
                        const text = this.querySelector('.btn-text');

                        if (spinner && icon && text) {
                            this.disabled = true;
                            spinner.style.display = 'inline-block';
                            icon.style.display = 'none';
                            text.textContent = ' Menyimpan...';

                            setTimeout(() => {
                                this.disabled = false;
                                spinner.style.display = 'none';
                                icon.style.display = 'inline-block';
                                text.textContent = ' Simpan Perubahan';
                            }, 5000);
                        }
                    });
                }
            });
        </script>
    @endpush
</x-layouts.dashboard>
