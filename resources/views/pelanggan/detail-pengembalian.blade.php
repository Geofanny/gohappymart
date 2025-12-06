@extends('layouts/main-pelanggan-no-footer')

@section('content')
    <style>
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
    <div class="container py-5 mb-3">
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
                                <a href="/pesanan-saya" class="nav-link {{ Request::is('pesanan-saya') ? 'active' : '' }}">
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

                <style>
                    .status-banner {
                        padding: 10px 18px;
                        border-radius: 8px;
                        color: #ffffff;
                        display: flex;
                        background: #da8830;
                        /* Soft Brown Neutral */
                        align-items: center;
                        gap: 10px;
                        font-weight: 600;
                        margin-bottom: 15px;
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                    }
                </style>

                <div class="status-banner">
                    <span id="statusText">{{ $pengembalian->status }}</span>
                </div>

                <!-- PRODUK PESANAN -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-semibold mb-0">Produk Pesanan</h5>
                    </div>

                    <div class="card-body">

                        @php
                            $total_pengembalian = 0;
                        @endphp

                        @foreach ($pengembalian->item as $item)
                            @php
                                $jumlah = $jumlahProduk[$item->id_produk] ?? 0;
                                $total_harga = $jumlah * $item->produk->harga;
                                $total_pengembalian += $total_harga;
                            @endphp

                            <div class="d-flex mb-3 pb-3 border-bottom">
                                <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                    class="rounded me-3" style="width:90px; height:90px; object-fit:cover;">

                                <div class="flex-grow-1 ml-3">
                                    <h6 class="fw-semibold mb-1">{{ $item->produk->nama_produk }}</h6>
                                    <p class="mb-1">x{{ $jumlah }}</p>

                                    <div class="d-flex justify-content-between mb-0">
                                        <p class="mb-0">Harga: Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                        </p>
                                        <p class="mb-0 fw-semibold">Rp {{ number_format($total_harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Total Pengembalian --}}
                        <div class="d-flex justify-content-between mt-2">
                            <h6 class="fw-bold">Total Pengembalian</h6>
                            <h6 class="fw-bold">Rp {{ number_format($total_pengembalian, 0, ',', '.') }}</h6>
                        </div>


                    </div>
                </div>

                @if ($pengembalian->status === 'Dikirim' && $pengembalian->solusi !== 'Pengembalian dana')
                    <div class="card mb-3 border-success">
                        <div class="card-body d-flex justify-content-between align-items-center">

                            <!-- Kiri: Icon + Teks -->
                            <div class="d-flex align-items-center" style="gap: 12px;">
                                <span class="badge bg-success p-2">
                                    <i class="fas fa-check-circle fa-lg text-white"></i>
                                </span>

                                <div>
                                    <h6 class="fw-semibold mb-1">Selesaikan Pengembalian</h6>
                                    <small class="text-muted">
                                        Konfirmasi penerimaan barang untuk menyelesaikan proses pengembalian.
                                    </small>
                                </div>
                            </div>

                            <!-- Kanan: Tombol -->
                            <form action="/pengembalian/selesaikan/{{ $pengembalian->id_pengembalian }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    Sudah Diterima
                                </button>
                            </form>

                        </div>
                    </div>
                @endif

                @if ($pengembalian->status === 'Diterima' && $pengembalian->solusi === 'Pengembalian dana')
                    <div class="card mb-3 border-info">
                        <div class="card-body d-flex justify-content-between align-items-center">

                            <!-- Kiri: Icon + Teks -->
                            <div class="d-flex align-items-center" style="gap: 12px;">
                                <span class="badge bg-info p-2">
                                    <i class="fas fa-wallet fa-lg text-white"></i>
                                </span>

                                <div>
                                    <h6 class="fw-semibold mb-1">Konfirmasi Pengembalian Dana</h6>
                                    <small class="text-muted">
                                        Lakukan konfirmasi apabila dana pengembalian telah Anda terima.
                                    </small>
                                </div>
                            </div>

                            <!-- Kanan: Tombol -->
                            <form action="/pengembalian/selesaikan/{{ $pengembalian->id_pengembalian }}" method="POST">
                                @csrf
                                <button class="btn btn-info btn-sm text-white">
                                    Dana Telah Masuk
                                </button>
                            </form>

                        </div>
                    </div>
                @endif




                @if (
                    $pengembalian->status === 'Diterima' &&
                        $pengembalian->solusi !== 'Pengembalian dana' &&
                        is_null($pengembalian->no_resi_pengembalian))
                    <div class="card mb-3">
                        <div class="card-body">

                            <h5 class="mb-1"><span>Resi Pengiriman</span></h5>

                            <!-- Keterangan di bawah judul -->
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">
                                Masukkan nomor resi pengiriman untuk pengembalian barang.
                            </div>

                            <div class="d-flex justify-content-between align-items-center" style="gap: 12px;">
                                <input type="text" class="form-control resi-input" placeholder="Contoh: 19328BSHGSxx">
                                <button class="btn btn-primary btn-resi">Submit</button>
                            </div>

                        </div>
                    </div>

                    <div class="card mb-3 border-warning">
                        <div class="card-body d-flex align-items-center" style="gap: 12px;">
                            <!-- Icon peringatan -->
                            <span class="badge bg-warning text-dark p-2">
                                <i class="fas fa-truck fa-lg"></i>
                            </span>

                            <!-- Pesan alert -->
                            <div>
                                <h6 class="mb-1 fw-semibold">Pengiriman Barang</h6>
                                <small class="text-muted">
                                    Segera kirim paket ke <b>JNE terdekat</b> untuk memproses pengembalian barang.
                                </small>
                            </div>
                        </div>
                    </div>
                @endif

                <div id="modalKonfirmasi" class="custom-modal modal-konfirmasi-resi">
                    <div class="custom-modal-content">
                        <div class="modal-header">
                            <h5>Konfirmasi Nomor Resi</h5>
                            <span class="close-btn">&times;</span>
                        </div>

                        <!-- Form -->
                        <form id="formTerima"
                            action="/pengembalian/{{ $pengembalian->id_pengembalian }}/update-resi-tunggu" method="POST">
                            @csrf
                            <div class="modal-body">
                                <p>Anda akan mengirimkan barang untuk pengembalian menggunakan nomor resi berikut:</p>
                                <p id="resiModal" style="font-weight: 600; font-size: 14px;"></p>
                                <input type="hidden" name="no_resi_pengembalian" id="inputResi">
                                <p>Pastikan nomor resi yang dimasukkan sudah benar. Admin akan memverifikasi status
                                    pengembalian setelah resi dikirim.</p>
                            </div>

                            <div class="modal-actions d-flex justify-content-end" style="gap: 8px;">
                                <button type="button" class="btn btn-sm btn-secondary" id="cancelTerima">Batal</button>
                                <button type="submit" class="btn btn-sm btn-primary">Ya, Benar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mb-3 shadow-sm" style="border-radius: 8px;">
                    <div class="card-body">

                        <div class="d-flex justify-content-between">
                            <h6 class="fw-bold">Alasan</h6>
                            <p class="text-muted mb-0">{{ $pengembalian->alasan }}</p>
                        </div>
                        <hr>

                        <div>
                            <h6 class="fw-bold">Detail Alasan</h6>
                            <p class="text-muted mb-0">{{ $pengembalian->deskripsi }}</p>
                        </div>
                        <hr>

                        <div class="d-flex justify-content-between">
                            <h6 class="fw-bold">Solusi</h6>
                            <p class="text-muted mb-0">{{ $pengembalian->solusi }}</p>
                        </div>

                        @if ($pengembalian->solusi === 'Pengembalian dana')
                            <hr>

                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-0">Pengembalian Dana</h6>
                                <h6 class="fw-bold mb-0">Rp {{ number_format($total_pengembalian, 0, ',', '.') }}</h6>
                            </div>

                            <small class="text-muted" style="font-size: 11px;">
                                Pengembalian dana akan dihubungi oleh admin.
                            </small>
                        @endif

                        @if ($pengembalian->status === 'Dalam Pengiriman' && $pengembalian->solusi !== 'Pengembalian dana')
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-0">Resi Pengiriman</h6>
                                <h6 class="fw-bold mb-0" style="text-transform: uppercase;">
                                    {{ $pengembalian->no_resi_pengembalian }}</h6>
                            </div>

                            <small class="text-muted" style="font-size: 11px;">
                                Gunakan nomor resi ini untuk mengirimkan paket kembali ke admin.
                            </small>
                        @endif
                    </div>
                </div>

                <!-- RINCIAN PENGAJUAN -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-semibold mb-0">Rincian Pengajuan</h5>
                    </div>

                    <div class="card-body">

                        <!-- NOMOR PENGAJUAN -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Nomor Pengajuan</span>

                            <div class="d-flex align-items-center">
                                <span class="fw-semibold mr-2"
                                    id="noPengembalianText">{{ $pengembalian->no_pengembalian }}</span>

                                <button id="btnSalinPengembalian"
                                    onclick="navigator.clipboard.writeText('{{ $pengembalian->no_pengembalian }}')"
                                    style="
                                        border:1px solid #ccc;
                                        background:#f8f9fa;
                                        padding:2px 6px;
                                        font-size:12px;
                                        border-radius:4px;
                                        cursor:pointer;">
                                    Salin
                                </button>
                            </div>
                        </div>

                        @if ($pengembalian->status === 'Dikirim')
                            <!-- RESI PENGEMBALIAN -->
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Resi Pelacakan</span>
                                <span class="fw-semibold">{{ $pengembalian->no_resi_balasan ?? '-' }}</span>
                            </div>
                        @endif

                        <!-- TANGGAL PENGAJUAN -->
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tanggal Pengajuan</span>
                            <span
                                class="fw-semibold">{{ \Carbon\Carbon::parse($pengembalian->tgl_pengajuan)->translatedFormat('d M Y H:i') }}</span>
                        </div>

                        <!-- TANGGAL SELESAI (jika ada) -->
                        @if ($pengembalian->tgl_selesai && $pengembalian->status === 'Selesai')
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tanggal Selesai</span>
                                <span
                                    class="fw-semibold">{{ \Carbon\Carbon::parse($pengembalian->tgl_selesai)->translatedFormat('d M Y H:i') }}</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 CSS Kustom --}}
    <style>
        .label-col {
            font-size: 14px;
        }

        .form-control-sm {
            font-size: 14px;
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
    </style>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2880,
                showConfirmButton: false
            });
        @endif
    </script>
    <script>
        // Ambil elemen
        const btnSubmitResi = document.querySelector('.btn-resi'); // tombol submit di card resi
        const modal = document.getElementById('modalKonfirmasi'); // modal
        const closeBtn = modal.querySelector('.close-btn'); // tombol ×
        const cancelBtn = document.getElementById('cancelTerima'); // tombol batal
        const resiInput = document.querySelector('.resi-input');
        const resiModal = document.getElementById('resiModal');
        const inputResi = document.querySelector('#inputResi');

        // Fungsi buka modal
        btnSubmitResi.addEventListener('click', function(e) {
            e.preventDefault(); // supaya form tidak submit langsung
            if (resiInput.value.trim() === '') {
                resiModal.textContent = 'Isi resi terlebih dahulu';
            }
            resiModal.textContent = resiInput.value.trim();
            inputResi.value = resiInput.value.trim();
            modal.style.display = 'flex';
        });

        // Fungsi tutup modal
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        cancelBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Tutup modal saat klik di luar konten modal
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('btnSalinPengembalian');
            const textEl = document.getElementById('noPengembalianText');

            btn.addEventListener('click', function() {
                const text = textEl.innerText;

                // Coba clipboard API dulu
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(() => {
                        showCopied(btn);
                    }).catch(() => {
                        fallbackCopy(text, btn);
                    });
                } else {
                    // Fallback jika clipboard API tidak tersedia
                    fallbackCopy(text, btn);
                }
            });

            function fallbackCopy(text, btn) {
                const temp = document.createElement("textarea");
                temp.value = text;
                document.body.appendChild(temp);
                temp.select();
                document.execCommand("copy");
                document.body.removeChild(temp);
                showCopied(btn);
            }

            function showCopied(btn) {
                const oldText = btn.innerText;
                btn.innerText = "Tersalin";
                setTimeout(() => btn.innerText = oldText, 1200);
            }
        });
    </script>
@endsection
