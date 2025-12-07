@extends('layouts/main-pelanggan')

@section('link')
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/linericon/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

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
    </style>
@endsection

@section('content')
    <style>
        /* --- TAB NAV SCROLLABLE --- */
        .promo-tabs-wrapper {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 5px;
            scrollbar-width: none;
        }

        .promo-tabs-wrapper::-webkit-scrollbar {
            display: none;
        }

        .promo-tabs {
            border-bottom: none !important;
            display: inline-flex;
            gap: 10px;
            flex-wrap: nowrap !important;
        }

        /* --- TAB BUTTON --- */
        .promo-tabs .nav-link {
            font-weight: 600;
            padding: 12px 40px;
            border-radius: 5px;
            color: #444;
            background: #f9f9f9;
            transition: all 0.25s ease;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
        }

        .promo-tabs .nav-link i {
            font-size: 28px;
            /* ikon dibesarkan */
            color: #444;
        }

        .promo-tabs .nav-link span {
            font-size: 14px;
            font-weight: 600;
            text-align: center;
        }

        .promo-tabs .nav-link.active i {
            color: #0d6efd;
        }

        .promo-tabs .nav-link:hover i {
            color: #0d6efd;
        }

        .promo-tabs .nav-link:hover {
            background: #fff;
            color: #0d6efd;
            border-color: #dbe7ff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .promo-tabs .nav-link.active {
            background-color: #fff !important;
            color: #0d6efd !important;
            font-weight: 600;
            border-bottom: 3px solid #0d6efd !important;
        }

        /* PRODUCT CARD */
        .product-card {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #eee;
            transition: .2s;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .product-card img {
            height: 150px;
            object-fit: cover;
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
    </style>

    <div class="container py-5 mb-5">

        <!-- TABS SCROLL -->
        <div class="promo-tabs-wrapper">
            <ul class="nav nav-tabs mb-4 promo-tabs" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active d-flex flex-column align-items-center" data-bs-toggle="tab" href="#tabFlash"
                        role="tab">
                        <i class="fa-solid fa-bolt fa-2x mb-1"></i> <!-- Icon listrik -->
                        <span>Flash Sale</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center" data-bs-toggle="tab" href="#tabBig"
                        role="tab">
                        <i class="fa-solid fa-fire fa-2x mb-1"></i> <!-- Icon api -->
                        <span>Big Sale</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center" data-bs-toggle="tab" href="#tabLain"
                        role="tab">
                        <i class="fa-solid fa-tags fa-2x mb-1"></i> <!-- Icon bandrol -->
                        <span>Promo Lainnya</span>
                    </a>
                </li>
            </ul>
        </div>

        <style>
            /* Banner Image */
            .banner-wrapper {
                width: 100%;
                height: 410px;
                object-fit: fill;
                /* 🔥 Tekan gambar biar muat penuh tanpa potong */
                border-radius: 12px;
                aspect-ratio: 16 / 9;
                overflow: hidden;
                border-radius: 10px;
                margin-bottom: 15px;
            }

            .banner-wrapper img {
                width: 100%;
                height: 100%;

                display: block;
            }

            /* Ribbon Header */
            .ribbon {
                min-width: 600px;
                font-size: 30px;
                font-weight: bold;
                color: #fff;

                --f: .5em;
                --r: .8em;

                position: relative;
                display: inline-block;
                margin-bottom: 15px;
                padding-inline: .75em;
                line-height: 2;

                background: #003366;
                border-bottom: var(--f) solid #0005;
                border-right: var(--r) solid #0000;

                clip-path: polygon(calc(100% - var(--r)) 0,
                        0 0,
                        0 calc(100% - var(--f)),
                        var(--f) 100%,
                        var(--f) calc(100% - var(--f)),
                        calc(100% - var(--r)) calc(100% - var(--f)),
                        100% calc(50% - var(--f)/2));
            }
        </style>

        <div class="tab-content">

            <div class="tab-pane fade show active" id="tabFlash" role="tabpanel">
                @if ($promoFlashsale && $produkFlashsale->count() > 0)
                    {{-- Ribbon --}}
                    <div class="ribbon mb-3">
                        <span style="display:inline-block; transform: skew(-10deg);">FLASH</span>
                        <span style="display:inline-block; transform: skew(-10deg);">
                            <i class="fa-solid fa-bolt text-warning"
                                style="font-size: 1.3em; position: relative; top: -1px; margin: 0 2px;"></i>ALE
                        </span>
                    </div>

                    {{-- Banner --}}
                    <div class="banner-wrapper mb-4">
                        <img src="{{ asset('storage/uploads/promo/' . $promoFlashsale->banner) }}"
                            alt="{{ $promoFlashsale->nama_promo }}">
                    </div>

                    {{-- Timer --}}
                    <div class="promo-timer-wrapper text-center mb-4">
                        <div class="promo-timer d-inline-flex align-items-center justify-content-center"
                            data-start="{{ $promoFlashsale->tgl_mulai }}" data-end="{{ $promoFlashsale->tgl_selesai }}">

                            <span class="line me-3"></span>
                            <span class="flash-text" style="display:inline-block; transform: skew(-10deg);">FLASH</span>
                            <span class="flash-text" style="display:inline-block; transform: skew(-10deg);">
                                <i class="fa-solid fa-bolt text-warning"
                                    style="font-size: 1.3em; position: relative; top: -1px; margin: 0 2px;"></i>ALE
                            </span>
                            <!-- Icon jam standar -->
                            <i class="fa-regular fa-clock timer-icon me-2"></i>
                            <span class="berakhir-text me-2">BERAKHIR DALAM</span>
                            <span class="time-digit" id="hours">00</span><span>:</span>
                            <span class="time-digit" id="minutes">00</span><span>:</span>
                            <span class="time-digit" id="seconds">00</span>
                            <span class="line ms-3"></span>
                        </div>
                    </div>

                    <style>
                        .promo-timer-wrapper {
                            display: flex;
                            justify-content: center;
                        }

                        .promo-timer {
                            font-family: 'Inter', sans-serif;
                            font-weight: 600;
                            font-size: 1rem;
                            color: #333;
                            gap: 8px;
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            padding: 10px 20px;
                            border-radius: 12px;
                            background: linear-gradient(90deg, rgba(13, 110, 253, 0.15), rgba(13, 110, 253, 0.05));
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                        }

                        .promo-timer .line {
                            display: inline-block;
                            height: 2px;
                            background-color: #d1d5db;
                            flex-grow: 1;
                            max-width: 70px;
                            border-radius: 2px;
                            transition: all 0.3s ease;
                        }

                        .flash-text,
                        .berakhir-text {
                            font-weight: 700;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        }

                        .flash-text {
                            color: #0d6efd;
                            font-size: 1.05rem;
                        }

                        .berakhir-text {
                            color: #555;
                            font-size: 0.95rem;
                        }

                        .timer-icon {
                            color: #444;
                            font-size: 1.2rem;
                        }

                        .time-digit {
                            display: inline-block;
                            min-width: 32px;
                            text-align: center;
                            font-family: 'Courier New', monospace;
                            font-size: 1rem;
                            padding: 2px 6px;
                            border-radius: 4px;
                            background-color: #f3f4f6;
                            color: #111;
                            transition: transform 0.3s ease, opacity 0.3s ease;
                        }

                        .time-digit.change {
                            animation: slideDown 0.4s ease;
                        }

                        @keyframes slideDown {
                            0% {
                                transform: translateY(-8px);
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

                        .promo-timer:hover .line {
                            background-color: #0d6efd;
                        }
                    </style>



                    {{-- Produk --}}
                    <section class="lattest-product-area pb-40 category-list">
                        <div class="product-scroll">
                            <div class="row g-3">
                                @foreach ($produkFlashsale as $p)
                                    @php
                                        $promoAktif = $p->promos->where('kategori', 'flashsale')->first();
                                        $diskon = $promoAktif ? $promoAktif->nilai_diskon : 0;
                                        $tipeDiskon = $promoAktif ? $promoAktif->tipe : null;

                                        if ($promoAktif) {
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

                                    <div class="col-6 col-md-4 col-lg-3 product-loaded col-xl-custom real-item">
                                        <div class="card text-center card-product h-100">
                                            <div class="card-product__img">
                                                <a href="/detail-produk/{{ $p->id_produk }}">
                                                    <img class="card-img"
                                                        src="{{ asset('storage/uploads/produk/' . $p->gambar) }}"
                                                        alt="{{ $p->nama_produk }}">
                                                </a>
                                                <i class="ti-heart love-produk {{ in_array($p->id_produk, $wishlistProdukIds ?? []) ? 'active' : '' }}"
                                                    data-id="{{ $p->id_produk }}"></i>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-product__title slice-nama">
                                                    <a href="/detail-produk/{{ $p->id_produk }}">{{ $p->nama_produk }}</a>
                                                </h5>
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
                @else
                    <p>Tidak ada promo flash sale aktif.</p>
                @endif
            </div>

            {{-- Script Timer --}}
            <script>
                const timerElement = document.querySelector('.promo-timer');

                if (timerElement) {
                    const startTime = timerElement.dataset.start;
                    const endTime = timerElement.dataset.end;

                    if (startTime && endTime) {
                        const endDate = new Date(endTime).getTime();

                        const timer = setInterval(() => {
                            const now = new Date().getTime();

                            if (now >= endDate) {
                                clearInterval(timer);
                                document.getElementById("hours").textContent = "00";
                                document.getElementById("minutes").textContent = "00";
                                document.getElementById("seconds").textContent = "00";
                                timerElement.style.display = 'none';
                                return;
                            }

                            const distance = endDate - now;
                            updateCountdown(distance);
                        }, 1000);

                        function updateCountdown(distance) {
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
                            el.textContent = newValue.toString().padStart(2, "0");
                        }
                    }
                }
            </script>

            {{-- Style Timer --}}
            {{-- <style>
                .promo-timer-wrapper {
                    text-align: center;
                }
            
                .promo-timer {
                    background-color: rgba(61, 57, 57, 0.85);
                    border: 1px solid rgba(255, 255, 255, 0.25);
                    color: #fff;
                    font-weight: 600;
                    border-radius: 8px;
                    font-size: 1rem;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    padding: 8px 16px;
                    box-shadow: 0 0 12px rgba(0, 234, 255, 0.4);
                    animation: pulseBlue 1.6s infinite ease-in-out;
                }
            
                .promo-timer i {
                    font-size: 1.5em;
                    color: #ffc107; /* icon jam kuning */
                }
            
                .flash-text, .berakhir-text {
                    font-weight: 700;
                    text-transform: uppercase;
                }
            
                .time-digit {
                    display: inline-block;
                    min-width: 28px;
                    text-align: center;
                    font-size: 1.1rem;
                    font-family: monospace;
                    transition: transform 0.4s ease, opacity 0.4s ease;
                }
            
                @keyframes pulseBlue {
                    0% { box-shadow: 0 0 6px rgba(0, 234, 255, 0.3); }
                    50% { box-shadow: 0 0 14px rgba(0, 234, 255, 0.6); }
                    100% { box-shadow: 0 0 6px rgba(0, 234, 255, 0.3); }
                }
            
                .time-digit.change {
                    animation: slideDown 0.4s ease;
                }
            
                @keyframes slideDown {
                    0% { transform: translateY(-10px); opacity: 0.3; }
                    50% { transform: translateY(3px); opacity: 0.9; }
                    100% { transform: translateY(0); opacity: 1; }
                }
            </style>
             --}}


            <div class="tab-pane fade show" id="tabBig" role="tabpanel">

                @if ($promoBigsale && $produkBigsale->count() > 0)
                    {{-- Ribbon --}}
                    <div class="ribbon mb-3" style="background:linear-gradient(90deg, #8b1c1c, #b33a3a);"><i
                            class="fa-solid fa-fire me-1" style=" style="font-size:1.4rem; line-height:1;
                            color:#fff8f0;""></i> {{ $promoBigsale->nama_promo }}</div>

                    {{-- Banner --}}
                    <div class="banner-wrapper mb-4">
                        <img src="{{ asset('storage/uploads/promo/' . $promoBigsale->banner) }}"
                            alt="{{ $promoBigsale->nama_promo }}">
                    </div>

                    <div class="promo-timer-wrapper text-center mb-4">
                        <div class="big-timer d-inline-flex align-items-center justify-content-center"
                            data-start="{{ $promoBigsale->tgl_mulai }}" data-end="{{ $promoBigsale->tgl_selesai }}">

                            <span class="big-line me-3"></span>
                            <i class="fa-solid fa-fire big-fire-icon me-1"></i>
                            <span class="big-flash-text me-2">BIG SALE</span>
                            <i class="fa-regular fa-clock big-timer-icon me-2"></i>
                            <span class="big-berakhir-text me-2">BERAKHIR DALAM</span>
                            <span class="big-time-digit" id="hours-big">00</span><span>:</span>
                            <span class="big-time-digit" id="minutes-big">00</span><span>:</span>
                            <span class="big-time-digit" id="seconds-big">00</span>
                            <span class="big-line ms-3"></span>
                        </div>
                    </div>

                    <style>
                        .big-timer {
                            font-family: 'Inter', sans-serif;
                            font-weight: 600;
                            font-size: 1rem;
                            color: #fff8f0;
                            /* soft cream */
                            gap: 10px;
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            padding: 12px 24px;
                            border-radius: 12px;
                            background: linear-gradient(90deg, #8b1c1c, #b33a3a);
                            /* merah gelap ke merah medium */
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        }

                        /* Lines */
                        .big-line {
                            display: inline-block;
                            height: 1.5px;
                            background-color: rgba(255, 255, 255, 0.3);
                            flex-grow: 1;
                            max-width: 60px;
                            border-radius: 1px;
                        }

                        /* Text */
                        .big-flash-text,
                        .big-berakhir-text {
                            font-weight: 700;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            color: #fff8f0;
                        }

                        /* Icon Jam */
                        .big-timer-icon {
                            color: #fff8f0;
                            font-size: 1.1rem;
                        }

                        /* Icon Api */
                        .big-fire-icon {
                            color: #fff8f0;
                            font-size: 1.1rem;
                        }

                        /* Timer Digits */
                        .big-time-digit {
                            display: inline-block;
                            min-width: 30px;
                            text-align: center;
                            font-family: 'Courier New', monospace;
                            font-size: 0.95rem;
                            padding: 3px 6px;
                            border-radius: 4px;
                            background-color: rgba(255, 255, 255, 0.15);
                            color: #fff8f0;
                            transition: transform 0.3s ease, opacity 0.3s ease;
                        }

                        /* Digit Change Animation */
                        .big-time-change {
                            animation: bigSlideDown 0.4s ease;
                        }

                        @keyframes bigSlideDown {
                            0% {
                                transform: translateY(-5px);
                                opacity: 0.3;
                            }

                            50% {
                                transform: translateY(2px);
                                opacity: 0.8;
                            }

                            100% {
                                transform: translateY(0);
                                opacity: 1;
                            }
                        }

                        /* Hover effect: subtle shadow */
                        .big-timer:hover {
                            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
                            transition: box-shadow 0.2s ease;
                        }
                    </style>


                    {{-- Script Timer Big Sale --}}
                    <script>
                        const bigTimerElement = document.querySelector('.big-timer');

                        if (bigTimerElement) {
                            const endTime = bigTimerElement.dataset.end;
                            if (endTime) {
                                const endDate = new Date(endTime).getTime();
                                const intervalId = setInterval(() => {
                                    const now = new Date().getTime();
                                    if (now >= endDate) {
                                        clearInterval(intervalId);
                                        document.getElementById("hours-big").textContent = "00";
                                        document.getElementById("minutes-big").textContent = "00";
                                        document.getElementById("seconds-big").textContent = "00";
                                        const section = document.getElementById('tabBig');
                                        if (section) {
                                            section.style.transition = 'opacity 0.5s ease';
                                            section.style.opacity = '0';
                                            setTimeout(() => {
                                                section.style.display = 'none';
                                            }, 500);
                                        }
                                        return;
                                    }
                                    const distance = endDate - now;
                                    const totalHours = Math.floor(distance / (1000 * 60 * 60));
                                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                    updateTimer("hours-big", totalHours);
                                    updateTimer("minutes-big", minutes);
                                    updateTimer("seconds-big", seconds);
                                }, 1000);
                            }

                            function updateTimer(id, value) {
                                const el = document.getElementById(id);
                                if (!el) return;
                                const formatted = value.toString().padStart(2, "0");
                                if (el.textContent !== formatted) {
                                    el.textContent = formatted;
                                    el.classList.add("big-time-change");
                                    setTimeout(() => el.classList.remove("big-time-change"), 400);
                                }
                            }
                        }
                    </script>


                    {{-- Produk --}}
                    <section class="lattest-product-area pb-40 category-list">
                        <div class="product-scroll">
                            <div class="row g-3">
                                @foreach ($produkBigsale as $p)
                                    @php
                                        $promoAktif = $p->promos->where('kategori', 'bigsale')->first();
                                        $diskon = $promoAktif ? $promoAktif->nilai_diskon : 0;
                                        $tipeDiskon = $promoAktif ? $promoAktif->tipe : null;

                                        if ($promoAktif) {
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

                                    <div class="col-6 col-md-4 col-lg-3 product-loaded col-xl-custom real-item">
                                        <div class="card text-center card-product h-100">
                                            <div class="card-product__img">
                                                <a href="/detail-produk/{{ $p->id_produk }}">
                                                    <img class="card-img"
                                                        src="{{ asset('storage/uploads/produk/' . $p->gambar) }}"
                                                        alt="{{ $p->nama_produk }}">
                                                </a>
                                                <i class="ti-heart love-produk {{ in_array($p->id_produk, $wishlistProdukIds ?? []) ? 'active' : '' }}"
                                                    data-id="{{ $p->id_produk }}"></i>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-product__title slice-nama">
                                                    <a
                                                        href="/detail-produk/{{ $p->id_produk }}">{{ $p->nama_produk }}</a>
                                                </h5>
                                                <p class="card-product__price">
                                                    <a href="/detail-produk/{{ $p->id_produk }}">
                                                        <span class="text-muted"
                                                            style="text-decoration: line-through; opacity: 0.6; font-size: 2.3vh;">
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
                @else
                    <p>Tidak ada Big flash sale aktif.</p>
                @endif

            </div>





            <div class="tab-pane fade show" id="tabLain" role="tabpanel">

                @if($produkUmumSaleList && count($produkUmumSaleList) > 0)
            
                    @foreach($produkUmumSaleList as $item)
                        @php
                            $promoUmum = $item['promo'];
                            $produkUmumSale = $item['produk'];
                        @endphp
            
                        {{-- Ribbon --}}
                        <div class="ribbon mb-3">{{ $promoUmum->nama_promo }}</div>
            
                        {{-- Banner --}}
                        <div class="banner-wrapper mb-4">
                            <img src="{{ asset('storage/uploads/promo/' . $promoUmum->banner) }}"
                                 alt="{{ $promoUmum->nama_promo }}">
                        </div>
            
                        {{-- Produk --}}
                        <section class="lattest-product-area pb-40 category-list">
                            <div class="product-scroll">
                                <div class="row g-3">
                                    @foreach($produkUmumSale as $p)
                                        @php
                                            $promoAktif = $p->promos->where('kategori', 'umum')
                                                                    ->where('id', $promoUmum->id)
                                                                    ->first();
                                            $diskon = $promoAktif ? $promoAktif->nilai_diskon : 0;
                                            $tipeDiskon = $promoAktif ? $promoAktif->tipe : null;
            
                                            if ($promoAktif) {
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
            
                                        <div class="col-6 col-md-4 col-lg-3 product-loaded col-xl-custom real-item">
                                            <div class="card text-center card-product {{ $promoAktif && $promoAktif->tipe === 'Persen' ? 'promo' : '' }}"
                                                 data-diskon="{{ $diskon }}">
                                                <div class="card-product__img">
                                                    <a href="/detail-produk/{{ $p->id_produk }}">
                                                        <img class="card-img"
                                                             src="{{ asset('storage/uploads/produk/' . $p->gambar) }}"
                                                             alt="{{ $p->nama_produk }}">
                                                    </a>
                                                    <i class="ti-heart leaft-love-produk {{ in_array($p->id_produk, $wishlistProdukIds ?? []) ? 'active' : '' }}"
                                                       data-id="{{ $p->id_produk }}"></i>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-product__title slice-nama">
                                                        <a href="/detail-produk/{{ $p->id_produk }}">{{ $p->nama_produk }}</a>
                                                    </h5>
                                                    <p class="card-product__price mb-2">
                                                        <a href="/detail-produk/{{ $p->id_produk }}">
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
            
                    @endforeach
            
                @else
                    <p>Tidak ada promo umum aktif.</p>
                @endif
            </div>
            

        </div>

    </div>

    <style>
        /* Custom col untuk 5 per baris di XL */
        @media (min-width: 1200px) {
            .col-xl-custom {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }
    </style>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Cek hash di URL
            const hash = window.location.hash;
    
            if(hash) {
                const tabLink = document.querySelector('.promo-tabs a[href="' + hash + '"]');
                if(tabLink) {
                    // Gunakan Bootstrap 5 tab API
                    const tab = new bootstrap.Tab(tabLink);
                    tab.show();
                }
            }
        });
    </script>
    

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
        $(document).on('click', '.wishlist-btn', function() {
            let btn = $(this);
            let id_produk = $(this).data('id');
            let icon = $(this).find('i');

            $.ajax({
                url: `/wishlist/${id_produk}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status === 'added') {
                        // ubah warna ke merah (aktif)
                        btn.css({
                            backgroundColor: '#D60000',
                            color: 'white',
                            transition: 'all 0.3s ease'
                        });
                        icon.css('color', 'white');
                        Toast.fire({
                            icon: 'success',
                            title: 'Produk ditambahkan ke Wishlist ❤️'
                        });
                        // alert('Produk ditambahkan ke wishlist ❤️');
                    } else if (res.status === 'removed') {
                        btn.css({
                            backgroundColor: '#fff0f0',
                            color: '#D60000',
                            transition: 'all 0.3s ease'
                        });
                        icon.css('color', '#D60000');
                        Toast.fire({
                            icon: 'warning',
                            title: 'Produk dihapus dari Wishlist 💔'
                        });
                        // alert('Produk dihapus dari wishlist');
                    }
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
@endsection
