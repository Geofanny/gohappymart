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
                    <h1 class="mb-0">Pengembalian Pesanan</h1>
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
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Pengajuan</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengembalians as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->no_pengembalian }}</td>
                                    <td>{{ $p->pesanan->pelanggan->nama_pelanggan ?? '-' }}</td>
                                    <td>{{ $p->tgl_pengajuan }}</td>
                                    <td>{{ $p->tgl_selesai ? $p->tgl_selesai : '-' }}</td>
                                    <td>
                                        @if ($p->status === 'Menunggu Konfirmasi')
                                            <span class="badge bg-warning text-dark">{{ $p->status }}</span>
                                        @elseif ($p->status === 'Diterima')
                                            <span class="badge bg-success">{{ $p->status }}</span>
                                        @elseif ($p->status === 'Ditolak')
                                            <span class="badge bg-danger">{{ $p->status }}</span>
                                        @elseif ($p->status === 'Dalam Pengiriman')
                                            <span class="badge bg-primary">{{ $p->status }}</span>
                                        @elseif ($p->status === 'Selesai')
                                            <span class="badge bg-secondary">{{ $p->status }}</span>
                                        @else
                                            <span class="badge bg-info">{{ $p->status }}</span>
                                        @endif
                                    </td>                                    
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailModal-{{ $p->id_pengembalian }}">
                                            <i class="ti ti-eye me-1"></i> Detail
                                        </button>
                                        
                                        @if ($p->status === 'Diterima' && is_null($p->tgl_selesai))
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#suksesModal-{{ $p->id_pengembalian }}">
                                                <i class="ti ti-check me-1"></i> Selesai
                                            </button>
                                        @endif

                                        @if ($p->status === 'Dikirim' && is_null($p->tgl_selesai))
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#suksesModal-{{ $p->id_pengembalian }}">
                                                <i class="ti ti-check me-1"></i> Selesai
                                            </button>
                                        @endif

                                        @if ($p->status === 'Menunggu Konfirmasi')
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#konfirmasiModal-{{ $p->id_pengembalian }}">
                                                <i class="ti ti-clipboard-check me-1"></i> Konfirmasi
                                            </button>
                                        @endif
                                        
                                        @if ($p->status === 'Dalam Pengiriman')
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#updateResiModal-{{ $p->id_pengembalian }}">
                                                <i class="ti ti-notes me-1"></i> Resi
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>No. Pengembalian</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>


                    @foreach ($pengembalians as $p)
                        @php
                            // Pisahkan data alamat dari field pengiriman
                            $alamatArray = explode('|', $p->pesanan->pengiriman->alamat ?? '');

                            $namaPenerima = $alamatArray[0] ?? '';
                            $hpPenerima = $alamatArray[1] ?? '';
                            $alamatLengkap = $alamatArray[2] ?? '';
                            $alamatTambahan = $alamatArray[3] ?? '';
                            $labelAlamat = $alamatArray[4] ?? '';

                            // Format alamat final
                            $alamatFinal = $alamatLengkap;
                            if ($alamatTambahan) {
                                $alamatFinal .= ' ' . $alamatTambahan;
                            }
                            if ($labelAlamat) {
                                $alamatFinal .= ' (' . $labelAlamat . ')';
                            }
                        @endphp

                        <div class="modal fade" id="detailModal-{{ $p->id_pengembalian }}" tabindex="-1">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header bg-info">
                                        <h5 class="modal-title text-white">
                                            Pengembalian: {{ $p->no_pengembalian }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        {{-- INFORMASI PELANGGAN --}}
                                        <div class="mb-4">
                                            <h6 class="fw-bold mb-2">Informasi Pelanggan</h6>
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Nama Pelanggan:</small>
                                                        <div>{{ $p->pesanan->pelanggan->nama_pelanggan ?? '-' }}
                                                            ({{ $p->pesanan->pelanggan->no_hp ?? '-' }})
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Tanggal Pengajuan:</small>
                                                        <div>{{ date('d-m-Y', strtotime($p->tgl_pengajuan)) }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Resi Pengembalian:</small>
                                                        <div>{{ $p->no_resi_pengembalian ?? '-' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Status Pengembalian:</small>
                                                        <div class="fw-bold text-warning">{{ $p->status }}</div>
                                                    </div>
                                                </div>
                                                {{-- Alamat Lengkap --}}
                                                <div class="col-12">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Alamat Lengkap:</small>
                                                        <div>{{ $alamatFinal ?: '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- INFORMASI PENGEMBALIAN --}}
                                        <div class="mb-4">
                                            <h6 class="fw-bold mb-2">Informasi Pengembalian</h6>
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Alasan:</small>
                                                        <div>{{ $p->alasan ?? '-' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Solusi:</small>
                                                        <div>{{ $p->solusi ?? '-' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Resi Pengiriman Ulang:</small>
                                                        <div>{{ $p->no_resi_balasan ?? '-' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Tanggal Selesai:</small>
                                                        <div class="fw-semibold">
                                                            {{ $p->tgl_selesai ? date('d-m-Y', strtotime($p->tgl_selesai)) : '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="border rounded p-2">
                                                        <small class="text-muted">Detail Alasan:</small>
                                                        <div>{{ $p->deskripsi ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- DAFTAR PRODUK --}}
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
                                                    @php $total = 0; @endphp
                                                    @foreach ($p->pesanan->produk as $produk)
                                                        @php
                                                            $subtotal = $produk->jumlah * $produk->produk->harga;
                                                            $total += $subtotal;
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset('storage/uploads/produk/' . $produk->produk->gambar) }}"
                                                                        class="rounded me-2" width="50" height="50"
                                                                        style="object-fit: cover">
                                                                    <div class="fw-semibold">
                                                                        {{ $produk->produk->nama_produk }}</div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">{{ $produk->jumlah }}</td>
                                                            <td class="text-end">Rp
                                                                {{ number_format($produk->produk->harga, 0, ',', '.') }}
                                                            </td>
                                                            <td class="text-end">Rp
                                                                {{ number_format($subtotal, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- TOTAL --}}
                                        <div class="mt-3 text-end">
                                            <h5>Total: <span class="fw-bold text-danger">Rp
                                                    {{ number_format($total, 0, ',', '.') }}</span></h5>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($pengembalians as $p)
                        @php
                            $totalRefund = 0;
                            foreach ($p->pesanan->produk as $produk) {
                                $subtotal = $produk->jumlah * $produk->produk->harga;
                                $totalRefund += $subtotal;
                            }
                        @endphp

                        <!-- Modal Konfirmasi Pengembalian -->
                        <div class="modal fade" id="konfirmasiModal-{{ $p->id_pengembalian }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title text-dark">Konfirmasi Pengembalian:
                                            {{ $p->no_pengembalian }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p>Anda akan mengambil keputusan terhadap pengembalian ini. Pastikan data sudah
                                            benar:</p>

                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-2">
                                                <strong>Nama Pelanggan:</strong>
                                                <div>{{ $p->pesanan->pelanggan->nama_pelanggan ?? '-' }}
                                                    ({{ $p->pesanan->pelanggan->no_hp ?? '-' }})
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Tanggal Pengajuan:</strong>
                                                <div>{{ date('d-m-Y', strtotime($p->tgl_pengajuan)) }}</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Status Saat Ini:</strong>
                                                <div>{{ $p->status }}</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Alasan Pengembalian:</strong>
                                                <div>{{ $p->alasan ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Solusi Pengembalian:</strong>
                                                <div>{{ $p->solusi ?? '-' }}</div>
                                            </div>
                                            @if ($p->solusi === 'Pengembalian dana')
                                            <div class="col-md-6 mb-2">
                                                <strong>Pengembalian Dana:</strong>
                                                <div class="fw-bold text-danger">
                                                    Rp {{ number_format($totalRefund, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-md-6 mb-2">
                                                <strong>Alasan lainnya:</strong>
                                                <div>{{ $p->deskripsi ?? '-' }}</div>
                                            </div>
                                        </div>

                                        <p class="text-muted small">Pastikan semua informasi telah diperiksa sebelum
                                            memutuskan untuk menerima atau menolak pengembalian.</p>
                                    </div>

                                    <div class="modal-footer d-flex justify-content-between">
                                        <!-- Tolak Pengembalian -->
                                        <form action="{{ route('pengembalian.tolak', $p->id_pengembalian) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="ti ti-x me-1"></i> Tolak
                                            </button>
                                        </form>

                                        <!-- Terima Pengembalian -->
                                        <form action="{{ route('pengembalian.terima', $p->id_pengembalian) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="ti ti-check me-1"></i> Terima
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($pengembalians as $p)
                        <div class="modal fade" id="updateResiModal-{{ $p->id_pengembalian }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">

                                    {{-- Header --}}
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title text-white">
                                            Update Resi Pengiriman: {{ $p->no_pengembalian }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    {{-- Body --}}
                                    <form action="{{ route('pengembalian.updateResi', $p->id_pengembalian) }}"
                                        method="POST">
                                        @csrf
                                        <div class="modal-body">

                                            <p>Masukkan nomor resi pengiriman untuk pengembalian ini. Pastikan nomor resi
                                                sudah benar sebelum menyimpan.</p>

                                            {{-- Input Resi --}}
                                            <div class="mb-4">
                                                <label for="no_resi_{{ $p->id_pengembalian }}"
                                                    class="form-label fw-semibold">
                                                    Nomor Resi Pengiriman
                                                </label>
                                                <input type="text" class="form-control"
                                                    id="no_resi_{{ $p->id_pengembalian }}" name="no_resi_pengiriman"
                                                    value="{{ $p->no_resi_balasan ?? '' }}"
                                                    placeholder="Contoh: 19328BSHGSxx" required>
                                            </div>

                                            {{-- Informasi Pengembalian --}}
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <div class="border rounded p-2 bg-light">
                                                        <small class="text-muted">Nama Pelanggan</small>
                                                        <div class="fw-semibold">
                                                            {{ $p->pesanan->pelanggan->nama_pelanggan ?? '-' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="border rounded p-2 bg-light">
                                                        <small class="text-muted">Tanggal Pengajuan</small>
                                                        <div class="fw-semibold">
                                                            {{ date('d-m-Y', strtotime($p->tgl_pengajuan)) }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="border rounded p-2 bg-light">
                                                        <small class="text-muted">Status Saat Ini</small>
                                                        <div class="fw-semibold">{{ $p->status }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- Footer --}}
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="ti ti-check me-1"></i> Simpan Resi
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Penyelesaian Pengembalian -->
                        <div class="modal fade" id="suksesModal-{{ $p->id_pengembalian }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <!-- Header -->
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title text-white">Selesaikan Pengembalian</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Body -->
                                    <div class="modal-body">

                                        <p class="mb-3">
                                            Pastikan seluruh proses pengembalian telah diselesaikan sesuai prosedur.
                                        </p>

                                        <div class="alert alert-info py-2">
                                            <i class="fas fa-info-circle me-2"></i>
                                            tindakan ini akan menandai pengembalian sebagai <strong>selesai</strong> di sistem.
                                        </div>

                                    </div>

                                    <!-- Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>

                                        <form action="/pengembalian/selesaikan/{{ $p->id_pengembalian }}/admin" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                Konfirmasi Penyelesaian
                                            </button>
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
