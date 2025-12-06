@extends('layouts/main-pelanggan')

@section('link')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ===== HERO SECTION ===== */
        .contact-hero {
            text-align: center;
            padding: 60px 20px 40px;
            background: linear-gradient(135deg, #007bff, #00a8ff);
            color: #fff;
            border-radius: 0 0 40px 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .contact-hero h2 {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .contact-hero p {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* ===== MAIN LAYOUT ===== */
        .contact-wrapper {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 40px;
            margin: 60px auto;
            max-width: 1100px;
        }

        .contact-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
            padding: 35px;
        }

        /* ===== FORM STYLING ===== */
        .contact-form label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
            display: block;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 15px;
            color: #555;
            margin-bottom: 15px;
            transition: border-color 0.2s;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        .contact-form button {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background-color 0.25s;
        }

        .contact-form button:hover {
            background-color: #0056b3;
        }

        /* ===== INFO KONTAK + MAPS ===== */
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 25px;
            margin-bottom: 25px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .contact-item i {
            font-size: 20px;
            color: #007bff;
            margin-top: 3px;
            flex-shrink: 0;
        }

        .contact-item h6 {
            font-weight: 700;
            color: #007bff;
            margin-bottom: 6px;
        }

        .contact-item p {
            color: #555;
            margin: 0;
            line-height: 1.5;
        }

        .contact-map {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .contact-map iframe {
            width: 100%;
            height: 250px;
            border: none;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .contact-wrapper {
                grid-template-columns: 1fr;
                gap: 30px;
                padding: 0 20px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="contact-hero">
        <h2 style="color: white">Hubungi Kami</h2>
        <p>Kami senang mendengar dari Anda! Silakan kirim pesan atau kunjungi kami langsung di lokasi toko.</p>
    </section>

    <!-- Main Content -->
    <div class="contact-wrapper">
        <!-- Kolom Kiri: Form -->
        <div class="contact-card">
            <h4 class="mb-3 text-primary fw-bold">Kirim Pesan</h4>
            <form class="contact-form" method="POST" action="#">
                @csrf
                <div>
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Masukkan nama Anda" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Masukkan email aktif" required>
                </div>
                <div>
                    <label>Subjek</label>
                    <input type="text" name="subjek" placeholder="Masukkan subjek pesan" required>
                </div>
                <div>
                    <label>Pesan</label>
                    <textarea name="pesan" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
                </div>
                <button type="submit">Kirim Pesan</button>
            </form>
        </div>

        @php
            // Pisahkan alamat dan koordinat
            $alamatParts = explode('|', $kontak->alamat);
            $alamatTeks = trim($alamatParts[0]);
            $koordinat = isset($alamatParts[1]) ? trim($alamatParts[1]) : null;

            // Default lokasi jika tidak ada koordinat
            $defaultMap =
                'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.7093916783285!2d106.82370107475128!3d-6.175392460519197!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e3a1b0d3f9%3A0x5039cf9b4575b50!2sMonas!5e0!3m2!1sid!2sid!4v1691234567890!5m2!1sid!2sid';

            // Buat URL peta dinamis berdasarkan koordinat
            $mapUrl = $koordinat ? "https://www.google.com/maps?q={$koordinat}&hl=id&z=15&output=embed" : $defaultMap;
        @endphp

        <div class="contact-card">
            <h4 class="mb-3 text-primary fw-bold">Informasi Kontak</h4>

            <div class="contact-info">
                <div class="contact-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <div>
                        <h6>Alamat</h6>
                        <p>{{ $alamatTeks }}</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <div>
                        <h6>Telepon</h6>
                        <p>{{ $kontak->no_hp }}</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <div>
                        <h6>Email</h6>
                        <p>{{ $kontak->email }}</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fa-brands fa-whatsapp"></i>
                    <div>
                        <h6>WhatsApp</h6>
                        <p><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kontak->no_hp) }}" target="_blank"
                                style="color:#007bff; text-decoration:none;">Chat Sekarang</a></p>
                    </div>
                </div>
            </div>

            <!-- Maps Dinamis -->
            <div class="contact-map" style="position: relative;">
                <iframe src="{{ $mapUrl }}" allowfullscreen loading="lazy"></iframe>
                <div class="circle-overlay"></div>
            </div>
            <style>
                .circle-overlay {
                    position: absolute;
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    border: 3px solid red;
                    background-color: rgba(255, 0, 0, 0.2);
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    pointer-events: none;
                    /* biar iframe tetap bisa diklik */
                }
            </style>
        </div>

    </div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
