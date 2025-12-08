@extends('layouts/main-pelanggan')

@section('link')
    <style>
        .image-section {
            position: relative;
            text-align: center;
        }

        .main-image {
            width: 100%;
            max-width: 750px;
            height: 450px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Card umum */
        .overlay-card {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 25px 22px;
            border-radius: 20px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
            width: 380px;
            text-align: left;
            backdrop-filter: blur(5px);

            /* animasi awal */
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease;
        }

        /* Saat muncul di layar */
        .overlay-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Posisi card */
        .card-motto {
            top: 10%;
            left: 1%;
        }

        .card-visi {
            top: 40%;
            right: 1%;
        }

        .card-misi {
            bottom: 10%;
            left: 1%;
        }

        .overlay-card h5 {
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .overlay-card p {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 0;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .overlay-card {
                width: 90%;
                left: 50% !important;
                right: auto !important;
                transform: translateX(-50%);
                padding: 20px 24px;
            }

            .card-motto {
                top: 5%;
            }

            .card-visi {
                top: 40%;
            }

            .card-misi {
                bottom: 5%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        @if (!$toko)
            <div class="mt-5 mb-5 text-center" style="padding: 40px 0;">
                <h4 class="fw-semibold" style="color: #333;">
                    Informasi Toko Belum Tersedia
                </h4>

                <p class="text-muted" style="font-size: 0.95rem; line-height: 1.6; max-width: 480px; margin: 10px auto 0;">
                    Data mengenai toko saat ini belum ditambahkan.
                    Silakan kembali lagi nanti untuk melihat informasi terbaru.
                </p>

                <div
                    style="
                height: 3px;
                width: 70px;
                background: #dcdcdc;
                border-radius: 50px;
                margin: 25px auto 0;
            ">
                </div>
            </div>
        @else
            <div class="section-intro mb-5">
                <h2>Tentang <span class="section-intro__style">Kami</span></h2>
            </div>
            <div class="mb-4">
                <p class="text-muted">
                    {!! $toko->deskripsi !!}
                </p>
            </div>

            <div class="image-section mb-5">
                <img src="{{ asset('storage/uploads/toko/gambar/' . $toko->gambar) }}" alt="Tentang Kami" class="main-image">

                <!-- Card Motto -->
                <div class="overlay-card card-motto">
                    <h5 class="fw-bold text-primary">Motto Kami</h5>
                    <p>{{ $toko->tagline }}</p>
                </div>

                <!-- Card Visi -->
                <div class="overlay-card card-visi">
                    <h5 class="fw-bold text-success">Visi</h5>
                    <p>{{ $toko->visi }}</p>
                </div>

                <!-- Card Misi -->
                <div class="overlay-card card-misi">
                    <h5 class="fw-bold text-warning">Misi</h5>
                    <p>
                        {{ $toko->misi }}
                    </p>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cards = document.querySelectorAll('.overlay-card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                        observer.unobserve(entry.target); // biar animasi cuma sekali
                    }
                });
            }, {
                threshold: 0.3
            });

            cards.forEach(card => observer.observe(card));
        });
    </script>
@endsection
