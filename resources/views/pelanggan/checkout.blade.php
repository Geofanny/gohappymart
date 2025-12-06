@extends('layouts/main-pelanggan-no-footer')

@section('link')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Styling agar select sama tinggi dengan input text */
        .custom-select {
            display: block;
            width: 100%;
            height: 40px;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .custom-select:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        /* Label selalu di atas */
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .nice-select .list {
            -webkit-overflow-scrolling: touch;
            max-height: 200px;
            overflow-y: auto;
            width: 100%;
        }

        .card .card-body h5 {
            display: inline-block;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')

    <div class="container my-4">
        {{-- Card form alamat pengiriman --}}
        {{-- <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-3">Alamat Pengiriman</h5>
                <form>
                    <div class="mb-3">
                        <label for="nama_penerima" class="form-label">Nama Penerima</label>
                        <input type="text" class="form-control" id="nama_penerima" value="Geofanny Alfareza Pratama">
                    </div>

                    <div class="mb-3">
                        <label for="label" class="form-label">Label (mis. Rumah / Kantor)</label>
                        <input type="text" class="form-control" id="label" value="Rumah">
                    </div>

                    <div class="mb-3">
                        <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat_lengkap" rows="3">Jl. Melati No. 23, Kec. Pancoran, Kota Jakarta Selatan, DKI Jakarta</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <select class="custom-select" id="provinsi">
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kota" class="form-label">Kota / Kabupaten</label>
                            <select class="custom-select" id="kota" disabled>
                                <option value="">Pilih Kota / Kabupaten</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select class="custom-select" id="kecamatan" disabled>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kode_pos" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" id="kode_pos" placeholder="Masukkan Kode Pos">
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="phone" class="form-label">No. HP</label>
                        <input type="text" class="form-control" id="phone" value="0812-3456-7890">
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_primary" checked>
                        <label class="form-check-label" for="is_primary">
                            Jadikan alamat utama
                        </label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-secondary me-2">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div> --}}

        {{-- Card alamat pengiriman --}}
        <style>
            /* Gaya border bawah amplop */
            .envelope-border {
                position: relative;
                overflow: hidden;
            }

            .envelope-border::after {
                content: "";
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 6px;
                background-image: repeating-linear-gradient(45deg,
                        red 0 10px,
                        white 10px 20px,
                        #0066cc 20px 30px,
                        white 30px 40px);
                background-size: 40px 6px;
            }
        </style>

        <div class="card shadow-sm mb-4 envelope-border">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-semibold">Alamat Pengiriman</h5>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAlamat">
                        <i class="ti ti-edit me-1"></i> Ubah
                    </button>
                </div>

                <div class="row">
                    <!-- Kolom kiri -->
                    <div class="col-md-2">
                        <p class="mb-1 fw-semibold" id="namaPenerima">...</p>
                        <p class="mb-1 text-muted" id="noHp">...</p>
                    </div>

                    <!-- Kolom kanan -->
                    <div class="col-md-10">
                        <p class="mb-1 fw-semibold" id="alamatLengkap">
                            ...
                        </p>
                        <p class="mb-0 text-muted" id="alamatTambahan">...</p>
                        <p class="mb-0 text-muted" id="labelAlamat">...</p>
                    </div>
                </div>
            </div>
        </div>


        {{-- Modal Form Alamat --}}
        <div class="modal fade" id="modalAlamat" tabindex="-1" aria-labelledby="modalAlamatLabel" aria-hidden="true" style="z-index: 9999; background-color: rgba(71, 70, 70, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAlamatLabel">Ubah Alamat Pengiriman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAlamat">
                            <div class="mb-3">
                                <label for="nama_penerima" class="form-label">Nama Penerima</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Penerima"
                                    id="nama_penerima">
                            </div>

                            <div class="mb-3">
                                <label for="label" class="form-label">Label (mis. Rumah / Kantor)</label>
                                <input type="text" class="form-control" id="label"
                                    placeholder="Contoh: Rumah, Kantor, Kos, Apartemen">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <select class="custom-select" id="provinsi">
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="kota" class="form-label">Kota / Kabupaten</label>
                                    <select class="custom-select" id="kota" disabled>
                                        <option value="">Pilih Kota / Kabupaten</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <select class="custom-select" id="kecamatan" disabled>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                    <input type="text" class="form-control" id="kode_pos"
                                        placeholder="Masukkan Kode Pos">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat_lengkap" placeholder="Masukkan Alamat Lengkap" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">No. HP</label>
                                <input type="text" class="form-control" id="phone"
                                    placeholder="Masukkan Nomor Telepon">
                            </div>

                            <div class="d-flex justify-content-end" style="gap: 5px;">
                                <button type="reset" id="btnNantiSaja" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Nanti
                                    Saja</button>
                                <button type="reset" id="btnBatal" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- Kanan kiri layout --}}
        <div class="row">
            {{-- Kolom kiri --}}
            <div class="col-lg-8">

                {{-- Card tabel pesanan --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Pesanan Produk</h5>

                        {{-- Tabel produk --}}
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table align-middle mb-0">
                                <thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($checkoutItems))
                                        @foreach ($checkoutItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center product-info">
                                                        <img src="{{ asset('storage/uploads/produk/' . $item['gambar']) }}"
                                                            class="me-3 rounded cart-product-img"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                        <span class="fw-semibold">{{ $item['nama_produk'] }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h6 class="text-danger mb-0">Rp
                                                        {{ number_format($item['harga'], 0, ',', '.') }}</h6>
                                                </td>
                                                <td>{{ $item['jumlah'] }}</td>
                                                <td>
                                                    <h6 class="text-danger mb-0">Rp
                                                        {{ number_format($item['subtotal'], 0, ',', '.') }}</h6>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada produk di
                                                checkout.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        {{-- Kolom pesan --}}
                        <div class="mt-4">
                            <label for="pesan" class="form-label">
                                <h5>Pesan untuk Penjual (opsional)</h5>
                            </label>
                            <textarea id="pesan" name="pesan" class="form-control" rows="3"
                                placeholder="Tulis catatan khusus untuk pesanan ini..."></textarea>
                        </div>

                    </div>
                </div>

                {{-- Card metode pengiriman --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Metode Pengiriman</h5>

                        <div class="alert alert-info" id="shipping-info">
                            <small>Pilih kecamatan terlebih dahulu untuk menghitung ongkir</small>
                        </div>

                        <div class="row" id="shipping-options" style="display: none;">
                            <!-- Shipping options akan diisi via JavaScript -->
                        </div>
                    </div>
                </div>

                {{-- Card metode pembayaran --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Metode Pembayaran</h5>
                        <div class="row">
                            <!-- COD -->
                            <div class="col-12 col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                id="cod" value="cod" checked>
                                            <h6 class="mb-1">Bayar di Tempat (COD)</h6>
                                        </div>
                                        {{-- <div class="flex-grow-1">
                                            <small class="text-muted d-block">Bayar langsung ke kurir</small>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <!-- Transfer -->
                            <div class="col-12 col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                id="transfer" value="transfer">
                                            <h6 class="mb-1">Transfer Bank</h6>
                                        </div>
                                        {{-- <div class="flex-grow-1">
                                            <small class="text-muted d-block">BCA, BRI, Mandiri</small>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <!-- E-Wallet -->
                            <div class="col-12 col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                id="ewallet" value="ewallet">
                                            <h6 class="mb-1">E-Wallet</h6>
                                        </div>
                                        {{-- <div class="flex-grow-1">
                                            <small class="text-muted d-block">GoPay, OVO, DANA</small>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom kanan --}}
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 80px;">
                    <div class="card-body">
                        <h5 class="mb-3">Ringkasan Pesanan</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal Produk</span>
                            <span class="subtotal"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkos Kirim</span>
                            <span class="shipping-cost"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Metode Pembayaran</span>
                            <span class="payment-method-text">Bayar di Tempat (COD)</span>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between fw-bold mb-3">
                            <h5>Total Bayar</h5>
                            <h5><span class="total-price text-danger"></span></h5>
                        </div>

                        <button id="btnBayar" class="btn btn-primary w-100">Buat Pesanan</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- Bootstrap JS (versi 5 ke atas) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    {{-- Bayar --}}
    <script>
        $('#btnBayar').on('click', function(e) {
            e.preventDefault();

            const metode = $('input[name="paymentMethod"]:checked').val();
            // Ambil jasa_kirim yang dipilih
            const selectedShipping = $('.shipping-radio:checked');
            const jasaKirim = selectedShipping.data('service') || '-';

            // Ambil alamat & catatan
            const namaPenerima = $('#namaPenerima').text().trim();
            const noHp = $('#noHp').text().trim();
            const alamatLengkap = $('#alamatLengkap').text().trim();
            const alamatTambahan = $('#alamatTambahan').text().trim();
            const labelAlamat = $('#labelAlamat').text().trim();

            const alamatGabungan =
                `${namaPenerima} | ${noHp} | ${alamatLengkap} | ${alamatTambahan} | ${labelAlamat}`;

            const catatan = $('#pesan').val().trim();

            const produkIds = @json(array_column($checkoutItems, 'id_produk'));
            const jumlahBeli = @json(array_column($checkoutItems, 'jumlah'));

            let jumlahObj = {};
            produkIds.forEach((id, index) => {
                jumlahObj[id] = jumlahBeli[index];
            });

            let subtotalText = $('.total-price').text().replace(/\./g, '').replace('Rp', '').trim();
            let subtotal = parseInt(subtotalText) || 0;

            let shippingCostText = $('.shipping-cost').text().replace(/\./g, '').replace('Rp', '').trim();
            let shippingCost = parseInt(shippingCostText) || 0;


            if (metode === 'cod') {

                $.ajax({
                    url: '/pesanan/cod',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        alamat: alamatGabungan,
                        catatan: catatan,
                        jasa_kirim: jasaKirim,
                        subtotal: subtotal,
                        shippingCost : shippingCost,
                        produk_ids: produkIds,
                        metode: metode,
                        jumlah: jumlahObj
                    },
                    success: function(res) {
                        window.location.href = '/pesanan-berhasil';
                        // Swal.fire('Sukses', res.message, 'success').then(() => {
                            
                        // });
                    },
                    error: function(err) {
                        Swal.fire('Error', err.responseJSON.message || 'Terjadi kesalahan', 'error');
                    }
                });

                return;
            }

            // kirim metode ke server
            fetch('/get-snap-token', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        paymentMethod: metode,
                        subtotal: subtotal,
                        namaPenerima: namaPenerima,
                        noHp: noHp,
                        produk_ids: produkIds,
                        jumlah: jumlahObj
                    })
                })
                .then(res => res.json())
                .then(data => {
                    const noPesanan = data.no_pesanan;
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            // Kirim data hasil pembayaran ke backend
                            fetch('/pesanan/midtrans-sukses', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        result: result,
                                        alamat: alamatGabungan,
                                        no_pesanan: noPesanan,
                                        catatan: catatan,
                                        jasa_kirim: jasaKirim,
                                        subtotal: subtotal,
                                        shippingCost : shippingCost,
                                        produk_ids: produkIds,
                                        metode: metode,
                                        jumlah: jumlahObj
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    window.location.href = '/pesanan-berhasil';
                                })
                                .catch(err => {
                                    Swal.fire('Error', 'Gagal menyimpan pesanan ke database.',
                                        'error');
                                    console.error(err);
                                    // console.log(shippingCost);
                                });
                        },

                        onPending: function(result) {
                            Swal.fire('Pending', 'Menunggu pembayaran...', 'info');
                            console.log(result);
                        },
                        onError: function(result) {
                            window.location.href = '/checkout';
                        },
                        // onClose: function() {
                        //     Swal.fire('Dibatalkan', 'Kamu menutup pembayaran.', 'warning');
                        // }
                    });
                })
                .catch(err => console.error(err));
        });
    </script>

    {{-- Pengiriman --}}
    <script>
        $(document).ready(function() {
            // Variabel untuk menyimpan data
            let selectedKecamatan = null; // UBAH: null dulu, nanti diisi saat user pilih
            let originKecamatan = '2170'; // ID kecamatan toko (Tapos)
            let totalWeight = 1000; // Berat dalam gram
            const apiKey = '39dede19ea7eec1743e387dff154883b'; // API Key RajaOngkir

            // Load provinsi
            $.ajax({
                url: '/api/provinsi',
                type: 'GET',
                success: function(res) {
                    if (res.data && res.data.length > 0) {
                        $('#provinsi').empty();
                        $('#provinsi').append('<option value="">Pilih Provinsi</option>');

                        res.data.forEach(function(prov) {
                            $('#provinsi').append(
                                `<option value="${prov.id}">${prov.name}</option>`
                            );
                        });

                        if (typeof $.fn.niceSelect !== 'undefined') {
                            $('#provinsi').niceSelect('update');
                        }
                    }
                }
            });

            // Saat provinsi dipilih
            $('#provinsi').on('change', function() {
                let province_id = $(this).val();
                $('#kota').html('<option value="">Memuat...</option>').prop('disabled', true);
                $('#kecamatan').html('<option value="">Pilih Kecamatan</option>').prop('disabled', true);

                resetShipping();

                if (typeof $.fn.niceSelect !== 'undefined') {
                    $('#kota').niceSelect('update');
                    $('#kecamatan').niceSelect('update');
                }

                if (province_id) {
                    $.ajax({
                        url: `/api/kota/${province_id}`,
                        type: 'GET',
                        success: function(res) {
                            if (res.data && res.data.length > 0) {
                                $('#kota').empty();
                                $('#kota').append(
                                    '<option value="">Pilih Kota / Kabupaten</option>');
                                res.data.forEach(function(city) {
                                    $('#kota').append(
                                        `<option value="${city.id}">${city.name}</option>`
                                    );
                                });
                                $('#kota').prop('disabled', false);

                                if (typeof $.fn.niceSelect !== 'undefined') {
                                    $('#kota').niceSelect('update');
                                }
                            }
                        }
                    });
                }
            });

            // Saat kota dipilih
            $('#kota').on('change', function() {
                let city_id = $(this).val();
                $('#kecamatan').html('<option value="">Memuat...</option>').prop('disabled', true);

                resetShipping();

                if (typeof $.fn.niceSelect !== 'undefined') {
                    $('#kecamatan').niceSelect('update');
                }

                if (city_id) {
                    $.ajax({
                        url: `/api/kecamatan/${city_id}`,
                        type: 'GET',
                        success: function(res) {
                            if (res.data && res.data.length > 0) {
                                $('#kecamatan').empty();
                                $('#kecamatan').append(
                                    '<option value="">Pilih Kecamatan</option>');
                                res.data.forEach(function(district) {
                                    $('#kecamatan').append(
                                        `<option value="${district.id}">${district.name}</option>`
                                    );
                                });
                                $('#kecamatan').prop('disabled', false);

                                if (typeof $.fn.niceSelect !== 'undefined') {
                                    $('#kecamatan').niceSelect('update');
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            // console.error('Error loading kecamatan:', error);
                            $('#kecamatan').html(
                                '<option value="">Gagal memuat kecamatan</option>');
                        }
                    });
                }
            });

            // Saat kecamatan dipilih
            $('#kecamatan').on('change', function() {
                selectedKecamatan = $(this).val(); // Ambil ID kecamatan yang dipilih

                // console.log('Kecamatan terpilih:', selectedKecamatan);
                // console.log('Origin (Toko):', originKecamatan);

                if (selectedKecamatan) {
                    calculateShipping();
                } else {
                    resetShipping();
                }
            });

            // Fungsi reset shipping
            function resetShipping() {
                selectedKecamatan = null;
                $('#shipping-options').hide().html('');
                $('#shipping-info').show().html(
                    '<small>Pilih kecamatan terlebih dahulu untuk menghitung ongkir</small>');
                updateTotalPrice(0);
            }

            // Fungsi hitung ongkir - PANGGIL API RAJAONGKIR LANGSUNG
            function calculateShipping() {
                $('#shipping-info').html(
                    '<small><i class="fas fa-spinner fa-spin"></i> Menghitung ongkir...</small>').show();
                $('#shipping-options').hide().html('');

                // console.log('Mengirim request ke server Laravel...');

                fetch('/api/ongkir', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            origin: originKecamatan,
                            destination: selectedKecamatan,
                            weight: totalWeight
                        })
                    })
                    .then(response => response.json())
                    .then(res => {
                        console.log('Response ongkir dari Laravel:', res);

                        if (res.data && res.data.length > 0) {
                            displayShippingOptions(res.data);
                        } else {
                            $('#shipping-info').html(
                                '<small class="text-danger">Tidak ada layanan pengiriman tersedia</small>'
                            ).show();
                        }
                    })
                    .catch(error => {
                        // console.error('Error calculating shipping:', error);
                        $('#shipping-info').html(
                            '<small class="text-danger">Gagal menghitung ongkir. Silakan coba lagi.</small>'
                        ).show();
                    });
            }


            // Fungsi tampilkan opsi pengiriman
            function displayShippingOptions(shippingData) {
                $('#shipping-info').hide();

                if (shippingData.length === 0) {
                    $('#shipping-info').html(
                        '<small class="text-danger">Tidak ada layanan pengiriman tersedia</small>').show();
                    return;
                }

                let html = '';
                let isFirst = true;

                // Filter hanya beberapa kurir populer
                const popularCouriers = ['jne', 'pos', 'jnt', 'sicepat', 'lion', 'ninja'];
                const filteredData = shippingData.filter(item => popularCouriers.includes(item.code));

                // Ambil hanya 6 layanan termurah
                const limitedData = filteredData.slice(0, 6);

                limitedData.forEach(function(shipping) {
                    const serviceLabel = `${shipping.name} - ${shipping.service}`;
                    const price = shipping.cost;
                    const etd = shipping.etd || 'Estimasi tidak tersedia';

                    html += `
                <div class="col-12 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="form-check me-3">
                                <input class="form-check-input shipping-radio" 
                                       type="radio" 
                                       name="shippingMethod"
                                       value="${price}" 
                                       data-service="${serviceLabel}"
                                       data-etd="${etd}"
                                       ${isFirst ? 'checked' : ''}>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${shipping.name}</h6>
                                <small class="text-muted d-block">${shipping.service}</small>
                                <small class="text-muted d-block">Estimasi: ${etd}</small>
                                <div class="fw-semibold text-primary">Rp${formatNumber(price)}</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                    if (isFirst) {
                        updateTotalPrice(price);
                        isFirst = false;
                    }
                });

                $('#shipping-options').html(html).show();

                // Event listener untuk perubahan metode pengiriman
                $('.shipping-radio').on('change', function() {
                    const shippingCost = parseInt($(this).val());
                    updateTotalPrice(shippingCost);
                });
            }

            // Fungsi update total harga
            function updateTotalPrice(shippingCost) {
                const subtotal =
                    {{ !empty($checkoutItems) ? array_sum(array_column($checkoutItems, 'subtotal')) : 0 }};
                const total = subtotal + shippingCost;

                $('.shipping-cost').text('Rp ' + formatNumber(shippingCost));
                $('.total-price').text('Rp ' + formatNumber(total));
            }

            // Fungsi format number
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        });
    </script>

    {{-- Ringkasan --}}
    {{-- <script>
        $(document).ready(function() {
            // Ambil data subtotal dari PHP
            const checkoutItems = @json($checkoutItems);
            const subtotalProduk = checkoutItems.reduce((acc, item) => acc + parseInt(item.subtotal), 0);
            const ongkirDefault = 15000; // sementara fix dulu
            let totalBayar = subtotalProduk + ongkirDefault;

            // Inisialisasi awal ringkasan
            updateRingkasan();

            // Event jika user ganti metode pembayaran
            $('input[name="paymentMethod"]').on('change', function() {
                const metode = $(this).val();
                let metodeText = '';

                if (metode === 'cod') {
                    metodeText = 'Bayar di Tempat (COD)';
                } else if (metode === 'transfer') {
                    metodeText = 'Transfer Bank';
                } else if (metode === 'ewallet') {
                    metodeText = 'E-Wallet';
                }

                $('.payment-method-text').text(metodeText);
            });

            // Event kalau user ganti ongkir (kalau API aktif)
            $(document).on('change', '.shipping-radio', function() {
                const shippingCost = parseInt($(this).val());
                updateRingkasan(shippingCost);
            });

            // Fungsi update ringkasan pesanan
            function updateRingkasan(shippingCost = ongkirDefault) {
                const total = subtotalProduk + shippingCost;

                $('.subtotal').text('Rp ' + formatRupiah(subtotalProduk));
                $('.shipping-cost').text('Rp ' + formatRupiah(shippingCost));
                $('.total-price').text('Rp ' + formatRupiah(total));
            }

            // Fungsi format angka ke Rupiah
            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
        });
    </script> --}}

    {{-- Ringkasan --}}
    <script>
        $(document).ready(function() {
            // Ambil data subtotal dari PHP
            const checkoutItems = @json($checkoutItems);
            const subtotalProduk = checkoutItems.reduce((acc, item) => acc + parseInt(item.subtotal), 0);
            const ongkirDefault = 0; // nilai default awal
            updateRingkasan(ongkirDefault);

            // Event jika user ganti metode pembayaran
            $('input[name="paymentMethod"]').on('change', function() {
                const metode = $(this).val();
                let metodeText = '';

                if (metode === 'cod') metodeText = 'Bayar di Tempat (COD)';
                else if (metode === 'transfer') metodeText = 'Transfer Bank';
                else if (metode === 'ewallet') metodeText = 'E-Wallet';

                $('.payment-method-text').text(metodeText);
            });

            // Event: jika user pilih salah satu kurir (radio button)
            $(document).on('change', '.shipping-radio', function() {
                const shippingCost = parseInt($(this).val());
                updateRingkasan(shippingCost);
            });

            // Fungsi update ringkasan
            function updateRingkasan(shippingCost = ongkirDefault) {
                const total = subtotalProduk + shippingCost;

                $('.subtotal').text('Rp ' + formatRupiah(subtotalProduk));
                $('.shipping-cost').text('Rp ' + formatRupiah(shippingCost));
                $('.total-price').text('Rp ' + formatRupiah(total));
            }

            // Fungsi format angka ke Rupiah
            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
        });
    </script>


    {{-- Slice kalimat --}}
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

    {{-- <script>
        $(document).ready(function() {
            // Saat form disubmit
            $('#formAlamat').on('submit', function(e) {
                e.preventDefault(); // Biar gak reload halaman

                // Ambil nilai dari form modal
                const namaPenerima = $('#nama_penerima').val() || '-';
                const labelAlamat = $('#label').val() || '-';
                const provinsi = $('#provinsi option:selected').text() || '';
                const kota = $('#kota option:selected').text() || '';
                const kecamatan = $('#kecamatan option:selected').text() || '';
                const kodePos = $('#kode_pos').val() || '';
                const alamatLengkap = $('#alamat_lengkap').val() || '-';
                const noHp = $('#phone').val() || '-';

                // Gabungkan alamat lengkap dengan wilayah
                let alamatGabungan = alamatLengkap;
                if (kecamatan || kota || provinsi) {
                    alamatGabungan +=
                        `, ${kecamatan ? kecamatan + ',' : ''} ${kota ? kota + ',' : ''} ${provinsi}`;
                }
                if (kodePos) {
                    alamatGabungan += `, ${kodePos}`;
                }

                // Update tampilan di card
                $('#namaPenerima').text(namaPenerima);
                $('#noHp').text(noHp);
                $('#alamatLengkap').text(alamatGabungan);
                $('#alamatTambahan').text(alamatLengkap);
                $('#labelAlamat').text(labelAlamat);

                // Tutup modal setelah update
                $('#modalAlamat').modal('hide');
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {

            function isAlamatKosong() {
                const nama = $('#namaPenerima').text().trim();
                const noHp = $('#noHp').text().trim();
                const alamat = $('#alamatLengkap').text().trim();

                return (
                    nama === '...' ||
                    noHp === '...' ||
                    alamat === '...' ||
                    nama === '' ||
                    noHp === '' ||
                    alamat === ''
                );
            }

            const modalAlamatEl = document.getElementById('modalAlamat');
            const modalAlamat = new bootstrap.Modal(modalAlamatEl, {
                backdrop: 'static',
                keyboard: false
            });

            // Fungsi untuk atur tombol mana yang tampil
            function updateButtonVisibility() {
                if (isAlamatKosong()) {
                    $('#btnNantiSaja').show();
                    $('#btnBatal').hide();
                } else {
                    $('#btnNantiSaja').hide();
                    $('#btnBatal').show();
                }
            }

            // Jalankan saat halaman dimuat
            if (isAlamatKosong()) {
                modalAlamat.show();
            }
            updateButtonVisibility();

            // Klik tombol “Nanti Saja” → redirect ke /keranjang
            $('#btnNantiSaja').on('click', function(e) {
                e.preventDefault();

                const prev = document.referrer; // halaman sebelum user membuka halaman ini

                if (prev && prev !== window.location.href) {
                    window.location.href = prev; // balik ke halaman sebelumnya beneran
                }
            });

            // Klik tombol “Batal” → cukup tutup modal
            $('#btnBatal').on('click', function(e) {
                e.preventDefault();
                modalAlamat.hide();
            });

            // Saat form disubmit (klik tombol Simpan)
            $('#formAlamat').on('submit', function(e) {
                e.preventDefault();

                // Ambil data dari input
                const namaPenerima = $('#nama_penerima').val() || '-';
                const labelAlamat = $('#label').val() || '-';
                const provinsi = $('#provinsi option:selected').text() || '';
                const kota = $('#kota option:selected').text() || '';
                const kecamatan = $('#kecamatan option:selected').text() || '';
                const kodePos = $('#kode_pos').val() || '';
                const alamatLengkap = $('#alamat_lengkap').val() || '-';
                const noHp = $('#phone').val() || '-';

                // Gabungkan alamat lengkap
                let alamatGabungan = "";

                // Jika ada kecamatan / kota / provinsi
                if (kecamatan || kota || provinsi) {
                    alamatGabungan +=
                        `${kecamatan ? 'Kec. ' + kecamatan + ', ' : ''}` +
                        `${kota ? 'Kota ' + kota + ', ' : ''}` +
                        `${provinsi ? provinsi : ''}`;
                }

                // Jika ada kode pos
                if (kodePos) {
                    alamatGabungan += `${alamatGabungan ? ' ' : ''}${kodePos}`;
                }


                // Update tampilan di card
                $('#namaPenerima').text(namaPenerima);
                $('#noHp').text(noHp);
                $('#alamatLengkap').text(alamatLengkap);
                $('#alamatTambahan').text(alamatGabungan);
                $('#labelAlamat').text(labelAlamat);

                // Tutup modal
                modalAlamat.hide();

                // 🔥 Setelah disimpan, update tombol (jadi tampil “Batal”)
                updateButtonVisibility();
            });
        });
    </script>
@endsection
