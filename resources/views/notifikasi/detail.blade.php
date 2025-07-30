<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('notifikasi.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left fa-sm"></i>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Notification Detail Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 bg-{{ $notifikasi->status === 'Unread' ? 'warning' : 'success' }} text-white">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white mr-3">
                            <i
                                class="fas fa-bell text-{{ $notifikasi->status === 'Unread' ? 'warning' : 'success' }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="m-0 font-weight-bold">{{ $notifikasi->title }}</h6>
                            <small>
                                Status:
                                <span class="badge badge-light">
                                    {{ $notifikasi->status === 'Unread' ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                                </span>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="notification-content">
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-info-circle mr-2"></i>
                                Pesan Notifikasi
                            </h5>
                            <div class="alert alert-light border-left-primary">
                                <p class="mb-0">{{ $notifikasi->message }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <h6 class="text-secondary mb-2">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        Tanggal & Waktu
                                    </h6>
                                    <p class="mb-0">
                                        <strong>Dibuat:</strong>
                                        {{ $notifikasi->created_at->translatedFormat('l, d F Y - H:i:s') }} WIB
                                    </p>
                                    <p class="mb-0 text-muted">
                                        <small>{{ $notifikasi->created_at->diffForHumans() }}</small>
                                    </p>
                                    @if ($notifikasi->updated_at != $notifikasi->created_at)
                                        <p class="mb-0 mt-2">
                                            <strong>Terakhir Update:</strong>
                                            {{ $notifikasi->updated_at->translatedFormat('l, d F Y - H:i:s') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <h6 class="text-secondary mb-2">
                                        <i class="fas fa-users mr-2"></i>
                                        Target Role
                                    </h6>
                                    <span class="badge badge-info p-2">
                                        <i class="fas fa-user-tag mr-1"></i>
                                        {{ $notifikasi->target_role }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @if ($notifikasi->status === 'Unread')
                                <form method="POST" action="{{ route('notifikasi.mark-read', $notifikasi->id) }}"
                                    style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm mr-2">
                                        <i class="fas fa-check mr-1"></i>
                                        Tandai Sudah Dibaca
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('notifikasi.destroy', $notifikasi->id) }}"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus notifikasi ini?')">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus Notifikasi
                                </button>
                            </form>
                        </div>
                        <div class="text-muted">
                            <small>
                                <i class="fas fa-hashtag mr-1"></i>
                                ID: {{ $notifikasi->id }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informasi Tambahan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item mb-3">
                        <label class="font-weight-bold text-muted">Status Notifikasi:</label>
                        <div class="mt-1">
                            @if ($notifikasi->status === 'Unread')
                                <span class="badge badge-warning p-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Belum Dibaca
                                </span>
                            @else
                                <span class="badge badge-success p-2">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Sudah Dibaca
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item mb-3">
                        <label class="font-weight-bold text-muted">Jenis Notifikasi:</label>
                        <div class="mt-1">
                            @if (Str::contains($notifikasi->title, 'Transaksi'))
                                <span class="badge badge-primary p-2">
                                    <i class="fas fa-exchange-alt mr-1"></i>
                                    Transaksi Stok
                                </span>
                            @elseif(Str::contains($notifikasi->title, 'Status'))
                                <span class="badge badge-info p-2">
                                    <i class="fas fa-sync-alt mr-1"></i>
                                    Update Status
                                </span>
                            @else
                                <span class="badge badge-secondary p-2">
                                    <i class="fas fa-bell mr-1"></i>
                                    Umum
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item mb-3">
                        <label class="font-weight-bold text-muted">Waktu Relatif:</label>
                        <div class="mt-1">
                            <i class="fas fa-clock text-muted mr-1"></i>
                            {{ $notifikasi->created_at->diffForHumans() }}
                        </div>
                    </div>

                    @if (Str::contains($notifikasi->message, 'barang'))
                        <div class="info-item">
                            <label class="font-weight-bold text-muted">Tindakan yang Disarankan:</label>
                            <div class="mt-2">
                                <a href="{{ route('stok.index') }}" class="btn btn-outline-primary btn-sm btn-block">
                                    <i class="fas fa-list mr-1"></i>
                                    Lihat Daftar Transaksi
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt mr-2"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('notifikasi.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list mr-1"></i>
                            Semua Notifikasi
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-home mr-1"></i>
                            Dashboard
                        </a>
                        @if (Str::contains($notifikasi->message, 'barang'))
                            <a href="{{ route('stok.form') }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-plus mr-1"></i>
                                Transaksi Baru
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .icon-circle {
                height: 3rem;
                width: 3rem;
                border-radius: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .notification-content {
                font-size: 16px;
                line-height: 1.6;
            }

            .info-box {
                background: #f8f9fc;
                border-radius: 8px;
                padding: 15px;
                border-left: 4px solid #5a5c69;
            }

            .info-item {
                border-bottom: 1px solid #e3e6f0;
                padding-bottom: 15px;
            }

            .info-item:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }

            .border-left-primary {
                border-left: .25rem solid #4e73df !important;
            }

            .d-grid {
                display: grid;
            }

            .gap-2 {
                gap: 0.5rem;
            }
        </style>
    @endpush
</x-layouts.dashboard>
