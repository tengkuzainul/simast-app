<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>

        <div class="d-flex align-items-center" style="gap: 10px">
            <form method="POST" action="{{ route('notifikasi.mark-all-read') }}" style="display: inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="fas fa-check-double fa-sm"></i>
                    Tandai Semua Dibaca
                </button>
            </form>
        </div>
    </div>

    <!-- Notifications List Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                </div>
                <div class="col-md-6 text-right">
                    <span class="badge badge-info p-2">
                        Total: {{ $notifikasis->total() }} notifikasi
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($notifikasis->count() > 0)
                <div class="list-group">
                    @foreach ($notifikasis as $notifikasi)
                        <div
                            class="list-group-item list-group-item-action {{ $notifikasi->status === 'Unread' ? 'list-group-item-warning' : '' }}">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="icon-circle bg-{{ $notifikasi->status === 'Unread' ? 'warning' : 'secondary' }} mr-3">
                                            <i
                                                class="fas fa-{{ $notifikasi->status === 'Unread' ? 'bell' : 'bell-slash' }} text-white"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 font-weight-bold">{{ $notifikasi->title }}</h6>
                                            <p class="mb-1 text-gray-700">{{ Str::limit($notifikasi->message, 100) }}
                                            </p>
                                            <small class="text-muted">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $notifikasi->created_at->diffForHumans() }}
                                                •
                                                <span
                                                    class="text-capitalize badge badge-{{ $notifikasi->status === 'Unread' ? 'warning' : 'success' }} badge-sm">
                                                    {{ $notifikasi->status === 'Unread' ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                                                </span>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center" style="gap: 5px">
                                    <a href="{{ route('notifikasi.show', $notifikasi->id) }}"
                                        class="btn btn-sm btn-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($notifikasi->status === 'Unread')
                                        <form method="POST"
                                            action="{{ route('notifikasi.mark-read', $notifikasi->id) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success" title="Tandai Dibaca">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('notifikasi.destroy', $notifikasi->id) }}"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus notifikasi ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $notifikasis->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-bell-slash fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Tidak Ada Notifikasi</h5>
                    <p class="text-muted">Belum ada notifikasi untuk ditampilkan</p>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .icon-circle {
                height: 2.5rem;
                width: 2.5rem;
                border-radius: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .list-group-item-warning {
                border-left: 4px solid #f6c23e;
            }

            .list-group-item:hover {
                background-color: #f8f9fc;
            }

            .badge-sm {
                font-size: 0.7rem;
                padding: 0.2rem 0.5rem;
            }
        </style>
    @endpush
</x-layouts.dashboard>
