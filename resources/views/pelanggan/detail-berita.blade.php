@extends('layouts/main-pelanggan')

@section('link')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .news-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        margin: 60px auto;
        max-width: 1100px;
        margin-top: 40px;
    }

    .news-main h2 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .news-meta {
        font-size: 14px;
        color: #777;
        margin-bottom: 20px;
    }

    .news-main img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        margin-bottom: 25px;
        border-radius: 10px;
    }

    .news-content p {
        line-height: 1.8;
        color: #444;
        margin-bottom: 15px;
    }

    .news-content img {
        max-width: 100%;
        border-radius: 10px;
        margin: 15px 0;
        object-fit: cover;
    }

    .share-section {
        margin-top: 40px;
        border-top: 1px solid #ddd;
        padding-top: 20px;
    }

    .share-section h6 {
        font-weight: 700;
        margin-bottom: 12px;
    }

    .share-buttons {
        display: flex;
        gap: 12px;
    }

    .share-buttons a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        transition: transform 0.2s, opacity 0.2s;
    }

    .share-buttons a:hover {
        transform: translateY(-3px);
        opacity: 0.9;
    }

    .share-facebook { background: #1877f2; }
    .share-twitter { background: #1da1f2; }
    .share-whatsapp { background: #25d366; }
    .share-linkedin { background: #0077b5; }

    .sidebar-title {
        font-weight: 700;
        margin-bottom: 20px;
    }

    .sidebar-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 18px;
        border-bottom: 1px solid #eee;
        padding-bottom: 12px;
    }

    .sidebar-item img {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
    }

    .sidebar-item h6 {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
        font-size: 15px;
        line-height: 1.3;
    }

    .sidebar-item p {
        font-size: 13px;
        color: #777;
        margin: 0;
    }

    .sidebar-item:hover h6 {
        color: #007bff;
    }

    @media (max-width: 992px) {
        .news-container {
            grid-template-columns: 1fr;
            gap: 25px;
            padding: 0 10px;
            margin-top: 3vh;
        }
        .news-main img {
            height: 300px;
        }
        .sidebar-title {
            margin-top: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="news-container">
        <!-- Kiri: Konten Berita -->
        <div class="news-main">
            <h2>{{ $berita->judul }}</h2>
            <div class="news-meta">
                <i class="fa-regular fa-calendar"></i>
                {{ \Carbon\Carbon::parse($berita->tgl)->translatedFormat('d F Y') }}
                &nbsp; | &nbsp;
                <i class="fa-solid fa-user"></i> {{ $berita->user->name ?? 'Admin' }}
            </div>

            <img src="{{ asset('storage/uploads/berita/' . $berita->gambar) }}" alt="{{ $berita->judul }}">

            <div class="news-content">
                {!! $berita->isi !!}
            </div>

            <!-- Bagikan Artikel -->
            <div class="share-section">
                <h6>Bagikan Artikel Ini:</h6>
                <div class="share-buttons">
                    <a href="#" class="share-facebook" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="share-twitter" title="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" class="share-whatsapp" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" class="share-linkedin" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <!-- Kanan: Berita Lainnya -->
        <aside>
            <h5 class="sidebar-title">Berita Lainnya</h5>

            @foreach ($beritaLain as $lain)
            <div class="sidebar-item">
                <a href="/detail-berita/{{ $lain->id_berita }}">
                    <img src="{{ asset('storage/uploads/berita/' . $lain->gambar) }}" alt="{{ $lain->judul }}">
                </a>
                <div>
                    <h6>
                        <a href="/detail-berita/{{ $lain->id_berita }}" style="text-decoration:none;">
                            {{ Str::limit($lain->judul, 40) }}
                        </a>
                    </h6>
                    <p>{{ \Carbon\Carbon::parse($lain->tgl)->translatedFormat('d M Y') }}</p>
                </div>
            </div>
            @endforeach
        </aside>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const currentUrl = encodeURIComponent(window.location.href);
    document.querySelector('.share-facebook').href = `https://www.facebook.com/sharer/sharer.php?u=${currentUrl}`;
    document.querySelector('.share-twitter').href = `https://twitter.com/intent/tweet?url=${currentUrl}`;
    document.querySelector('.share-whatsapp').href = `https://wa.me/?text=${currentUrl}`;
    document.querySelector('.share-linkedin').href = `https://www.linkedin.com/sharing/share-offsite/?url=${currentUrl}`;
</script>
@endsection
