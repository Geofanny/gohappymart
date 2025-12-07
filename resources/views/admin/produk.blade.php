@extends('layouts/dashboard')

@section('link')
    <link rel="stylesheet" href="{{ asset('../assets') }}/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 mb-2 mb-md-0">
                    <h1 class="mb-0">Manajemen Produk</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start gap-2">
                    <!-- Tombol Tambah Produk -->
                    <a href="/dashboard-admin/produk/baru" class="btn btn-success d-inline-flex align-items-center">
                        <i class="ti ti-plus me-2"></i> Tambah Produk
                    </a>

                    <form action="{{ route('produk.pdf') }}" method="GET" target="_blank">
                        <button type="submit" class="btn btn-primary d-inline-flex align-items-center">
                            <i class="fas fa-print me-2"></i> Print
                        </button>
                    </form>            

                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->


    <!-- DOM/Jquery table start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="dt-responsive">
                    <table id="dom-jqry" class="table table-striped  table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>SKU</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $index => $item)

                                <tr>
                                    <td>{{ $index + 1 }}.</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->kategori->nama ?? '-' }}</td>

                                    {{-- Kolom stok dengan badge --}}
                                    <td>
                                        <span class="badge 
                                            @if($item->status == 'aktif') bg-success 
                                            @elseif($item->status == 'nonaktif') bg-danger 
                                            @else bg-secondary @endif">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>                                    

                                    <td>
                                        <a href="/dashboard-admin/produk/edit/{{ $item->id_produk }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="ti ti-edit"></i> Edit
                                        </a>

                                        <button class="btn btn-sm btn-info btn-detail"
                                            data-gambar="{{ $item->gambar ? asset('storage/uploads/produk/' . $item->gambar) : 'https://dummyimage.com/300x300/cccccc/000000&text=No+Image' }}"
                                            data-sku="{{ $item->sku }}" data-nama="{{ $item->nama_produk }}"
                                            data-kategori="{{ $item->kategori->nama ?? '-' }}"
                                            data-harga="{{ $item->harga }}" data-stok="{{ $item->stok }}"
                                            data-status="{{ ucfirst($item->status) }}"
                                            data-deskripsi='{!! $item->deskripsi ?? '-' !!}'>
                                            <i class="ti ti-eye"></i> Detail
                                        </button>


                                        {{-- <button class="btn btn-sm btn-primary btn-stock" data-id="{{ $item->id_produk }}"
                                            data-nama="{{ $item->nama_produk }}" data-stok="{{ $item->stok }}">
                                            <i class="ti ti-box"></i> Stok
                                        </button> --}}

                                        <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $item->id_produk }}"
                                            data-nama="{{ $item->nama_produk }}">
                                            <i class="ti ti-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>SKU</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- DOM/Jquery table end -->

    <!-- Modal Detail Produk -->
    <div class="modal fade" id="modalDetailProduk" tabindex="-1" aria-labelledby="detailProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">

                <!-- Header -->
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="detailProdukLabel">
                        Detail Produk
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row g-4 align-items-start">

                        <!-- Gambar Produk -->
                        <div class="col-md-5 text-center">
                            <div class="border rounded-3 p-2 shadow-sm bg-light">
                                <img id="detail-gambar" src="https://dummyimage.com/300x300/cccccc/000000&text=No+Image"
                                    alt="Gambar Produk" class="img-fluid rounded"
                                    style="max-height: 300px; object-fit: contain;">

                            </div>
                        </div>

                        <!-- Info Produk -->
                        <div class="col-md-7">
                            <h4 id="detail-nama" class="fw-bold text-dark mb-3"></h4>

                            <table class="table table-bordered table-striped align-middle mb-3">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="bg-light text-secondary" style="width: 130px;">SKU</th>
                                        <td id="detail-sku" class="fw-medium text-dark"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light text-secondary">Kategori</th>
                                        <td id="detail-kategori" class="fw-medium text-dark"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light text-secondary">Harga</th>
                                        <td id="detail-harga" class="text-dark fw-bold"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light text-secondary">Stok</th>
                                        <td id="detail-stok" class="fw-medium text-dark"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light text-secondary">Status</th>
                                        <td><span id="detail-status" class="badge bg-success px-3 py-2"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div class="mt-4">
                        <h6 class="fw-bold mb-2"><i class="ti ti-info-circle me-1"></i> Deskripsi Produk</h6>
                        <div id="detail-deskripsi" class="border rounded bg-light p-3 shadow-sm"
                            style="max-height: 300px; overflow-y: auto; text-align: justify;">
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Stok -->
    <div class="modal fade" id="modalStokProduk" tabindex="-1" aria-labelledby="stokProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="stokProdukLabel">Update Stok Produk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="formStokProduk">
                    <div class="modal-body">
                        <table class="table table-bordered table-striped mb-3">
                            <tbody>
                                <tr>
                                    <th style="width: 150px;">Produk</th>
                                    <td id="stok-nama"></td>
                                </tr>
                                <tr>
                                    <th>Stok Saat Ini</th>
                                    <td id="stok-sekarang"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mb-3">
                            <label class="form-label">Aksi</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="aksi_stok" id="stok-tambah"
                                        value="tambah">
                                    <label class="form-check-label" for="stok-tambah">Tambah</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="aksi_stok" id="stok-kurang"
                                        value="kurang">
                                    <label class="form-check-label" for="stok-kurang">Kurang</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-none" id="jumlahStokDiv">
                            <label for="jumlahStok" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlahStok" name="jumlah_stok"
                                min="1">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/jquery.dataTables.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dom-jqry').DataTable({
                responsive: true, // <--- ini penting
                autoWidth: false, // biar kolom menyesuaikan layar
                pageLength: 10, // opsional: jumlah baris per halaman
            });
        });
    </script>
    <script>
        // Buat instance mixin reusable
        const Toast = Swal.mixin({
            toast: true, // jadi alert-nya tampil seperti toast
            position: 'top-end', // posisi di kanan atas
            showConfirmButton: false, // tanpa tombol OK
            timer: 5000, // auto-close dalam 3 detik
            timerProgressBar: true, // ada progress bar
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif
    </script>

    <script>
        $(document).on('click', '.btn-detail', function() {
            const harga = $(this).data('harga');
            const formattedHarga = formatRupiah(harga);

            const gambar = $(this).data('gambar');
            $('#detail-gambar').attr('src', gambar ? gambar :
                'https://dummyimage.com/300x300/cccccc/000000&text=No+Image');

            $('#detail-sku').text($(this).data('sku'));
            $('#detail-nama').text($(this).data('nama'));
            $('#detail-kategori').text($(this).data('kategori'));
            $('#detail-harga').text(formattedHarga);
            $('#detail-stok').text($(this).data('stok'));
            $('#detail-status').text($(this).data('status'));
            $('#detail-deskripsi').html($(this).data('deskripsi'));
            $('#modalDetailProduk').modal('show');
        });



        function formatRupiah(angka) {
            // Hilangkan karakter non-digit
            angka = angka.toString().replace(/[^,\d]/g, '');
            const split = angka.split(',');
            const sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp.' + rupiah;
        }
    </script>
    <script>
        $(document).on('click', '.btn-hapus', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');

            Swal.fire({
                title: 'Hapus Produk?',
                html: `Apakah kamu yakin ingin menghapus <b>${nama}</b>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/destroyProduk/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus produk.'
                            });
                        }
                    });
                }
            });
        });
    </script>
    {{-- <script>
        $(document).on('click', '.btn-stock', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const stok = $(this).data('stok');

            $('#stok-nama').text(nama);
            $('#stok-sekarang').text(stok);
            $('#jumlahStokDiv').addClass('d-none'); // sembunyikan input awal
            $('#formStokProduk')[0].reset();
            $('#formStokProduk').data('id', id);

            $('#modalStokProduk').modal('show');
        });

        $('input[name="aksi_stok"]').on('change', function() {
            $('#jumlahStokDiv').removeClass('d-none');
        });

        $('#formStokProduk').on('submit', function(e) {
            e.preventDefault();

            const id = $(this).data('id');
            const aksi = $('input[name="aksi_stok"]:checked').val();
            const jumlah = $('#jumlahStok').val();

            if (!aksi || jumlah <= 0) {
                Swal.fire('Oops', 'Pilih aksi dan masukkan jumlah stok yang valid!', 'warning');
                return;
            }

            // Kirim data ke server via AJAX
            $.ajax({
                url: `/produk/update-stok/${id}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    aksi: aksi,
                    jumlah: jumlah
                },
                success: function(response) {
                    Swal.fire('Berhasil', response.message, 'success');
                    $('#modalStokProduk').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    Swal.fire('Gagal', 'Terjadi kesalahan saat memperbarui stok.', 'error');
                }
            });
        });
    </script> --}}
@endsection
