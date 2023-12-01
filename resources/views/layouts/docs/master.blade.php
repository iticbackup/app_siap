<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Documentation SIMA</title>
    <link href="{{ URL::asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/css/metisMenu.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    @yield('css')
</head>
<body class="dark-sidenav">
    @include('layouts.docs.sidebar')
    <div class="page-wrapper">
        @include('layouts.docs.topbar')
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/moment.js') }}"></script>
    <script src="{{ asset('public/assets/js/app.js') }}"></script>
    @yield('script')
</body>
</html>