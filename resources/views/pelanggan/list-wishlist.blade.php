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
        <div class="card-body text-center" style="margin:0; height:70px;">
            <h6 class="card-product__title mb-2">
                <a href="#" class="text-decoration-none text-dark">{{ $p->produk->nama_produk }}</a>
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
