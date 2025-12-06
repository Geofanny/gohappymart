@extends('layouts/dashboard')

@section('content')
    <div class="col-12 mt-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="mb-3"><i class="ti ti-edit me-2"></i> Edit Produk</h1>
                <div class="border-bottom border-warning mb-4" style="border-width: 3px;"></div>

                <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- Baris 1: Kategori & SKU -->
                        <div class="col-md-6">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select id="id_kategori" name="id_kategori" class="form-control" required>
                                <option disabled>-- Pilih Kategori --</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id_kategori }}"
                                        {{ $produk->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                                        {{ ucwords($k->nama) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku"
                                value="{{ old('sku', $produk->sku) }}" required>
                            <small id="skuError" class="text-danger d-none">SKU sudah terdaftar!</small>
                        </div>

                        <!-- Baris 2: Nama Produk & Harga -->
                        <div class="col-md-6">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga"
                                value="{{ old('harga', $produk->harga) }}" required min="0">
                        </div>

                        <!-- Baris 3: Stok & Status -->
                        <div class="col-md-6">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok"
                                value="{{ old('stok', $produk->stok) }}" required min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusAktif"
                                    value="aktif" {{ $produk->status == 'aktif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusAktif">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusNonaktif"
                                    value="nonaktif" {{ $produk->status == 'nonaktif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusNonaktif">Nonaktif</label>
                            </div>
                        </div>

                        <!-- Baris 4: Gambar Produk -->
                        <div class="col-md-6">
                            <label for="gambar" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*"
                                onchange="previewImage(event)">
                            <small class="text-muted">Format gambar: JPG, PNG, WEBP (maks. 2MB)</small>

                            <!-- Preview gambar -->
                            <div class="mt-3" style="margin-bottom: -3vh">
                                <div id="previewCard" class="card border"
                                    style="width: 220px; height: 220px; overflow: hidden; border-radius: 10px;">
                                    <img id="preview"
                                        src="{{ $produk->gambar ? asset('storage/uploads/produk/' . $produk->gambar) : 'https://dummyimage.com/300x300/cccccc/000000&text=No+Image' }}"
                                        alt="Preview Gambar" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        <!-- Baris 5: Deskripsi -->
                        <div class="col-md-6">
                            <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control" id="myeditorinstance" name="deskripsi" rows="7"
                                placeholder="Tuliskan deskripsi produk">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        </div>

                        <!-- Baris 6: Tombol -->
                        <div class="col-12 mt-4 d-flex justify-content-between">
                            <a href="/dashboard-admin/produk" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="ti ti-device-floppy"></i> Perbarui Produk
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Preview Gambar -->
    <script>
        function previewImage(event) {
            const input = event.target;
            const previewCard = document.getElementById('previewCard');
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result; // tampilkan file baru
                    previewCard.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                // kalau user hapus file, kembali ke dummy atau gambar asli
                preview.src =
                    '{{ $produk->gambar ? asset('storage/uploads/produk/' . $produk->gambar) : 'https://dummyimage.com/300x300/cccccc/000000&text=No+Image' }}';
            }
        }
    </script>

    <!-- Script TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/boirjcaeyjxuv3ilkyyc9ud65xynmmc9sk4fv17mlov28lxl/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance',
            menubar: false,
            branding: false,
            statusbar: false,
            plugins: 'lists code table',
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | code',
            height: 300,
            content_style: 'body { font-family:Arial,Helvetica,sans-serif; font-size:14px }'
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sku').on('input', function() {
                let sku = $(this).val();
                let productId = '{{ $produk->id_produk }}'; // id produk saat edit

                if (sku.length === 0) {
                    $('#skuError').addClass('d-none');
                    $('button[type="submit"]').prop('disabled', false);
                    return;
                }

                $.ajax({
                    url: '/check-sku',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        sku: sku,
                        id: productId
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#skuError').removeClass('d-none');
                            $('button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#skuError').addClass('d-none');
                            $('button[type="submit"]').prop('disabled', false);
                        }
                    },
                    error: function() {
                        console.log('Error checking SKU');
                    }
                });
            });
        });
    </script>
@endsection
