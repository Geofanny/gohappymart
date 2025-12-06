<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GoHappyMart</title>
    <link rel="icon" href="{{ asset('../assets/images/logo-toko.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/nice-select/nice-select.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/owl-carousel/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/owl-carousel/owl.carousel.min.css">

    <link rel="stylesheet" href="{{ asset('assets-user') }}/css/style.css">

    <style>
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            /* transparan */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            backdrop-filter: blur(3px);
        }

        .loading-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: 30px;
        }

        .loading-logo {
            width: 100px;
            margin-bottom: 10px;
            animation: zoom 1.3s infinite alternate;
        }

        .loading-text {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            font-family: sans-serif;
            display: inline-flex;
            gap: 2px;
        }

        .loading-text span {
            display: inline-block;
            animation: bounce 1s infinite;
        }

        /* Delay tiap huruf */
        .loading-text span:nth-child(1) {
            animation-delay: 0s;
        }

        .loading-text span:nth-child(2) {
            animation-delay: 0.1s;
        }

        .loading-text span:nth-child(3) {
            animation-delay: 0.2s;
        }

        .loading-text span:nth-child(4) {
            animation-delay: 0.3s;
        }

        .loading-text span:nth-child(5) {
            animation-delay: 0.4s;
        }

        .loading-text span:nth-child(6) {
            animation-delay: 0.5s;
        }

        .loading-text span:nth-child(7) {
            animation-delay: 0.6s;
        }

        .loading-text span:nth-child(8) {
            animation-delay: 0.7s;
        }

        .loading-text span:nth-child(9) {
            animation-delay: 0.8s;
        }

        .loading-text span:nth-child(10) {
            animation-delay: 0.9s;
        }

        .loading-text span:nth-child(11) {
            animation-delay: 1s;
        }

        .loading-text span:nth-child(12) {
            animation-delay: 1.1s;
        }

        .loading-text span:nth-child(13) {
            animation-delay: 1.2s;
        }

        /* Animasi Bounce */
        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
    @yield('link')


</head>

<body>
    <!-- Loading Screen -->
    <div id="loadingOverlay">
        <div class="loading-content">
            <img src="{{ asset('assets-user') }}/img/logo-toko.png" class="loading-logo">
            <h2 class="loading-text">
                <span>G</span><span>o</span>&nbsp;
                <span>H</span><span>a</span><span>p</span><span>p</span><span>y</span>&nbsp;
                <span>M</span><span>a</span><span>r</span><span>t</span>
            </h2>

        </div>
    </div>

    @include('layouts/navbar-pelanggan')

    <main class="site-main">
        @yield('content')
    </main>


    @include('layouts/footer-pelanggan')


    <script src="{{ asset('assets-user') }}/vendors/jquery/jquery-3.2.1.min.js"></script>
    <script src="{{ asset('assets-user') }}/vendors/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets-user') }}/vendors/skrollr.min.js"></script>
    <script src="{{ asset('assets-user') }}/vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ asset('assets-user') }}/vendors/nice-select/jquery.nice-select.min.js"></script>
    <script src="{{ asset('assets-user') }}/vendors/jquery.ajaxchimp.min.js"></script>
    <script src="{{ asset('assets-user') }}/vendors/mail-script.js"></script>
    <script src="{{ asset('assets-user') }}/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loader = document.getElementById("loadingOverlay");

            // kasih delay 1.5 detik biar animasi keliatan
            setTimeout(() => {
                loader.style.opacity = "0";
                loader.style.transition = "opacity .6s ease";
                setTimeout(() => loader.style.display = "none", 600);
            }, 2000);
        });
    </script>


    @yield('script')
</body>

</html>
