@extends('layouts/dashboard')

@section('link')
    <link rel="stylesheet" href="{{ asset('../assets') }}/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <!-- Card Filter -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">

                <!-- Select Bulan -->
                <div class="col-md-4">
                    <label class="form-label text-muted">Bulan</label>
                    <select class="form-select shadow-sm">
                        <option>Pilih Bulan</option>
                        <option>Januari</option>
                        <option>Februari</option>
                        <option>Maret</option>
                        <option>April</option>
                        <option>Mei</option>
                        <option>Juni</option>
                        <option>Juli</option>
                        <option>Agustus</option>
                        <option>September</option>
                        <option>Oktober</option>
                        <option>November</option>
                        <option>Desember</option>
                    </select>
                </div>

                <!-- Select Tahun -->
                <div class="col-md-4">
                    <label class="form-label text-muted">Tahun</label>
                    <select class="form-select shadow-sm">
                        <option>Pilih Tahun</option>
                        <option>2024</option>
                        <option>2025</option>
                        <option>2026</option>
                    </select>
                </div>

                <!-- Tombol Print -->
                <div class="col-md-4">
                    <label class="form-label text-muted">Aksi</label>
                    <button class="btn btn-primary w-100 shadow-sm">
                        <i class="fas fa-print me-2"></i> Print
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Card Pemasukan & Pengeluaran -->
    <div class="row g-4">

        <!-- Pengeluaran -->
        <div class="col-md-6">
            <div class="card shadow-sm border rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Pengeluaran</h6>
                            <h3 class="fw-bold text-danger mb-0">Rp 2.500.000</h3>
                        </div>
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                            <i class="fas fa-arrow-circle-down text-danger fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pemasukan -->
        <div class="col-md-6">
            <div class="card shadow-sm border rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Pemasukan</h6>
                            <h3 class="fw-bold text-success mb-0">Rp 4.800.000</h3>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-arrow-circle-up text-success fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabel --}}
    {{-- Tabel --}}
<div class="col-sm-12">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <div class="dt-responsive">

                <table id="dom-jqry" class="table table-striped table-bordered nowrap align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tanggal Transaksi</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Row 1 -->
                        <tr>
                            <td>1</td>
                            <td>2025-01-10</td>
                            <td><span class="badge bg-success">Pemasukan</span></td>
                            <td>Pembayaran pesanan #INV001</td>
                            <td class="fw-bold text-success">Rp 1.200.000</td>
                            <td>
                                <button class="btn btn-info btn-sm">
                                    <i class="ti ti-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr>
                            <td>2</td>
                            <td>2025-01-12</td>
                            <td><span class="badge bg-danger">Pengeluaran</span></td>
                            <td>Belanja stok bahan baku</td>
                            <td class="fw-bold text-danger">Rp 750.000</td>
                            <td>
                                <button class="btn btn-info btn-sm">
                                    <i class="ti ti-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr>
                            <td>3</td>
                            <td>2025-01-15</td>
                            <td><span class="badge bg-success">Pemasukan</span></td>
                            <td>Pembayaran pesanan #INV002</td>
                            <td class="fw-bold text-success">Rp 3.600.000</td>
                            <td>
                                <button class="btn btn-info btn-sm">
                                    <i class="ti ti-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr>
                            <td>4</td>
                            <td>2025-01-17</td>
                            <td><span class="badge bg-danger">Pengeluaran</span></td>
                            <td>Gaji pegawai mingguan</td>
                            <td class="fw-bold text-danger">Rp 1.200.000</td>
                            <td>
                                <button class="btn btn-info btn-sm">
                                    <i class="ti ti-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>

                    </tbody>

                    <tfoot class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tanggal Transaksi</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>

                </table>

            </div>
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
