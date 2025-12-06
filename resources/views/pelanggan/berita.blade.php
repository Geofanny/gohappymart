@extends('layouts/main-pelanggan')

@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .news-section {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 20px;
            margin-top: 40px;
        }

        .news-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .news-header h2 {
            font-weight: 700;
            color: #007bff;
            margin-bottom: 10px;
        }

        .news-header p {
            color: #666;
            font-size: 0.95rem;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .news-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            display: flex;
            flex-direction: column;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .news-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .news-body {
            padding: 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        .news-title {
            font-weight: 700;
            color: #007bff;
            font-size: 1rem;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .news-meta {
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 10px;
        }

        .news-meta i {
            color: #007bff;
            margin-right: 6px;
        }

        .news-desc {
            color: #555;
            line-height: 1.5;
            font-size: 0.93rem;
        }

        .read-more {
            color: #007bff;
            font-weight: 600;
            text-decoration: none;
            margin-top: 10px;
            align-self: flex-start;
        }

        .read-more:hover {
            text-decoration: underline;
        }

        /* ===== Pagination Style ===== */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .pagination {
            list-style: none;
            display: flex;
            gap: 8px;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination li a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid #007bff;
            color: #007bff;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .pagination li a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .pagination li.active a {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination li.disabled a {
            pointer-events: none;
            opacity: 0.5;
        }

        .pagination i {
            font-size: 14px;
        }

        @media (max-width: 992px) {
            .news-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .news-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="news-section">
        <div class="news-header">
            <h2>Berita Terbaru</h2>
            <p>Temukan kabar dan promo menarik terbaru dari kami</p>
        </div>

        <div class="news-grid">
            @foreach ($berita as $item)
                <div class="news-card">
                    <a href="/detail-berita/{{ $item->id_berita }}">
                    <img src="{{ asset('storage/uploads/berita/' . $item->gambar) }}" alt="{{ $item->judul }}"
                        class="news-image">
                    <div class="news-body">
                        <div>
                            <h4 class="news-title">{{ $item->judul }}</h4>
                            <p class="news-meta">
                                <i class="fa-regular fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($item->tgl)->translatedFormat('d F Y') }}
                            </p>
                            <p class="news-desc">
                                {{ Str::limit(strip_tags($item->isi), 120, '...') }}
                            </p>
                        </div>
                        <a href="/detail-berita/{{ $item->id_berita }}" class="read-more">Baca Selengkapnya</a>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            <ul class="pagination">
                {{-- Tombol Previous --}}
                @if ($berita->onFirstPage())
                    <li><a href="#" style="pointer-events:none;opacity:0.5;"><i
                                class="fa-solid fa-angle-left"></i></a></li>
                @else
                    <li><a href="{{ $berita->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i></a></li>
                @endif

                {{-- Nomor Halaman --}}
                @foreach ($berita->getUrlRange(1, $berita->lastPage()) as $page => $url)
                    <li class="{{ $page == $berita->currentPage() ? 'active' : '' }}">
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Tombol Next --}}
                @if ($berita->hasMorePages())
                    <li><a href="{{ $berita->nextPageUrl() }}"><i class="fa-solid fa-angle-right"></i></a></li>
                @else
                    <li><a href="#" style="pointer-events:none;opacity:0.5;"><i
                                class="fa-solid fa-angle-right"></i></a></li>
                @endif
            </ul>
        </div>

    </div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
