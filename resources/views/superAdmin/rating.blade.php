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
                    <h1 class="mb-0">Rating Produk</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start gap-2">

                    <!-- Select Filter Pewarnaan Stok -->
                    <select id="filterStok" class="form-select form-select-sm me-2" style="width: auto;">
                        <option value="">Semua Rating</option>
                        <option value="1">1 Bintang</option>
                        <option value="2">2 Bintang</option>
                        <option value="3">3 Bintang</option>
                        <option value="4">4 Bintang</option>
                        <option value="5">5 Bintang</option>
                    </select>


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
                                <th>#</th>
                                <th>Nama Pelanggan</th>
                                <th>Rating</th>
                                <th>Tanggal Rating</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ulasan as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $u->pelanggan->nama_pelanggan ?? '-' }}</td>
                                    <td>
                                        <span class="d-none rating-value">{{ $u->rating }}</span>

                                        @for ($s = 0; $s < $u->rating; $s++)
                                            <i class="fa fa-star text-warning"></i>
                                        @endfor
                                        @for ($s = $u->rating; $s < 5; $s++)
                                            <i class="fa fa-star-o text-warning"></i>
                                        @endfor
                                    </td>

                                    <td>{{ $u->tgl_ulasan }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailModal-{{ $u->id_ulasan }}">
                                            <i class="ti ti-eye me-1"></i> Detail
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama Pelanggan</th>
                                <th>Rating</th>
                                <th>Tanggal Rating</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        </tbody>
                    </table>

                    <div class="modal fade" id="detailModal-{{ $u->id_ulasan }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                    
                                <div class="modal-header bg-info">
                                    <h5 class="modal-title text-white fs-4">
                                        Detail Ulasan
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                    
                                <div class="modal-body fs-5">
                    
                                    <!-- NAMA PELANGGAN -->
                                    <div class="mb-3">
                                        <strong>Nama Pelanggan:</strong>
                                        <p class="mb-1">{{ $u->pelanggan->nama_pelanggan ?? '-' }}</p>
                                    </div>
                    
                                    <!-- RATING -->
                                    <div class="mb-3">
                                        <strong>Rating:</strong><br>
                                        @for ($s = 0; $s < $u->rating; $s++)
                                            <i class="fa fa-star text-warning"></i>
                                        @endfor
                                        @for ($s = $u->rating; $s < 5; $s++)
                                            <i class="fa fa-star-o text-warning"></i>
                                        @endfor
                                    </div>
                    
                                    <!-- ULASAN -->
                                    <div class="mb-3">
                                        <strong>Ulasan:</strong>
                                        <p class="text-muted">{{ $u->ulasan }}</p>
                                    </div>
                    
                                </div>
                    
                                <div class="modal-footer">
                                    <button class="btn btn-secondary fs-5" data-bs-dismiss="modal">Tutup</button>
                                </div>
                    
                            </div>
                        </div>
                    </div>
                    


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

            var table = $('#dom-jqry').DataTable();

            // Tambahkan row kosong untuk pesan "Tidak ada data"
            var emptyRow = `
            <tr class="empty-message">
                <td colspan="6" class="text-center py-4 text-muted fw-semibold">
                    Tidak ada data ditemukan
                </td>
            </tr>
        `;

            $('#filterStok').on('change', function() {
                var value = $(this).val();

                var anyVisible = false;

                table.rows().every(function() {
                    var rating = $(this.node()).find('.rating-value').text().trim();

                    if (value === "" || rating === value) {
                        $(this.node()).show();
                        anyVisible = true;
                    } else {
                        $(this.node()).hide();
                    }
                });

                // Hilangkan pesan lama
                $('#dom-jqry tbody .empty-message').remove();

                // Jika tidak ada baris tampil → tampilkan pesan
                if (!anyVisible) {
                    $('#dom-jqry tbody').append(emptyRow);
                }
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
