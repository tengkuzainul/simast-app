<x-base :title="$title ?? __('Dashboard')">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <x-layouts.partials.sidebar />
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Navbar -->
                <x-layouts.partials.navbar :breadCrumbs="$breadcrumbs ?? []" />
                <!-- End of Navbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    {{ $slot }}
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Sistem Manajemen Stok &mdash; SIMAST - APP
                            {{ now()->format('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <x-layouts.partials.modal-logout />
</x-base>
