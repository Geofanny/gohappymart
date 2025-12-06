@extends('layouts/main-pelanggan')

@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Font Awesome 6.6.0 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc8H4bw8z3fK4mV91iI3yP5zEJ0l+Z8jv7+8YgO5kOq7ZCVn0ImtRKgZ7cxzQ6dV+z0aX6k2l0KJgkB+X1J7mQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- Styling -->
    <style>
        .banner-carousel {
            margin-top: 80px;
        }

        #promoSection .owl-prev span,
        #promoSection .owl-next span {
            display: none;
        }

        #promoSection.show-nav .owl-prev span,
        #promoSection.show-nav .owl-next span {
            display: inline-block;
        }

        #produkSection .owl-prev span,
        #produkSection .owl-next span {
            display: none;
        }

        #produkSection.show-nav .owl-prev span,
        #produkSection.show-nav .owl-next span {
            display: inline-block;
        }

        #kategoriSection .owl-prev span,
        #kategoriSection .owl-next span {
            display: none;
        }

        #kategoriSection.show-nav .owl-prev span,
        #kategoriSection.show-nav .owl-next span {
            display: inline-block;
        }

        .card-product__img img {
            width: 100%;
            height: 180px;
            /* sesuaikan kebutuhan */
            object-fit: cover;
            border-radius: 5px;
            /* opsional biar lebih halus */
        }


        .banner-carousel .banner-img {
            width: 100%;
            height: 410px;
            object-fit: fill;
            /* 🔥 Tekan gambar biar muat penuh tanpa potong */
            border-radius: 12px;
            transition: transform 0.9s ease-in-out, filter 0.3s ease;
            aspect-ratio: 16 / 9;
            /* ⚖️ Biar proporsi awal terjaga */
        }

        /* Opsional: efek lembut biar perpindahan gambar halus */
        .carousel-item {
            transition: transform 0.9s ease-in-out;
        }

        .carousel-item.active .banner-img {
            transform: scale(1.01);
            filter: brightness(1.02);
        }

        .kategori-card {
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .kategori-img-wrapper {
            height: 80px;
            overflow: hidden;
        }

        .kategori-img {
            max-height: 100%;
            width: auto;
            object-fit: contain;
        }

        .kategori-nama {
            margin-top: 4px;
            font-size: 0.85rem;
            text-align: center;
        }

        /* Override icon default Owl Carousel */
        .kategori-carousel .owl-nav .owl-prev::before,
        .kategori-carousel .owl-nav .owl-next::before {
            font-size: 150px;
            /* besar icon */
        }

        /* Custom navigasi Owl Carousel */
        .kategori-carousel .owl-nav button {
            position: absolute;
            top: 22%;
            background-color: rgba(13, 110, 253, 0.8);
            /* biru semi transparan */
            color: #fff;
            border-radius: 50%;
            font-size: 1000px;
            transition: background-color 0.3s ease;
            z-index: 10;
        }

        .kategori-carousel .owl-nav button:hover {
            background-color: #0d6efd;
            /* biru lebih terang saat hover */
        }

        .kategori-carousel .owl-nav .owl-prev {
            left: -15px;
            /* geser sedikit ke kiri */
        }

        .kategori-carousel .owl-nav .owl-next {
            right: -15px;
            /* geser sedikit ke kanan */
        }

        /* Hilangkan outline default */
        .kategori-carousel .owl-nav button:focus {
            outline: none;
        }

        .trending-carousel .owl-nav button {
            background-color: rgba(13, 110, 253, 0.8);
            color: #fff;
            font-size: 24px;
            /* lebih besar */
            padding: 10px 15px;
            border-radius: 50%;
            position: absolute;
            top: 25%;
            z-index: 10;
        }

        .trending-carousel .owl-nav button:hover {
            background-color: #0d6efd;
        }

        .trending-carousel .owl-nav .owl-prev {
            left: -20px;
        }

        .trending-carousel .owl-nav .owl-next {
            right: -20px;
        }

        .trending-carousel .owl-nav button:focus {
            outline: none;
        }

        @media (max-width: 768px) {
            .banner-carousel .banner-img {
                height: 200px;
            }
        }

        /* Custom line indicator */
        .carousel-line-indicators {
            gap: 8px;
        }

        .carousel-line-indicators button {
            width: 40px;
            height: 4px;
            border: none;
            background-color: #d0d0d0;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .carousel-line-indicators button.active {
            background-color: #0d6efd;
            width: 60px;
        }

        .carousel-line-indicators button:focus {
            outline: none;
            box-shadow: none;
        }

        .promo {
            position: relative;
            overflow: hidden;
        }

        .promo::before {
            content: attr(data-diskon) "%";
            position: absolute;
            top: 12px;
            right: -32px;
            width: 120px;
            padding: 4px 0;
            background: #ffcc00;
            color: #003366;
            font-weight: 700;
            text-align: center;
            transform: rotate(45deg);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            font-size: 1.2rem;
            z-index: 10;
        }

        @media (max-width: 768px) {
            .promo::before {
                width: 90px;
                font-size: 0.65rem;
                right: -25px;
                top: 10px;
            }
        }

        .promo-header {
            background-color: #003366;
            color: #fff;
            border-radius: 10px;
        }

        .promo-header h2 {
            color: #fff;
        }

        .judul-diskon {
            color: #ffcc00;
        }

        .lihat-semua-produk {
            color: #fff;
            font-size: 0.9rem;
        }

        .lihat-semua-produk:hover {
            text-decoration: none;
            color: gainsboro;
        }

        .section-intro h2 {
            margin-bottom: 0;
        }

        .promo-timer {
            background-color: rgba(61, 57, 57, 0.733);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
            font-weight: 600;
            border-radius: 6px;
            font-size: 0.9rem;
            margin-left: 15px;
            box-shadow: 0 0 8px rgba(0, 234, 255, 0.4);
            animation: pulseBlue 1.6s infinite ease-in-out;
        }

        /* ================= Skeleton Loading ================= */
        .skeleton {
            background: #e2e2e2;
            border-radius: 6px;
            position: relative;
            overflow: hidden;
        }

        .skeleton::after {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.35) 50%, rgba(255, 255, 255, 0) 100%);
            animation: loadingSkeleton 1.5s infinite;
        }

        @keyframes loadingSkeleton {
            0% {
                left: -100%;
            }

            50% {
                left: 100%;
            }

            100% {
                left: 100%;
            }
        }

        .skeleton-card {
            padding: 10px;
        }

        .skeleton-img {
            width: 100%;
            height: 180px;
        }

        .skeleton-text {
            height: 16px;
            width: 70%;
            margin: 10px auto 5px;
        }

        .skeleton-price {
            height: 14px;
            width: 40%;
            margin: auto;
        }

        /* Hide real card first */
        .product-loaded {
            display: none;
        }

        /* Skeleton fade transitions */
        .skeleton-show {
            opacity: 1;
            transition: opacity .4s ease-in-out;
        }

        .skeleton-hide {
            opacity: 0;
            pointer-events: none;
        }

        .skeleton-wrapper {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 8px 0;
        }

        /* Card Skeleton kecil */
        .skeleton-item.small {
            width: 130px;
            flex: 0 0 auto;
        }

        .skeleton-card {
            border-radius: 10px;
            padding: 6px;
        }

        /* Ukuran gambar kecil */
        .skeleton-img.small-img {
            width: 100%;
            height: 60px;
            border-radius: 8px;
        }

        /* Text kecil */
        .skeleton-text.small-text {
            width: 70%;
            height: 10px;
            margin: 6px auto 0;
            border-radius: 4px;
        }


        @keyframes pulseBlue {
            0% {
                box-shadow: 0 0 6px rgba(0, 234, 255, 0.3);
            }

            50% {
                box-shadow: 0 0 12px rgba(0, 234, 255, 0.6);
            }

            100% {
                box-shadow: 0 0 6px rgba(0, 234, 255, 0.3);
            }
        }

        .time-digit {
            display: inline-block;
            min-width: 22px;
            text-align: center;
            position: relative;
            transition: transform 0.4s ease, opacity 0.4s ease;
        }

        /* 🔹 Efek angka turun */
        .time-digit.change {
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            0% {
                transform: translateY(-10px);
                opacity: 0.3;
            }

            50% {
                transform: translateY(3px);
                opacity: 0.9;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .promo-timer span {
            display: inline-block;
            min-width: 22px;
            text-align: center;
        }

        /* 🔹 Responsif */
        @media (max-width: 768px) {
            .section-intro {
                /* flex-direction: column; */
                /* align-items: flex-start; */
                gap: 10px;
            }

            .promo-timer {
                font-size: 0.85rem;
                padding: 4px 10px;
                margin-left: 10px;
                /* biar pas di layar kecil */
                margin-top: 6px;
            }

            .lihat-semua-produk {
                margin-top: 10px;
                font-size: 0.85rem;
            }
        }

        .card-product__img {
            position: relative;
            /* agar icon bisa diposisikan di dalam gambar */
            overflow: hidden;
        }

        .love-produk {
            position: absolute;
            top: 10px;
            /* jarak dari atas gambar */
            right: 10px;
            /* jarak dari kanan gambar */
            font-size: 20px;
            color: #fff;
            /* warna hati putih agar kontras di background biru */
            background: #007bff;
            /* biru */
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            transition: 0.3s;
        }

        .love-produk:hover {
            background: #D60000;
            color: #fff;
        }

        .love-produk.active {
            background: #D60000;
            color: #fff;
        }

        .leaft-love-produk.active {
            background: #D60000;
            color: #fff;
        }

        .leaft-love-produk {
            position: absolute;
            top: 10px;
            /* jarak dari atas gambar */
            left: 10px;
            /* jarak dari kiri gambar */
            font-size: 20px;
            color: #fff;
            /* warna hati putih agar kontras di background biru */
            background: #007bff;
            /* biru */
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            transition: 0.3s;
        }

        .leaft-love-produk:hover {
            background: #D60000;
            /* biru lebih gelap saat hover */
            color: #fff;
        }

        .wishlist-btn {
            background: #8894FF;
            /* default biru */
            color: #fff;
        }

        .wishlist-btn.active {
            background: #D60000;
            /* merah jika di wishlist */
            color: #fff;
        }

        /* Card produk Big Sale dengan height tetap */
        #bigSaleSection .big-sale-card {
            width: 180px;
            /* Lebar card */
            height: 250px;
            /* Tinggi card sama untuk semua */
            margin: 0 auto 10px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
        }

        #bigSaleSection .big-sale-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Container gambar proporsional */
        #bigSaleSection .big-sale-card .card-product__img {
            width: 100%;
            height: 80%;
            /* 60% dari total tinggi card untuk gambar */
            overflow: hidden;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        /* Gambar di dalam card */
        #bigSaleSection .big-sale-card .card-product__img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Card body mengambil sisa tinggi */
        #bigSaleSection .big-sale-card .card-body {
            height: 40%;
            /* sisa dari total tinggi card */
            padding: 0.5rem 0.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Judul produk */
        #bigSaleSection .big-sale-card .card-product__title {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        /* Harga produk */
        #bigSaleSection .big-sale-card .card-product__price {
            font-size: 0.85rem;
            color: #D60000;
        }

        /* ===== Header Promo Kupon + Timer + Tombol ===== */
        #bigSaleSection .promo-header-big {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 15px;
            /* jarak antar kupon dan timer */
            flex-wrap: wrap;
            /* responsif saat layar sempit */
            position: relative;
        }

        /* Kupon */
        #bigSaleSection .promo-header-big .coupon-style {
            margin: 0;
            font-size: 2rem;
            padding: 12px 30px;
            background-color: #fff;
            color: #ec3d3d;
            border: 2px dashed #ec3d3d;
            border-radius: 12px;
            transform: skew(-3deg);
            position: relative;
            display: inline-block;
            text-transform: capitalize;
        }

        #bigSaleSection .promo-header-big .coupon-style::before,
        #bigSaleSection .promo-header-big .coupon-style::after {
            content: "";
            position: absolute;
            width: 14px;
            height: 14px;
            background: #fff;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        #bigSaleSection .promo-header-big .coupon-style::before {
            left: -7px;
        }

        #bigSaleSection .promo-header-big .coupon-style::after {
            right: -7px;
        }

        /* Timer dengan efek detak halus */
        #bigSaleSection .promo-header-big .big-timer {
            display: flex;
            gap: 6px;
            align-items: center;
            font-weight: 700;
            font-size: 1.2rem;
            color: #ec3d3d;
            background: #fff;
            padding: 8px 16px;
            border-radius: 12px;
            box-shadow: inset 0 0 10px rgba(236, 61, 61, 0.1);
        }

        /* Angka berdetak halus */
        #bigSaleSection .promo-header-big .big-timer .time-digit {
            min-width: 28px;
            text-align: center;
            font-variant-numeric: tabular-nums;
            animation: softPulse 1s ease-in-out infinite;
        }

        /* Titik dua tetap statis */
        #bigSaleSection .promo-header-big .big-timer span:not(.time-digit) {
            opacity: 0.8;
        }

        /* Efek detak lembut */
        @keyframes softPulse {

            0%,
            100% {
                transform: scale(1);
                text-shadow: 0 0 3px rgba(236, 61, 61, 0.3);
            }

            50% {
                transform: scale(1.05);
                text-shadow: 0 0 6px rgba(236, 61, 61, 0.5);
            }
        }


        /* Tombol lihat semua produk */
        #bigSaleSection .promo-header-big .btn-see-all {
            margin-left: auto;
            /* dorong ke kanan */
            font-size: 0.95rem;
            padding: 6px 14px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
        }

        /* Responsif */
        @media (max-width: 576px) {
            #bigSaleSection .promo-header-big {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            #bigSaleSection .promo-header-big .coupon-style {
                font-size: 1.5rem;
                padding: 8px 20px;
            }

            #bigSaleSection .promo-header-big .promo-timer {
                font-size: 0.85rem;
                padding: 5px 10px;
            }

            #bigSaleSection .promo-header-big .btn-see-all {
                font-size: 0.8rem;
                padding: 5px 12px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container my-4">
        <div class="row align-items-center">
            <!-- 🟢 Kiri -->
            <div class="col-md-3 d-flex align-items-center">
                <div class="tagline-left w-100 overflow-hidden">
                    <h5 class="m-0 fw-semibold">Belanja Tanpa Ribet</h5>
                </div>
            </div>

            <!-- 🟡 Tengah (search lebih besar, col-md-9) -->
            <div class="col-md-7 d-flex justify-content-center">
                <form action="{{ route('pelanggan.cariProduk') }}" method="GET" class="w-100">
                    <input type="search" name="q" class="form-control search-fixed" placeholder="Cari produk..."
                        value="{{ request('q') }}">
                </form>
            </div>

            <!-- 🔵 Kanan (lebih kecil, col-md-1) -->
            <div class="col-md-2 d-flex justify-content-end align-items-center gap-3" style="gap: 10px;">
                <a href="/keranjang" class="position-relative">
                    <i class="ti-shopping-cart" style="font-size: 20px;"></i>
                    <span class="nav-shop__circle">0</span>
                </a>

                <a href="/wishlist" class="position-relative">
                    <i class="ti-heart" style="font-size: 20px;"></i>
                    <span id="wishlist-count" class="nav-shop__circle">0</span>
                </a>

                <a href="/kebijakan-toko" class="position-relative">
                    <i class="ti-help-alt" style="font-size: 23px;"></i>
                </a>
            </div>
        </div>
    </div>

    <style>
        /* 🎯 Search Box */
        .search-fixed {
            width: 100%;
            padding: 12px 20px;
        }

        .search-fixed:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 6px rgba(13, 110, 253, 0.3);
        }

        /* 🛒 Notif Bulat */
        .nav-shop__circle {
            position: absolute;
            top: -6px;
            right: -8px;
            width: 18px;
            height: 18px;
            background-color: #0d6efd;
            color: white;
            font-size: 12px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }

        /* ✨ Tagline */
        .tagline-left h5 {
            font-family: "Poppins", sans-serif;
            font-size: 1.2rem;
            font-weight: 600;
            background: linear-gradient(90deg, #0d6efd, #00c3ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
        }

        /* 📱 Responsif */
        @media (max-width: 768px) {
            .search-fixed {
                max-width: 100%;
                margin: 10px 0;
            }

            .col-md-2,
            .col-md-9,
            .col-md-1 {
                text-align: center;
                justify-content: center !important;
            }
        }
    </style>

    <!-- ================ Banner Carousel Start ================= -->
    <section class="banner-carousel mb-2" style="margin-top: 1vh;">
        <div class="container">
            <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">

                <!-- Carousel items -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('assets-user/img/product/b1.png') }}" class="d-block w-100 banner-img"
                            alt="Banner 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets-user/img/product/b2.png') }}" class="d-block w-100 banner-img"
                            alt="Banner 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets-user/img/product/b3.png') }}" class="d-block w-100 banner-img"
                            alt="Banner 3">
                    </div>
                </div>

                <!-- Custom line indicators -->
                <div class="carousel-line-indicators d-flex justify-content-center mt-3">
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ Banner Carousel End ================= -->

    {{-- Kategori Produk --}}
    <section id="kategoriSection" class="kategori-produk py-4 mb-2">
        <div class="container">
            <div class="section-intro mb-4">
                <h2>Kategori <span class="section-intro__style">Produk</span></h2>
            </div>
            {{-- SKELETON LOADING --}}
            <div class="skeleton-wrapper" id="skeletonContainer">
                @for ($i = 0; $i < 8; $i++)
                    <div class="skeleton-item small">
                        <div class="card skeleton-card h-100">
                            <div class="skeleton skeleton-img small-img"></div>
                            <div class="card-body p-1 text-center">
                                <div class="skeleton skeleton-text small-text"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="owl-carousel owl-theme kategori-carousel">

                @foreach ($kategori as $k)
                    <a href="{{ route('pelanggan.cariProduk', ['kategori' => $k->id_kategori]) }}"
                        class="item p-2 product-loaded real-item" style="text-decoration:none;">
                        <div class="card kategori-card text-center kategori-item"
                            style="height:60px; display:flex; align-items:center; justify-content:center; border-radius:10px; background: linear-gradient(white, white) padding-box, linear-gradient(to right, #0d6efd, #4dabf7) border-box; border: 3px solid transparent; position: relative;">

                            <div class="card-body p-0 m-0 d-flex align-items-center justify-content-center">
                                <h6 class="kategori-nama fw-semibold mb-0" style="max-width: 85px; word-wrap: break-word;">
                                    {{ $k->nama }}
                                </h6>
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .kategori-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 0;

            /* Segitiga */
            border-top: 18px solid #0d6efd;
            /* Warna segitiga */
            border-right: 18px solid transparent;
            border-bottom: 0;
            border-left: 0;

            border-top-left-radius: 10px;
            /* ikut bentuk card */
        }
    </style>

    <!-- ================ trending product carousel start ================= -->
    <section id="produkSection" class="section-margin calc-60px" style="margin-top: -2px !important;">
        <div class="container">
            <div class="section-intro pb-60px">
                <h2>Produk <span class="section-intro__style">Terlaris</span></h2>
            </div>

            <div class="row g-3" id="skeletonContainer" style="margin-top: -1vh; margin-bottom: 5vh;">
                @for ($i = 0; $i < 5; $i++)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-custom skeleton-show skeleton-item">
                        <div class="card skeleton-card h-100">
                            <div class="skeleton skeleton-img"></div>
                            <div class="card-body">
                                <div class="skeleton skeleton-text"></div>
                                <div class="skeleton skeleton-price"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="owl-carousel owl-theme trending-carousel" style="margin-top: -8vh;">

                @foreach ($produkPopuler as $p)
                    <div class="item p-2 product-loaded real-item">
                        <div class="card text-center card-product">
                            <div class="card-product__img">
                                <a href="/detail-produk/{{ $p->id_produk }}">
                                    <img class="card-img"
                                        src="{{ $p->gambar ? asset('storage/uploads/produk/' . $p->gambar) : 'https://dummyimage.com/300x300/cccccc/000000&text=No+Image' }}"
                                        alt="{{ $p->nama_produk }}">
                                </a>
                                <i class="ti-heart love-produk {{ in_array($p->id_produk, $wishlistProdukIds) ? 'active' : '' }}"
                                    data-id="{{ $p->id_produk }}"></i>
                            </div>
                            <div class="card-body">
                                <h4 class="card-product__title slice-nama"><a
                                        href="/detail-produk/{{ $p->id_produk }}">{{ $p->nama_produk }}</a></h4>
                                <p class="card-product__price">
                                    <a href="/detail-produk/{{ $p->id_produk }}">
                                        {{-- {{$p->harga_promo }} --}}
                                        @if ($p->harga_promo < $p->harga)
                                            <strong style="color: #D60000;">
                                                Rp. {{ number_format($p->harga_promo, 0, ',', '.') }}
                                            </strong>
                                        @else
                                            <strong style="color: #D60000;">
                                                Rp. {{ number_format($p->harga, 0, ',', '.') }}
                                            </strong>
                                        @endif
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- ================ trending product carousel end ================= -->


    {{-- <section id="promoSection" class="section-margin calc-60px" style="margin-top: -50px !important">
        <div class="container">
            <!-- 🔹 HEADER PROMO -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-body py-3 px-4 d-flex justify-content-between align-items-center flex-wrap promo-header" style="background-image: url('asse')">
                    <div class="d-flex align-items-center flex-wrap">
                        <h2 class="mb-0 me-4 fw-bold" style="display: inline-flex; align-items: center;">
                            <span style="display:inline-block; transform: skew(-10deg);">FLAS</span>
                            <span style="display:inline-block; transform: skew(-10deg);">H <i
                                    class="fa-solid fa-bolt text-warning"
                                    style="font-size: 1.1em; position: relative; top: -1px; margin: 0 2px;">
                                </i>ALE</span>
                        </h2>


                        <!-- 🔹 Timer -->
                        <div class="promo-timer d-flex align-items-center px-3 py-2 rounded"
                        data-start="{{ $promoFlashsale ? $promoFlashsale->tgl_mulai : '' }}"
                        data-end="{{ $promoFlashsale ? $promoFlashsale->tgl_selesai : '' }}">
                            <span class="time-digit" id="hours">00</span><span>:</span>
                            <span class="time-digit" id="minutes">00</span><span>:</span>
                            <span class="time-digit" id="seconds">00</span>
                        </div>
                    </div>

                    <!-- 🔹 Lihat Semua Produk -->
                    <a href="#" class="lihat-semua-produk text-decoration-none fw-semibold">
                        Lihat Semua Produk <i class="fa-solid fa-angle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Skelton -->
            <div class="row g-3" id="skeletonContainer" style="margin-top: 5vh; margin-bottom: 5vh;">
                @for ($i = 0; $i < 5; $i++)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-custom skeleton-show skeleton-item">
                        <div class="card skeleton-card h-100">
                            <div class="skeleton skeleton-img"></div>
                            <div class="card-body">
                                <div class="skeleton skeleton-text"></div>
                                <div class="skeleton skeleton-price"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- 🔹 Carousel Produk -->
            <div class="owl-carousel owl-theme trending-carousel" style="margin-top: -5vh;">
                @foreach ($produkFlashsale as $p)
                    @php
                        $promo = $p->promos->where('kategori', 'flashsale')->first(); 
                        $diskon = $promo ? $promo->nilai_diskon : 0;
                        $hargaSetelahDiskon = $p->harga - ($p->harga * $diskon) / 100;
                    @endphp
                    <div class="item p-2 product-loaded real-item">
                        <div class="card text-center card-product promo" data-diskon="{{ $diskon }}">
                            <div class="card-product__img">
                                <img class="card-img" src="{{ asset('storage/uploads/produk/' . $p->gambar) }}"
                                    alt="{{ $p->nama_produk }}">
                                <i class="ti-heart leaft-love-produk {{ in_array($p->id_produk, $wishlistProdukIds) ? 'active' : '' }}"
                                    data-id="{{ $p->id_produk }}"></i>
                            </div>
                            <div class="card-body">
                                <h4 class="card-product__title slice-nama"><a href="#">{{ $p->nama_produk }}</a></h4>

                                <p class="card-product__price">
                                    <span style="text-decoration: line-through; opacity: 0.6;">
                                        Rp. {{ number_format($p->harga, 0, ',', '.') }}
                                    </span><br>
                                    <strong style="color: #D60000;">
                                        Rp. {{ number_format($hargaSetelahDiskon, 0, ',', '.') }}
                                    </strong>
                                </p>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section> --}}

    @if ($promoFlashsale && $produkFlashsale->count() > 0)
        <section id="promoSection" class="section-margin calc-60px" style="margin-top: -50px !important">
            <div class="container">
                <!-- 🔹 HEADER PROMO -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div
                        class="card-body py-3 px-4 d-flex justify-content-between align-items-center flex-wrap promo-header">
                        <div class="d-flex align-items-center flex-wrap">
                            <h2 class="mb-0 me-4 fw-bold" style="display: inline-flex; align-items: center;">
                                <span style="display:inline-block; transform: skew(-10deg);">FLAS</span>
                                <span style="display:inline-block; transform: skew(-10deg);">H
                                    <i class="fa-solid fa-bolt text-warning"
                                        style="font-size: 1.1em; position: relative; top: -1px; margin: 0 2px;"></i>ALE
                                </span>
                            </h2>

                            <!-- 🔹 Timer -->
                            <div class="promo-timer d-flex align-items-center px-3 py-2 rounded"
                                data-start="{{ $promoFlashsale->tgl_mulai }}"
                                data-end="{{ $promoFlashsale->tgl_selesai }}">
                                <span class="time-digit" id="hours">00</span><span>:</span>
                                <span class="time-digit" id="minutes">00</span><span>:</span>
                                <span class="time-digit" id="seconds">00</span>
                            </div>
                        </div>

                        <!-- 🔹 Lihat Semua Produk -->
                        <a href="#" class="lihat-semua-produk text-decoration-none fw-semibold">
                            Lihat Semua Produk <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- 🔹 Carousel Produk -->
                <div class="owl-carousel owl-theme trending-carousel">
                    @foreach ($produkFlashsale as $p)
                        @php
                            $promo = $p->promos->where('kategori', 'flashsale')->first();
                            $diskon = $promo ? $promo->nilai_diskon : 0;
                            $tipeDiskon = $promo ? $promo->tipe : null;

                            if ($promo) {
                                if ($tipeDiskon === 'Persen') {
                                    $hargaSetelahDiskon = $p->harga - ($p->harga * $diskon) / 100;
                                } elseif ($tipeDiskon === 'Nominal') {
                                    $hargaSetelahDiskon = max(0, $p->harga - $diskon);
                                } else {
                                    $hargaSetelahDiskon = $p->harga;
                                }
                            } else {
                                $hargaSetelahDiskon = $p->harga;
                            }
                        @endphp
                        <div class="item p-2 product-loaded real-item">
                            <div class="card text-center card-product">
                                <div class="card-product__img">
                                    <a href="/detail-produk/{{ $p->id_produk }}">
                                        <img class="card-img" src="{{ asset('storage/uploads/produk/' . $p->gambar) }}"
                                            alt="{{ $p->nama_produk }}">
                                    </a>
                                    <i class="ti-heart leaft-love-produk {{ in_array($p->id_produk, $wishlistProdukIds) ? 'active' : '' }}"
                                        data-id="{{ $p->id_produk }}"></i>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-product__title slice-nama">
                                        <a href="/detail-produk/{{ $p->id_produk }}">{{ $p->nama_produk }}</a>
                                    </h4>
                                    <p class="card-product__price mb-2">
                                        <a href="/detail-produk/{{ $p->id_produk }}">
                                            <strong style="color: #D60000;">
                                                Rp. {{ number_format($hargaSetelahDiskon, 0, ',', '.') }}
                                            </strong>
                                        </a>
                                    </p>
                                    <style>
                                        .progress {
                                            position: relative;
                                            height: 25px;
                                            border-radius: 10px;
                                            overflow: hidden;
                                            font-size: 13px;
                                            background-color: #e3f2fd;
                                            /* 💡 biru muda sebagai latar belakang */
                                        }

                                        .progress-bar {
                                            background-color: #f31818;
                                            /* 💡 biru utama (tema) */
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            text-align: center;
                                            white-space: nowrap;
                                            transition: width 0.8s ease-in-out;
                                        }

                                        .progress-text {
                                            position: absolute;
                                            width: 100%;
                                            text-align: center;
                                            top: 0;
                                            left: 0;
                                            line-height: 25px;
                                            font-weight: 500;
                                            font-size: 13px;
                                            transition: color 0.3s ease;
                                        }
                                    </style>

                                    @php
                                        $stok = $p->stok ?? 0;
                                        $stokMaks = 100;
                                        $persenSisa = min(100, ($stok / $stokMaks) * 100);

                                        if ($stok > 10) {
                                            $statusStok = 'Stok Tebatas';
                                        } elseif ($stok > 5) {
                                            $statusStok = 'Mulai menipis';
                                        } else {
                                            $statusStok = 'Hampir habis!';
                                        }

                                        // 💡 Ubah warna teks otomatis berdasarkan panjang bar
                                        $textColor = $persenSisa < 40 ? 'text-dark' : 'text-white';
                                    @endphp

                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $persenSisa }}%;" aria-valuenow="{{ $persenSisa }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                        <div class="progress-text {{ $textColor }}">{{ $statusStok }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- ================ offer section end ================= -->

    {{-- card baru untuk 11.11 big sale --}}
    {{-- <section id="bigSaleSection" class="section-margin" style="margin-top: -20px;">
        <div class="container" style="background: #ec3d3d; padding: 40px 20px; border-radius: 15px;">

            <div class="promo-header-big mb-4">
                <h2 class="coupon-style" style="color: #f06819">
                    {{ $promoBigsale->nama_promo ?? 'Big Sale' }}
                </h2>

                <div class="big-timer"
                    data-start="{{ $promoBigsale ? $promoBigsale->tgl_mulai : '' }}"
                    data-end="{{ $promoBigsale ? $promoBigsale->tgl_selesai : '' }}">
                    <span class="time-digit" id="hours-big">00</span><span>:</span>
                    <span class="time-digit" id="minutes-big">00</span><span>:</span>
                    <span class="time-digit" id="seconds-big">00</span>
                </div>

                <a href="#" class="btn-see-all" style="font-size: 1.2rem">Lihat Semua <i class="fa-solid fa-angle-right"></i>
                </a>
            </div>



            <!-- 🔹 Card besar untuk carousel + tombol lihat semua produk -->
            <div class="card p-4" style="background-color: #fff;">
                <!-- Carousel Produk -->
                <div class="owl-carousel owl-theme trending-carousel mt-3">
                    @foreach ($produkBigsale as $p)
                        @php
                            $diskon = 20;
                            $hargaSetelahDiskon = $p->harga - ($p->harga * $diskon) / 100;
                        @endphp
                        <div class="item p-2 product-loaded real-item">
                            <div class="card text-center big-sale-card"
                                style="background-color: #fff; border-radius: 12px;">
                                <div class="card-product__img position-relative">
                                    <img class="card-img" src="{{ asset('storage/uploads/produk/' . $p->gambar) }}"
                                        alt="{{ $p->nama_produk }}">
                                    <i class="ti-heart love-produk {{ in_array($p->id_produk, $wishlistProdukIds) ? 'active' : '' }}"
                                        data-id="{{ $p->id_produk }}"></i>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-product__title slice-nama"><a href="#">{{ $p->nama_produk }}</a></h4>
                                    <p class="card-product__price">
                                        <strong style="color: #D60000;">
                                            Rp. {{ number_format($hargaSetelahDiskon, 0, ',', '.') }}
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>

        </div>
    </section> --}}

    @if ($promoBigsale && $produkBigsale->count() > 0)
        <section id="bigSaleSection" class="section-margin" style="margin-top: -20px;">
            <div class="container" style="background: #ec3d3d; padding: 40px 20px; border-radius: 15px;">
                <div class="promo-header-big mb-4">
                    <h2 class="coupon-style" style="color: #f06819">
                        {{ $promoBigsale->nama_promo ?? 'Big Sale' }}
                    </h2>

                    <div class="big-timer" data-start="{{ $promoBigsale->tgl_mulai }}"
                        data-end="{{ $promoBigsale->tgl_selesai }}">
                        <span class="time-digit" id="hours-big">00</span><span>:</span>
                        <span class="time-digit" id="minutes-big">00</span><span>:</span>
                        <span class="time-digit" id="seconds-big">00</span>
                    </div>

                    <a href="#" class="btn-see-all" style="font-size: 1.2rem">
                        Lihat Semua <i class="fa-solid fa-angle-right"></i>
                    </a>
                </div>

                <div class="card p-4" style="background-color: #fff;">
                    <div class="owl-carousel owl-theme trending-carousel mt-3">
                        @foreach ($produkBigsale as $p)
                            @php
                                // $promo = $p->promos->where('kategori', 'bigsale')->first();
                                // $diskon = $promo ? $promo->nilai_diskon : 0;
                                // $hargaSetelahDiskon = $p->harga - ($p->harga * $diskon) / 100;

                                $promo = $p->promos->where('kategori', 'bigsale')->first();
                                $diskon = $promo ? $promo->nilai_diskon : 0;
                                $tipeDiskon = $promo ? $promo->tipe : null;

                                if ($promo) {
                                    if ($tipeDiskon === 'Persen') {
                                        $hargaSetelahDiskon = $p->harga - ($p->harga * $diskon) / 100;
                                    } elseif ($tipeDiskon === 'Nominal') {
                                        $hargaSetelahDiskon = max(0, $p->harga - $diskon);
                                    } else {
                                        $hargaSetelahDiskon = $p->harga;
                                    }
                                } else {
                                    $hargaSetelahDiskon = $p->harga;
                                }
                            @endphp
                            <div class="item p-2 product-loaded real-item">
                                <div class="card text-center big-sale-card"
                                    style="background-color: #fff; border-radius: 12px;">
                                    <div class="card-product__img position-relative">
                                        <a href="/detail-produk/{{ $p->id_produk }}">
                                            <img class="card-img"
                                                src="{{ asset('storage/uploads/produk/' . $p->gambar) }}"
                                                alt="{{ $p->nama_produk }}">
                                        </a>
                                        <i class="ti-heart love-produk {{ in_array($p->id_produk, $wishlistProdukIds) ? 'active' : '' }}"
                                            data-id="{{ $p->id_produk }}"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-product__title slice-nama">
                                            <a href="/detail-produk/{{ $p->id_produk }}">{{ $p->nama_produk }}</a>
                                        </h4>
                                        <p class="card-product__price">
                                            <a href="/detail-produk/{{ $p->id_produk }}">
                                                <span class="text-muted"
                                                    style="text-decoration: line-through; opacity: 0.6;">
                                                    Rp. {{ number_format($p->harga, 0, ',', '.') }}
                                                </span><br>
                                                <strong style="color: #D60000;">
                                                    Rp. {{ number_format($hargaSetelahDiskon, 0, ',', '.') }}
                                                </strong>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($promoUmum && $produkUmumSale->count() > 0)
        <section id="promoAllSection" class="section-margin calc-60px" style="margin-top: -40px !important">
            <div class="container">
                <!-- 🔹 HEADER PROMO -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div
                        class="card-body py-3 px-4 d-flex justify-content-between align-items-center flex-wrap promo-header">
                        <div class="d-flex align-items-center flex-wrap">
                            <h2 class="mb-0 me-4">Serbu Promonya <span class="judul-diskon">Sekarang!</span></h2>
                        </div>

                        <!-- 🔹 Lihat Semua Produk -->
                        <a href="#" class="lihat-semua-produk text-decoration-none fw-semibold">
                            Lihat Semua Promo <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- SKELETON LOADING --}}
                <div class="row g-3" id="skeletonContainer" style="margin-top: 5vh; margin-bottom: 5vh;">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-custom skeleton-show skeleton-item">
                            <div class="card skeleton-card h-100">
                                <div class="skeleton skeleton-img"></div>
                                <div class="card-body">
                                    <div class="skeleton skeleton-text"></div>
                                    <div class="skeleton skeleton-price"></div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- 🔹 Carousel Produk -->
                <div class="owl-carousel owl-theme trending-carousel" style="margin-top: -5vh;">
                    @foreach ($produkUmumSale as $p)
                        @php
                            $promo = $p->promos->where('kategori', 'umum')->first();
                            $diskon = $promo ? $promo->nilai_diskon : 0;
                            $tipeDiskon = $promo ? $promo->tipe : null;

                            if ($promo) {
                                if ($tipeDiskon === 'Persen') {
                                    $hargaSetelahDiskon = $p->harga - ($p->harga * $diskon) / 100;
                                } elseif ($tipeDiskon === 'Nominal') {
                                    $hargaSetelahDiskon = max(0, $p->harga - $diskon);
                                } else {
                                    $hargaSetelahDiskon = $p->harga;
                                }
                            } else {
                                $hargaSetelahDiskon = $p->harga;
                            }

                            // Tentukan apakah class promo muncul atau tidak
                            $cardClass = $tipeDiskon === 'Persen' ? 'promo' : '';
                        @endphp
                        <div class="item p-2 product-loaded real-item">
                            <div class="card text-center card-product {{ $promo && $promo->tipe === 'Persen' ? 'promo' : '' }}"
                                data-diskon="{{ $diskon }}">
                                <div class="card-product__img">
                                    <a href="/detail-produk/{{ $p->id_produk }}">
                                        <img class="card-img" src="{{ asset('storage/uploads/produk/' . $p->gambar) }}"
                                            alt="{{ $p->nama_produk }}">
                                    </a>
                                    <i class="ti-heart leaft-love-produk {{ in_array($p->id_produk, $wishlistProdukIds) ? 'active' : '' }}"
                                        data-id="{{ $p->id_produk }}"></i>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-product__title slice-nama"><a
                                            href="/detail-produk/{{ $p->id_produk }}">{{ $p->nama_produk }}</a></h4>

                                    <p class="card-product__price">
                                        <a href="/detail-produk/{{ $p->id_produk }}">
                                            <span class="text-muted"
                                                style="text-decoration: line-through; opacity: 0.6; font-size: 15px;">
                                                Rp. {{ number_format($p->harga, 0, ',', '.') }}
                                            </span><br>
                                            <strong style="color: #D60000;">
                                                Rp. {{ number_format($hargaSetelahDiskon, 0, ',', '.') }}
                                            </strong>
                                        </a>
                                    </p>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    <!-- ================ Rekomendasi Produk Grid ================= -->
    <section class="section-margin calc-60px" style="margin-top: -60px !important">
        <div class="container">
            <div class="section-intro pb-60px">
                <h2>Rekomendasi <span class="section-intro__style">Produk</span></h2>
            </div>

            {{-- SKELETON LOADING --}}
            <div class="row g-3" id="skeletonContainer" style="margin-top: -1vh;">
                @for ($i = 0; $i < 10; $i++)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-custom skeleton-show skeleton-item mb-5">
                        <div class="card skeleton-card h-100">
                            <div class="skeleton skeleton-img"></div>
                            <div class="card-body">
                                <div class="skeleton skeleton-text"></div>
                                <div class="skeleton skeleton-price"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="row g-3">

                @foreach ($produkRekomendasi as $p)
                    @php
                        $promo = $p->promos->first(); // semua kategori
                        $diskon = $promo->nilai_diskon ?? 0;
                        $tipeDiskon = $promo->tipe ?? null;

                        if ($promo) {
                            if ($tipeDiskon === 'Persen') {
                                $hargaSetelahDiskon = $p->harga - ($p->harga * $diskon) / 100;
                            } elseif ($tipeDiskon === 'Nominal') {
                                $hargaSetelahDiskon = max(0, $p->harga - $diskon);
                            } else {
                                $hargaSetelahDiskon = $p->harga;
                            }
                        } else {
                            $hargaSetelahDiskon = $p->harga;
                        }
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3 col-xl-custom  product-loaded real-item">
                        <div class="card text-center card-product h-100">
                            <div class="card-product__img">
                                <a href="/detail-produk/{{ $p->id_produk }}">
                                    <img class="card-img" src="{{ asset('storage/uploads/produk/' . $p->gambar) }}"
                                        alt="{{ $p->nama_produk }}">
                                    <i class="ti-heart love-produk {{ in_array($p->id_produk, $wishlistProdukIds) ? 'active' : '' }}"
                                        data-id="{{ $p->id_produk }}"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-product__title slice-nama"><a
                                        href="/detail-produk/{{ $p->id_produk }}">{{ $p->nama_produk }}</a>
                                </h5>
                                <a href="/detail-produk/{{ $p->id_produk }}">
                                    <p class="card-product__price">
                                        @if ($promo && $hargaSetelahDiskon < $p->harga)
                                            <strong style="color: #D60000;">
                                                Rp. {{ number_format($hargaSetelahDiskon, 0, ',', '.') }}
                                            </strong>
                                        @else
                                            <strong style="color: #D60000;">
                                                Rp. {{ number_format($p->harga, 0, ',', '.') }}
                                            </strong>
                                        @endif
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        /* Custom col untuk 5 per baris di XL */
        @media (min-width: 1200px) {
            .col-xl-custom {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }
    </style>

    <!-- ================ Best Selling item  carousel end ================= -->

    <!-- ================ Blog + Testimoni ================= -->
    <section class="section-margin calc-60px" style="margin-top: -2px !important">
        <div class="container">
            <div class="row g-4">
                <!-- 🔹 Kiri: Blog (lebih besar) -->
                <div class="col-lg-8">
                    <div class="section-intro pb-3 mb-4">
                        <p>Popular Item in the market</p>
                        <h2>Latest <span class="section-intro__style">News</span></h2>
                    </div>

                    <div class="row g-3 mb-3">

                        @forelse ($berita as $b)
                            <div class="col-6 col-md-6 col-lg-4">
                                <div class="card card-blog h-100">
                                    <a href="/detail-berita/{{ $b->id_berita }}">
                                        <div class="card-blog__img">
                                            <img class="card-img rounded-0" style="height: 120px; object-fit: cover;"
                                                src="{{ $b->gambar ? asset('storage/uploads/berita/' . $b->gambar) : asset('assets-user/img/no-image.jpg') }}"
                                                alt="{{ $b->judul }}">
                                        </div>

                                        <div class="card-body p-2">
                                            <ul class="card-blog__info mb-1">
                                                <li><a href="#">{{ $b->user->nama ?? 'Admin' }}</a></li>
                                                <li>{{ $b->tgl->format('M d, Y') }}</li>
                                            </ul>

                                            <h6 class="card-blog__title">
                                                <a
                                                    href="/detail-berita/{{ $b->id_berita }}">{{ Str::limit($b->judul, 40) }}</a>
                                            </h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @empty

                            <!-- Jika berita kosong tampilkan kartu placeholder -->
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    Tidak ada berita terbaru.
                                </div>
                            </div>
                        @endforelse
                    </div>

                </div>

                <!-- 🔹 Kanan: Testimoni Carousel (lebih kecil, 3 baris, tanpa nav/dots) -->
                <div class="col-lg-4">
                    <div class="section-intro  ">
                        <p>What our customers say</p>
                        <h2><span class="section-intro__style">Testimonials</span></h2>
                    </div>

                    @if ($testimoniToko->isEmpty())
                        <p class="text-muted">Belum ada testimoni untuk toko ini.</p>
                    @else
                        @php
                            $chunks = $testimoniToko->chunk(3);
                        @endphp

                        <div class="owl-carousel owl-theme testimonial-carousel" style="overflow: hidden;">
                            @foreach ($chunks as $group)
                                <div class="item px-1" style="box-sizing: border-box; margin-top: 6vh;">
                                    <div class="row g-2">

                                        @foreach ($group as $r)
                                            <div class="col-12 mb-3">
                                                <div class="card h-100 border mb-2">
                                                    <div class="card-body">
                                                        <h6>{{ $r->pelanggan->nama_pelanggan ?? 'Anonymous' }}</h6>

                                                        <p class="mb-1">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="ti-star {{ $i <= $r->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                                            @endfor
                                                        </p>

                                                        <p>{{ $r->ulasan }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <!-- 🔹 Owl Carousel Initialization -->
    <script>
        $(document).ready(function() {
            $(".testimonial-carousel").owlCarousel({
                items: 1, // 3 testimoni per view
                loop: true,
                margin: 10,
                nav: false, // hilangkan panah
                dots: false, // hilangkan bulat
                autoplay: true,
                autoplayTimeout: 5000
            });
        });
    </script>


    <!-- ================ Blog section end ================= -->
@endsection

@section('script')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            customClass: {
                popup: 'colored-toast'
            },
            didOpen: (toast) => {
                toast.style.marginTop = '100px'; // ubah sesuai kebutuhan
                const iconEl = toast.querySelector('.swal2-icon');
                if (iconEl) {
                    iconEl.style.border = 'none';
                    iconEl.style.background = 'transparent';
                    iconEl.style.boxShadow = 'none';
                }
                const iconContent = toast.querySelector('.swal2-icon-content');
                if (iconContent) {
                    iconContent.style.fontSize = '1.8rem';
                    iconContent.style.lineHeight = '1';
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bannerCarousel = document.querySelector('#bannerCarousel');
            const carousel = new bootstrap.Carousel(bannerCarousel, {
                interval: 2000, // 4 detik per slide
                ride: 'carousel',
                wrap: true // kalau udah slide terakhir, balik lagi ke awal
            });

            // Biar garis indikator ikut berubah aktifnya
            const indicators = document.querySelectorAll('.carousel-line-indicators button');

            bannerCarousel.addEventListener('slide.bs.carousel', function(event) {
                indicators.forEach(btn => btn.classList.remove('active'));
                indicators[event.to].classList.add('active');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".kategori-carousel").owlCarousel({
                items: 3, // jumlah card per slide default
                margin: 10,
                loop: false,
                nav: true,
                dots: false,
                touchDrag: true, // swipe di mobile
                mouseDrag: true, // drag di desktop
                responsive: {
                    0: {
                        items: 2
                    },
                    345: {
                        items: 3
                    },
                    576: {
                        items: 5
                    },
                    768: {
                        items: 6
                    },
                    992: {
                        items: 8
                    }
                },
                onInitialized: function(event) {
                    // Besarkan icon navigasi
                    $('.owl-prev span, .owl-next span').css({
                        'font-size': '50px', // ukuran lebih besar
                        'line-height': '30px'
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".trending-carousel").owlCarousel({
                items: 5, // 5 card per slide
                margin: 15,
                loop: false,
                nav: true,
                dots: false,
                touchDrag: true,
                mouseDrag: true,
                responsive: {
                    0: {
                        items: 2
                    }, // mobile
                    576: {
                        items: 3
                    },
                    768: {
                        items: 3
                    }, // tablet
                    992: {
                        items: 4
                    }, // small desktop
                    1200: {
                        items: 5
                    } // large desktop
                },
                onInitialized: function(event) {
                    // Besarkan icon navigasi
                    $('.owl-prev span, .owl-next span').css({
                        'font-size': '50px', // ukuran lebih besar
                        'line-height': '30px'
                    });
                }
            });
        });
    </script>

    {{-- <script>
        // 🔹 Timer Countdown Dinamis
        const timerElement = document.querySelector('.promo-timer');
        
        if (timerElement) {
            const startTime = timerElement.dataset.start;
            const endTime = timerElement.dataset.end;
            
            if (startTime && endTime) {
                const startDate = new Date(startTime).getTime();
                const endDate = new Date(endTime).getTime();
                
                const timer = setInterval(() => {
                    const now = new Date().getTime();
                    
                    // Jika belum dimulai, tampilkan waktu menuju mulai
                    if (now < startDate) {
                        const distance = startDate - now;
                        updateCountdown(distance);
                        return;
                    }
                    
                    // Jika sudah dimulai, hitung mundur sampai selesai
                    if (now >= startDate && now < endDate) {
                        const distance = endDate - now;
                        updateCountdown(distance);
                        return;
                    }
                    
                    // Jika sudah selesai
                    if (now >= endDate) {
                        clearInterval(timer);
                        document.getElementById("hours").innerHTML = "00";
                        document.getElementById("minutes").innerHTML = "00";
                        document.getElementById("seconds").innerHTML = "00";
                        
                        // Optional: Sembunyikan atau reload section
                        // timerElement.closest('.card').style.opacity = '0.5';
                        return;
                    }
                }, 1000);
                
                function updateCountdown(distance) {
                    const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
                    const minutes = Math.floor((distance / (1000 * 60)) % 60);
                    const seconds = Math.floor((distance / 1000) % 60);
                    
                    updateTimer("hours", hours);
                    updateTimer("minutes", minutes);
                    updateTimer("seconds", seconds);
                }
                
                function updateTimer(id, newValue) {
                    const el = document.getElementById(id);
                    const formatted = newValue.toString().padStart(2, "0");
                    
                    if (el.textContent !== formatted) {
                        el.textContent = formatted;
                        el.classList.add("change");
                        setTimeout(() => el.classList.remove("change"), 400);
                    }
                }
            } else {
                // Jika tidak ada data promo, sembunyikan timer
                console.warn('Tidak ada data promo flashsale aktif');
            }
        }
    </script> --}}

    <script>
        // 🔹 Timer Flash Sale dengan Auto-Hide
        const timerElement = document.querySelector('.promo-timer');

        if (timerElement) {
            const startTime = timerElement.dataset.start;
            const endTime = timerElement.dataset.end;

            if (startTime && endTime) {
                const endDate = new Date(endTime).getTime();

                const timer = setInterval(() => {
                    const now = new Date().getTime();

                    // Jika sudah selesai, sembunyikan section
                    if (now >= endDate) {
                        clearInterval(timer);
                        document.getElementById("hours").textContent = "00";
                        document.getElementById("minutes").textContent = "00";
                        document.getElementById("seconds").textContent = "00";

                        const section = document.getElementById('promoSection');
                        if (section) {
                            section.style.transition = 'opacity 0.5s ease';
                            section.style.opacity = '0';
                            setTimeout(() => {
                                section.style.display = 'none';
                            }, 500);
                        }
                        return;
                    }

                    // ✅ Hitung mundur dari waktu sekarang sampai waktu selesai
                    const distance = endDate - now;
                    updateCountdown(distance);

                }, 1000);

                function updateCountdown(distance) {
                    // ✅ Total waktu tersisa dalam jam, menit, detik
                    const totalHours = Math.floor(distance / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    updateTimer("hours", totalHours);
                    updateTimer("minutes", minutes);
                    updateTimer("seconds", seconds);
                }

                function updateTimer(id, newValue) {
                    const el = document.getElementById(id);
                    if (!el) return;

                    const formatted = newValue.toString().padStart(2, "0");

                    if (el.textContent !== formatted) {
                        el.textContent = formatted;
                        el.classList.add("change");
                        setTimeout(() => el.classList.remove("change"), 400);
                    }
                }
            }
        }
    </script>

    {{-- <script>
        // 🔹 Timer mundur otomatis (contoh 2 jam dari sekarang)
        const countdownTime = new Date().getTime() + 2 * 60 * 60 * 1000;

        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = countdownTime - now;

            if (distance < 0) {
                clearInterval(timer);
                document.getElementById("hours").innerHTML = "00";
                document.getElementById("minutes").innerHTML = "00";
                document.getElementById("seconds").innerHTML = "00";
                return;
            }

            const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((distance / (1000 * 60)) % 60);
            const seconds = Math.floor((distance / 1000) % 60);

            document.getElementById("hours").innerHTML = hours.toString().padStart(2, "0");
            document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, "0");
            document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, "0");
        }, 1000);

        function updateTimer(id, newValue) {
            const el = document.getElementById(id);
            const currentValue = el.textContent;
            const formatted = newValue.toString().padStart(2, "0");

            if (currentValue !== formatted) {
                el.textContent = formatted;
                el.classList.add("change");
                setTimeout(() => el.classList.remove("change"), 400);
            }
        }
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            setTimeout(() => {

                document.querySelectorAll(".skeleton-item").forEach(el => {
                    el.classList.add("skeleton-hide");
                    setTimeout(() => el.remove(), 400);
                });

                document.querySelectorAll(".product-loaded").forEach(el => {
                    el.style.display = "block";
                });

                $(".trending-carousel").trigger("refresh.owl.carousel");

                // ✅ Show navigation setelah loaded
                setTimeout(() => {
                    document.getElementById("promoSection")
                        .classList.add("show-nav");
                    document.getElementById("produkSection")
                        .classList.add("show-nav");
                    document.getElementById("kategoriSection")
                        .classList.add("show-nav");
                }, 300);

            }, 5000);

        });
    </script>

    <script>
        function updateWishlistCount() {
            $.ajax({
                url: '{{ route('wishlist.count') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    const count = data.count ?? 0;
                    $('#wishlist-count').text(count);
                },
                error: function(err) {
                    console.log('Error fetching wishlist count', err);
                }
            });
        }

        // Panggil setiap kali halaman load
        $(document).ready(function() {
            updateWishlistCount();

            // Opsional: panggil setiap 10 detik agar real-time
            setInterval(updateWishlistCount, 10000);
        });
    </script>

    {{-- <script>
        $(document).on('click', '.wishlist-btn', function(event) {
            event.preventDefault(); // hentikan behavior default <button>
            event.stopPropagation(); // hentikan bubble ke <a> parent

            let btn = $(this);
            let id_produk = $(this).closest('button').data('id') || $(this).data('id');
            // icon love di gambar
            let iconLove = $('.love-produk[data-id="' + id_produk + '"]');


            $.ajax({
                url: `/wishlist/${id_produk}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status === 'added') {
                        btn.addClass('active');
                        iconLove.addClass('active');
                    } else if (res.status === 'removed') {
                        btn.removeClass('active');
                        iconLove.removeClass('active');
                    }

                    updateWishlistCount();
                },
                error: function(err) {
                    if (err.status === 401) {
                        alert('Silakan login terlebih dahulu untuk menambah wishlist!');
                        window.location.href = '/login';
                    }
                }
            });
        });
    </script> --}}

    <script>
        $(document).on('click', '.love-produk', function(event) {
            event.preventDefault();
            event.stopPropagation();

            let iconLove = $(this);
            let id_produk = iconLove.data('id');

            $.ajax({
                url: `/wishlist/${id_produk}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status === 'added') {
                        iconLove.addClass('active');
                        Toast.fire({
                            iconHtml: '❤️', // custom icon love
                            title: 'Produk ditambahkan ke Wishlist'
                        });
                    } else if (res.status === 'removed') {
                        iconLove.removeClass('active');
                        Toast.fire({
                            iconHtml: '💔', // custom icon patah love
                            title: 'Produk dihapus dari Wishlist'
                        });
                    }

                    updateWishlistCount();
                },
                error: function(err) {
                    if (err.status === 401) {
                        alert('Silakan login terlebih dahulu untuk menambah wishlist!');
                        window.location.href = '/login';
                    }
                }
            });
        });

        $(document).on('click', '.leaft-love-produk', function(event) {
            event.preventDefault();
            event.stopPropagation();

            let iconLove = $(this);
            let id_produk = iconLove.data('id');

            $.ajax({
                url: `/wishlist/${id_produk}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status === 'added') {
                        iconLove.addClass('active');
                        Toast.fire({
                            iconHtml: '❤️', // custom icon love
                            title: 'Produk ditambahkan ke Wishlist'
                        });
                    } else if (res.status === 'removed') {
                        iconLove.removeClass('active');
                        Toast.fire({
                            iconHtml: '💔', // custom icon patah love
                            title: 'Produk dihapus dari Wishlist'
                        });
                    }

                    updateWishlistCount();
                },
                error: function(err) {
                    if (err.status === 401) {
                        alert('Silakan login terlebih dahulu untuk menambah wishlist!');
                        window.location.href = '/login';
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            function updateKeranjangCount() {
                $.getJSON('/keranjang/count', function(data) {
                    $('.ti-shopping-cart').siblings('.nav-shop__circle').text(data.count);
                });
            }

            // Panggil pertama kali saat halaman load
            updateKeranjangCount();

            // Update otomatis setiap 10 detik
            setInterval(updateKeranjangCount, 10000);
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 🔹 Timer Big Sale Dinamis
            const bigTimerElement = document.querySelector('.big-timer');
            
            if (bigTimerElement) {
                const startTime = bigTimerElement.dataset.start;
                const endTime = bigTimerElement.dataset.end;
                
                if (startTime && endTime) {
                    const startDate = new Date(startTime).getTime();
                    const endDate = new Date(endTime).getTime();
                    
                    const elHours = document.getElementById('hours-big');
                    const elMinutes = document.getElementById('minutes-big');
                    const elSeconds = document.getElementById('seconds-big');
                    
                    // Jika elemen tidak ada, hentikan
                    if (!elHours || !elMinutes || !elSeconds) return;
                    
                    const intervalId = setInterval(() => {
                        const now = new Date().getTime();
                        
                        // Jika belum dimulai, tampilkan waktu menuju mulai
                        if (now < startDate) {
                            const distance = startDate - now;
                            updateBigSaleCountdown(distance);
                            return;
                        }
                        
                        // Jika sudah dimulai, hitung mundur sampai selesai
                        if (now >= startDate && now < endDate) {
                            const distance = endDate - now;
                            updateBigSaleCountdown(distance);
                            return;
                        }
                        
                        // Jika sudah selesai
                        if (now >= endDate) {
                            clearInterval(intervalId);
                            elHours.textContent = "00";
                            elMinutes.textContent = "00";
                            elSeconds.textContent = "00";
                            
                            // Optional: Sembunyikan section atau tampilkan notifikasi
                            // bigTimerElement.closest('section').style.opacity = '0.5';
                            return;
                        }
                    }, 1000);
                    
                    function updateBigSaleCountdown(distance) {
                        const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
                        const minutes = Math.floor((distance / (1000 * 60)) % 60);
                        const seconds = Math.floor((distance / 1000) % 60);
                        
                        updateBigSaleTimer("hours-big", hours);
                        updateBigSaleTimer("minutes-big", minutes);
                        updateBigSaleTimer("seconds-big", seconds);
                    }
                    
                    function updateBigSaleTimer(id, newValue) {
                        const el = document.getElementById(id);
                        const formatted = newValue.toString().padStart(2, "0");
                        
                        if (el.textContent !== formatted) {
                            el.textContent = formatted;
                            el.classList.add("change");
                            setTimeout(() => el.classList.remove("change"), 400);
                        }
                    }
                } else {
                    // console.warn('Tidak ada data promo Big Sale aktif');
                }
            }
        });
    </script> --}}

    <script>
        // 🔹 Timer Big Sale dengan Auto-Hide
        const bigTimerElement = document.querySelector('.big-timer');

        if (bigTimerElement) {
            const endTime = bigTimerElement.dataset.end;

            if (endTime) {
                const endDate = new Date(endTime).getTime();

                const intervalId = setInterval(() => {
                    const now = new Date().getTime();

                    // Jika sudah selesai, sembunyikan section
                    if (now >= endDate) {
                        clearInterval(intervalId);
                        document.getElementById("hours-big").textContent = "00";
                        document.getElementById("minutes-big").textContent = "00";
                        document.getElementById("seconds-big").textContent = "00";

                        const section = document.getElementById('bigSaleSection');
                        if (section) {
                            section.style.transition = 'opacity 0.5s ease';
                            section.style.opacity = '0';
                            setTimeout(() => {
                                section.style.display = 'none';
                            }, 500);
                        }
                        return;
                    }

                    // Hitung mundur
                    const distance = endDate - now;
                    updateBigSaleCountdown(distance);

                }, 1000);

                function updateBigSaleCountdown(distance) {
                    const totalHours = Math.floor(distance / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    updateBigSaleTimer("hours-big", totalHours);
                    updateBigSaleTimer("minutes-big", minutes);
                    updateBigSaleTimer("seconds-big", seconds);
                }

                function updateBigSaleTimer(id, newValue) {
                    const el = document.getElementById(id);
                    if (!el) return;

                    const formatted = newValue.toString().padStart(2, "0");

                    if (el.textContent !== formatted) {
                        el.textContent = formatted;
                        el.classList.add("change");
                        setTimeout(() => el.classList.remove("change"), 400);
                    }
                }
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maxLength = 30; // jumlah huruf maksimal yang ditampilkan

            document.querySelectorAll('.slice-nama').forEach(span => {
                const text = span.textContent.trim();

                if (text.length > maxLength) {
                    const shortened = text.slice(0, maxLength); // tambahkan elipsis
                    span.textContent = shortened;
                    span.setAttribute('title', text); // tooltip tetap nama lengkap
                }
            });
        });
    </script>
@endsection
