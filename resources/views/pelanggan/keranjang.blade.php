@extends('layouts/main-pelanggan-no-footer')

@section('link')
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/linericon/style.css">

    <style>
        .cart-product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            object-position: center;
        }

        .product-info {
            gap: 15px;
        }

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

        /* Default untuk desktop & layar besar */
        .cart_area {
            margin-top: -7vh;
        }

        .cart-summary-card {
            margin-top: 2rem;
        }

        .cart-summary-card .left-actions i {
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }

        .cart-summary-card .left-actions i:hover {
            color: #ff5c5c;
        }

        .left-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .right-summary {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .right-summary h5 {
            font-size: 1.8rem;
        }

        /* Styling tombol + - */
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quantity-control button {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            width: 32px;
            height: 32px;
            font-weight: bold;
            font-size: 18px;
            line-height: 1;
            border-radius: 6px;
            transition: background-color 0.2s, color 0.2s;
        }

        .quantity-control button:hover {
            background-color: #0d6efd;
            color: white;
        }

        .quantity-control input {
            width: 60px;
            text-align: center;
            border: 1px solid #ced4da;
            border-radius: 6px;
            height: 32px;
        }

        /* --- RESPONSIVE: ubah jadi CARD di mobile & tablet --- */
        @media (max-width: 991.98px) {
            .cart_area {
                margin-top: -5vh;
            }

            .cart-cards {
                margin-top: -3vh;
            }

            .cart-table {
                display: none !important;
            }

            .cart-cards {
                display: block !important;
            }

            .cart-card {
                display: flex;
                align-items: center;
                border: 1px solid #e5e5e5;
                border-radius: 15px;
                padding: 15px;
                margin-bottom: 15px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                gap: 15px;
            }

            .cart-card-left {
                position: relative;
                display: flex;
                align-items: center;
            }

            .cart-card-left input[type="checkbox"] {
                position: absolute;
                left: -1px;
                top: 50%;
                transform: translateY(-50%);
                scale: 1.2;
            }

            .cart-card-left img {
                width: 90px;
                border-radius: 10px;
                margin-left: 25px;
            }

            .cart-card-right {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                gap: 5px;
            }

            .cart-card-right h6 {
                font-weight: 600;
                margin-bottom: 5px;
                max-width: 100%;
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                /* maksimal 2 baris */
                -webkit-box-orient: vertical;
            }

            .cart-card-right .price {
                color: #dc3545;
                font-weight: 600;
                font-size: 1rem;
            }

            .cart-card-right .quantity-section {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .cart-card-right .btn-delete {
                align-self: flex-end;
                margin-top: 5px;
            }

            .cart-summary-card {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                border-radius: 20px 20px 0 0 !important;
                z-index: 999;
                margin: 0;
                box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.15);
            }

            body {
                padding-bottom: 120px;
            }

            .cart-summary-card .card-body {
                padding: 10px 15px !important;
            }

            .right-summary {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .right-summary h5 {
                font-size: 1.5rem;
            }

            .right-summary a {
                width: 100%;
                text-align: center;
            }
        }

        @media (min-width: 992px) {
            .cart-cards {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="section-intro">
            <h2>Keranjang <span class="section-intro__style">Kamu</span></h2>
        </div>
    </div>

    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">

                <!-- TABEL DESKTOP -->
                <div class="card border-0 rounded-4 shadow-lg cart-table">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Product</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $item)
                                        @php
                                            $produk = $item->produk;
                                            $subtotal = $produk->harga * $item->jumlah;
                                        @endphp
                                        <tr data-produk-id="{{ $produk->id_produk }}">
                                            <td><input type="checkbox" class="product-checkbox"
                                                    data-id="{{ $item->id_keranjang_produk }}"></td>
                                            <td>
                                                <a href="/detail-produk/{{ $produk->id_produk }}" style="color: #777777">
                                                    <div class="d-flex align-items-center product-info">
                                                        <img src="{{ asset('storage/uploads/produk/' . $produk->gambar) }}"
                                                            class="cart-product-img me-3 rounded">
                                                        <span class="fw-semibold">{{ $produk->nama_produk }}</span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <h6 class="text-danger">Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                                </h6>
                                            </td>
                                            <td>
                                                <div class="quantity-control">
                                                    <button type="button" class="qty-minus"
                                                        data-id="{{ $item->id_keranjang_produk }}">−</button>
                                                    <input type="text" readonly value="{{ $item->jumlah }}"
                                                        id="qty{{ $item->id_keranjang_produk }}">
                                                    <button type="button" class="qty-plus"
                                                        data-id="{{ $item->id_keranjang_produk }}">+</button>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="text-danger">Rp {{ number_format($subtotal, 0, ',', '.') }}</h6>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-danger btn-sm btn-hapus"
                                                    data-id="{{ $item->id_keranjang_produk }}">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Keranjangmu masih kosong.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <!-- CARD MOBILE -->
                <div class="cart-cards">
                    <!-- Card Pilih Semua -->
                    <div class="cart-card select-all-card d-flex align-items-center gap-2 p-3 mb-5"
                        style="background-color: #fff; border:1px solid #e5e5e5; border-radius: 15px; margin-bottom: 10px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                        <input type="checkbox" id="selectAllMobile" style="scale:1.2;">
                        <label for="selectAllMobile" class="mb-0 fw-semibold">Pilih Semua</label>
                    </div>

                    @forelse ($items as $item)
                        @php
                            $produk = $item->produk;
                        @endphp
                        <div class="cart-card" data-produk-id="{{ $produk->id_produk }}">
                            <div class="cart-card-left">
                                <input type="checkbox" class="product-checkbox" data-id="{{ $item->id_keranjang_produk }}">
                                <img src="{{ asset('storage/uploads/produk/' . $produk->gambar) }}"
                                    alt="{{ $produk->nama_produk }}">
                            </div>

                            <div class="cart-card-right">
                                <h6 class="product-name">{{ $produk->nama_produk }}</h6>
                                <p class="mb-1 text-muted small">
                                    <span class="price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                </p>

                                <div class="quantity-section">
                                    <div class="quantity-control">
                                        <button type="button" class="qty-minus"
                                            data-id="{{ $item->id_keranjang_produk }}">−</button>
                                        <input type="text" readonly value="{{ $item->jumlah }}"
                                            id="qty{{ $item->id_keranjang_produk }}">
                                        <button type="button" class="qty-plus"
                                            data-id="{{ $item->id_keranjang_produk }}">+</button>
                                    </div>
                                </div>

                                <button class="btn btn-outline-danger btn-sm btn-hapus mt-2"
                                    data-id="{{ $item->id_keranjang_produk }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">Keranjangmu masih kosong.</p>
                    @endforelse

                </div>
            </div>

            <!-- RINGKASAN -->
            <div class="card cart-summary-card border-0 shadow-lg p-2 mt-4">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div class="left-actions d-flex align-items-center flex-wrap gap-3">
                        <span class="fw-bold">Produk dipilih (10)</span>
                        <div class="action-group d-flex align-items-center gap-2">
                            <i class="fas fa-trash text-danger"></i><span class="text-muted">&nbsp;Hapus</span>
                        </div>
                        <div class="action-group d-flex align-items-center gap-2">
                            <i class="fas fa-heart text-primary"></i><span class="text-muted">&nbsp;Favorit</span>
                        </div>
                    </div>
                    <div class="right-summary mt-3 mt-md-0">
                        <h5 class="mb-0 fw-semibold text-dark">Total: <span class="text-danger">$2160.00</span></h5>
                        <button id="btnCheckout" class="btn btn-primary rounded-pill px-5 py-2">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-margin calc-60px" style="margin-top: 18px !important">
        <div class="container">
            <div class="section-intro pb-60px">
                <h2>Lihat Juga <span class="section-intro__style">Produk Lainnya</span></h2>
            </div>

            <div class="row g-3">

                @foreach ($produkRekomendasi as $p)
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
                                            Rp. {{ number_format($p->harga, 0, ',', '.') }}
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
        function refreshKeranjang() {
            // Simpan state checkbox sebelum refresh
            const checkedIds = Array.from(document.querySelectorAll('.product-checkbox:checked'))
                .map(cb => cb.dataset.id);

            fetch('/keranjang/partial')
                .then(res => res.text())
                .then(html => {
                    document.querySelector('.cart_inner').innerHTML = html;

                    attachEvents();
                    attachCheckboxEvents();

                    // Restore state checkbox
                    checkedIds.forEach(id => {
                        const cb = document.querySelector(`.product-checkbox[data-id="${id}"]`);
                        if (cb) cb.checked = true;
                    });

                    updateCartSummary();
                });
        }

        const cartSummary = document.querySelector('.cart-summary-card');
        const selectedCountEl = cartSummary.querySelector('.left-actions .fw-bold');
        const totalEl = cartSummary.querySelector('.right-summary span');

        function updateCartSummary() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            let checkedCount = 0;
            let totalPrice = 0;

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    checkedCount++;
                    const row = cb.closest('tr, .cart-card');
                    if (row) {
                        let hargaEl = row.querySelector('.text-danger, .price');
                        let qtyEl = row.querySelector('input[type="text"]');
                        if (hargaEl && qtyEl) {
                            // Ambil angka saja
                            let hargaText = hargaEl.textContent.replace(/[^0-9]/g, '');
                            let qty = parseInt(qtyEl.value);
                            totalPrice += parseInt(hargaText) * qty;
                        }
                    }
                }
            });

            // Tampilkan cart summary jika ada produk dipilih
            cartSummary.style.display = checkedCount > 0 ? 'flex' : 'none';
            selectedCountEl.textContent = `Produk dipilih (${checkedCount})`;

            // Format total dengan Rp dan pemisah ribuan
            totalEl.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
        }

        updateCartSummary();

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.cart-table .product-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateCartSummary();
            });
        }

        if (selectAllMobile) {
            selectAllMobile.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.cart-cards .product-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateCartSummary();
            });
        }

        document.querySelectorAll('.product-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                syncSelectAll();
                updateCartSummary();
            });
        });

        function attachCheckboxEvents() {
            const selectAll = document.getElementById('selectAll');
            const selectAllMobile = document.getElementById('selectAllMobile');

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.cart-table .product-checkbox');
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateCartSummary();
                });
            }

            if (selectAllMobile) {
                selectAllMobile.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.cart-cards .product-checkbox');
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateCartSummary();
                });
            }

            document.querySelectorAll('.product-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    syncSelectAll();
                    updateCartSummary();
                });
            });
        }

        function attachEvents() {
            document.querySelectorAll('.qty-minus, .qty-plus').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const input = document.getElementById(`qty${id}`);
                    let delta = this.classList.contains('qty-plus') ? 1 : -1;
                    let newVal = parseInt(input.value) + delta;
                    if (newVal < 1) newVal = 1;
                    input.value = newVal;

                    updateCartSummary();

                    fetch(`/keranjang/update/${id}`, {
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            jumlah: newVal
                        })
                    }).then(() => refreshKeranjang());
                });
            });

            document.querySelectorAll('.btn-hapus').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    fetch(`/keranjang/hapus/${id}`, {
                        method: 'DELETE',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    }).then(() => refreshKeranjang());
                });
            });
        }

        // initial attach
        attachEvents();
        attachCheckboxEvents();
        updateCartSummary();
    </script>
    <script>
        // Potong nama produk jadi maksimal 10 kata
        document.querySelectorAll(".product-name").forEach(el => {
            const words = el.textContent.trim().split(/\s+/);
            if (words.length > 10) {
                el.textContent = words.slice(0, 10).join(" ") + "...";
            }
        });
    </script>

    <script>
        // Fungsi untuk handle select all di desktop
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.cart-table .product-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
            });
        }

        // Fungsi untuk handle select all di mobile
        const selectAllMobile = document.getElementById('selectAllMobile');
        if (selectAllMobile) {
            selectAllMobile.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.cart-cards .product-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
            });
        }

        // Sinkronisasi: jika semua checkbox individual dicentang, select all otomatis tercentang
        function syncSelectAll() {
            const desktopCheckboxes = document.querySelectorAll('.cart-table .product-checkbox');
            if (desktopCheckboxes.length) {
                const allChecked = Array.from(desktopCheckboxes).every(cb => cb.checked);
                selectAll.checked = allChecked;
            }

            const mobileCheckboxes = document.querySelectorAll('.cart-cards .product-checkbox');
            if (mobileCheckboxes.length) {
                const allCheckedMobile = Array.from(mobileCheckboxes).every(cb => cb.checked);
                selectAllMobile.checked = allCheckedMobile;
            }
        }

        // Event listener individual checkboxes untuk sinkronisasi
        document.querySelectorAll('.product-checkbox').forEach(cb => {
            cb.addEventListener('change', syncSelectAll);
        });
    </script>

    <script>
        document.getElementById('btnCheckout').addEventListener('click', function(e) {
            e.preventDefault();

            const selectedCheckboxes = document.querySelectorAll('.product-checkbox:checked');
            if (selectedCheckboxes.length === 0) {
                Swal.fire('Peringatan', 'Pilih minimal satu produk untuk checkout!', 'warning');
                return;
            }

            const selectedItems = [];

            selectedCheckboxes.forEach(cb => {
                const row = cb.closest('tr, .cart-card');
                if (row) {
                    const id = cb.dataset.id;
                    const hargaText = row.querySelector('.text-danger, .price').textContent.replace(
                        /[^0-9]/g, '');
                    const jumlah = parseInt(row.querySelector('input[type="text"]').value);
                    const nama = row.querySelector('.product-name, .fw-semibold').textContent.trim();
                    const gambar = row.querySelector('img').getAttribute('src');

                    selectedItems.push({
                        id_keranjang_produk: id,
                        nama_produk: nama,
                        harga: parseInt(hargaText),
                        jumlah: jumlah,
                        gambar: gambar,
                        subtotal: parseInt(hargaText) * jumlah
                    });
                }
            });

            // Kirim ke backend untuk disimpan ke session
            fetch("{{ route('checkout.session') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        items: selectedItems
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.href = "/checkout";
                    } else {
                        Swal.fire('Error', data.error || 'Gagal membuat session checkout', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Terjadi kesalahan server.', 'error');
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // === EVENT HAPUS PRODUK (tetap sama) ===
            document.querySelectorAll('.action-group').forEach(group => {
                const iconTrash = group.querySelector('.fa-trash');
                const textTrash = group.querySelector('.text-muted');

                if (iconTrash && textTrash && textTrash.textContent.includes('Hapus')) {
                    group.addEventListener('click', function() {
                        const selected = document.querySelectorAll('.product-checkbox:checked');
                        if (selected.length === 0) {
                            Swal.fire('Peringatan', 'Pilih produk yang ingin dihapus!', 'warning');
                            return;
                        }

                        const ids = Array.from(selected).map(cb => cb.dataset.id);

                        Swal.fire({
                            title: 'Hapus produk?',
                            text: `Apakah kamu yakin ingin menghapus ${ids.length} produk dari keranjang?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`/keranjang/hapus-multiple`, {
                                        method: 'DELETE',
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({
                                            ids
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire('Berhasil',
                                                'Produk terpilih telah dihapus.',
                                                'success');
                                            refreshKeranjang();
                                        } else {
                                            Swal.fire('Gagal', data.error ||
                                                'Gagal menghapus produk.', 'error');
                                        }
                                    })
                                    .catch(() => Swal.fire('Error',
                                        'Terjadi kesalahan server.', 'error'));
                            }
                        });
                    });
                }
            });


            // === EVENT FAVORIT PRODUK (versi baru) ===
            document.querySelectorAll('.action-group').forEach(group => {
                const iconHeart = group.querySelector('.fa-heart');
                const textHeart = group.querySelector('.text-muted');

                if (iconHeart && textHeart && textHeart.textContent.includes('Favorit')) {
                    group.addEventListener('click', function() {
                        event.preventDefault();

                        const selected = document.querySelectorAll('.product-checkbox:checked');
                        if (selected.length === 0) {
                            Swal.fire('Peringatan', 'Pilih produk yang ingin dijadikan favorit!',
                                'warning');
                            return;
                        }

                        const produkIds = Array.from(selected).map(cb => {
                            const row = cb.closest('tr') || cb.closest('.cart-card');
                            return row ? row.dataset.produkId : null;
                        }).filter(Boolean);

                        // Kirim ke backend (satu request aja)
                        fetch(`/wishlist/favorit-multiple`, {
                                method: 'POST',
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    produk_ids: produkIds
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(data.message, '', 'success');
                                } else {
                                    Swal.fire('Gagal', data.error ||
                                        'Gagal menambahkan ke wishlist.', 'error');
                                }
                            })
                            .catch(() => {
                                Swal.fire('Error', 'Terjadi kesalahan server.', 'error');
                            });
                    });
                }
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.product-info span').forEach(span => {
                const text = span.textContent.trim();
                const words = text.split(/\s+/); // pisah berdasarkan spasi

                if (words.length > 4) {
                    const shortened = words.slice(0, 4).join(' ') + '...';
                    span.textContent = shortened;
                    span.setAttribute('title', text); // tooltip tampilkan nama lengkap
                }
            });
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener untuk semua .cart-card (kecuali tombol dan checkbox)
        document.querySelectorAll('.cart-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Hindari klik pada elemen yang tidak seharusnya memicu redirect
                if (
                    e.target.closest('button') || 
                    e.target.closest('input[type="checkbox"]') || 
                    e.target.closest('.quantity-control')
                ) {
                    return; // jangan redirect kalau klik tombol, checkbox, atau kontrol jumlah
                }
    
                const idProduk = this.dataset.produkId;
                if (idProduk) {
                    window.location.href = `/detail-produk/${idProduk}`;
                }
            });
        });
    });
    </script>
    
@endsection
