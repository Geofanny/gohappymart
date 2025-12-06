@extends('layouts/main-pelanggan')

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


        .quantity-wrapper {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            /* padding: 6px 10px; */
            transition: all 0.2s ease-in-out;
        }

        .quantity-wrapper:hover {
            border-color: #0d6efd;
            box-shadow: 0 3px 6px rgba(13, 110, 253, 0.1);
        }

        .quantity-wrapper .items-count {
            color: #333;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .quantity-wrapper .items-count:hover {
            background: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
            transform: scale(1.05);
        }

        .quantity-wrapper .qty {
            width: 50px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            color: #333;
            outline: none;
        }

        .btn-success {
            background-color: #dd7411;
            border: #c7630f;
            color: #fff;

        }

        .btn-success:hover {
            background-color: #c7630f;
            color: whitesmoke;
        }

        .btn-success:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(221, 116, 17, 0.4);
            /* efek fokus oranye */
        }
    </style>
@endsection

@section('content')
    <div class="product_image_area">
        <div class="container">
            <div class="row s_product_inner">
                <div class="col-lg-6">
                    <div class="owl-carousel owl-theme s_Product_carousel">
                        <div class="single-prd-item">
                            <img class="img-fluid" src="{{ asset('storage/uploads/produk/' . $produk->gambar) }}"
                                alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">
                        <div class="card_area d-flex align-items-center mb-3" style="margin-top: -4vh;">
                            <a class="icon_btn wishlist-btn" href="javascript:void(0);" data-id="{{ $produk->id_produk }}"
                                style="
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                width: 45px;
                                height: 45px;
                                border-radius: 50%;
                                font-size: 22px;
                                box-shadow: 0 2px 6px rgba(0,0,0,0.15);
                                transition: all 0.3s ease;
                                background-color: {{ $isInWishlist ? '#D60000' : '#fff0f0' }};
                                color: {{ $isInWishlist ? 'white' : '#D60000' }};
                            ">
                                <i class="lnr lnr-heart" style="color: {{ $isInWishlist ? 'white' : '#D60000' }}"></i>
                            </a>
                        </div>
                        <h3>{{ $produk->nama_produk }}</h3>
                        {{-- <h2 id="totalHarga" style="color: #D60000;">Rp. {{ number_format($produk->harga, 0, ',', '.') }}
                        </h2> --}}
                        @if ($hargaPromo < $produk->harga)
                            <h2 id="totalHarga" style="color:#D60000;">
                                Rp. {{ number_format($hargaPromo, 0, ',', '.') }}
                            </h2>
                            <del style="color:#888;">
                                Rp. {{ number_format($produk->harga, 0, ',', '.') }}
                            </del>
                        @else
                            <h2 id="totalHarga" style="color:#D60000;">
                                Rp. {{ number_format($produk->harga, 0, ',', '.') }}
                            </h2>
                        @endif

                        <ul class="list mb-4">
                            <li><span>Stok</span> : <span id="stokProduk">{{ $produk->stok }}</span></li>
                        </ul>
                        <div class="quantity-wrapper mb-4">
                            <button class="items-count" id="btnMinus" type="button" onclick="decrementQty()">
                                <i class="ti-minus"></i>
                            </button>
                            <input type="text" readonly name="qty" id="sst" value="1" title="Quantity:"
                                class="input-text qty">
                            <button class="items-count" id="btnPlus" type="button" onclick="incrementQty()">
                                <i class="ti-plus"></i>
                            </button>
                        </div>
                        <br>
                        <a class="button primary-btn" href="javascript:void(0);" id="btnTambahKeranjang"
                            href="#">Tambah Keranjang</a>
                        <a class="button btn-success" href="javascript:void(0);" id="btnPesanSekarang">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                        aria-selected="true">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab"
                        aria-controls="review" aria-selected="false">Reviews</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <p>{{ $produk->deskripsi }}</p>
                </div>
                <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row total_rate">
                                <div class="col-4">
                                    <div class="box_total d-flex flex-column justify-content-center align-items-center"
                                        style="height:33vh; margin:auto; border:1px solid #ddd; border-radius:8px; padding:10px;">
                                        <h5>Overall</h5>
                                        <h4>{{ number_format($averageRating, 1) }}</h4>
                                        <h6>({{ $totalReviews }} Reviews)</h6>
                                    </div>
                                </div>

                                <div class="col-8">
                                    <div class="rating_list">
                                        <h3>Based on {{ $totalReviews }} Reviews</h3>
                                        <ul class="list-unstyled">
                                            @for ($i = 5; $i >= 1; $i--)
                                                @php
                                                    $count = $ratingCounts[$i];
                                                    $percent = $totalReviews
                                                        ? round(($count / $totalReviews) * 100)
                                                        : 0;
                                                @endphp
                                                <li class="mb-2">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div>
                                                            {{ $i }} Star
                                                            @for ($s = 0; $s < $i; $s++)
                                                                <i class="fa fa-star text-warning"></i>
                                                            @endfor
                                                        </div>
                                                        <span>{{ $count }}</span>
                                                    </div>
                                                    <!-- progress bar panjang sesuai persen, membentuk tangga -->
                                                    <div class="progress mt-1"
                                                        style="height:6px; background-color:#e9ecef;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width:{{ $percent }}%; background-color:#0d6efd;"
                                                            aria-valuenow="{{ $percent }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="review_list">
                                @forelse($ulasan as $item)
                                    <div class="review_item mb-4 pb-3" style="border-bottom: 1px solid #dee2e6;">
                                        <div class="media mb-1">
                                            <div class="d-flex">
                                                <i class="fas fa-user-circle"
                                                    style="font-size: 45px; color: #6c757d;"></i>
                                            </div>
                                            <div class="media-body">
                                                <h4>{{ $item->pelanggan->nama_pelanggan ?? 'Anonymous' }}</h4>
                                                @for ($s = 0; $s < $item->rating; $s++)
                                                    <i class="fa fa-star text-warning"></i>
                                                @endfor
                                                @for ($s = $item->rating; $s < 5; $s++)
                                                    <i class="fa fa-star-o text-warning"></i>
                                                @endfor
                                                <br>
                                                <span>{{ \Carbon\Carbon::parse($item->tgl_ulasan)->format('d-m-Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <p class="mb-3">{{ $item->ulasan }}</p>
                                        @if ($item->bukti->count())
                                            <div class="d-flex mb-2" style="gap: 3vh;">
                                                @foreach ($item->bukti as $bukti)
                                                    <img src="{{ asset('storage/uploads/ulasan/' . $bukti->nama_file) }}"
                                                        alt=""
                                                        style="width:120px; height:120px; object-fit:cover;">
                                                @endforeach
                                            </div>
                                        @endif
                                        {{-- BALASAN DARI PENJUAL --}}
                                        @if (!empty($item->balasan))
                                            <div class="mt-4 mb-2 p-3 bg-light border rounded"
                                                style="border-left: 4px solid #0d6efd !important;">
                                                <strong class="text-primary d-block mb-1">Balasan Penjual:</strong>
                                                <p class="mb-0">{{ $item->balasan }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--================End Product Description Area =================-->

    <section class="section-margin calc-60px" style="margin-top: -4vh !important;">
        <div class="container">
            <div class="section-intro pb-60px">
                <h2>Lihat Juga <span class="section-intro__style">Produk Lainnya</span></h2>
            </div>

            <div class="row g-3">

                @foreach ($produkRekomendasi as $p)
                    @php
                        $promo = $p->promos->first(); // semua kategori
                        $diskon = $promo->nilai_diskon ?? 0;
                        $tipeDiskon = $promo->tipe ?? null;
                    
                        if ($promo) {
                            if ($tipeDiskon === 'Persen') {
                                $hargaSetelahDiskon = $p->harga - ($p->harga * $diskon / 100);
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
                                <h5 class="card-product__title"><a
                                        href="/detail-produk/{{ $p->id_produk }}">{{ $p->nama_produk }}</a></h5>
                                <p class="card-product__price">
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
        function updateWishlistCount() {
            $.ajax({
                url: '{{ route('wishlist.count') }}',
                type: 'GET',
                dataType: 'json',
                // success: function(data) {
                //     $('#wishlist-count').text(data.count);
                // },
                // error: function(err) {
                //     console.log('Error fetching wishlist count', err);
                // }
            });
        }

        // Panggil setiap kali halaman load
        $(document).ready(function() {
            updateWishlistCount();

            // Opsional: panggil setiap 10 detik agar real-time
            setInterval(updateWishlistCount, 10000);
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
    </script>

    <script>
        const hargaProduk = {{ $hargaPromo }};  // otomatis harga promo / harga normal
        const stokProduk = {{ $produk->stok }};

        const inputQty = document.getElementById('sst');
        const btnPlus = document.getElementById('btnPlus');
        const btnMinus = document.getElementById('btnMinus');

        function updateHarga() {
            const qty = parseInt(inputQty.value);
            const total = hargaProduk * qty;
            document.getElementById('totalHarga').textContent =
                'Rp. ' + total.toLocaleString('id-ID');
        }

        function updateButtonState() {
            const qty = parseInt(inputQty.value);

            // ❗ Jika harga promo 0 → langsung disable semuanya
            if (hargaProduk === 0) {
                btnPlus.disabled = true;
                btnMinus.disabled = true;

                inputQty.value = 1; // kunci qty tetap 1

                btnPlus.style.opacity = "0.5";
                btnMinus.style.opacity = "0.5";
                btnPlus.style.cursor = "not-allowed";
                btnMinus.style.cursor = "not-allowed";
                return;
            }

            // Kondisi normal
            btnMinus.disabled = qty <= 1;
            btnPlus.disabled = qty >= stokProduk;

            btnPlus.style.opacity = btnPlus.disabled ? "0.5" : "1";
            btnMinus.style.opacity = btnMinus.disabled ? "0.5" : "1";
            btnPlus.style.cursor = btnPlus.disabled ? "not-allowed" : "pointer";
            btnMinus.style.cursor = btnMinus.disabled ? "not-allowed" : "pointer";
        }

        function incrementQty() {
            if (hargaProduk === 0) return; // cegah klik
            let value = parseInt(inputQty.value);
            if (!isNaN(value) && value < stokProduk) {
                inputQty.value = value + 1;
                updateHarga();
                updateButtonState();
            }
        }

        function decrementQty() {
            if (hargaProduk === 0) return; // cegah klik
            let value = parseInt(inputQty.value);
            if (!isNaN(value) && value > 1) {
                inputQty.value = value - 1;
                updateHarga();
                updateButtonState();
            }
        }

        updateButtonState();
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

    <script>
        $('#btnTambahKeranjang').click(function() {
            let id_produk = "{{ $produk->id_produk }}";
            let jumlah = parseInt($('#sst').val());

            $.ajax({
                url: '/tambah-keranjang',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_produk: id_produk,
                    jumlah: jumlah
                },
                success: function(res) {
                    if (res.status === 'success') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Produk ditambahkan ke keranjang'
                        });
                    }
                },
                error: function(err) {
                    if (err.status === 401) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Login Dulu!',
                            text: 'Silakan login terlebih dahulu untuk menambahkan ke keranjang.',
                            confirmButtonText: 'Login Sekarang'
                        }).then(() => {
                            window.location.href = '/login';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: err.responseJSON?.message || 'Terjadi kesalahan.',
                        });
                    }
                }
            });
        });
    </script>
    <script>
        document.getElementById('btnPesanSekarang').addEventListener('click', function() {
            let jumlah = document.getElementById('sst').value;
            let id_produk = "{{ $produk->id_produk }}";

            fetch("{{ route('checkout.session') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id_produk: id_produk,
                        jumlah: jumlah
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        window.location.href = "/checkout";
                    } else {
                        alert("Gagal menambahkan ke checkout");
                    }
                })
                .catch(err => console.error(err));
        });
    </script>
@endsection
