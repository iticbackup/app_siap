<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="public/auths/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="public/auths/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="public/auths/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="public/auths/css/iofrm-theme17.css">
</head>
<body>
    <div class="form-body without-side">
        <div class="website-logo">
            <a href="{{ route('login') }}">
                <div class="logo">
                    <img class="logo-size" src="{{ asset('public/logo/sima.png') }}" alt="">
                </div>
            </a>
        </div>
        @yield('content_auth')
    </div>
</body>
<script src="public/auths/js/jquery.min.js"></script>
<script src="public/auths/js/popper.min.js"></script>
<script src="public/auths/js/bootstrap.min.js"></script>
<script src="public/auths/js/main.js"></script>
</html>