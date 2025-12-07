@extends('layouts/dashboard')

@section('link')
    <link rel="stylesheet" href="{{ asset('../assets') }}/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center mb-3">
                <div class="col-12 col-md-6 mb-2 mb-md-0">
                    <h1 class="mb-0">Pelanggan</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start gap-2">
            
                    <!-- Form Filter & Print -->
                    <form action="{{ route('pelanggan.print') }}" method="GET" target="_blank" class="d-flex gap-2">
            
                        <!-- Select Filter Status -->
                        <select name="status" class="form-select form-select-sm" style="width: auto;">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
            
                        <!-- Tombol Print -->
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-print me-1"></i> Print
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
                                <th>#</th>
                                <th>Nama Pelanggan</th>
                                <th>Nomor Handphone</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggan as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->nama_pelanggan }}</td>
                                    <td>{{ $p->no_hp }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tgl_buat)->format('d/m/y  H:i') }}</td>
                                    <td class="status-col">
                                        @if ($p->status == 'aktif')
                                            <span class="badge bg-success status-badge">Aktif</span>
                                        @else
                                            <span class="badge bg-danger status-badge">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailPelanggan-{{ $p->id_pelanggan }}">
                                            <i class="ti ti-pencil me-1"></i> Edit
                                        </button>

                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#hapusPelanggan-{{ $p->id_pelanggan }}">
                                            <i class="ti ti-trash me-1"></i> Hapus
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @foreach ($pelanggan as $p)
                        <div class="modal fade" id="detailPelanggan-{{ $p->id_pelanggan }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header bg-info">
                                        <h5 class="modal-title text-white">
                                            Kelola Pelanggan: {{ $p->nama_pelanggan }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <h5 class="mb-3 fw-bold">Biodata Pelanggan</h5>

                                        <div class="card border-0 shadow-sm mb-4">
                                            <div class="card-body">

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <small class="text-muted">Nama Pelanggan</small>
                                                        <div class="fw-semibold fs-6 mt-1">
                                                            <i class="ti ti-user text-primary me-1"></i>
                                                            {{ $p->nama_pelanggan }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <small class="text-muted">Username</small>
                                                        <div class="fw-semibold fs-6 mt-1">
                                                            <i class="ti ti-id text-primary me-1"></i> {{ $p->username }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <small class="text-muted">Email</small>
                                                        <div class="fw-semibold fs-6 mt-1">
                                                            <i class="ti ti-mail text-primary me-1"></i>
                                                            {{ $p->email }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <small class="text-muted">Nomor HP</small>
                                                        <div class="fw-semibold fs-6 mt-1">
                                                            <i class="ti ti-phone text-primary me-1"></i>
                                                            {{ $p->no_hp }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <small class="text-muted">Jenis Kelamin</small>
                                                        <div class="fw-semibold fs-6 mt-1 text-capitalize">
                                                            <i class="ti ti-user-check text-primary me-1"></i>
                                                            {{ $p->jk }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <small class="text-muted">Status Akun</small>
                                                        <div class="mt-1">
                                                            @if ($p->status == 'aktif')
                                                                <span class="badge bg-success px-3 py-2">
                                                                    <i class="ti ti-check me-1"></i> Aktif
                                                                </span>
                                                            @else
                                                                <span class="badge bg-danger px-3 py-2">
                                                                    <i class="ti ti-x me-1"></i> Nonaktif
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div>
                                                    <small class="text-muted">Tanggal Terdaftar</small>
                                                    <div class="fw-semibold fs-6 mt-1">
                                                        <i class="ti ti-calendar text-primary me-1"></i>
                                                        {{ \Carbon\Carbon::parse($p->tgl_buat)->format('d F Y • H:i') }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <hr class="mb-4">

                                        <h5 class="mb-3 fw-bold">Ubah Password</h5>

                                        <form action="/pelanggan/{{ $p->id_pelanggan }}/update-password-pelanggan"
                                            method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Password Baru</label>
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="Masukkan password baru">
                                            </div>

                                            <button class="btn btn-warning btn-sm mb-4" type="submit">Ubah
                                                Password</button>
                                        </form>

                                        <hr>

                                        <h5 class="mb-3 fw-bold">Ubah Status Pelanggan</h5>

                                        <form action="{{ route('pelanggan.updateStatus', $p->id_pelanggan) }}"
                                            method="POST">
                                            @csrf

                                            <label class="form-label fw-bold d-block">Status Akun</label>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="statusAktif-{{ $p->id_pelanggan }}" value="aktif"
                                                    {{ $p->status == 'aktif' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="statusAktif-{{ $p->id_pelanggan }}">Aktif</label>
                                            </div>

                                            <div class="form-check form-check-inline mb-3">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="statusNonaktif-{{ $p->id_pelanggan }}" value="nonaktif"
                                                    {{ $p->status == 'nonaktif' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="statusNonaktif-{{ $p->id_pelanggan }}">Nonaktif</label>
                                            </div>

                                            <br>

                                            <button class="btn btn-primary btn-sm">Simpan Status</button>
                                        </form>

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Modal HAPUS -->
                        <div class="modal fade" id="hapusPelanggan-{{ $p->id_pelanggan }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title text-white">
                                            Hapus Pelanggan
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p class="fw-semibold mb-2">Apakah Anda yakin ingin menghapus pelanggan berikut?
                                        </p>

                                        <div class="p-3 border rounded bg-light">
                                            <p class=""><strong>Nama:</strong> {{ $p->nama_pelanggan }}</p>
                                            <p class=""><strong>Status:</strong>
                                                @if ($p->status == 'aktif')
                                                    <span class="badge bg-success status-badge">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger status-badge">Nonaktif</span>
                                                @endif
                                            </p>

                                        </div>

                                        <p class="text-danger mt-3 mb-0">
                                            Tindakan ini tidak dapat dibatalkan.
                                        </p>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                                        <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
    <!-- DOM/Jquery table end -->

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

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif
    </script>
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
        $(document).ready(function() {

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var filterValue = $('#filterStok').val();
                if (filterValue === "") return true;

                var statusText = $(settings.aoData[dataIndex].anCells[4]).find('.status-badge').text()
                    .trim().toLowerCase();

                return statusText === filterValue;
            });

            var table = $('#dom-jqry').DataTable();

            $('#filterStok').on('change', function() {
                table.draw();
            });

        });
    </script>




    <script>
        $(document).ready(function() {

            // SHOW DETAIL MODAL
            $(document).on('click', '.btn-detail', function() {
                var target = $(this).data('target');
                var modal = new bootstrap.Modal(document.getElementById(target));
                modal.show();
            });

            // OPTIONAL: CLOSE MODAL MANUAL (jika dibutuhkan)
            $(document).on('click', '.close-detail-modal', function() {
                var target = $(this).data('target');
                var modal = bootstrap.Modal.getInstance(document.getElementById(target));
                modal.hide();
            });

        });
    </script>
@endsection
@endsection
