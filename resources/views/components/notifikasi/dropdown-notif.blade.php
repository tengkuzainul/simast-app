<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle text-white" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw text-white"></i>
        <!-- Counter - Alerts -->
        <span id="notif-count" class="badge badge-danger badge-counter">{{ $notifs->count() }}</span>
    </a>

    <!-- Dropdown - Alerts -->
    <div id="notif-list" class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header bg-dark">Notifikasi</h6>
        <div id="notif-items">
            @forelse ($notifs as $data)
                <a class="dropdown-item d-flex align-items-center" href="#"
                    onclick="markAsReadThenRedirect({{ $data->id }}, '{{ route('notifikasi.show', $data->id) }}')">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-bell text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-gray-500">{{ $data->created_at->diffForHumans() }}</div>
                            <div class="small text-gray-800 text-capitalize">{{ $data->status }}</div>
                        </div>
                        <p class="font-weight-bold mb-0">{{ $data->title }}</p>
                        <span class="font-weight-light">{{ $data->message }}</span>
                    </div>
                </a>
            @empty
                <p class="dropdown-item d-flex align-items-center justify-content-center">Tidak Ada Notifikasi.</p>
            @endforelse
        </div>
        <a class="dropdown-item text-center small text-gray-500" href="{{ route('notifikasi.index') }}">
            <i class="fas fa-list mr-1"></i>
            Lihat Semua Notifikasi
        </a>
    </div>

    @push('script-notifications')
        <script>
            let prevCount = 0;

            async function fetchNotifikasi() {
                try {
                    const response = await fetch('/notifikasi/latest');
                    const notifs = await response.json();

                    const notifCount = document.getElementById('notif-count');
                    const notifList = document.getElementById('notif-items');

                    notifCount.textContent = notifs.length;
                    notifList.innerHTML = '';

                    if (notifs.length === 0) {
                        notifList.innerHTML = `
                        <p class="dropdown-item d-flex align-items-center justify-content-center">
                            Tidak Ada Notifikasi.
                        </p>`;
                    } else {
                        notifs.forEach(data => {
                            const time = new Date(data.created_at).toLocaleString('id-ID');
                            const item = `
                            <a class="dropdown-item d-flex align-items-center" href="#"
                                onclick="markAsReadThenRedirect(${data.id}, '/notifikasi/${data.id}')">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-bell text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="small text-gray-500">${time}</div>
                                        <div class="small text-gray-800 text-capitalize">${data.status}</div>
                                    </div>
                                    <p class="font-weight-bold mb-0">${data.title}</p>
                                    <span class="font-weight-light">${data.message}</span>
                                </div>
                            </a>`;
                            notifList.insertAdjacentHTML('beforeend', item);
                        });

                        // Tambahkan link "Lihat Semua" di akhir
                        notifList.insertAdjacentHTML('beforeend', `
                            <a class="dropdown-item text-center small text-gray-500" href="/notifikasi">
                                <i class="fas fa-list mr-1"></i>
                                Lihat Semua Notifikasi
                            </a>
                        `);
                    }

                    prevCount = notifs.length;
                } catch (err) {
                    console.error('Gagal fetch notifikasi:', err);
                }
            }

            function markAsReadThenRedirect(id, redirectUrl) {
                fetch(`/notifikasi/read/${id}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = redirectUrl;
                        }
                    })
                    .catch(err => console.error('Gagal update notifikasi:', err));
            }

            // Jalankan awal dan polling tiap 10 detik
            fetchNotifikasi();
            setInterval(fetchNotifikasi, 20000);
        </script>
    @endpush
</li>
