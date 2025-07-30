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
                    <h6 class="m-0 font-weight-bold text-primary">Pilih Jenis {{ $title }}</h6>
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('stok.pilih-jenis') }}"
                        class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="jenisTransaksi" class="form-label font-weight-bold">Pilih Jenis
                                    Transaksi</label>
                                <select name="jenisTransaksi"
                                    class="form-control @error('jenisTransaksi') is-invalid @enderror"
                                    id="jenisTransaksi" aria-label="Default select example"
                                    {{ $jenisTransaksi ? 'disabled' : '' }}>
                                    <option selected disabled>Pilih Jenis Transaksi</option>
                                    @foreach (['masuk', 'keluar'] as $jenis)
                                        <option value="{{ $jenis }}"
                                            {{ old('jenisTransaksi', $jenisTransaksi) == $jenis ? 'selected' : '' }}
                                            class="text-capitalize">
                                            {{ ucfirst($jenis) }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($jenisTransaksi)
                                    <input type="hidden" name="jenisTransaksi" value="{{ $jenisTransaksi }}">
                                    <small class="text-success font-weight-bold">
                                        <i class="fas fa-check-circle"></i> Jenis transaksi: <span
                                            class="text-capitalize">{{ $jenisTransaksi }}</span>
                                    </small>
                                @endif
                                @error('jenisTransaksi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            @if (!$jenisTransaksi)
                                <button type="submit" class="btn btn-success loading-indicator">
                                    <i class="fas fa-check fa-sm text-white-100 icon-default"></i>
                                    <span class="spinner-border spinner-border-sm spinner-loading" role="status"
                                        aria-hidden="true" style="display: none;"></span>
                                    <span class="btn-text"> Pilih Jenis Transaksi</span>
                                </button>
                            @else
                                <a href="{{ route('stok.form') }}" class="btn btn-warning">
                                    <i class="fas fa-edit fa-sm"></i>
                                    Ubah Jenis Transaksi
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if ($jenisTransaksi)
            <div class="col-md-6 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $title }} - <span
                                class="text-capitalize">{{ $jenisTransaksi }}</span></h6>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" method="POST"
                            action="{{ route('stok.add-to-cart', ['jenis' => $jenisTransaksi]) }}"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="kodeTransaksi" class="form-label font-weight-bold">Kode Transaksi <span
                                            class="text-danger border border-danger px-2 rounded">Dibuat
                                            Otomatis</span></label>
                                    <input type="text" name="kodeTransaksi"
                                        value="{{ old('kodeTransaksi', $kodeTransaksi) }}"
                                        class="form-control @error('kodeTransaksi') is-invalid @enderror"
                                        id="kodeTransaksi" placeholder="Masukkan Kode Barang" readonly disabled>
                                    @error('kodeTransaksi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="barang" class="form-label font-weight-bold">Pilih Barang</label>
                                    <select name="barang" class="form-control @error('barang') is-invalid @enderror"
                                        id="barang" aria-label="Default select example">
                                        <option selected disabled>Pilih Barang</option>
                                        @forelse ($barangs as $barang)
                                            <option value="{{ $barang->id }}"
                                                {{ old('barang') == $barang->id ? 'selected' : '' }}>
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

                                @if ($jenisTransaksi === 'masuk')
                                    <div class="col-6 mb-3">
                                        <label for="pemasok" class="form-label font-weight-bold">Pilih Pemasok
                                            <span
                                                class="border border-success px-2 py-1 ml-2 text-success rounded small font-weight-bold">Wajib
                                                untuk transaksi masuk</span>
                                        </label>
                                        <select name="pemasok"
                                            class="form-control @error('pemasok') is-invalid @enderror" id="pemasok"
                                            aria-label="Default select example">
                                            <option selected disabled>Pilih Pemasok</option>
                                            @forelse ($pemasoks as $pemasok)
                                                <option value="{{ $pemasok->id }}"
                                                    {{ old('pemasok') == $pemasok->id ? 'selected' : '' }}>
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
                                @endif

                                <div class="col-6 mb-3">
                                    <label for="jumlahBarang" class="form-label font-weight-bold">Jumlah Barang</label>
                                    <input type="number" name="jumlahBarang" value="{{ old('jumlahBarang') }}"
                                        class="form-control @error('jumlahBarang') is-invalid @enderror"
                                        id="jumlahBarang" placeholder="Masukkan Jumlah Barang" min="1">
                                    @error('jumlahBarang')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center mt-3">
                                <button type="submit" class="btn btn-success loading-indicator">
                                    <i class="fas fa-plus fa-sm text-white-100 icon-default"></i>
                                    <span class="spinner-border spinner-border-sm spinner-loading" role="status"
                                        aria-hidden="true" style="display: none;"></span>
                                    <span class="btn-text"> Tambah ke Keranjang</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @if ($jenisTransaksi)
            <div class="col-md-6 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Keranjang Transaksi
                            {{ ucfirst($jenisTransaksi) }}</h6>
                        <div>
                            @if (!empty($cartItems))
                                <form method="POST" action="{{ route('stok.clear-cart') }}"
                                    style="display: inline;" class="mr-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-warning"
                                        onclick="return confirm('Kosongkan semua keranjang?')">
                                        <i class="fas fa-trash-alt fa-sm"></i> Kosongkan
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('stok.process') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-save fa-sm"></i> Proses Semua
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if (!empty($cartItems))
                            @foreach ($cartItems as $key => $item)
                                <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ URL::asset('assets/img/default-foto-barang.png') }}"
                                            alt="default" width="50" height="50"
                                            class="rounded border shadow">
                                        <div class="ml-3">
                                            <h6 class="text-dark font-weight-bold mb-1">{{ $item['barang_nama'] }}
                                            </h6>
                                            <p class="text-muted small mb-1">{{ $item['barang_kode'] }}</p>
                                            @if ($item['pemasok_nama'])
                                                <p class="text-info small mb-1">Pemasok: {{ $item['pemasok_nama'] }}
                                                </p>
                                            @endif
                                            <p class="text-primary font-weight-bold mb-0">
                                                @if (isset($item['barang_harga']) && $item['barang_harga'] > 0)
                                                    Rp. {{ number_format($item['barang_harga'], 0, ',', '.') }} &mdash;
                                                @endif
                                                x {{ $item['jumlah'] }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <form method="POST" action="{{ route('stok.remove-from-cart', $key) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus item ini dari keranjang?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            <div class="text-center mt-3">
                                <p class="text-muted">Total: {{ count($cartItems) }} item dalam keranjang</p>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Keranjang transaksi kosong</p>
                                <small class="text-muted">Tambahkan barang menggunakan form di sebelah kiri</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-6 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Barang Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <p class="text-muted">Pilih jenis transaksi terlebih dahulu</p>
                            <small class="text-muted">Gunakan form di atas untuk memilih jenis transaksi
                                (masuk/keluar)</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/transaksi-stok.js') }}"></script>
    @endpush
</x-layouts.dashboard>
