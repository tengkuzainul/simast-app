<x-base :title="__('Login')">
    <div class="bg-gradient-secondary">
        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center align-items-center vh-100">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"
                                    style="background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20210903/pngtree-clothing-store-casual-fashion-mens-photography-photos-with-pictures-image_796891.jpg'); background-size: cover; background-position: center; backdrop-filter: blur(5px); background-color: rgba(0, 0, 0, 0.5); background-blend-mode: darken;">
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4 fw-bold">SIMAST APP</h1>
                                            <p class="small">
                                                Silahkan masukkan email dan password untuk masuk ke akun anda 😊
                                            </p>
                                        </div>

                                        {{ $slot }}

                                        <div class="text-center">
                                            <p class="small">&copy; <a href="{{ route('login') }}">Sistem
                                                    Informasi Manajemen Stok</a> &mdash; Rizki Ananda
                                                Store, All rights reserved.</p>
                                            <p class="small">{{ now()->format('Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-base>
