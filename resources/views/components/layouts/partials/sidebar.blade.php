<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-store"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            <span class="flex flex-column gap-0">
                <span class="mb-0">SiMast - App</span>
                <span style="font-size: 7px">Rizki Ananda Store</span>
            </span>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Menu</div>

    @assignRole('Owner')
        <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Data Pengguna</span></a>
        </li>
    @endassignRole

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('kategori*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
            data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-list"></i>
            <span>Data Master</span>
        </a>
        <div id="collapseTwo"
            class="collapse {{ request()->is('kategori*') || request()->is('barang*') || request()->is('pemasok*') ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6
                    class="collapse-header {{ request()->is('kategori*') || request()->is('barang*') || request()->is('pemasok*') ? 'text-primary' : '' }}">
                    Data &rarr;</h6>
                <a class="collapse-item {{ request()->is('kategori*') ? 'active' : '' }}"
                    href="{{ route('kategori.index') }}">Kategori Barang</a>
                <a class="collapse-item  {{ request()->is('barang*') ? 'active' : '' }}"
                    href="{{ route('barang.index') }}">Barang</a>
                <a class="collapse-item  {{ request()->is('pemasok*') ? 'active' : '' }}"
                    href="{{ route('pemasok.index') }}">Pemasok</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ request()->is('manajemen-stok*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('manajemen-stok*') ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true"
            aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Manajemen Stok</span>
        </a>
        <div id="collapseUtilities" class="collapse {{ request()->is('manajemen-stok*') ? 'show' : '' }}"
            aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header {{ request()->is('manajemen-stok*') ? 'text-primary' : '' }}">
                    Data &rarr;</h6>

                @assignRole('Op-Gudang')
                    <a class="collapse-item {{ request()->routeIs('stok.form') ? 'active' : '' }}"
                        href="{{ route('stok.form') }}">Transaksi Stok</a>
                @endassignRole

                <a class="collapse-item {{ request()->routeIs('stok.index') ? 'active' : '' }}"
                    href="{{ route('stok.index') }}">Data Transaksi</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Laporan</div>
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-file"></i>
            <span>Data Laporan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
