<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('public/login/css/style.css') }}">
</head>

<body class="img js-fullheight" style="background-image: url({{ asset('public/login/img/flat-lay-desk-dark-concept-with-copy-space.jpg') }});">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    {{-- <h2 class="heading-section">Login #10</h2> --}}
                    <div class="heading-section">
                        <img src="{{ asset('public/login/img/sima.png') }}" width="250">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @yield('content')
            </div>
        </div>
    </section>

    <script src="{{ asset('public/login/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/login/js/popper.js') }}"></script>
    <script src="{{ asset('public/login/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/login/js/main.js') }}"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317"
        integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA=="
        data-cf-beacon='{"rayId":"84b58c5e99906bf4","version":"2024.1.0","token":"cd0b4b3a733644fc843ef0b185f98241"}'
        crossorigin="anonymous"></script>
</body>

</html>
