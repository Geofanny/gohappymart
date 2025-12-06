@extends('layouts/main-pelanggan-no-footer')

@section('link')
    <!-- ================= Custom CSS ================= -->
    <style>
        /* Card background soft gray agar terlihat beda dari background putih */

        .card-product {
            background-color: #f8f9fa;
            transition: transform 0.3s, box-shadow 0.3s;
        }


        /* Image wrapper */
        .card-product__img {
            position: relative;
            overflow: hidden;
        }

        .card-product__img img {
            object-fit: cover;
            height: 220px;
            width: 100%;
            border-top-left-radius: .5rem;
            border-top-right-radius: .5rem;
            transition: transform 0.3s;
        }

        .card-product__img:hover img {
            transform: scale(1.05);
        }

        /* Icon love di atas gambar */
        .love-produk {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #fff;
            background: rgba(214, 0, 0, 0.85);
            /* merah semi-transparan */
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s;
        }

        .love-produk:hover,
        .love-produk.active {
            background: #D60000;
            color: #fff;
        }

        /* Custom col untuk 5 per baris di XL */
        @media (min-width: 1200px) {
            .col-xl-custom {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }
    </style>
    <!-- Tambahan CSS khusus halaman jika diperlukan -->
@endsection

@section('content')
    <!-- ================ Wishlist Produk Grid ================= -->
    <section class="section-margin calc-60px" style="margin-top: 5vh;">
        <div class="container">
            <div class="section-intro pb-60px">
                <h2>Produk <span class="section-intro__style">Favorit Kamu</span></h2>
            </div>
            {{-- <div class="row g-3" style="margin-top: -2vh;">
                @foreach ($wishlist as $p)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-custom product-loaded real-item mb-5">
                        <div class="card card-product h-100 border-0 rounded-3 shadow-sm">
                            <div class="card-product__img position-relative">
                                <img class="card-img rounded-top-3"
                                    src="{{ asset('storage/uploads/produk/' . $p->produk->gambar) }}"
                                    alt="{{ $p->produk->nama_produk }}">
                                <i class="ti-heart love-produk {{ in_array($p->produk->id_produk, $wishlistProdukIds) ? 'active' : '' }}"
                                    data-id="{{ $p->produk->id_produk }}"></i>
                            </div>
                            <div class="card-body text-center" style="margin: 0; height:70px;">
                                <h6 class="card-product__title mb-2">
                                    <a href="#"
                                        class="text-decoration-none text-dark">{{ $p->produk->nama_produk }}</a>
                                </h6>
                                <p class="card-product__price mb-0">
                                    <strong class="text-danger">
                                        Rp. {{ number_format($p->produk->harga, 0, ',', '.') }}
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> --}}
            <div class="row g-3" id="wishlist-container" style="margin-top: -2vh;">
            </div>

        </div>
    </section>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- <script>
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
                    } else if (res.status === 'removed') {
                        iconLove.removeClass('active');
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
    </script> --}}

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
        function fetchWishlist() {
            $.get('/wishlist/data', function(html) {
                $('#wishlist-container').html(html);
            });
        }

        // Fetch awal
        fetchWishlist();

        // Refresh otomatis tiap 5 detik
        setInterval(fetchWishlist, 5000);

        // Toggle love icon
        $(document).on('click', '.love-produk', function(event) {
            event.preventDefault();
            event.stopPropagation();

            let iconLove = $(this);
            let id_produk = iconLove.data('id');

            $.post(`/wishlist/${id_produk}`, {
                _token: '{{ csrf_token() }}'
            }, function(res) {
                // icon tetap toggle
                if (res.status === 'added') {
                    iconLove.addClass('active');
                    
                } else if (res.status === 'removed') {
                    iconLove.removeClass('active');
                    Toast.fire({
                            icon: 'success',
                            title: 'Produk dihapus dari Wishlist'
                        });
                }

                // Re-fetch wishlist agar card update real-time
                fetchWishlist();
            }).fail(function(err) {
                if (err.status === 401) {
                    alert('Silakan login terlebih dahulu!');
                    window.location.href = '/login';
                }
            });
        });
    </script>
@endsection
