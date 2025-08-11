<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="font/CS-Interface/style.css" />

    <link rel="stylesheet" href="{{ asset('public/absensi/new/') }}/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('public/absensi/new/') }}/css/vendor/OverlayScrollbars.min.css" />

    <link rel="stylesheet" href="{{ asset('public/absensi/new/') }}/css/styles.css" />

    <link rel="stylesheet" href="{{ asset('public/absensi/new/') }}/css/main.css" />
    <script src="{{ asset('public/absensi/new/') }}/js/base/loader.js"></script>

    <title>@yield('title')</title>
</head>

<body class="h-100">
    <div id="root" class="h-100">
        <div class="fixed-background"></div>

        <div class="container-fluid p-0 h-100 position-relative">
            <div class="row g-0 h-100">
                <!-- Left Side Start -->
                <div class="offset-0 col-12 d-none d-lg-flex offset-md-1 col-lg h-lg-100">
                    <div class="min-h-100 d-flex align-items-center">
                        <div class="w-100 w-lg-75 w-xxl-50">
                            <div>
                                <div class="mb-5">
                                    <h1 class="display-3 text-white">Multiple Niches</h1>
                                    <h1 class="display-3 text-white">Ready for Your Project</h1>
                                </div>
                                <p class="h6 text-white lh-1-5 mb-5">
                                    Dynamically target high-payoff intellectual capital for customized technologies.
                                    Objectively integrate emerging core competencies before
                                    process-centric communities...
                                </p>
                                <div class="mb-5">
                                    <a class="btn btn-lg btn-outline-white" href="index.html">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Left Side End -->

                <!-- Right Side Start -->
                <div class="col-12 col-lg-auto h-100 pb-4 px-4 pt-0 p-lg-0">
                    <div
                        class="sw-lg-70 min-h-100 bg-foreground d-flex justify-content-center align-items-center shadow-deep py-5 full-page-content-right-border">
                        <div class="sw-lg-50 px-5">
                            <div class="sh-11">
                                <a href="index.html">
                                    <div class="logo-default"></div>
                                </a>
                            </div>
                            <div class="mb-5">
                                <h2 class="cta-1 mb-0 text-primary">Selamat Datang di,</h2>
                                <h2 class="cta-1 text-primary">Absensi ITIC</h2>
                            </div>
                            <div class="mb-5">
                                <p class="h6">Silahkan Gunakan Akun Anda!</p>
                            </div>
                            <div>
                                <form class="tooltip-end-bottom" method="POST" action="{{ route('absensi.login.post') }}" novalidate>
                                    @csrf
                                    <div class="mb-3 filled form-group tooltip-end-top">
                                        <i data-acorn-icon="user"></i>
                                        <input type="text" class="form-control" placeholder="Username" name="username" required />
                                    </div>
                                    <div class="mb-3 filled form-group tooltip-end-top">
                                        <i data-acorn-icon="lock-off"></i>
                                        <input class="form-control pe-7" name="password" type="password"
                                            placeholder="Password" required />
                                        {{-- <a class="text-small position-absolute t-3 e-3"
                                            href="Pages.Authentication.ForgotPassword.html">Forgot?</a> --}}
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-primary">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Side End -->
            </div>
        </div>
    </div>
    <!-- Vendor Scripts Start -->
    <script src="{{ asset('public/absensi/new/') }}/js/vendor/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/vendor/OverlayScrollbars.min.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/vendor/autoComplete.min.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/vendor/clamp.min.js"></script>

    <script src="{{ asset('public/absensi/new/') }}/icon/acorn-icons.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/icon/acorn-icons-interface.js"></script>

    <script src="{{ asset('public/absensi/new/') }}/js/vendor/jquery.validate/jquery.validate.min.js"></script>

    <script src="{{ asset('public/absensi/new/') }}/js/vendor/jquery.validate/additional-methods.min.js"></script>

    <!-- Vendor Scripts End -->

    <!-- Template Base Scripts Start -->
    <script src="{{ asset('public/absensi/new/') }}/js/base/helpers.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/base/globals.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/base/nav.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/base/search.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/base/settings.js"></script>
    <!-- Template Base Scripts End -->
    <!-- Page Specific Scripts Start -->

    <script src="{{ asset('public/absensi/new/') }}/js/pages/auth.login.js"></script>

    <script src="{{ asset('public/absensi/new/') }}/js/common.js"></script>
    <script src="{{ asset('public/absensi/new/') }}/js/scripts.js"></script>
    <!-- Page Specific Scripts End -->
</body>

</html>
