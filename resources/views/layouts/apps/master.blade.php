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
    <link href="{{ URL::asset('public/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link rel="stylesheet" href="https://mannatthemes.com/dastone/default/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://mannatthemes.com/dastone/default/assets/css/icons.min.css">
    <link rel="stylesheet" href="https://mannatthemes.com/dastone/default/assets/css/metisMenu.min.css">
    <link rel="stylesheet" href="https://mannatthemes.com/dastone/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://mannatthemes.com/dastone/default/assets/css/app.min.css"> --}}
    @yield('css')
    <style>
        #loading-bar-spinner.spinner {
            left: 50%;
            margin-left: -20px;
            top: 50%;
            margin-top: -20px;
            position: absolute;
            z-index: 19 !important;
            -webkit-animation: loading-bar-spinner 400ms linear infinite;
            animation: loading-bar-spinner 400ms linear infinite;
        }

        #loading-bar-spinner.spinner .spinner-icon {
            width: 40px;
            height: 40px;
            border: solid 4px transparent;
            border-top-color: #00C8B1 !important;
            border-left-color: #00C8B1 !important;
            border-radius: 50%;
        }

        @-webkit-keyframes loading-bar-spinner {
            0% {
                transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes loading-bar-spinner {
            0% {
                transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="dark-sidenav">
    @include('layouts.apps.loading')
    @include('layouts.apps.sidebar')
    @include('layouts.apps.modalLoading')
    <div class="page-wrapper">
        @include('layouts.apps.topbar')
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            @include('layouts.apps.footer')
        </div>
    </div>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
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

    {{-- <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";
    const firebaseConfig = {
        apiKey: "AIzaSyCbUWkgQ6udgnUldAuwnqAub53eW6lXS9E",
        authDomain: "app-siap.firebaseapp.com",
        projectId: "app-siap",
        storageBucket: "app-siap.appspot.com",
        messagingSenderId: "596272474074",
        appId: "1:596272474074:web:6fe5475895cb115d2c02e3"
    };
    const app = initializeApp(firebaseConfig);
    </script> --}}
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->

    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyCbUWkgQ6udgnUldAuwnqAub53eW6lXS9E",
            authDomain: "app-siap.firebaseapp.com",
            projectId: "app-siap",
            storageBucket: "app-siap.appspot.com",
            messagingSenderId: "596272474074",
            appId: "1:596272474074:web:6fe5475895cb115d2c02e3"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging.requestPermission().then(function () {
                return messaging.getToken()
            }).then(function(token) {
                
                axios.post("{{ route('fcmToken') }}",{
                    _method:"PATCH",
                    token
                }).then(({data})=>{
                    console.log(data)
                }).catch(({response:{data}})=>{
                    console.error(data)
                })

            }).catch(function (err) {
                console.log(`Token Error :: ${err}`);
            });
        }

        initFirebaseMessagingRegistration();
    
        messaging.onMessage(function({data:{body,title}}){
            new Notification(title, {body});
        });
    </script>
    @yield('script')
</body>

</html>
