<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="{{ URL::asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/css/metisMenu.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link rel="stylesheet" href="https://mannatthemes.com/dastone/default/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://mannatthemes.com/dastone/default/assets/css/icons.min.css">
    <link rel="stylesheet" href="https://mannatthemes.com/dastone/default/assets/css/metisMenu.min.css">
    <link rel="stylesheet" href="https://mannatthemes.com/dastone/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://mannatthemes.com/dastone/default/assets/css/app.min.css"> --}}
    @yield('css')
</head>
<body class="dark-sidenav">
    @include('layouts.apps.sidebar')
    <div class="page-wrapper">
        @include('layouts.apps.topbar')
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            @include('layouts.apps.footer')
        </div>
    </div>

    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/waves.js') }}"></script>
    <script src="{{ asset('public/assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/moment.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('public/assets/js/app.js') }}"></script>
    {{-- <script src="https://mannatthemes.com/dastone/default/assets/js/jquery.min.js"></script>
    <script src="https://mannatthemes.com/dastone/default/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://mannatthemes.com/dastone/default/assets/js/metismenu.min.js"></script>
    <script src="https://mannatthemes.com/dastone/default/assets/js/waves.js"></script>
    <script src="https://mannatthemes.com/dastone/default/assets/js/feather.min.js"></script>
    <script src="https://mannatthemes.com/dastone/default/assets/js/simplebar.min.js"></script>
    <script src="https://mannatthemes.com/dastone/default/assets/js/moment.js"></script>
    <script src="https://mannatthemes.com/dastone/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="https://mannatthemes.com/dastone/default/assets/js/app.js"></script> --}}
    @yield('script')
</body>
</html>