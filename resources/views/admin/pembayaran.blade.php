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
                    <h1 class="mb-0">Pengiriman Pesanan</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start gap-2">

                    <!-- Select Filter Pewarnaan Stok -->
                    <select id="filterStok" class="form-select form-select-sm me-2" style="width: auto;">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="dibatalkan">Dibatalkan</option>
                        <option value="Berhasil">Berhasil</option>
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
                    <table id="dom-jqry" class="table table-striped  table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Pesanan</th>
                                <th>ID Pembayaran</th>
                                <th>Metode</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayaran as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->no_pesanan }}</td>
                                    <td>{{ $item->pembayaran->no_pembayaran ?? '-' }}</td>
                                    <td>{{ $item->pembayaran->metode ?? '-' }}</td>
                                    <td>{{ $item->pembayaran->tgl_pembayaran ?? '-' }}</td>
                                    <td>
                                        @php
                                            $status = $item->pembayaran->status ?? null;

                                            $label = match ($status) {
                                                'pending' => 'Pending',
                                                'Berhasil' => 'Berhasil',
                                                'dibatalkan' => 'Dibatalkan',
                                                default => '-',
                                            };
                                        @endphp

                                        <span
                                            class="badge 
                                            @switch($status)
                                                @case('dibatalkan') bg-danger @break
                                                @case('pending') bg-warning text-dark @break
                                                @case('Berhasil') bg-success @break
                                                @default bg-secondary 
                                            @endswitch
                                        ">
                                            {{ $label }}
                                        </span>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>No. Pesanan</th>
                                <th>ID Pembayaran</th>
                                <th>Metode</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>

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

            $('#filterStok').on('change', function() {
                var value = $(this).val();

                let label = "";

                if (value === "pending") label = "Pending";
                if (value === "dibatalkan") label = "Dibatalkan";
                if (value === "Berhasil") label = "Berhasil";

                if (value === "") {
                    table.column(5).search("").draw(); // kolom Status
                } else {
                    table.column(5).search(label, true, false).draw();
                }
            });
        });
    </script>

@endsection
@endsection
