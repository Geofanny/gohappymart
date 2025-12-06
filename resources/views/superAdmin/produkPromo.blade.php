@extends('layouts/dashboard')

@section('link')
    <link rel="stylesheet" href="{{ asset('../assets') }}/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center mb-3">
                <div class="col-12 col-md-12">
                    <h1 class="mb-0">Manajemen Diskon Produk</h1>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= TABLE UTAMA ================= --}}
    <div class="card p-3">
        <table class="table table-striped table-bordered nowrap" id="tableProduk" style="width:100%">
            <thead>
                <tr>
                    <th></th> <!-- Kolom kontrol responsive -->
                    <th>No</th>
                    <th>Diskon</th>
                    <th>Total Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promos as $i => $promo)
                    <tr>
                        <td></td>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            {{ $promo->nama_promo }}
                            @if ($promo->tipe === 'Persen')
                                ({{ $promo->nilai_diskon }}%)
                            @else
                                (Rp {{ number_format($promo->nilai_diskon, 0, ',', '.') }})
                            @endif
                        </td>
                        <td>{{ $promo->produks_count }} Produk</td>
                        <td>
                            <button class="btn btn-primary btn-sm me-2 btnTambahProduk" data-id="{{ $promo->id_promo }}"
                                data-nilai="{{ $promo->nilai_diskon }}" data-tipe="{{ $promo->tipe }}">
                                <i class="ti ti-plus me-1"></i>Tambah Produk
                            </button>

                            <button class="btn btn-info btn-sm text-white btnLihatProduk" data-id="{{ $promo->id_promo }}"
                                data-nama="{{ $promo->nama_promo }}" data-nilai="{{ $promo->nilai_diskon }}"
                                data-tipe="{{ $promo->tipe }}">
                                <i class="ti ti-eye me-1"></i>Lihat Produk
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

    {{-- ================= MODAL TAMBAH PRODUK ================= --}}
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

    {{-- ================= MODAL LIHAT PRODUK ================= --}}
    <div class="modal fade" id="modalLihatProduk" tabindex="-1" aria-labelledby="modalLihatProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="modalLihatProdukLabel">
                        <i class="ti ti-eye me-2"></i>Daftar Produk dalam Diskon
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="filterKategoriLihat" class="form-label">Filter Kategori</label>
                            <select id="filterKategoriLihat" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->nama }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered nowrap" id="tableProdukLihat" style="width:100%">
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
                            {{-- diisi dinamis via AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/jquery.dataTables.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script src="{{ asset('../assets') }}/js/plugins/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // === Table utama ===
            var table = $('#tableProduk').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 0 // kolom pertama jadi ikon “+”
                    }
                },
                columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }, // kolom pertama untuk ikon +
                    {
                        orderable: false,
                        targets: -1
                    }, // kolom aksi tidak bisa diurutkan
                    {
                        responsivePriority: 1,
                        targets: 2
                    }, // Diskon
                    {
                        responsivePriority: 2,
                        targets: 3
                    }, // Total Produk
                    {
                        responsivePriority: 10000,
                        targets: -1
                    } // kolom aksi disembunyikan di layar kecil
                ],
                autoWidth: false,
                pageLength: 10
            });


            // === Table di modal ===
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

            function loadProdukBelumDiskon(kategori = '') {
                $.ajax({
                    url: '/produk-belum-diskon',
                    type: 'GET',
                    data: {
                        kategori: kategori
                    },
                    success: function(data) {
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
                    },
                    error: function() {
                        Swal.fire('Gagal!', 'Gagal memuat produk.', 'error');
                    }
                });
            }

            // Panggil saat modal tampil pertama kali
            // Panggil saat modal tampil pertama kali
            $('#tableProduk').on('click', '.btnTambahProduk', function() {
                // Reset tombol aktif lain
                $('.btnTambahProduk').removeClass('active');
                $(this).addClass('active');

                // Ambil data dari tombol yang diklik
                const promoNama = $(this).closest('tr').find('td').eq(2).text()
            .trim(); // kolom diskon (nama promo)
                const promoNilai = $(this).data('nilai');
                const promoTipe = $(this).data('tipe');

                // Format nilai diskon
                let displayDiskon = '';
                if (promoTipe === 'Persen') {
                    displayDiskon = promoNilai + '%';
                } else {
                    displayDiskon = 'Rp. ' + parseFloat(promoNilai).toLocaleString('id-ID');
                }

                // 🔹 Ubah judul modal Tambah Produk
                $('#modalTambahProdukLabel').html(`
        <i class="ti ti-plus me-2"></i>
        Tambah Produk ke Diskon 
        <span class="fw-bold">${promoNama}</span>
    `);

                // Tampilkan modal dan muat data produk
                $('#modalTambahProduk').modal('show');
                loadProdukBelumDiskon($('#filterKategori').val());

                // Recalc layout DataTables setelah modal muncul
                setTimeout(() => table2.columns.adjust().responsive.recalc(), 300);
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
                const promoNilai = parseFloat(promoBtn.data('nilai')) || 0;
                const promoTipe = promoBtn.data('tipe');

                const hargaAsli = parseFloat(btn.data('harga')) || 0; // ✅ FIX
                const formatRupiah = (angka) => 'Rp ' + angka.toLocaleString('id-ID');

                if (btn.hasClass('btn-success')) {
                    btn.removeClass('btn-success')
                        .addClass('btn-danger')
                        .html('<i class="ti ti-x me-1"></i>Batal');

                    let hargaSetelahDiskon = promoTipe === 'Persen' ?
                        hargaAsli - (hargaAsli * promoNilai / 100) :
                        hargaAsli - promoNilai;
                    
                    hargaSetelahDiskon = Math.round(hargaSetelahDiskon);

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

                // Ambil ID promo dari tombol yang diklik sebelumnya
                const promoId = $('.btnTambahProduk.active').data('id');

                // console.log(promoId);

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

                        // Reload halaman biar update total produk
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



            // $('#tableProduk').on('click', '.btn-info', function() {
            //     alert('Menampilkan detail produk diskon ini!');
            // });

            // === Saat modal tampil, hitung ulang kolom ===
            $('#modalTambahProduk').on('shown.bs.modal', function() {
                table2.columns.adjust().responsive.recalc();
            });

            // === Table Lihat Produk ===
            var table3 = $('#tableProdukLihat').DataTable({
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

            // === Saat modal Lihat Produk tampil, hitung ulang kolom ===
            $('#modalLihatProduk').on('shown.bs.modal', function() {
                table3.columns.adjust().responsive.recalc();
            });


            // Tombol “Lihat Produk” diklik
            $('#tableProduk').on('click', '.btnLihatProduk', function() {
                var promoId = $(this).data('id');

                var promoNama = $(this).data('nama');

                var promoNilai = $(this).data('nilai');

                var promoTipe = $(this).data('tipe');

                // Format nilai diskon
                let displayDiskon = '';
                if (promoTipe === 'Persen') {
                    displayDiskon = promoNilai + '%';
                } else {
                    // Format Rupiah
                    displayDiskon = 'Rp. ' + parseFloat(promoNilai)
                        .toLocaleString('id-ID');
                }

                // Ubah judul modal
                $('#modalLihatProdukLabel').html(`
        <i class="ti ti-eye me-2"></i>
        Daftar Produk dalam Diskon 
        <span class="fw-bold">${promoNama} (${displayDiskon})</span>
    `);

                // kosongkan dulu tabel
                table3.clear().draw();

                // ambil data produk via AJAX
                $.ajax({
                    url: `/promo/${promoId}/produk`,
                    type: 'GET',
                    success: function(data) {
                        table3.clear();

                        data.forEach(function(item) {
                            // Ambil tipe dan nilai diskon dari promo
                            const tipeDiskon = item
                                .tipe_diskon; // "Persen" atau "Nominal"
                            const nilaiDiskon = parseFloat(item.nilai_diskon);
                            const hargaAsli = parseFloat(item.harga);

                            let hargaSetelahDiskon = hargaAsli;

                            // 🔢 Hitung harga diskon
                            if (tipeDiskon === "Persen") {
                                hargaSetelahDiskon = hargaAsli - (hargaAsli *
                                    nilaiDiskon / 100);
                            } else {
                                hargaSetelahDiskon = hargaAsli - nilaiDiskon;
                            }

                            hargaSetelahDiskon = Math.round(hargaSetelahDiskon);

                            // 🔹 Format ke Rupiah
                            const formatRupiah = (angka) => {
                                return 'Rp. ' + angka.toLocaleString('id-ID');
                            };

                            // 🔹 Buat tampilan harga coret dan harga diskon
                            const hargaTampil = `
            <div>
                <span class="text-muted text-decoration-line-through d-block">${formatRupiah(hargaAsli)}</span>
                <span class="fw-bold text-danger">${formatRupiah(hargaSetelahDiskon)}</span>
            </div>
        `;

                            table3.row.add([
                                item.no,
                                item.sku,
                                item.nama,
                                item.kategori,
                                hargaTampil,
                                `
    <div>
        <button class="btn btn-danger btn-sm btnHapusProduk" 
            data-id="${item.id_produk}" 
            data-promo="${promoId}">
            <i class="ti ti-trash me-1"></i>Hapus
        </button>
    </div>
    `
                            ]);

                        });

                        table3.draw();
                        $('#modalLihatProduk').modal('show');
                    },
                    error: function() {
                        alert('Gagal memuat data produk untuk promo ini!');
                    }
                });
            });

            $('#tableProdukLihat').on('click', '.btnHapusProduk', function() {
                const idProduk = $(this).data('id');
                const idPromo = $(this).data('promo');
                const row = $(this).closest('tr');

                // Tutup modal dulu supaya SweetAlert terlihat
                $('#modalLihatProduk').modal('hide');

                // Konfirmasi pakai SweetAlert
                Swal.fire({
                    title: 'Yakin ingin menghapus produk ini dari diskon?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/promo/${idPromo}/produk/${idProduk}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                // Hapus baris dari tabel
                                table3.row(row).remove().draw();

                                location.reload();

                                // Notifikasi sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Produk berhasil dihapus dari diskon.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                            },
                            error: function() {
                                Swal.fire('Gagal!',
                                    'Gagal menghapus produk dari diskon!', 'error');
                                // Buka kembali modal jika gagal
                                $('#modalLihatProduk').modal('show');
                            }
                        });
                    } else {
                        // Jika batal, buka kembali modal
                        $('#modalLihatProduk').modal('show');
                    }
                });
            });




            // 🔍 Filter kategori di modal lihat produk
            $('#filterKategoriLihat').on('change', function() {
                var kategori = $(this).val();
                table3.column(3).search(kategori ? '^' + kategori + '$' : '', true, false).draw();
            });

        });
    </script>
@endsection
