<!-- partials/keranjang_items.blade.php -->

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
                        <tr>
                            <td><input type="checkbox" class="product-checkbox" data-id="{{ $item->id_keranjang_produk }}"></td>
                            <td>
                                <a href="/detail-produk/{{ $produk->id_produk }}" style="color: #777777">
                                    <div class="d-flex align-items-center product-info">
                                        <img src="{{ asset('storage/uploads/produk/' . $produk->gambar) }}"
                                            class="cart-product-img me-3 rounded">
                                        <span class="fw-semibold">{{ $produk->nama_produk }}</span>
                                    </div>
                                </a>
                            </td>
                            <td><h6 class="text-danger">Rp {{ number_format($produk->harga,0,',','.') }}</h6></td>
                            <td>
                                <div class="quantity-control">
                                    <button type="button" class="qty-minus" data-id="{{ $item->id_keranjang_produk }}">−</button>
                                    <input type="text" value="{{ $item->jumlah }}" id="qty{{ $item->id_keranjang_produk }}">
                                    <button type="button" class="qty-plus" data-id="{{ $item->id_keranjang_produk }}">+</button>
                                </div>
                            </td>
                            <td><h6 class="text-danger">Rp {{ number_format($subtotal,0,',','.') }}</h6></td>
                            <td>
                                <button class="btn btn-outline-danger btn-sm btn-hapus" data-id="{{ $item->id_keranjang_produk }}">
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
    <div class="cart-card select-all-card d-flex align-items-center gap-2 p-3 mb-5"
        style="background-color:#fff;border:1px solid #e5e5e5;border-radius:15px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
        <input type="checkbox" id="selectAllMobile" style="scale:1.2;">
        <label for="selectAllMobile" class="mb-0 fw-semibold">Pilih Semua</label>
    </div>

    <div class="cart-cards">
        @forelse ($items as $item)
            @php $produk = $item->produk; @endphp
            <div class="cart-card">
                <div class="cart-card-left">
                    <input type="checkbox" class="product-checkbox" data-id="{{ $item->id_keranjang_produk }}">
                    <a href="/detail-produk/{{ $produk->id_produk }}">
                        <img src="{{ asset('storage/uploads/produk/' . $produk->gambar) }}"
                            alt="{{ $produk->nama_produk }}">
                    </a>
                </div>
                <div class="cart-card-right">
                    <h6 class="product-name">{{ $produk->nama_produk }}</h6>
                    <p class="mb-1 text-muted small">
                        <span class="price">Rp {{ number_format($produk->harga,0,',','.') }}</span>
                    </p>
                    <div class="quantity-section">
                        <div class="quantity-control">
                            <button type="button" class="qty-minus" data-id="{{ $item->id_keranjang_produk }}">−</button>
                            <input type="text" value="{{ $item->jumlah }}" id="qty{{ $item->id_keranjang_produk }}">
                            <button type="button" class="qty-plus" data-id="{{ $item->id_keranjang_produk }}">+</button>
                        </div>
                    </div>
                    <button class="btn btn-outline-danger btn-sm btn-hapus mt-2" data-id="{{ $item->id_keranjang_produk }}">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        @empty
            <p class="text-muted text-center">Keranjangmu masih kosong.</p>
        @endforelse
    </div>
</div>
