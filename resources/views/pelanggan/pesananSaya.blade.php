@extends('layouts/main-pelanggan-no-footer')

@section('content')
    <style>
        /* TAB SCROLLABLE */
        .custom-scroll-tabs {
            overflow-x: auto;
            white-space: nowrap;
            flex-wrap: nowrap !important;
            border-bottom: 1px solid #ddd;
        }

        /* STYLE TAB */
        .custom-scroll-tabs .nav-link {
            white-space: nowrap;
            padding: 12px 40px;
            /* lebar tab */
            font-weight: 500;
            color: #333 !important;
            background-color: #fff !important;
            /* selalu putih */
            border: none !important;
            border-radius: 0 !important;
        }

        /* ACTIVE STATE - putih + garis bawah biru */
        .custom-scroll-tabs .nav-link.active {
            background-color: #fff !important;
            /* tidak abu */
            color: #0d6efd !important;
            font-weight: 600;
            border-bottom: 3px solid #0d6efd !important;
        }

        /* Hilangkan Scrollbar (opsional) */
        .custom-scroll-tabs::-webkit-scrollbar {
            height: 0;
        }

        .akun-menu {
            text-align: left !important;
        }

        .akun-menu .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #333;
            border-radius: 10px;
            padding: 10px 12px;
            transition: 0.2s ease;
            font-weight: 500;
        }

        .akun-menu .nav-link:hover {
            background-color: #f0f4ff;
            color: #0d6efd;
        }

        .akun-menu .nav-link.active {
            background-color: #0d6efd;
            color: #fff !important;
        }

        .akun-menu .nav-link.text-danger:hover {
            background-color: #ffe6e6;
        }

        .btn-custom-action {
            color: #1ABC9C;
            border: 1px solid #1ABC9C;
        }

        .btn-custom-action:hover {
            background-color: #1ABC9C;
            color: white;
        }

        .modal-custom {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .modal-content-custom {
            background: #fff;
            padding: 20px;
            width: 90%;
            max-width: 380px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .custom-modal {
            display: none;
            position: fixed;
            inset: 0;
            /* top:0; bottom:0; left:0; right:0 */
            background: rgba(0, 0, 0, 0.45);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .custom-modal-content {
            background-color: #fff;
            border-radius: 8px;
            width: 350px;
            max-width: 90%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.2s ease-in-out;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #e5e5e5;
        }

        .modal-header h5 {
            margin: 0;
            text-align: left;
            /* header tetap rata kiri */
            font-size: 1.1rem;
        }

        .modal-body {
            padding: 15px 20px;
            font-size: 0.95rem;
            color: #333;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 15px 20px;
            border-top: 1px solid #e5e5e5;
        }

        .close-btn {
            font-size: 20px;
            cursor: pointer;
            color: #888;
            transition: color 0.2s;
        }

        .close-btn:hover {
            color: #333;
        }

        /* Animasi fade */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <div class="container py-5 mb-2">
        <div class="row">
            <!-- 🔹 Sidebar Kiri -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 text-center">

                        <!-- Foto / Icon User -->
                        <div class="mb-3">
                            <i class="fas fa-user-circle" style="font-size: 80px; color: #6c757d;"></i>
                        </div>

                        <!-- Nama User -->
                        <h5 class="fw-semibold mb-1">
                            {{ Auth::guard('pelanggan')->user()->nama_pelanggan }}
                        </h5>

                        <!-- Email User -->
                        <p class="text-muted mb-3" style="font-size: 14px;">
                            {{ Auth::guard('pelanggan')->user()->email }}
                        </p>

                        <hr>

                        <!-- Menu (100% kiri) -->
                        <ul class="nav flex-column akun-menu">

                            <li class="nav-item mb-2">
                                <a href="/profil" class="nav-link {{ Request::is('profil') ? 'active' : '' }}">
                                    <i class="fas fa-user me-2"></i>&nbsp; Profil
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/pesanan-saya" class="nav-link {{ Request::is('pesanan') ? 'active' : '' }}">
                                    <i class="fas fa-box me-2"></i>&nbsp;Pesanan
                                </a>
                            </li>
                        </ul>

                        <hr>
                        <ul class="nav flex-column akun-menu">
                            <li class="nav-item">
                                <a href="/logout" class="nav-link text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>


            <!-- 🔹 Konten Kanan -->
            <div class="col-md-9">

                <!-- 🔸 Tabs Scrollable -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">

                        <!-- Nav Tabs -->

                        <ul class="nav nav-tabs custom-scroll-tabs mb-3" id="pesananTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua"
                                    type="button" role="tab">Semua</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="proses-tab" data-bs-toggle="tab" data-bs-target="#diproses"
                                    type="button" role="tab">Sedang diproses</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="dikemas-tab" data-bs-toggle="tab" data-bs-target="#dikemas"
                                    type="button" role="tab">Dikemas</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="dikirim-tab" data-bs-toggle="tab" data-bs-target="#dikirim"
                                    type="button" role="tab">Dikirim</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="dibatalkan-tab" data-bs-toggle="tab"
                                    data-bs-target="#dibatalkan" type="button" role="tab">Dibatalkan</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai"
                                    type="button" role="tab">Selesai</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pengembalian-tab" data-bs-toggle="tab"
                                    data-bs-target="#pengembalian" type="button" role="tab">Pengembalian</button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="pesananTabContent">

                            <div class="tab-pane fade show active" id="semua" role="tabpanel">

                                @foreach ($pesanan as $p)
                                    <div class="card mb-4 shadow-sm" style="border:1px solid #e0e0e0; border-radius:5px;">
                                        <a href="/detail-pesanan/{{ $p->id_pesanan }}">
                                            <!-- HEADER -->
                                            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center"
                                                style="border-radius:12px 12px 0 0;">

                                                <span class="text-muted" style="font-size:14px; font-weight: 800;">
                                                    Tanggal: {{ \Carbon\Carbon::parse($p->tgl_pesanan)->format('d M Y') }}
                                                </span>

                                                <!-- Badge Status -->
                                                @php
                                                    $badgeStyle = match ($p->status) {
                                                        'diproses' => 'background-color:#e7f1ff; color:#0d6efd;',
                                                        'dikemas' => 'background-color:#fff3cd; color:#856404;',
                                                        'dikirim' => 'background-color:#d1e7dd; color:#0f5132;',
                                                        'selesai' => 'color:#0f5132;',
                                                        'dibatalkan' => 'background-color:#f8d7da; color:#842029;',
                                                        default => 'background-color:#eee; color:#333;',
                                                    };
                                                @endphp

                                                <span class="badge" style="font-size:14px; {{ $badgeStyle }}">
                                                    Pesanan {{ $p->status }}
                                                </span>

                                            </div>


                                            <!-- BODY -->
                                            <div class="card-body pb-2">

                                                @foreach ($p->produk as $item)
                                                    <div class="d-flex mb-3">

                                                        <!-- Gambar Produk -->
                                                        <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                                            class="rounded"
                                                            style="width:90px; height:90px; object-fit:cover;">
                                                        &nbsp;&nbsp;&nbsp;

                                                        <div class="flex-grow-1 ms-3">

                                                            <h6 class="fw-semibold mb-1">{{ $item->produk->nama_produk }}
                                                            </h6>

                                                            <div class="row mt-2">
                                                                <div class="col-6">
                                                                    <small class="text-muted"
                                                                        style="font-size: 2vh;">x{{ $item->jumlah }}</small>
                                                                </div>

                                                                <div class="col-6 d-flex justify-content-end">
                                                                    <small class="text-muted" style="font-size: 2.3vh;">Rp
                                                                        {{ number_format($item->produk->harga, 0, ',', '.') }}</small>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>


                                            <!-- FOOTER -->
                                            <div class="card-footer bg-white border-top pt-3"
                                                style="border-radius:0 0 12px 12px;">

                                                <div class="d-flex justify-content-end align-items-center"
                                                    style="gap: 2vh;">


                                                    <!-- Tampilkan tombol batal hanya jika dikemas/diproses -->
                                                    @if (in_array($p->status, ['diproses']))
                                                        <a href="#" id="btnBatalSemua"
                                                            class="btn btn-outline-danger btn-sm btn-batal-semua"
                                                            data-id="{{ $p->id_pesanan }}">
                                                            Batalkan Pesanan
                                                        </a>
                                                    @endif

                                                    @if (in_array($p->status, ['selesai']))
                                                        @if ($p->ulasan->count() == 0)
                                                            <a href="/penilaian/pesanan/{{ $p->id_pesanan }}"
                                                                class="btn btn-sm btn-custom-action">
                                                                Beri Penilaian
                                                            </a>
                                                        @endif
                                                        @if ($p->pengembalian->count() == 0)
                                                            <a href="/pesanan/ajuan/pengembalian/{{ $p->id_pesanan }}"
                                                                class="btn btn-sm btn-custom-action">
                                                                Ajukan Pengembalian
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if (in_array($p->status, ['dikirim']))
                                                        <a href="#"
                                                            class="btn btn-sm btn-custom-action btn-terima-semua"
                                                            id="btnTerimaSemua" data-id="{{ $p->id_pesanan }}">Terima
                                                            Pesanan</a>
                                                    @endif

                                                    <p class="mb-0" style="font-size: 3.5vh;">
                                                        <span class="text-muted">Total:</span>
                                                        <span class="text-danger" style="font-weight: 500;">
                                                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                                        </span>
                                                    </p>
                                                </div>

                                            </div>
                                        </a>

                                    </div>
                                @endforeach

                            </div>

                            <div class="tab-pane fade" id="diproses" role="tabpanel">
                                @foreach ($pesananDiproses as $p)
                                    <div class="card mb-4 shadow-sm" style="border:1px solid #e0e0e0; border-radius:5px;">
                                        <a href="/detail-pesanan/{{ $p->id_pesanan }}">
                                            <!-- HEADER -->
                                            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center"
                                                style="border-radius:12px 12px 0 0;">

                                                <span class="text-muted" style="font-size:14px; font-weight: 800;">
                                                    Tanggal: {{ \Carbon\Carbon::parse($p->tgl_pesanan)->format('d M Y') }}
                                                </span>

                                                <!-- Badge Status -->
                                                @php
                                                    $badgeStyle = match ($p->status) {
                                                        'diproses' => 'background-color:#e7f1ff; color:#0d6efd;',
                                                        'dikemas' => 'background-color:#fff3cd; color:#856404;',
                                                        'dikirim' => 'background-color:#d1e7dd; color:#0f5132;',
                                                        'selesai' => 'color:#0f5132;',
                                                        'dibatalkan' => 'background-color:#f8d7da; color:#842029;',
                                                        default => 'background-color:#eee; color:#333;',
                                                    };
                                                @endphp

                                                <span class="badge" style="font-size:14px; {{ $badgeStyle }}">
                                                    Pesanan {{ $p->status }}
                                                </span>

                                            </div>


                                            <!-- BODY -->
                                            <div class="card-body pb-2">

                                                @foreach ($p->produk as $item)
                                                    <div class="d-flex mb-3">

                                                        <!-- Gambar Produk -->
                                                        <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                                            class="rounded"
                                                            style="width:90px; height:90px; object-fit:cover;">
                                                        &nbsp;&nbsp;&nbsp;

                                                        <div class="flex-grow-1 ms-3">

                                                            <h6 class="fw-semibold mb-1">{{ $item->produk->nama_produk }}
                                                            </h6>

                                                            <div class="row mt-2">
                                                                <div class="col-6">
                                                                    <small class="text-muted"
                                                                        style="font-size: 2vh;">x{{ $item->jumlah }}</small>
                                                                </div>

                                                                <div class="col-6 d-flex justify-content-end">
                                                                    <small class="text-muted" style="font-size: 2.3vh;">Rp
                                                                        {{ number_format($item->produk->harga, 0, ',', '.') }}</small>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>


                                            <!-- FOOTER -->
                                            <div class="card-footer bg-white border-top pt-3"
                                                style="border-radius:0 0 12px 12px;">

                                                <div class="d-flex justify-content-end align-items-center"
                                                    style="gap: 2vh;">

                                                    <!-- Tampilkan tombol batal hanya jika dikemas/diproses -->
                                                    <a href="#" id="btnBatal"
                                                        class="btn btn-outline-danger btn-sm btn-batal"
                                                        data-id="{{ $p->id_pesanan }}">
                                                        Batalkan Pesanan
                                                    </a>

                                                    <p class="mb-0" style="font-size: 3.5vh;">
                                                        <span class="text-muted">Total:</span>
                                                        <span class="text-danger" style="font-weight: 500;">
                                                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                                        </span>
                                                    </p>
                                                </div>

                                            </div>
                                        </a>

                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane fade" id="dikemas" role="tabpanel">
                                @foreach ($pesananDikemas as $p)
                                    <div class="card mb-4 shadow-sm" style="border:1px solid #e0e0e0; border-radius:5px;">
                                        <a href="/detail-pesanan/{{ $p->id_pesanan }}">
                                            <!-- HEADER -->
                                            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center"
                                                style="border-radius:12px 12px 0 0;">

                                                <span class="text-muted" style="font-size:14px; font-weight: 800;">
                                                    Tanggal: {{ \Carbon\Carbon::parse($p->tgl_pesanan)->format('d M Y') }}
                                                </span>

                                                <!-- Badge Status -->
                                                @php
                                                    $badgeStyle = match ($p->status) {
                                                        'diproses' => 'background-color:#e7f1ff; color:#0d6efd;',
                                                        'dikemas' => 'background-color:#fff3cd; color:#856404;',
                                                        'dikirim' => 'background-color:#d1e7dd; color:#0f5132;',
                                                        'selesai' => 'color:#0f5132;',
                                                        'dibatalkan' => 'background-color:#f8d7da; color:#842029;',
                                                        default => 'background-color:#eee; color:#333;',
                                                    };
                                                @endphp

                                                <span class="badge" style="font-size:14px; {{ $badgeStyle }}">
                                                    Pesanan {{ $p->status }}
                                                </span>

                                            </div>


                                            <!-- BODY -->
                                            <div class="card-body pb-2">

                                                @foreach ($p->produk as $item)
                                                    <div class="d-flex mb-3">

                                                        <!-- Gambar Produk -->
                                                        <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                                            class="rounded"
                                                            style="width:90px; height:90px; object-fit:cover;">
                                                        &nbsp;&nbsp;&nbsp;

                                                        <div class="flex-grow-1 ms-3">

                                                            <h6 class="fw-semibold mb-1">{{ $item->produk->nama_produk }}
                                                            </h6>

                                                            <div class="row mt-2">
                                                                <div class="col-6">
                                                                    <small class="text-muted"
                                                                        style="font-size: 2vh;">x{{ $item->jumlah }}</small>
                                                                </div>

                                                                <div class="col-6 d-flex justify-content-end">
                                                                    <small class="text-muted" style="font-size: 2.3vh;">Rp
                                                                        {{ number_format($item->produk->harga, 0, ',', '.') }}</small>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>


                                            <!-- FOOTER -->
                                            <div class="card-footer bg-white border-top pt-3"
                                                style="border-radius:0 0 12px 12px;">

                                                <div class="d-flex justify-content-end align-items-center"
                                                    style="gap: 2vh;">

                                                    <p class="mb-0" style="font-size: 3.5vh;">
                                                        <span class="text-muted">Total:</span>
                                                        <span class="text-danger" style="font-weight: 500;">
                                                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                                        </span>
                                                    </p>
                                                </div>

                                            </div>
                                        </a>

                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane fade" id="dikirim" role="tabpanel">
                                @foreach ($pesananDikirim as $p)
                                    <div class="card mb-4 shadow-sm" style="border:1px solid #e0e0e0; border-radius:5px;">
                                        <a href="/detail-pesanan/{{ $p->id_pesanan }}">
                                            <!-- HEADER -->
                                            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center"
                                                style="border-radius:12px 12px 0 0;">

                                                <span class="text-muted" style="font-size:14px; font-weight: 800;">
                                                    Tanggal: {{ \Carbon\Carbon::parse($p->tgl_pesanan)->format('d M Y') }}
                                                </span>

                                                <!-- Badge Status -->
                                                @php
                                                    $badgeStyle = match ($p->status) {
                                                        'diproses' => 'background-color:#e7f1ff; color:#0d6efd;',
                                                        'dikemas' => 'background-color:#fff3cd; color:#856404;',
                                                        'dikirim' => 'background-color:#d1e7dd; color:#0f5132;',
                                                        'selesai' => 'color:#0f5132;',
                                                        'dibatalkan' => 'background-color:#f8d7da; color:#842029;',
                                                        default => 'background-color:#eee; color:#333;',
                                                    };
                                                @endphp

                                                <span class="badge" style="font-size:14px; {{ $badgeStyle }}">
                                                    Pesanan {{ $p->status }}
                                                </span>

                                            </div>


                                            <!-- BODY -->
                                            <div class="card-body pb-2">

                                                @foreach ($p->produk as $item)
                                                    <div class="d-flex mb-3">

                                                        <!-- Gambar Produk -->
                                                        <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                                            class="rounded"
                                                            style="width:90px; height:90px; object-fit:cover;">
                                                        &nbsp;&nbsp;&nbsp;

                                                        <div class="flex-grow-1 ms-3">

                                                            <h6 class="fw-semibold mb-1">{{ $item->produk->nama_produk }}
                                                            </h6>

                                                            <div class="row mt-2">
                                                                <div class="col-6">
                                                                    <small class="text-muted"
                                                                        style="font-size: 2vh;">x{{ $item->jumlah }}</small>
                                                                </div>

                                                                <div class="col-6 d-flex justify-content-end">
                                                                    <small class="text-muted" style="font-size: 2.3vh;">Rp
                                                                        {{ number_format($item->produk->harga, 0, ',', '.') }}</small>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>


                                            <!-- FOOTER -->
                                            <div class="card-footer bg-white border-top pt-3"
                                                style="border-radius:0 0 12px 12px;">

                                                <div class="d-flex justify-content-end align-items-center"
                                                    style="gap: 2vh;">
                                                    <!-- Tombol Trigger -->
                                                    <a href="#" class="btn btn-sm btn-custom-action btn-terima"
                                                        id="btnTerima" data-id="{{ $p->id_pesanan }}">Terima Pesanan</a>

                                                    <p class="mb-0" style="font-size: 3.5vh;">
                                                        <span class="text-muted">Total:</span>
                                                        <span class="text-danger" style="font-weight: 500;">
                                                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                                        </span>
                                                    </p>
                                                </div>

                                            </div>
                                        </a>

                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane fade" id="dibatalkan" role="tabpanel">
                                @foreach ($pesananDibatalkan as $p)
                                    <div class="card mb-4 shadow-sm" style="border:1px solid #e0e0e0; border-radius:5px;">
                                        <a href="/detail-pesanan/{{ $p->id_pesanan }}">
                                            <!-- HEADER -->
                                            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center"
                                                style="border-radius:12px 12px 0 0;">

                                                <span class="text-muted" style="font-size:14px; font-weight: 800;">
                                                    Tanggal: {{ \Carbon\Carbon::parse($p->tgl_pesanan)->format('d M Y') }}
                                                </span>

                                                <!-- Badge Status -->
                                                @php
                                                    $badgeStyle = match ($p->status) {
                                                        'diproses' => 'background-color:#e7f1ff; color:#0d6efd;',
                                                        'dikemas' => 'background-color:#fff3cd; color:#856404;',
                                                        'dikirim' => 'background-color:#d1e7dd; color:#0f5132;',
                                                        'selesai' => 'color:#0f5132;',
                                                        'dibatalkan' => 'background-color:#f8d7da; color:#842029;',
                                                        default => 'background-color:#eee; color:#333;',
                                                    };
                                                @endphp

                                                <span class="badge" style="font-size:14px; {{ $badgeStyle }}">
                                                    Pesanan {{ $p->status }}
                                                </span>

                                            </div>


                                            <!-- BODY -->
                                            <div class="card-body pb-2">

                                                @foreach ($p->produk as $item)
                                                    <div class="d-flex mb-3">

                                                        <!-- Gambar Produk -->
                                                        <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                                            class="rounded"
                                                            style="width:90px; height:90px; object-fit:cover;">
                                                        &nbsp;&nbsp;&nbsp;

                                                        <div class="flex-grow-1 ms-3">

                                                            <h6 class="fw-semibold mb-1">{{ $item->produk->nama_produk }}
                                                            </h6>

                                                            <div class="row mt-2">
                                                                <div class="col-6">
                                                                    <small class="text-muted"
                                                                        style="font-size: 2vh;">x{{ $item->jumlah }}</small>
                                                                </div>

                                                                <div class="col-6 d-flex justify-content-end">
                                                                    <small class="text-muted" style="font-size: 2.3vh;">Rp
                                                                        {{ number_format($item->produk->harga, 0, ',', '.') }}</small>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>


                                            <!-- FOOTER -->
                                            <div class="card-footer bg-white border-top pt-3"
                                                style="border-radius:0 0 12px 12px;">

                                                <div class="d-flex justify-content-end align-items-center"
                                                    style="gap: 2vh;">

                                                    <p class="mb-0" style="font-size: 3.5vh;">
                                                        <span class="text-muted">Total:</span>
                                                        <span class="text-danger" style="font-weight: 500;">
                                                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                                        </span>
                                                    </p>
                                                </div>

                                            </div>
                                        </a>

                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane fade" id="selesai" role="tabpanel">
                                @foreach ($pesananSelesai as $p)
                                    <div class="card mb-4 shadow-sm" style="border:1px solid #e0e0e0; border-radius:5px;">
                                        <a href="/detail-pesanan/{{ $p->id_pesanan }}">
                                            <!-- HEADER -->
                                            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center"
                                                style="border-radius:12px 12px 0 0;">

                                                <span class="text-muted" style="font-size:14px; font-weight: 800;">
                                                    Tanggal: {{ \Carbon\Carbon::parse($p->tgl_pesanan)->format('d M Y') }}
                                                </span>

                                                <!-- Badge Status -->
                                                @php
                                                    $badgeStyle = match ($p->status) {
                                                        'diproses' => 'background-color:#e7f1ff; color:#0d6efd;',
                                                        'dikemas' => 'background-color:#fff3cd; color:#856404;',
                                                        'dikirim' => 'background-color:#d1e7dd; color:#0f5132;',
                                                        'selesai' => 'color:#0f5132;',
                                                        'dibatalkan' => 'background-color:#f8d7da; color:#842029;',
                                                        default => 'background-color:#eee; color:#333;',
                                                    };
                                                @endphp

                                                <span class="badge" style="font-size:14px; {{ $badgeStyle }}">
                                                    Pesanan {{ $p->status }}
                                                </span>

                                            </div>


                                            <!-- BODY -->
                                            <div class="card-body pb-2">

                                                @foreach ($p->produk as $item)
                                                    <div class="d-flex mb-3">

                                                        <!-- Gambar Produk -->
                                                        <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                                            class="rounded"
                                                            style="width:90px; height:90px; object-fit:cover;">
                                                        &nbsp;&nbsp;&nbsp;

                                                        <div class="flex-grow-1 ms-3">

                                                            <h6 class="fw-semibold mb-1">{{ $item->produk->nama_produk }}
                                                            </h6>

                                                            <div class="row mt-2">
                                                                <div class="col-6">
                                                                    <small class="text-muted"
                                                                        style="font-size: 2vh;">x{{ $item->jumlah }}</small>
                                                                </div>

                                                                <div class="col-6 d-flex justify-content-end">
                                                                    <small class="text-muted" style="font-size: 2.3vh;">Rp
                                                                        {{ number_format($item->produk->harga, 0, ',', '.') }}</small>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>


                                            <!-- FOOTER -->
                                            <div class="card-footer bg-white border-top pt-3"
                                                style="border-radius:0 0 12px 12px;">

                                                <div class="d-flex justify-content-end align-items-center"
                                                    style="gap: 2vh;">

                                                    @if ($p->ulasan->count() == 0)
                                                        <a href="/penilaian/pesanan/{{ $p->id_pesanan }}"
                                                            class="btn btn-sm btn-custom-action">
                                                            Beri Penilaian
                                                        </a>
                                                    @endif

                                                    @if ($p->pengembalian->count() == 0)
                                                        <a href="/pesanan/ajuan/pengembalian/{{ $p->id_pesanan }}"
                                                            class="btn btn-sm btn-custom-action">
                                                            Ajukan Pengembalian
                                                        </a>
                                                    @endif

                                                    <p class="mb-0" style="font-size: 3.5vh;">
                                                        <span class="text-muted">Total:</span>
                                                        <span class="text-danger" style="font-weight: 500;">
                                                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                                        </span>
                                                    </p>
                                                </div>

                                            </div>
                                        </a>

                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane fade" id="pengembalian" role="tabpanel">

                                @foreach ($pengembalianMenunggu as $p)
                                    <div class="card mb-4 shadow-sm" style="border:1px solid #e0e0e0; border-radius:5px;">
                                        <a href="/detail-pengembalian/{{ $p->id_pengembalian }}">

                                            <!-- HEADER -->
                                            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center"
                                                style="border-radius:12px 12px 0 0;">

                                                <span class="text-muted" style="font-size:14px; font-weight: 800;">
                                                    Tanggal Pengajuan:
                                                    {{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d M Y') }}
                                                </span>

                                                <span
                                                    class="badge 
                                                    @if ($p->status === 'Menunggu Konfirmasi') bg-warning text-dark
                                                    @elseif($p->status === 'Diterima') bg-success text-white
                                                    @elseif($p->status === 'Ditolak') bg-danger text-white
                                                    @elseif($p->status === 'Dalam Pengiriman') bg-primary text-white
                                                    @elseif($p->status === 'Selesai') bg-secondary text-white
                                                    @else bg-info text-white @endif"
                                                    style="font-size:14px;">
                                                    {{ $p->status }}
                                                </span>

                                            </div>

                                            <!-- BODY -->
                                            <div class="card-body pb-2">

                                                @foreach ($p->item as $item)
                                                    @php
                                                        // ambil qty dari pesanan
                                                        $pesananItem = $p->pesanan->produk
                                                            ->where('id_produk', $item->id_produk)
                                                            ->first();
                                                        $qty = $pesananItem ? $pesananItem->jumlah : 1;

                                                        // harga produk
                                                        $harga = $item->produk->harga;

                                                        // subtotal
                                                        $subtotal = $harga * $qty;
                                                    @endphp

                                                    <div class="d-flex mb-3">

                                                        <!-- Gambar Produk -->
                                                        <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                                            class="rounded"
                                                            style="width:90px; height:90px; object-fit:cover;">
                                                        &nbsp;&nbsp;&nbsp;

                                                        <div class="flex-grow-1 ms-3">

                                                            <h6 class="fw-semibold mb-1">{{ $item->produk->nama_produk }}
                                                            </h6>

                                                            <div class="row mt-2">
                                                                <div class="col-6">
                                                                    <small class="text-muted"
                                                                        style="font-size: 2vh;">x{{ $qty }}</small><br>
                                                                    <small class="text-muted" style="font-size: 2.1vh;">
                                                                        Harga: Rp {{ number_format($harga, 0, ',', '.') }}
                                                                    </small>
                                                                </div>

                                                                <div class="col-6 d-flex justify-content-end">
                                                                    <span class="fw-semibold text-danger"
                                                                        style="font-size: 3vh;">
                                                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>

                                            <!-- FOOTER -->
                                            <div class="card-footer bg-white border-top pt-3"
                                                style="border-radius:0 0 12px 12px;">

                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">No. Pengajuan:</span>
                                                    <strong class="text-dark">{{ $p->no_pengembalian }}</strong>
                                                </div>

                                                <div class="d-flex justify-content-between mt-2">
                                                    <span class="text-muted">Solusi:</span>
                                                    <strong class="text-dark">{{ $p->solusi }}</strong>
                                                </div>

                                            </div>

                                        </a>
                                    </div>
                                @endforeach

                            </div>

                            <!-- Modal -->
                            <div id="modalTerima" class="custom-modal">
                                <div class="custom-modal-content">
                                    <div class="modal-header">
                                        <h5>Konfirmasi Terima Pesanan</h5>
                                        <span class="close-btn">&times;</span>
                                    </div>
                                    <!-- Form dimulai di sini -->
                                    <form id="formTerima" action="" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin menerima pesanan ini?</p>
                                        </div>
                                        <div class="modal-actions">
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                id="cancelTerima">Batal</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Terima</button>
                                        </div>
                                    </form>
                                    <!-- Form selesai -->
                                </div>
                            </div>

                            <div id="modalBatal" class="custom-modal">
                                <div class="custom-modal-content">
                                    <div class="modal-header">
                                        <h5>Alasan Pembatalan</h5>
                                        <span class="close-btn">&times;</span>
                                    </div>
                                    <!-- Form dimulai di sini -->
                                    <form id="formBatal" action="" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label class="d-flex align-items-center gap-2">
                                                    <input type="radio" name="alasan" value="Perubahan rencana">
                                                    <span>&nbsp;&nbsp;Perubahan rencana</span>
                                                </label>
                                            </div>

                                            <div class="mb-2">
                                                <label class="d-flex align-items-center gap-2">
                                                    <input type="radio" name="alasan" value="Salah pilih produk">
                                                    <span>&nbsp;&nbsp;Salah pilih produk</span>
                                                </label>
                                            </div>

                                            <div class="mb-2">
                                                <label class="d-flex align-items-center gap-2">
                                                    <input type="radio" name="alasan" value="Tidak jadi membeli">
                                                    <span>&nbsp;&nbsp;Tidak jadi membeli</span>
                                                </label>
                                            </div>

                                            <div class="mb-2">
                                                <label class="d-flex align-items-center gap-2">
                                                    <input type="radio" name="alasan" value="Lainnya"
                                                        id="radioLainnya">
                                                    <span>&nbsp;&nbsp;Lainnya</span>
                                                </label>
                                            </div>

                                            <!-- Textarea muncul hanya kalau pilih "Lainnya" -->
                                            <div id="textareaLainnya" class="mt-2" style="display:none;">
                                                <textarea class="form-control" name="alasan_lain" rows="3" placeholder="Tulis alasan lain..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-actions">
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                id="cancelBatal">Batal</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Konfirmasi</button>
                                        </div>
                                    </form>
                                    <!-- Form selesai -->
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- <script>
        const modal = document.getElementById("modalTerima");
        const modalBatal = document.getElementById("modalBatal");
        const btnBatal = document.getElementById("btnBatal");
        const btnTerima = document.getElementById("btnTerima");
        const btnTerimaSemua = document.getElementById("btnTerimaSemua");
        const closeBtn = document.querySelector(".close-btn");
        const cancelBtn = document.getElementById("cancelBtn");
        const formTerima = document.getElementById("formTerima");
        const formBatal = document.getElementById("formBatal");


        btnTerima.onclick = function(e) {
            e.preventDefault();
            formTerima.action = `/terimaPesanan/${btnTerima.dataset.id}`;
            modal.style.display = "flex";
        }

        btnTerimaSemua.onclick = function(e) {
            e.preventDefault();
            formTerima.action = `/terimaPesanan/${btnTerimaSemua.dataset.id}`;
            modal.style.display = "flex";
        }

        btnBatal.onclick = function(e) {
            e.preventDefault();
            formBatal.action = `/pesanan-batal/${btnBatal.dataset.id}`;
            modalBatal.style.display = "flex";
        }

        closeBtn.onclick = cancelBtn.onclick = function() {
            modal.style.display = "none";
        }

        // Tutup modal jika klik di luar kontennya
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script> --}}

    <script>
        const modal = document.getElementById("modalTerima");
        // const btnTerima = document.getElementById("btnTerima");
        // const btnTerimaSemua = document.getElementById("btnTerimaSemua");
        const formTerima = document.getElementById("formTerima");

        const modalBatal = document.getElementById("modalBatal");
        // const btnBatal = document.getElementById("btnBatal");
        // const btnBatalSemua = document.getElementById("btnBatalSemua");
        const formBatal = document.getElementById("formBatal");

        const closeBtn = document.querySelector(".close-btn");
        const cancelBtn = document.getElementById("cancelBtn");

        // Helper untuk menambahkan listener jika element ada
        function addListener(el, event, callback) {
            if (el) {
                el.addEventListener(event, callback);
            }
        }

        document.querySelectorAll('.btn-batal').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.dataset.id;
                formBatal.action = `/pesanan-batal/${id}`;

                modalBatal.style.display = "flex";
            });
        });

        document.querySelectorAll('.btn-batal-semua').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.dataset.id;
                formBatal.action = `/pesanan-batal/${id}`;

                modalBatal.style.display = "flex";
            });
        });

        document.querySelectorAll('.btn-terima').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                formTerima.action = `/terimaPesanan/${this.dataset.id}`;
                modalTerima.style.display = "flex";
            });
        });

        document.querySelectorAll('.btn-terima-semua').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                formTerima.action = `/terimaPesanan/${this.dataset.id}`;
                modalTerima.style.display = "flex";
            });
        });


        document.querySelectorAll('.close-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const modal = btn.closest('.custom-modal');
                if (modal) modal.style.display = "none";
            });
        });


        // Tombol cancel unik per modal
        document.getElementById("cancelTerima")?.addEventListener('click', function() {
            modal.style.display = "none";
        });

        document.getElementById("cancelBatal")?.addEventListener('click', function() {
            modalBatal.style.display = "none";
        });

        // Tutup modal jika klik di luar kontennya
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioLainnya = document.getElementById('radioLainnya');
            const textareaLainnya = document.getElementById('textareaLainnya');

            // Ambil semua radio alasan di modalBatal
            const radios = document.querySelectorAll('#modalBatal input[name="alasan"]');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (radioLainnya.checked) {
                        textareaLainnya.style.display = 'block';
                    } else {
                        textareaLainnya.style.display = 'none';
                    }
                });
            });
        });
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const tabButtons = document.querySelectorAll('#pesananTab .nav-link');
            const tabContents = document.querySelectorAll('#pesananTabContent .tab-pane');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // 1. Hapus class active dari semua tab
                    tabButtons.forEach(btn => btn.classList.remove('active'));

                    // 2. Tambahkan class active ke tab yang diklik
                    this.classList.add('active');

                    // 3. Sembunyikan semua content
                    tabContents.forEach(content => {
                        content.classList.remove('show', 'active');
                    });

                    // 4. Ambil target id (#semua, #dikemas, dll)
                    const targetID = this.getAttribute('data-bs-target');
                    const targetContent = document.querySelector(targetID);

                    // 5. Tampilkan tab content yang sesuai
                    targetContent.classList.add('show', 'active');

                    // 6. Scroll otomatis ke tengah (opsional biar rapi)
                    this.scrollIntoView({
                        behavior: "smooth",
                        inline: "center",
                        block: "nearest"
                    });
                });
            });

        });
    </script>
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Semua tombol batal
            const btnBatalList = document.querySelectorAll(".btn-batal");

            btnBatalList.forEach(btn => {
                btn.addEventListener("click", function(e) {
                    e.preventDefault();

                    const idPesanan = this.dataset.id; // <-- AMBIL ID PESANANNYA
                    const modal = document.getElementById("modalBatal");
                    const form = document.getElementById("formBatal");

                    // set action dynamic
                    form.action = "/pesanan-batal/" + idPesanan;

                    modal.style.display = "flex";
                });
            });

            // Tombol close modal
            document.getElementById("btnCloseModal").addEventListener("click", function() {
                document.getElementById("modalBatal").style.display = "none";
            });

        });
    </script> --}}
@endsection
