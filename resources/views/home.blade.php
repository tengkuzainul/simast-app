<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-dark shadow-sm"
            onclick="event.preventDefault(); runConfetti();">
            <i class="fas fa-smile fa-sm"></i> Hallo, {{ Auth::user()->name }}
        </a>

        <script>
            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            function runConfetti() {
                if (typeof confetti === "function") {
                    confetti({
                        angle: randomInRange(55, 125),
                        spread: randomInRange(50, 70),
                        particleCount: randomInRange(50, 100),
                        origin: {
                            y: 0.6
                        }
                    });
                } else {
                    alert('Confetti library is not loaded.');
                }
            }
        </script>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Pengguna
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $countPengguna }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Jumlah Kategori Barang
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $countPemasok }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Barang
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $countKatgeoriBarang }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Jumlah Pemasok
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $countBarang }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shipping-fast fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Transaksi Stok Masuk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $countTransaksiMasuk }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Jumlah Transaksi Stok Keluar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $countTransaksiKeluar }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="far fa-chart-bar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-center">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? __('Owner') }}&background=4C585B&color=fff&rounded=true"
                            class="rounded-circle mb-3" alt="Profile Picture" width="100" height="100">
                        <h5 class="font-weight-bold text-gray-800">{{ Auth::user()->name ?? __('Owner') }}</h5>
                        <p class="text-muted mb-1 text-capitalize">{{ Auth::user()->role ?? __('Owner') }}</p>
                        <p class="text-muted">{{ Auth::user()->email ?? __('Owner') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="font-weight-bold text-gray-800 mb-3">Navigasi Cepat</h5>
                    <div class="row">
                        @assignRole('Owner')
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('user.index') }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-users"></i> Manajemen Pengguna
                                </a>
                            </div>
                        @endassignRole
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-boxes"></i> Manajemen Kategori Barang
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('barang.index') }}" class="btn btn-success btn-block">
                                <i class="fas fa-box"></i> Manajemen Barang
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('pemasok.index') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-shipping-fast"></i> Manajemen Pemasok
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('stok.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-money-bill-wave"></i> Manajemen Stok
                            </a>
                        </div>
                        @assignRole('Owner')
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('laporan.form') }}" class="btn btn-danger btn-block">
                                    <i class="fas fa-file"></i> Buat Laporan
                                </a>
                            </div>
                        @endassignRole
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Session::has('confeti'))
        @push('script-confeti')
            <script>
                const duration = 5 * 1000,
                    animationEnd = Date.now() + duration,
                    defaults = {
                        startVelocity: 30,
                        spread: 360,
                        ticks: 60,
                        zIndex: 0
                    };

                function randomInRange(min, max) {
                    return Math.random() * (max - min) + min;
                }

                const interval = setInterval(function() {
                    const timeLeft = animationEnd - Date.now();

                    if (timeLeft <= 0) {
                        return clearInterval(interval);
                    }

                    const particleCount = 50 * (timeLeft / duration);

                    // since particles fall down, start a bit higher than random
                    confetti(
                        Object.assign({}, defaults, {
                            particleCount,
                            origin: {
                                x: randomInRange(0.1, 0.3),
                                y: Math.random() - 0.2
                            },
                        })
                    );
                    confetti(
                        Object.assign({}, defaults, {
                            particleCount,
                            origin: {
                                x: randomInRange(0.7, 0.9),
                                y: Math.random() - 0.2
                            },
                        })
                    );
                }, 250);
            </script>
        @endpush
    @endif
</x-layouts.dashboard>
