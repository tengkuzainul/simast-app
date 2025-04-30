<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>

    <!-- Card Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
        </div>
        <div class="card-body">
            <form enctype="multipart/form-data" method="POST" action="{{ route('laporan.rekap') }}">
                @csrf
                <div class="row">
                    <div class="col-4 mb-3">
                        <label for="tglAwal" class="form-label font-weight-bold">Masukkan Tanggal Awal Laporan <span
                                class="text-danger">*</span></label>
                        <input type="date" name="tglAwal" value="{{ old('tglAwal') }}"
                            class="form-control @error('tglAwal') is-invalid @enderror" id="tglAwal" placeholder="">
                        @error('tglAwal')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-4 mb-3">
                        <label for="tglAkhir" class="form-label font-weight-bold">Masukkan Tanggal Akhir Laporan <span
                                class="text-danger">*</span></label>
                        <input type="date" name="tglAkhir" value="{{ old('tglAkhir') }}"
                            class="form-control @error('tglAkhir') is-invalid @enderror" id="tglAkhir" placeholder="">
                        @error('tglAkhir')
                            <div class="valid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-4 mb-3">
                        <label for="jenisTransaksi" class="form-label font-weight-bold">Pilih Jenis Transaksi <span
                                class="text-danger">*</span></label>
                        <select name="jenisTransaksi" class="form-control @error('jenisTransaksi') is-invalid @enderror"
                            id="jenisTransaksi" aria-label="Default select example">
                            <option selected disabled>Pilih Jenis Transaksi</option>
                            @foreach (['masuk', 'keluar'] as $jenis)
                                <option value="{{ $jenis }}"
                                    {{ old('jenisTransaksi') == $jenis ? 'selected' : '' }} class="text-capitalize">
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
                </div>
                <div class="my-3 flex flex-column" style="gap: 15px">
                    <h5 class="font-weight-bold">Filter Cetak Laporan :</h5>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="barang" class="form-label font-weight-bold">Pilih Barang</label>
                            <select name="barang" class="form-control @error('barang') is-invalid @enderror"
                                id="barang" aria-label="Default select example">
                                <option selected disabled>Pilih Barang</option>
                                @forelse ($barangs as $barang)
                                    <option value="{{ $barang->id }}"
                                        {{ old('barang' == $barang->id ? 'selected' : '') }}>
                                        {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                    </option>
                                @empty
                                    <option disabled>
                                        Barang Belum Ada
                                    </option>
                                @endforelse
                            </select>
                            @error('barang')
                                <div class="valid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="pemasok" class="form-label font-weight-bold">Pilih Pemasok</label>
                            <select name="pemasok" class="form-control @error('pemasok') is-invalid @enderror"
                                id="pemasok" aria-label="Default select example">
                                <option selected disabled>Pilih Pemasok</option>
                                @forelse ($pemasoks as $pemasok)
                                    <option value="{{ $pemasok->id }}"
                                        {{ old('barang' == $pemasok->id ? 'selected' : '') }}>
                                        {{ $pemasok->nama_pemasok }}
                                    </option>
                                @empty
                                    <option disabled>
                                        Barang Belum Ada
                                    </option>
                                @endforelse
                            </select>
                            @error('pemasok')
                                <div class="valid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="badge border border-danger w-100 p-2 rounded">
                        <span class="font-weight-bold text-danger" style="font-size: 1rem">Informasi : Jika Mengisi
                            Filter
                            Maka
                            Data Yang Di
                            Cetak
                            Sesuai Dengan Filter Bukan Seluruh Data Yang Ada!</span>
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

</x-layouts.dashboard>
