@extends('layouts/main-pelanggan-no-footer')
@section('link')
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/linericon/style.css">
    <style>
        .card-product__img {
            position: relative;
            /* agar icon bisa diposisikan di dalam gambar */
            overflow: hidden;
        }

        .card-product__img img {
            width: 100%;
            height: 180px;
            /* sesuaikan kebutuhan */
            object-fit: cover;
            border-radius: 5px;
            /* opsional biar lebih halus */
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
            height: 130px;
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
    </style>
    <style>
        /* Container scroll khusus produk */
        .product-scroll {
            max-height: 90vh;      /* tinggi area scroling */
            overflow-y: auto;       /* aktifkan scroll vertikal */
            padding-right: 8px;     /* biar tidak nutup scrollbar */
        }
    
        /* Sembunyikan scrollbar (opsional) */
        .product-scroll::-webkit-scrollbar {
            width: 6px;
        }
    
        /* .product-scroll::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        } */
    
        .product-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
    
@endsection

@section('content')
    <section class="section-margin--small" style="margin-top: 8vh; height: margin-bottom:5vh; ">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-5">
                    <div class="sidebar-categories">
                        <div class="head" style="background: #007BFF;">Filter Pencarian</div>
                        <ul class="main-categories">
                            <li class="common-filter">
                                <div class="mb-2" style="font-weight: bold;">Kategori</div>
                                <form action="{{ route('pelanggan.cariProduk') }}" method="GET" class="w-100">
                                    <ul>
                                        @foreach ($kategori as $k)
                                            <li class="filter-list">
                                                <input class="pixel-radio" type="radio"
                                                    id="kategori-{{ $k->id_kategori }}" name="kategori"
                                                    value="{{ $k->id_kategori }}" onchange="this.form.submit()"
                                                    {{ request('kategori') == $k->id_kategori ? 'checked' : '' }}>
                                                <label for="kategori-{{ $k->id_kategori }}">
                                                    <span
                                                        style="font-size: 14px;">{{ ucwords(strtolower($k->nama)) }}</span>
                                                    <span>({{ $k->produk_count }})</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="col-xl-9 col-lg-8 col-md-7">
                    <!-- Start Filter Bar -->
                    <div class="filter-bar d-flex flex-wrap align-items-center">
                        <div>
                            <form action="{{ route('pelanggan.cariProduk') }}" method="GET" class="w-100">
                                <div class="input-group filter-bar-search">
                                    <input type="text" name="q" placeholder="Search" value="{{ $query ?? '' }}">
                                    <div class="input-group-append">
                                        <button type="button"><i class="ti-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Filter Bar -->
                    <!-- Start Best Seller -->
                    <section class="lattest-product-area pb-40 category-list">
                        <div class="row g-3" id="skeletonContainer" style="margin-top: -1vh;">
                            @for ($i = 0; $i < 10; $i++)
                                <div class="col-6 col-md-4 col-lg-3 skeleton-show skeleton-item mb-5">
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

                        <div class="product-scroll">
                            <div class="row g-3">

                                @foreach ($produk as $p)
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

                                    <div class="col-6 col-md-4 col-lg-3 product-loaded real-item">
                                        <div class="card text-center card-product h-100">
                                            <div class="card-product__img">
                                                <a href="/detail-produk/{{ $p->id_produk }}">
                                                    <img class="card-img"
                                                        src="{{ asset('storage/uploads/produk/' . $p->gambar) }}"
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
                    <!-- End Best Seller -->
                </div>
            </div>
        </div>
    </section>
@section('script')
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
@endsection
@endsection
