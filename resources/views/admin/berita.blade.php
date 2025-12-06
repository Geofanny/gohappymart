@extends('layouts/dashboard')

@section('link')
    <link rel="stylesheet" href="{{ asset('../assets') }}/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <style>
        .bg-purple {
            background-color: #6f42c1 !important;
        }

        .btn-purple {
            background-color: #6f42c1;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 mb-2 mb-md-0">
                    <h1 class="mb-0">Manajemen Berita</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start gap-2">
                    <!-- Tombol Tambah Produk -->
                    <a href="/dashboard-admin/berita/baru" class="btn btn-success d-inline-flex align-items-center">
                        <i class="ti ti-plus me-2"></i> Tambah Berita
                    </a>
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
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Penulis</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Terlihat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($berita as $index => $b)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $b->user->nama }}</td>
                                    <td>{{ $b->judul }}</td>
                                    <td>
                                        @if ($b->status == 'draft')
                                            <span class="badge bg-purple text-light">Draft</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Publish</span>
                                        @endif

                                    </td>
                                    <td>{{ $b->tgl->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($b->status == 'publish')
                                            {{ $b->pengunjung ?? 0 }} {{-- jika kolom pengunjung null, tampil 0 --}}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/dashboard-admin/berita/edit/{{ $b->id_berita }}" class="btn btn-sm btn-warning"><i class="ti ti-edit me-1"></i> Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                            data-id="{{ $b->id_berita }}">
                                            <i class="ti ti-trash me-1"></i> Hapus
                                        </button>
                                        @if ($b->status == 'draft')
                                            <button type="button" class="btn btn-sm btn-success btn-publish"
                                                data-id="{{ $b->id_berita }}">
                                                <i class="ti ti-check me-1"></i> Publish
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-purple btn-draft"
                                                data-id="{{ $b->id_berita }}">
                                                <i class="ti ti-arrow-back-up me-1"></i> Draft
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Penulis</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Terlihat</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- DOM/Jquery table end -->
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

            // Tombol info modal
            $('.btn-secondary[title="Informasi"]').on('click', function() {
                $('#modalInfoStok').modal('show');
            });

            $('.btn-hapus').click(function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data berita akan hilang permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form secara otomatis via POST/DELETE
                        $.ajax({
                            url: '/hapusBerita/' + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Terhapus!',
                                    response.message, // ambil message dari JSON
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Gagal!',
                                    xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat menghapus.',
                                    'error'
                                );
                            }
                        });

                    }
                });
            });

            $('.btn-publish').click(function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin publish berita?',
                    text: "Berita akan langsung terlihat oleh publik!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, publish!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/publishBerita/' + id,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Dipublish!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Gagal!',
                                    xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat publish.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $('.btn-draft').click(function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin ubah ke draft?',
                    text: "Status berita akan kembali draft!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#6f42c1',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, draftkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/draftBerita/' + id,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Berhasil!',
                                    response.message,
                                    'success'
                                ).then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
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
@endsection
