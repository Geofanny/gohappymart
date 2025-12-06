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
                        <option value="dikirim">Dalam Pengiriman</option>
                        <option value="dibatalkan">Dibatalkan</option>
                        <option value="selesai">Selesai</option>
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
                                <th>Resi</th>
                                <th>Tanggal Kirim</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengiriman as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->no_pesanan }}</td>
                                    <td>{{ $item->pengiriman->no_resi ?? '-' }}</td>
                                    <td>{{ $item->pengiriman->tgl_kirim ?? '-' }}</td>
                                    <td>{{ $item->pengiriman->tgl_selesai ?? '-' }}</td>
                                    <td>
                                        @php
                                            $status = $item->pengiriman->status ?? null;

                                            $label = match ($status) {
                                                'dikirim' => 'Dalam Pengiriman',
                                                'pending' => 'Pending',
                                                'selesai' => 'Selesai',
                                                'dibatalkan' => 'Dibatalkan',
                                                default => '-',
                                            };
                                        @endphp

                                        <span
                                            class="badge 
                                            @switch($status)
                                                @case('dibatalkan') bg-danger @break
                                                @case('pending') bg-primary @break
                                                @case('dikirim') bg-info @break
                                                @case('selesai') bg-success @break
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
                                <th>Resi</th>
                                <th>Tanggal Kirim</th>
                                <th>Tanggal Selesai</th>
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

                if (value === "dikirim") label = "Dalam Pengiriman";
                if (value === "dibatalkan") label = "Dibatalkan";
                if (value === "selesai") label = "Selesai";

                if (value === "") {
                    table.column(5).search("").draw(); // kolom Status
                } else {
                    table.column(5).search(label, true, false).draw();
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
