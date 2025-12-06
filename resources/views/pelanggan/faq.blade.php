@extends('layouts/main-pelanggan-no-footer')

@section('link')
<!-- Pastikan Font Awesome sudah ada -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    /* Layout utama dua kolom */
    .faq-container {
        display: grid;
        grid-template-columns: 1fr 2.5fr;
        gap: 30px;
        margin-top: 40px;
    }

    /* Sidebar kiri (tidak diubah) */
    .faq-sidebar {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
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

    .active{
        color: #007bff;
    }

    /* Konten kanan */
    .faq-content {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 35px 30px;
    }

    .faq-content h4 {
        margin-bottom: 25px;
        font-weight: 700;
        color: #007bff;
    }

    /* Accordion */
    .accordion {
        border-top: 1px solid #e5e5e5;
    }

    .accordion-item {
        border-bottom: 1px solid #e5e5e5;
    }

    .accordion-header {
        cursor: pointer;
        padding: 15px 10px;
        font-weight: 600;
        color: #333;
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: color 0.3s ease;
    }

    .accordion-header:hover {
        color: #007bff;
    }

    .accordion-header i {
        font-size: 14px;
        color: #007bff;
        transition: transform 0.3s ease;
    }

    .accordion-header.active i {
        transform: rotate(90deg);
    }

    .accordion-body {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: all 0.3s ease;
        color: #555;
        padding: 0 10px;
    }

    .accordion-body.show {
        max-height: 400px;
        opacity: 1;
        padding: 10px 10px 20px;
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
    <div class="faq-container">
        <!-- Sidebar kiri -->
        <aside class="faq-sidebar">
            <ul>
                <li><a href="/kebijakan-toko">Kebijakan Toko</a></li>
                <li><a href="/faq" style="color: #007bff">FAQ</a></li>
            </ul>
        </aside>

        <!-- Konten kanan -->
        <section class="faq-content">
            <h4>Pertanyaan yang Sering Diajukan</h4>
        
            @if ($faq->isEmpty())
                <p class="text-muted">Belum ada FAQ yang tersedia saat ini.</p>
            @else
                <div class="accordion">
                    @foreach ($faq as $item)
                        <div class="accordion-item">
                            <div class="accordion-header">
                                {{ $item->judul ?? 'Tanpa Judul' }}
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                            <div class="accordion-body">
                                {!! $item->isi !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
        
    </div>
</div>
@endsection

@section('script')
<script>
    // Sidebar aktif otomatis
    const currentUrl = window.location.href;
    document.querySelectorAll('.faq-sidebar a').forEach(link => {
        if (link.href === currentUrl) link.classList.add('active');
    });

    // Accordion logic
    const headers = document.querySelectorAll(".accordion-header");

    headers.forEach(header => {
        header.addEventListener("click", () => {
            const activeHeader = document.querySelector(".accordion-header.active");
            if (activeHeader && activeHeader !== header) {
                activeHeader.classList.remove("active");
                activeHeader.nextElementSibling.classList.remove("show");
            }

            header.classList.toggle("active");
            header.nextElementSibling.classList.toggle("show");
        });
    });
</script>
@endsection
