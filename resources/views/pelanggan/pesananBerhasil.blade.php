@extends('layouts/main-pelanggan-no-footer')

@section('content')
<style>
    /* Animasi checkmark */
    .checkmark {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        border: 5px solid #28a745;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pop 0.4s ease forwards;
    }

    .checkmark::after {
        content: "";
        position: absolute;
        width: 40px;
        height: 20px;
        border-left: 5px solid #28a745;
        border-bottom: 5px solid #28a745;
        transform: rotate(-45deg) scale(0);
        animation: draw 0.6s ease forwards 0.4s;
    }

    @keyframes pop {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @keyframes draw {
        from { transform: rotate(-45deg) scale(0); opacity: 0; }
        to { transform: rotate(-45deg) scale(1); opacity: 1; }
    }
</style>

<div class="container py-5 my-2">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10 text-center">

            {{-- Icon centang --}}
            <div class="checkmark mx-auto mb-4"></div>

            {{-- Judul --}}
            <h2 class="fw-bold text-success mb-3">Pesanan Berhasil!</h2>

            {{-- Pesan --}}
            <p class="text-muted mb-4 px-3">
                Terima kasih telah berbelanja. Pesanan kamu sudah kami terima dan sedang diproses.
            </p>

            {{-- Tombol Aksi --}}
            <div class="d-grid gap-5 d-sm-flex justify-content-center" style="gap: 3vh;">
                <a href="/" class="btn btn-success px-4 py-2 fw-semibold">
                    Kembali ke Beranda
                </a>
                <a href="/pesanan" class="btn btn-primary px-4 py-2 fw-semibold">
                    Lihat Pesanan Saya
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    {{-- Bootstrap Icons (untuk icon rumah & tas pesanan) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
