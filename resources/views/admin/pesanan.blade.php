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
                    <h1 class="mb-0">Pesanan Pelanggan</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start gap-2">

                    <!-- Select Filter Pewarnaan Stok -->
                    <select id="filterStok" class="form-select form-select-sm me-2" style="width: auto;">
                        <option value="">Semua Status</option>
                        <option value="diproses">Pending</option>
                        <option value="dikemas">Dikemas</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
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
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Pesanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->no_pesanan }}</td>
                                    <td>{{ $item->pelanggan->nama_pelanggan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tgl_pesanan)->format('d M Y, H:i') }}</td>
                                    <td>
                                        @php
                                            // Mapping status tampilan
                                            $statusDisplay = [
                                                'diproses' => 'Pending',
                                                'dikemas' => 'Dikemas',
                                                'dikirim' => 'Dikirim',
                                                'dibatalkan' => 'Dibatalkan',
                                                'selesai' => 'Selesai',
                                            ];

                                            // Mapping warna badge
                                            $statusClass = [
                                                'diproses' => 'badge bg-primary', // Biru
                                                'dikemas' => 'badge bg-warning text-dark', // Kuning
                                                'dikirim' => 'badge bg-info text-dark', // Biru muda
                                                'dibatalkan' => 'badge bg-danger', // Merah
                                                'selesai' => 'badge bg-success', // Hijau
                                            ];

                                            $tampilanStatus =
                                                $statusDisplay[$item->status] ?? strtoupper($item->status);
                                            $kelasBadge = $statusClass[$item->status] ?? 'badge bg-secondary';
                                        @endphp

                                        <span class="{{ $kelasBadge }}" data-status="{{ $item->status }}">
                                            {{ $tampilanStatus }}
                                        </span>

                                    </td>

                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailModal-{{ $item->id_pesanan }}">
                                            <i class="ti ti-eye me-1"></i> Detail
                                        </button>

                                        @if ($item->status == 'diproses')
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#kemasModal-{{ $item->id_pesanan }}">
                                                <i class="ti ti-package me-1"></i> Kemas
                                            </button>

                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#tolakModal-{{ $item->id_pesanan }}">
                                                <i class="ti ti-x me-1"></i> Tolak
                                            </button>
                                        @endif

                                        @if ($item->status == 'dikemas')
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#uploadResiModal-{{ $item->id_pesanan }}">
                                                <i class="ti ti-truck-delivery me-1"></i> Kirim
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>No. Pesanan</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Pesanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>

                    @foreach ($pesanan as $item)
                        {{-- Modal Kemas --}}
                        <div class="modal fade" id="kemasModal-{{ $item->id_pesanan }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">

                                    <form action="{{ route('pesanan.updateStatus', $item->id_pesanan) }}" method="POST">
                                        @csrf

                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Konfirmasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body text-center">
                                            <p>
                                                Pesanan <strong>{{ $item->no_pesanan }}</strong> akan diproses ke tahap
                                                Pengemasan. Lanjutkan?
                                            </p>

                                            <input type="hidden" name="status" value="dikemas">
                                        </div>

                                        <div class="modal-footer  d-flex justify-content-between">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning">Ya, Kemas</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="uploadResiModal-{{ $item->id_pesanan }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <form action="{{ route('pesanan.uploadResi', $item->id_pesanan) }}" method="POST">
                                        @csrf

                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title text-white">Upload Resi</h5>
                                            <button type="button" class="btn-close white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div>
                                                <label for="resi" class="form-label fw-semibold">No Resi</label>
                                                <input type="text" id="resi" class="form-control" name="no_resi"
                                                    placeholder="Contoh: 21234xxxxx" required>

                                                <small class="text-muted d-block mt-2">
                                                    Nomor resi digunakan untuk pelacakan paket oleh pelanggan.
                                                </small>
                                            </div>

                                        </div>

                                        <div class="modal-footer  d-flex justify-content-between">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Tolak --}}
                        <div class="modal fade" id="tolakModal-{{ $item->id_pesanan }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">

                                    <form action="{{ route('pesanan.updateStatusTolak', $item->id_pesanan) }}"
                                        method="POST">
                                        @csrf

                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Tolak Pesanan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p>Masukkan alasan penolakan:</p>
                                            <textarea name="alasan" class="form-control" rows="3" required></textarea>

                                            <input type="hidden" name="status" value="dibatalkan">
                                        </div>

                                        <div class="modal-footer ">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="detailModal-{{ $item->id_pesanan }}" tabindex="-1">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                <div class="modal-content">
    
                                    <div class="modal-header bg-info">
                                        <h5 class="modal-title text-white">
                                            Pesanan ({{ $item->no_pesanan }})
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
    
                                    <div class="modal-body">
                                        <div class="mb-4">
                                            <h6 class="fw-bold mb-2">Informasi Pelanggan</h6>
    
                                            <div class="row g-3">
    
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Nama Pelanggan:</small>
                                                        <div>{{ $item->pelanggan->nama_pelanggan }}
                                                            ({{ $item->pelanggan->no_hp }})</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Tanggal Pesanan:</small>
                                                        <div>
                                                            {{ \Carbon\Carbon::parse($item->tgl_pesanan)->format('d M Y, H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Metode Pembayaran:</small>
                                                        <div>{{ $item->pembayaran->metode }}</div>
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3">
                                                    @php
                                                        // Mapping status tampilan
                                                        $statusDisplay = [
                                                            'diproses' => 'Menunggu Diproses',
                                                            'dikemas' => 'Sedang Dikemas',
                                                            'dikirim' => 'Sedang Dikirim',
                                                            'selesai' => 'Selesai',
                                                            'dibatalkan' => 'Dibatalkan',
                                                        ];
    
                                                        $tampilanStatus =
                                                            $statusDisplay[$item->status] ?? strtoupper($item->status);
                                                    @endphp
    
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Status Pesanan:</small>
                                                        <div
                                                            class="fw-bold @if ($item->status === 'dibatalkan') text-danger
                                                                @elseif ($item->status === 'dikemas') text-warning
                                                                @elseif ($item->status === 'dikirim') text-info
                                                                @elseif ($item->status === 'selesai') text-success
                                                                @else text-primary @endif">
                                                            {{ $tampilanStatus }}
                                                        </div>
                                                    </div>
    
                                                </div>
    
                                            </div>
                                        </div>
    
                                        {{-- ALERT PEMBATALAN --}}
                                        @if ($item->status === 'dibatalkan' && !empty($item->alasan))
                                        @php
                                            // Pisahkan alasan | admin
                                            $parts = explode('|', $item->alasan);
                                    
                                            $alasanText = trim($parts[0] ?? '');
                                            $adminText  = trim($parts[1] ?? '');
                                    
                                            // Jika admin kosong, jangan tampilkan tanda kurung
                                            $adminDisplay = $adminText !== '' ? " ($adminText)" : '';
                                        @endphp
                                    
                                        <div class="alert alert-danger border border-danger rounded p-3 mb-4">
                                            <h6 class="fw-bold mb-2">
                                                <i class="ti ti-alert-circle me-1"></i> Pesanan Dibatalkan
                                            </h6>
                                            <div>
                                                <strong>Alasan:</strong> {{ $alasanText }}{!! $adminDisplay !!}
                                            </div>
                                        </div>
                                    @endif
                                    
    
    
                                        @if ($item->pengiriman)
                                            @php
                                                $alamat = explode('|', $item->pengiriman->alamat);
    
                                                $namaPenerima = $alamat[0] ?? '';
                                                $hpPenerima = $alamat[1] ?? '';
                                                $alamatLengkap = $alamat[2] ?? '';
                                                $alamatTambahan = $alamat[3] ?? '';
                                                $labelAlamat = $alamat[4] ?? '';
    
                                                // Format alamat final
                                                $alamatFinal = $alamatLengkap;
    
                                                if ($alamatTambahan) {
                                                    $alamatFinal .= ' ' . $alamatTambahan;
                                                }
    
                                                if ($labelAlamat) {
                                                    $alamatFinal .= ' (' . $labelAlamat . ' )';
                                                }
                                            @endphp
    
                                            <div class="mb-4">
                                                <h6 class="fw-bold mb-2">Informasi Pengiriman</h6>
    
                                                <div class="row g-3">
    
                                                    <div class="col-md-3">
                                                        <div class="border rounded p-2">
                                                            <small class="text-muted">Jasa Kirim</small>
                                                            <div>
                                                                {{ $item->pengiriman->kurir }} (Rp
                                                                {{ number_format($item->pengiriman->ongkir, 0, ',', '.') }})
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="col-md-3">
                                                        <div class="border rounded p-2">
                                                            <small class="text-muted">Nama Penerima:</small>
                                                            <div>{{ $namaPenerima }}</div>
                                                        </div>
                                                    </div>
    
                                                    <div class="col-md-3">
                                                        <div class="border rounded p-2">
                                                            <small class="text-muted">No. HP Penerima:</small>
                                                            <div>{{ $hpPenerima }}</div>
                                                        </div>
                                                    </div>
    
                                                    <div class="col-md-3">
                                                        <div class="border rounded p-2">
                                                            <small class="text-muted">Nomor Resi</small>
                                                            <div class="fw-semibold">
                                                                {{ $item->pengiriman->no_resi ?? '-' }}
                                                            </div>                                                        
                                                        </div>
                                                    </div>
                                                    
    
                                                    <div class="col-12">
                                                        <div class="border rounded p-2">
                                                            <small class="text-muted">Alamat Lengkap:</small>
                                                            <div>{{ $alamatFinal }}</div>
                                                        </div>
                                                    </div>
    
                                                </div>
                                            </div>
                                        @endif
    
    
                                        {{-- PRODUK (tidak diubah) --}}
                                        <h6 class="fw-bold mt-4">Daftar Produk</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th class="text-center" style="width: 100px">Qty</th>
                                                        <th class="text-end">Harga</th>
                                                        <th class="text-end">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $subtotal = 0;
                                                    @endphp
                                                    @foreach ($item->produk as $p)
                                                        @php
                                                            $total_harga = $p->jumlah * $p->produk->harga;
                                                            $subtotal += $total_harga;
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset('storage/uploads/produk/' . $p->produk->gambar) }}"
                                                                        class="rounded me-2" width="50" height="50"
                                                                        style="object-fit: cover">
    
                                                                    <div class="fw-semibold">
                                                                        {{ $p->produk->nama_produk }}
                                                                    </div>
                                                                </div>
                                                            </td>
    
                                                            <td class="text-center">{{ $p->jumlah }}</td>
                                                            <td class="text-end">Rp
                                                                {{ number_format($p->produk->harga, 0, ',', '.') }}</td>
                                                            <td class="text-end">
                                                                Rp {{ number_format($total_harga, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
    
    
                                        {{-- TOTAL --}}
                                        <div class="mt-3 text-end">
                                            <h5>Total:
                                                <span class="fw-bold text-danger">
                                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                </span>
                                            </h5>
                                        </div>
    
    
                                        {{-- CATATAN --}}
                                        @if ($item->catatan)
                                            <div class="mt-4">
                                                <h6 class="fw-bold">Catatan Pelanggan:</h6>
                                                <div class="border rounded p-3">
                                                    {{ $item->catatan }}
                                                </div>
                                            </div>
                                        @endif
    
                                    </div>
    
    
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            var table = $('#dom-jqry').DataTable();

            $('#filterStok').on('change', function() {
                var value = $(this).val();

                if (value === "") {
                    table.column(4).search("").draw();
                } else {
                    table.column(4).search(value, true, false).draw();
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
