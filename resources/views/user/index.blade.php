<x-layouts.dashboard :title="$title" :breadcrumbs="$breadcrumbs">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('user.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna & Email</th>
                            <th>Username</th>
                            <th>Level Pengguna</th>
                            <th>Aktivitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr id="{{ $user->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ $usr->name ?? __('Owner') }}&background=4C585B&color=fff&rounded=true"
                                            alt="Foto Pengguna" class="rounded-circle" width="30" height="30">
                                        <div class="ml-2 d-flex flex-column">
                                            <span class="mb-0 font-weight-bold text-gray-800">{{ $user->name }}</span>
                                            <span class="mb-0 font-weight-thin text-gray-800">{{ $user->email }}</span>
                                        </div>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <span
                                        class="badge text-white p-2 bg-{{ $user->role == 'Owner' ? 'primary' : 'secondary' }}">{{ $user->role }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        <span class="mb-0">{{ $user->last_login_at ?? 'Belum Pernah Login' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('user.destroy', $user->id) }}" class="btn btn-danger btn-sm"
                                            data-confirm-delete="true">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Username</th>
                            <th>Level Pengguna</th>
                            <th>Aktivitas</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
