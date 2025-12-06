@extends('layouts/dashboard')

@section('link')
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <link rel="stylesheet" href="{{ asset('../assets') }}/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header mb-1" style="margin-bottom: -4vh">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 d-flex align-items-center mb-2 mb-md-0">
                    <h1 class="mb-0">Manajemen Kategori</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start">
                    <!-- Tombol trigger modal -->
                    <button type="button" class="btn btn-shadow btn-success d-inline-flex align-items-center"
                        data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                        <i class="ti ti-plus me-2"></i>
                        Tambah Kategori
                    </button>
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
                                <th>KD Kategori</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>KD Kategori</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- DOM/Jquery table end -->

    <!-- ========== MODAL TAMBAH KATEGORI ========== -->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKategoriLabel">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="formTambahKategori">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode Kategori</label>
                            <input type="text" class="form-control" id="kode_kategori" name="kode_kategori"
                                placeholder="Contoh: KAT001" required>
                            <small id="kode_error" class="text-danger d-none">Kode sudah digunakan!</small>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
                                placeholder="Contoh: Plastik" required>
                            <small id="nama_error" class="text-danger d-none">Nama sudah digunakan!</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ========== END MODAL ========== -->

    <!-- ========== MODAL EDIT KATEGORI ========== -->
    <div class="modal fade" id="modalEditKategori" tabindex="-1" aria-labelledby="modalEditKategoriLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditKategoriLabel">Edit Kategori</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="formEditKategori">
                    @csrf
                    <input type="hidden" id="edit_id_kategori" name="id_kategori">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_kode_kategori" class="form-label">Kode Kategori</label>
                            <input type="text" class="form-control" id="edit_kode_kategori" name="kode" required>
                            <small id="edit_kode_error" class="text-danger d-none">Kode sudah digunakan!</small>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_nama_kategori" name="nama" required>
                            <small id="edit_nama_error" class="text-danger d-none">Nama sudah digunakan!</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ========== END MODAL EDIT ========== -->
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/jquery.dataTables.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/sweetalert2.all.min.js"></script>
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
    </script>
    <script>
        $(document).ready(function() {
            $('#dom-jqry').DataTable({
                ajax: '/dashboard-admin/listKategori', // endpoint dari controller
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'kode'
                    },
                    {
                        data: 'nama',
                        render: function(data) {
                            if (!data) return '';
                            // ubah tiap kata jadi Kapital di awal
                            return data
                                .toLowerCase()
                                .replace(/\b\w/g, function(l) {
                                    return l.toUpperCase();
                                });
                        }
                    },
                    {
                        data: 'id_kategori',
                        render: function(id) {
                            return `
                        <button class="btn btn-sm btn-warning me-1 editBtn" data-id="${id}">
                            <i class="ti ti-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${id}">
                            <i class="ti ti-trash"></i> Hapus
                        </button>
                    `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                responsive: true,
                autoWidth: false,
                pageLength: 10
            });

            // Hapus kategori
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin hapus?',
                    text: 'Data ini tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/destroyKategori/${id}`,
                            type: 'DELETE',
                            success: function(res) {
                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                });
                                // reload datatable
                                $('#dom-jqry').DataTable().ajax.reload(null, false);
                            },
                            error: function() {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Gagal menghapus data!'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Setup CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Saat form disubmit
            $('#formTambahKategori').on('submit', function(e) {
                e.preventDefault(); // biar gak reload halaman

                if (!$('#kode_error').hasClass('d-none') || !$('#nama_error').hasClass('d-none')) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Kategori atau Nama Sudah Terdaftar.'
                    });
                    return;
                }

                let formData = {
                    kode: $('#kode_kategori').val(),
                    nama: $('#nama_kategori').val(),
                };

                $.ajax({
                    type: "POST",
                    url: "/createKategori",
                    data: formData,
                    success: function(res) {
                        if (res.success) {
                            // Tutup modal
                            $('#modalTambahKategori').modal('hide');
                            // Reset form
                            $('#formTambahKategori')[0].reset();
                            // Tampilkan notifikasi
                            Toast.fire({
                                icon: 'success',
                                title: res.message
                            });
                            $('#dom-jqry').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function(xhr) {
                        let res = xhr.responseJSON;
                        Toast.fire({
                            icon: 'error',
                            title: res?.message || 'Terjadi kesalahan server!'
                        });
                    }
                });
            });

            // ===================== EDIT DATA ===================== //
            $(document).on('click', '.editBtn', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: `/getKategori/${id}`,
                    type: 'GET',
                    success: function(res) {
                        // Isi modal edit
                        $('#edit_id_kategori').val(res.data.id_kategori);
                        $('#edit_kode_kategori').val(res.data.kode);
                        $('#edit_nama_kategori').val(res.data.nama);

                        // Tampilkan modal
                        $('#modalEditKategori').modal('show');
                    },
                    error: function() {
                        Toast.fire({
                            icon: 'error',
                            title: 'Gagal mengambil data kategori!'
                        });
                    }
                });
            });

            // Saat form edit disubmit
            $('#formEditKategori').on('submit', function(e) {
                e.preventDefault();

                if (!$('#edit_kode_error').hasClass('d-none') || !$('#edit_nama_error').hasClass(
                    'd-none')) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Kode atau Nama sudah digunakan!'
                    });
                    return;
                }

                let id = $('#edit_id_kategori').val();
                let data = {
                    kode: $('#edit_kode_kategori').val(),
                    nama: $('#edit_nama_kategori').val(),
                };

                $.ajax({
                    url: `/updateKategori/${id}`,
                    type: 'PUT',
                    data: data,
                    success: function(res) {
                        $('#modalEditKategori').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        });
                        $('#dom-jqry').DataTable().ajax.reload(null, false);
                    },
                    error: function() {
                        Toast.fire({
                            icon: 'error',
                            title: 'Gagal mengupdate kategori!'
                        });
                    }
                });
            });


            // === CEK KODE UNIK ===
            $('#kode_kategori').on('input', function() {
                let kode = $(this).val().trim();
                if (kode === '') {
                    $('#kode_error').addClass('d-none');
                    return;
                }

                $.ajax({
                    url: '/checkKategori',
                    type: 'POST',
                    data: {
                        field: 'kode',
                        value: kode,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.exists) {
                            $('#kode_error').removeClass('d-none');
                        } else {
                            $('#kode_error').addClass('d-none');
                        }
                    }
                });
            });

            // === CEK NAMA UNIK ===
            $('#nama_kategori').on('input', function() {
                let nama = $(this).val().trim();
                if (nama === '') {
                    $('#nama_error').addClass('d-none');
                    return;
                }

                $.ajax({
                    url: '/checkKategori',
                    type: 'POST',
                    data: {
                        field: 'nama',
                        value: nama,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.exists) {
                            $('#nama_error').removeClass('d-none');
                        } else {
                            $('#nama_error').addClass('d-none');
                        }
                    }
                });
            });

            // === CEK KODE UNIK SAAT EDIT ===
            $('#edit_kode_kategori').on('input', function() {
                let kode = $(this).val().trim();
                let id = $('#edit_id_kategori').val();
                if (kode === '') {
                    $('#edit_kode_error').addClass('d-none');
                    return;
                }

                $.ajax({
                    url: '/checkKategori',
                    type: 'POST',
                    data: {
                        field: 'kode',
                        value: kode,
                        id: id, // kirim id kategori yg sedang di-edit
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.exists) {
                            $('#edit_kode_error').removeClass('d-none');
                        } else {
                            $('#edit_kode_error').addClass('d-none');
                        }
                    }
                });
            });

            // === CEK NAMA UNIK SAAT EDIT ===
            $('#edit_nama_kategori').on('input', function() {
                let nama = $(this).val().trim();
                let id = $('#edit_id_kategori').val();
                if (nama === '') {
                    $('#edit_nama_error').addClass('d-none');
                    return;
                }

                $.ajax({
                    url: '/checkKategori',
                    type: 'POST',
                    data: {
                        field: 'nama',
                        value: nama,
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.exists) {
                            $('#edit_nama_error').removeClass('d-none');
                        } else {
                            $('#edit_nama_error').addClass('d-none');
                        }
                    }
                });
            });


        });
    </script>
@endsection
