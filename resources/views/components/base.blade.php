<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ config('app.name', 'Laravel') }}">
    <meta name="author" content="{{ config('app.name', 'Laravel') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/fav-logo.png') }}" type="image/x-icon">

    @if (request()->routeIs('login'))
        <!-- Custom fonts for this template-->
        <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    @else
        <!-- Custom fonts for this template-->
        <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet" />

        <!-- Custom styles for this template-->
        <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet" />

        <!-- Custom styles for this page -->
        <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endif

    <title>SiMast App &mdash; {{ $title ?? __('Page Title') }}</title>
</head>

<body>

    @include('sweetalert::alert')

    {{ $slot }}

    <!-- JS Utama untuk semua halaman -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

    <!-- JS khusus halaman tertentu -->
    @switch(true)
        @case(request()->routeIs('home'))
            <!-- Chart.js (Dashboard) -->
            <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
            <script src="{{ asset('assets/js/demo/chart-area-demo.js') }}"></script>
            <script src="{{ asset('assets/js/demo/chart-pie-demo.js') }}"></script>
        @break

        @case(request()->is('kategori*') || request()->is('user*') || request()->is('barang*') || request()->is('pemasok*'))
            <!-- DataTables (Kategori) -->
            <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>
        @break
    @endswitch


</body>

</html>
