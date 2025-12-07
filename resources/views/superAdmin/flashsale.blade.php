@extends('layouts/dashboard')

@section('link')
    <link rel="stylesheet" href="{{ asset('../assets') }}/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header mb-1" style="margin-bottom: -4vh">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 d-flex align-items-center mb-2 mb-md-0">
                    <h1 class="mb-0">Flash Sale</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start">
                    <!-- tombol tambah produk disembunyikan default -->
                    <button id="btnTambahProduk" type="button"
                        class="btn hide-btn btn-shadow btn-success d-inline-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#modalTambahProduk">
                        <i class="ti ti-plus me-2"></i>
                        Tambah Produk
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- Tabs -->
    <div class="col-sm-12 mt-3">
        <div class="d-flex mb-3">
            <button id="tabFlashSale" class="btn btn-outline-primary active me-2 w-25">Flash Sale</button>
            <button id="tabProduk" class="btn btn-outline-primary w-25">Produk</button>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- TAB 1: FLASH SALE -->
                <div id="contentFlashSale">
                    <form action="{{ route('flashsale.simpan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_promo" id="id_promo" value="{{ $flashsale->id_promo ?? '' }}">

                        {{-- 🖼️ Preview Banner --}}
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <div id="bannerPreviewContainer"
                                    style="border: 2px dashed #ccc; border-radius: 10px; overflow: hidden; background-color: #f9f9f9; height: 250px;">
                                    <img id="bannerPreview"
                                        src="{{ isset($flashsale->banner) ? asset('storage/uploads/promo/' . $flashsale->banner) : '#' }}"
                                        alt="Preview Banner"
                                        style="width: 100%; height: 100%; object-fit: cover; {{ isset($flashsale->banner) ? '' : 'display:none;' }}">
                                </div>
                            </div>
                        </div>

                        {{-- 📂 Input Banner --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Banner Promo</label>
                                <input type="file" name="banner" id="bannerInput" class="form-control" accept="image/*"
                                    {{ isset($flashsale) ? '' : 'required' }}>
                            </div>
                        </div>

                        <div class="row mt-4">
                            {{-- 🎯 Tipe Diskon --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Tipe Diskon</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipe" value="Persen"
                                        {{ old('tipe', $flashsale->tipe ?? '') == 'Persen' ? 'checked' : '' }} required>
                                    <label class="form-check-label">Persen (%)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipe" value="Nominal"
                                        {{ old('tipe', $flashsale->tipe ?? '') == 'Nominal' ? 'checked' : '' }}>
                                    <label class="form-check-label">Nominal (Rp)</label>
                                </div>
                            </div>

                            {{-- 💰 Jumlah Diskon --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jumlah Diskon</label>
                                <input type="number" name="jumlah_diskon" class="form-control"
                                    placeholder="Masukkan nilai diskon"
                                    value="{{ old('jumlah_diskon', $flashsale->nilai_diskon ?? '') }}" required>
                            </div>

                            {{-- 🗓️ Tanggal & Waktu --}}
                            @php
                                $mulai = isset($flashsale) ? explode(' ', $flashsale->tgl_mulai) : [null, null];
                                $selesai = isset($flashsale) ? explode(' ', $flashsale->tgl_selesai) : [null, null];
                            @endphp

                            <div class="row mb-3">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control"
                                        value="{{ old('tanggal_mulai', $mulai[0] ?? '') }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Waktu Mulai</label>
                                    <input type="time" name="waktu_mulai" class="form-control"
                                        value="{{ old('waktu_mulai', $mulai[1] ?? '') }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control"
                                        value="{{ old('tanggal_selesai', $selesai[0] ?? '') }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Waktu Selesai</label>
                                    <input type="time" name="waktu_selesai" class="form-control"
                                        value="{{ old('waktu_selesai', $selesai[1] ?? '') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- 💾 Tombol Simpan --}}
                        <div class="row mt-2">
                            <div class="col-12">
                                <button type="submit" id="btnSimpanFlashSale" class="btn btn-primary w-100 py-2 fw-bold">
                                    <i class="ti ti-device-floppy me-2"></i>
                                    {{ isset($flashsale) ? 'Perbarui Flash Sale' : 'Simpan Flash Sale' }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>

                <!-- TAB 2: PRODUK -->
                <div id="contentProduk" style="display: none;">
                    <div class="dt-responsive">
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>SKU</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produkFlashsale as $promo)
                                    @foreach ($promo->produks as $produk)
                                        @php
                                            // Hitung harga setelah diskon
                                            if ($promo->tipe == 'Persen') {
                                                $hargaSetelahDiskon = $produk->harga - ($produk->harga * $promo->nilai_diskon / 100);
                                            } else {
                                                $hargaSetelahDiskon = $produk->harga - $promo->nilai_diskon;
                                            }
                            
                                            if ($hargaSetelahDiskon < 0) {
                                                $hargaSetelahDiskon = 0;
                                            }
                                        @endphp
                            
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $produk->sku }}</td>
                                            <td>{{ $produk->nama_produk }}</td>
                                            <td>{{ $produk->kategori->nama ?? '-' }}</td>
                                            <td>
                                                <div>
                                                    <span class="text-muted text-decoration-line-through d-block">
                                                        {{ 'Rp ' . number_format($produk->harga, 0, ',', '.') }}
                                                    </span>
                                                    <span class="fw-bold text-danger">
                                                        {{ 'Rp ' . number_format($hargaSetelahDiskon, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger btnHapus"
                                                    data-id="{{ $produk->id_produk }}" data-nama="{{ $produk->nama_produk }}">
                                                    <i class="ti ti-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT TAB -->


    <style>
        .hide-btn {
            display: none !important;
        }

        .show-btn {
            display: inline-flex !important;
        }

        #tabFlashSale.active,
        #tabProduk.active {
            background-color: #0d6efd;
            color: white;
        }

        #tabFlashSale,
        #tabProduk {
            border-radius: 10px 10px 0 0;
        }
    </style>


    <!-- Modal Tambah Diskon -->
    {{-- <div class="modal fade" id="modalTambahDiskon" tabindex="-1" aria-labelledby="modalTambahDiskonLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="modalTambahDiskonLabel">Tambah Diskon</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="formTambahDiskon" action="{{ url('/diskonBaru') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Preview Gambar -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <div id="bannerPreviewContainer"
                                    style="border: 2px dashed #ccc; border-radius: 10px; overflow: hidden; background-color: #f9f9f9; height: 250px;">
                                    <img id="bannerPreview" src="#" alt="Preview Banner"
                                        style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Banner Promo -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Banner Promo</label>
                                <input type="file" name="banner" id="bannerInput" class="form-control" accept="image/*"
                                    required>
                            </div>
                        </div>

                        <!-- Nama Promo -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Nama Promo</label>
                                <input type="text" name="nama_promo" class="form-control"
                                    placeholder="Contoh: Diskon Spesial Ramadhan" required>
                            </div>
                        </div>

                        <!-- Tipe & Nilai Diskon -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label d-block">Tipe Diskon</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipe" id="tipePersen"
                                        value="Persen" required>
                                    <label class="form-check-label" for="tipePersen">Persen (%)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipe" id="tipeNominal"
                                        value="Nominal" required>
                                    <label class="form-check-label" for="tipeNominal">Nominal (Rp)</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nilai Diskon</label>
                                <input type="number" name="nilai_diskon" class="form-control"
                                    placeholder="Masukkan nilai diskon" required>
                            </div>
                        </div>

                        <!-- Periode Diskon -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" class="form-control" required>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalTambahProdukLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="modalTambahProdukLabel">
                        <i class="ti ti-plus me-2"></i>Tambah Produk ke Diskon
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="filterKategori" class="form-label">Pilih Kategori</label>
                            <select id="filterKategori" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->nama }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered nowrap" id="tableProdukModal" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SKU</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-simpan">
                        <i class="ti ti-device-floppy me-1"></i>Simpan Pilihan
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/sweetalert2.all.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabFlashSale = document.getElementById("tabFlashSale");
            const tabProduk = document.getElementById("tabProduk");
            const contentFlashSale = document.getElementById("contentFlashSale");
            const contentProduk = document.getElementById("contentProduk");
            const btnTambahProduk = document.getElementById("btnTambahProduk");

            // Default: sembunyikan tombol tambah produk
            btnTambahProduk.classList.add("hide-btn");

            // Klik tab Flash Sale
            tabFlashSale.addEventListener("click", function() {
                tabFlashSale.classList.add("active");
                tabProduk.classList.remove("active");
                contentFlashSale.style.display = "block";
                contentProduk.style.display = "none";

                // 🔹 Hide tombol tambah produk
                btnTambahProduk.classList.add("hide-btn");
                btnTambahProduk.classList.remove("show-btn");
            });

            // Klik tab Produk
            tabProduk.addEventListener("click", function() {
                tabProduk.classList.add("active");
                tabFlashSale.classList.remove("active");
                contentProduk.style.display = "block";
                contentFlashSale.style.display = "none";

                // 🔹 Show tombol tambah produk
                btnTambahProduk.classList.remove("hide-btn");
                btnTambahProduk.classList.add("show-btn");
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Inisialisasi datatable
            $('#dom-jqry').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: -1
                    } // kolom terakhir = aksi
                ]
            });

            // SweetAlert Toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            // Pesan dari session Laravel
            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            // Reset form tambah saat modal ditutup
            $('#modalTambahDiskon').on('hidden.bs.modal', function() {
                $('#formTambahDiskon')[0].reset();
                $('#formTambahDiskon .error-text').remove();
                $('#formTambahDiskon button[type="submit"]').prop('disabled', false);
            });

            // ===== SweetAlert Hapus =====
            $('.btnHapus').on('click', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Diskon?',
                    html: `Yakin ingin menghapus <strong>${nama}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = '/hapusProdukFlashsale/' + id;
                });
            });

            var table2 = $('#tableProdukModal').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ], // urutan yang muncul di dropdown
                language: {
                    lengthMenu: "Tampilkan _MENU_ produk per halaman"
                }
            });

            // Tambah produk
            function loadProdukBelumDiskon(kategori = '') {
                $('#tableProdukModal tbody').html(
                    '<tr><td colspan="6" class="text-center py-4">⏳ Memuat data...</td></tr>');

                $.ajax({
                    url: '/produk-belum-flashsale',
                    type: 'GET',
                    data: {
                        kategori: kategori
                    },
                    success: function(data) {
                        console.log("Data produk:", data);
                        table2.clear();
                        data.forEach(function(item) {
                            const formatRupiah = (angka) => 'Rp ' + parseFloat(angka)
                                .toLocaleString('id-ID');
                            table2.row.add([
                                item.no,
                                item.sku,
                                item.nama,
                                item.kategori,
                                formatRupiah(item.harga),
                                `<div>
                        <button class="btn btn-success btn-sm btnPilihProduk" data-id="${item.id_produk}" data-harga="${item.harga}">
                            <i class="ti ti-check me-1"></i>Pilih
                        </button>
                    </div>`
                            ]);
                        });
                        table2.draw();
                        table2.columns.adjust().responsive.recalc();
                    },
                    error: function() {
                        Swal.fire('Gagal!', 'Gagal memuat produk.', 'error');
                    }
                });
            }

            $('#btnTambahProduk').on('click', function() {
                $('#modalTambahProduk').modal('show');
                $('.btnTambahProduk').removeClass('active');
                $(this).addClass('active'); // simpan promo yang sedang aktif
            });

            // Saat modal benar-benar sudah muncul
            $('#modalTambahProduk').on('shown.bs.modal', function() {
                loadProdukBelumDiskon(''); // langsung load semua produk tanpa filter
                table2.columns.adjust().responsive.recalc();
            });


            // Filter kategori
            $('#filterKategori').on('change', function() {
                loadProdukBelumDiskon($(this).val());
            });

            // Toggle tombol "Pilih" <-> "Batal"
            $('#tableProdukModal').on('click', '.btnPilihProduk', function() {
                const btn = $(this);
                const row = btn.closest('tr');

                let hargaCell = row.find('td').eq(4);
                if (!hargaCell.is(':visible')) {
                    hargaCell = row.next('.child').find('td:contains("Harga")').next();
                }

                const promoBtn = $('.btnTambahProduk.active');
                const promoTipe = "{{ $flashsale->tipe ?? '' }}";
                const promoNilai = parseFloat("{{ $flashsale->nilai_diskon ?? 0 }}");
                // console.log(promoNilai);

                const hargaAsli = parseFloat(btn.data('harga')) || 0; // ✅ FIX
                const formatRupiah = (angka) => 'Rp ' + angka.toLocaleString('id-ID');

                if (btn.hasClass('btn-success')) {
                    btn.removeClass('btn-success')
                        .addClass('btn-danger')
                        .html('<i class="ti ti-x me-1"></i>Batal');

                    let hargaSetelahDiskon = promoTipe === 'Persen' ?
                        hargaAsli - (hargaAsli * promoNilai / 100) :
                        hargaAsli - promoNilai;
                    // console.log(hargaSetelahDiskon);

                    hargaSetelahDiskon = Math.floor(hargaSetelahDiskon);

                    if (hargaSetelahDiskon < 0) hargaSetelahDiskon = 0;

                    const hargaTampil = `
            <div>
                <span class="text-muted text-decoration-line-through d-block">${formatRupiah(hargaAsli)}</span>
                <span class="fw-bold text-danger">${formatRupiah(hargaSetelahDiskon)}</span>
            </div>`;

                    hargaCell.html(hargaTampil);
                    const childHargaCell = row.next('.child').find('td:contains("Harga")').next();
                    if (childHargaCell.length) childHargaCell.html(hargaTampil);

                } else {
                    btn.removeClass('btn-danger')
                        .addClass('btn-success')
                        .html('<i class="ti ti-check me-1"></i>Pilih');

                    hargaCell.html(formatRupiah(hargaAsli));
                    const childHargaCell = row.next('.child').find('td:contains("Harga")').next();
                    if (childHargaCell.length) childHargaCell.html(formatRupiah(hargaAsli));
                }
            });

            // === Simpan produk ke promo ===
            $('.modal-footer .btn-simpan').on('click', function() {
                const selectedProduk = [];

                // Ambil ID produk yang tombolnya status BATAL (berarti dipilih)
                $('#tableProdukModal .btnPilihProduk.btn-danger').each(function() {
                    selectedProduk.push($(this).data('id'));
                });

                if (selectedProduk.length === 0) {
                    Swal.fire('Oops!', 'Tidak ada produk yang dipilih.', 'warning');
                    return;
                }

                // Ambil promoId langsung dari flashsale yang dikirim dari controller
                const promoId = "{{ $flashsale->id_promo ?? '' }}";

                if (!promoId) {
                    Swal.fire('Error!', 'ID promo tidak ditemukan.', 'error');
                    return;
                }

                $.ajax({
                    url: `/promo/${promoId}/produk`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        produk_ids: selectedProduk
                    },
                    success: function(res) {
                        $('#modalTambahProduk').modal('hide');

                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            location.reload();
                        }, 500);
                    },
                    error: function(err) {
                        Swal.fire('Gagal!', 'Gagal menambahkan produk ke promo.', 'error');
                    }
                });
            });


            $('#modalTambahProduk').on('shown.bs.modal', function() {
                table2.columns.adjust().responsive.recalc();
            });
        });
    </script>
    <script>
        document.getElementById('bannerInput').addEventListener('change', function(event) {
            const preview = document.getElementById('bannerPreview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                preview.src = '#';
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('form[action*="flashsale/simpan"]');
            const btnSubmit = form.querySelector('#btnSimpanFlashSale');

            // Fungsi validasi utama
            function validateDateTime() {
                const tanggalMulai = form.querySelector('input[name="tanggal_mulai"]').value;
                const waktuMulai = form.querySelector('input[name="waktu_mulai"]').value;
                const tanggalSelesai = form.querySelector('input[name="tanggal_selesai"]').value;
                const waktuSelesai = form.querySelector('input[name="waktu_selesai"]').value;

                // Hapus error sebelumnya
                form.querySelectorAll('.error-text').forEach(e => e.remove());
                let valid = true;

                // === Validasi tanggal ===
                if (tanggalMulai && tanggalSelesai) {
                    const mulai = new Date(`${tanggalMulai}T00:00`);
                    const selesai = new Date(`${tanggalSelesai}T00:00`);
                    if (mulai > selesai) {
                        const tanggalSelesaiInput = form.querySelector('input[name="tanggal_selesai"]');
                        tanggalSelesaiInput.insertAdjacentHTML(
                            'afterend',
                            '<small class="text-danger error-text">Tanggal selesai harus setelah tanggal mulai.</small>'
                        );
                        valid = false;
                    }
                }

                // === Validasi waktu ===
                if (waktuMulai && waktuSelesai) {
                    const [jmMulai, mnMulai] = waktuMulai.split(':').map(Number);
                    const [jmSelesai, mnSelesai] = waktuSelesai.split(':').map(Number);
                    const totalMulai = jmMulai * 60 + mnMulai;
                    const totalSelesai = jmSelesai * 60 + mnSelesai;

                    if (totalMulai >= totalSelesai && tanggalMulai === tanggalSelesai) {
                        const waktuSelesaiInput = form.querySelector('input[name="waktu_selesai"]');
                        waktuSelesaiInput.insertAdjacentHTML(
                            'afterend',
                            '<small class="text-danger error-text">Waktu selesai harus lebih besar dari waktu mulai.</small>'
                        );
                        valid = false;
                    }
                }

                // === Disable / Enable tombol simpan ===
                btnSubmit.disabled = !valid;
                return valid;
            }

            // Jalankan validasi otomatis setiap kali tanggal/waktu berubah
            ['tanggal_mulai', 'tanggal_selesai', 'waktu_mulai', 'waktu_selesai'].forEach(name => {
                const input = form.querySelector(`input[name="${name}"]`);
                input.addEventListener('change', validateDateTime);
                input.addEventListener('keyup', validateDateTime);
            });

            // Cek sebelum submit form (prevent jika tidak valid)
            form.addEventListener('submit', function(e) {
                if (!validateDateTime()) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
