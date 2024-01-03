<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Absensi</title>
    @php
        $assets = asset('public/absensi/login/');
    @endphp
    <link rel="stylesheet" type="text/css" href="{{ $assets }}/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $assets }}/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $assets }}/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="{{ $assets }}/css/iofrm-theme2.css">
</head>
<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="{{ route('absensi.login') }}">
                <div class="logo">
                    <img class="logo-size" src="{{ $assets }}/images/logo_itic.png">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">

                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>ITIC - Absensi</h3>
                        {{-- <p>Access to the most powerfull tool in the entire design and web industry.</p> --}}
                        <div class="page-links">
                            <a href="javascript:void()" class="active">Login</a>
                        </div>
                        <form method="POST" action="{{ route('absensi.login.post') }}">
                            @csrf
                            <input class="form-control" type="text" name="username" placeholder="Username" required>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            {{-- <input type="checkbox" id="chk1"><label for="chk1">Remmeber me</label> --}}
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button>
                                {{-- <a href="forget2.html">Forget password?</a> --}}
                            </div>
                        </form>
                        {{-- <div class="other-links">
                            <span>Or login with</span><a href="#">Facebook</a><a href="#">Google</a><a href="#">Linkedin</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ $assets }}/js/jquery.min.js"></script>
    <script src="{{ $assets }}/js/popper.min.js"></script>
    <script src="{{ $assets }}/js/bootstrap.min.js"></script>
    <script src="{{ $assets }}/js/main.js"></script>
</body>
</html>