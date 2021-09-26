<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('3S.png') }}"/>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('style')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <!-- Navbar -->
    <x-navbar></x-navbar>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <x-sidebar></x-sidebar>

    <!-- Content Wrapper. Contains page content -->
    @yield('body')
    <!-- /.content-wrapper -->

    <x-footer></x-footer>

</div>
<!-- ./wrapper -->

<!-- Additional Scripts -->
@include('sweetalert::alert')
@stack('script')

</body>
</html>
