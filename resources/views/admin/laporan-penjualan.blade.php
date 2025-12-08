@extends('layouts/dashboard')

@section('link')
    <link rel="stylesheet" href="{{ asset('../assets') }}/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <!-- Card Filter -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('laporan-penjualan.pdf') }}" method="GET" target="_blank" class="row g-3 align-items-end">

                <!-- Select Bulan -->
                <div class="col-md-4">
                    <label class="form-label text-muted">Bulan</label>
                    <select name="bulan" class="form-select shadow-sm" required>
                        <option value="">Pilih Bulan</option>
                        @foreach (range(1, 12) as $b)
                            <option value="{{ $b }}"
                                {{ (request('bulan') ?? now()->month) == $b ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Tahun -->
                <div class="col-md-4">
                    <label class="form-label text-muted">Tahun</label>
                    <select name="tahun" class="form-select shadow-sm" required>
                        <option value="">Pilih Tahun</option>
                        @foreach (range(date('Y') - 1, date('Y') + 1) as $t)
                            <option value="{{ $t }}"
                                {{ (request('tahun') ?? now()->year) == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <!-- Tombol Print -->
                <div class="col-md-4">
                    <label class="form-label text-muted">Aksi</label>
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">
                        <i class="fas fa-print me-2"></i> Print
                    </button>
                </div>

            </form>
        </div>
    </div>


    <!-- Card Pemasukan & Pengeluaran -->
    <div class="row g-4">

        <!-- Total Pengeluaran -->
        <div class="col-md-4">
            <div class="card shadow-sm border rounded-3">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Pengeluaran</h6>
                        <h3 class="fw-bold text-danger mb-0">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                        <i class="fas fa-arrow-circle-down text-danger fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Total Pemasukan -->
        <div class="col-md-4">
            <div class="card shadow-sm border rounded-3">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Pemasukan</h6>
                        <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-arrow-circle-up text-success fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Total Transaksi -->
        <div class="col-md-4">
            <div class="card shadow-sm border rounded-3">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Transaksi</h6>
                        <h3 class="fw-bold text-primary mb-0">{{ $totalTransaksi ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-file-invoice-dollar text-primary fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    
    <!-- Tabel Laporan -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <div class="dt-responsive">
                        <table id="laporan-penjualan" class="table table-striped table-bordered nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>No Pesanan</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTransactions as $key => $trx)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $trx['time']->format('d-m-Y') }}</td>
                                        <td>{{ $trx['no'] }}</td>
                                        <td>
                                            @if ($trx['type'] === 'in')
                                                <span class="badge bg-success">Pemasukan</span>
                                            @else
                                                <span class="badge bg-danger">Pengeluaran</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold {{ $trx['type'] === 'in' ? 'text-success' : 'text-danger' }}">
                                            Rp {{ number_format($trx['amount'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>No Pesanan</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div>
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
