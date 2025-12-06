@extends('layouts/main-pelanggan-no-footer')

@section('link')
<style>
    /* Layout utama dua kolom */
    .faq-container {
        display: grid;
        grid-template-columns: 1fr 2.5fr;
        gap: 30px;
        margin-top: 40px;
    }

    /* Sidebar kiri */
    .faq-sidebar {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 25px;
        height: fit-content;
    }

    .faq-sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .faq-sidebar ul li {
        margin-bottom: 12px;
    }

    .faq-sidebar a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: color 0.2s;
    }

    .faq-sidebar a:hover,
    .faq-sidebar a.active {
        color: #007bff;
    }

    /* Konten kanan */
    .faq-content {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 35px 30px;
    }

    .faq-content h4 {
        margin-bottom: 25px;
        font-weight: 700;
        color: #007bff;
    }

    /* List Kebijakan */
    .policy-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .policy-item {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .policy-item h6 {
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }

    .policy-item p {
        margin: 0;
        color: #555;
        line-height: 1.6;
    }

    .empty-state {
        text-align: center;
        color: #888;
        font-style: italic;
        padding: 30px 0;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .faq-container {
            grid-template-columns: 1fr;
        }

        .faq-sidebar {
            margin-bottom: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="faq-container" style="margin-bottom: 15vh;">
        <!-- Sidebar kiri -->
        <aside class="faq-sidebar">
            <ul>
                <li><a href="/kebijakan-toko" class="active">Kebijakan Toko</a></li>
                <li><a href="/faq">FAQ</a></li>
            </ul>
        </aside>

        <!-- Konten kanan -->
        <section class="faq-content">
            <h4>Kebijakan Toko</h4>

            @if ($kebijakan->isEmpty())
                <p class="empty-state">Belum ada kebijakan yang tersedia saat ini.</p>
            @else
                <ul class="policy-list">
                    @foreach ($kebijakan as $index => $item)
                        <li class="policy-item">
                            <h6>{{ $index + 1 }}. {{ $item->judul ?? 'Tanpa Judul' }}</h6>
                            <p>{!! $item->isi !!}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>
</div>
@endsection

@section('script')
<script>
    // Highlight menu aktif otomatis
    const currentUrl = window.location.href;
    document.querySelectorAll('.faq-sidebar a').forEach(link => {
        if (link.href === currentUrl) link.classList.add('active');
    });
</script>
@endsection
