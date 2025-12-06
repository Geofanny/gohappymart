@extends('layouts/main-pelanggan-no-footer')

@section('content')
    <div class="container py-5">
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
                                <a href="/pesanan" class="nav-link {{ Request::is('pesanan') ? 'active' : '' }}">
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
                    /* Gaya border bawah amplop */
                    .envelope-border {
                        position: relative;
                        overflow: hidden;
                    }

                    .envelope-border::after {
                        content: "";
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        width: 100%;
                        height: 6px;
                        background-image: repeating-linear-gradient(45deg,
                                red 0 10px,
                                white 10px 20px,
                                #0066cc 20px 30px,
                                white 30px 40px);
                        background-size: 40px 6px;
                    }

                    .status-banner {
                        padding: 10px 18px;
                        border-radius: 8px;
                        color: white;
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        font-weight: 600;
                        margin-bottom: 12px;
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                    }

                    .status-icon {
                        width: 18px;
                        height: 18px;
                    }

                    /* Warna status */
                    .status-processing {
                        background: #1e90ff;
                    }

                    /* Biru */
                    .status-packed {
                        background: #f39c12;
                    }

                    /* Oranye */
                    .status-shipping {
                        background: #27ae60;
                    }

                    /* Hijau */
                    .status-completed {
                        background: #1e8449;
                    }

                    /* Hijau Gelap */
                    .status-canceled {
                        background: #e74c3c;
                    }

                    /* Merah */
                </style>

                @php
                    $status = $pesanan->status;
                    $statusIcon = [
                        'diproses' => '
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="9" stroke="white" stroke-width="2"/>
                                <path d="M12 7v5l3 2" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        ',

                        'dikemas' => '
                            <svg class="status-icon" fill="white" viewBox="0 0 24 24">
                                <path d="M3 7l9-4 9 4-9 4z"></path>
                                <path d="M3 7v10l9 4v-10z"></path>
                                <path d="M21 7v10l-9 4v-10z"></path>
                            </svg>
                        ',
                        'dikirim' => '
                            <svg class="status-icon" fill="white" viewBox="0 0 24 24">
                                <path d="M3 3h13v13H3z"></path>
                                <path d="M16 8h5l2 3v5h-7z"></path>
                                <circle cx="7" cy="18" r="2"></circle>
                                <circle cx="17" cy="18" r="2"></circle>
                            </svg>
                        ',
                        'selesai' => '
                            <svg class="status-icon" fill="white" viewBox="0 0 24 24">
                                <path d="M20 6L9 17l-5-5" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                            </svg>
                        ',
                        'dibatalkan' => '
                            <svg class="status-icon" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="11" fill="white"/>
                                <path d="M8 8l8 8M16 8l-8 8"
                                    stroke="#D00000" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        ',

                    ];
                @endphp


                <div
                    class="status-banner {{ $status == 'diproses'
                        ? 'status-processing'
                        : ($status == 'dikemas'
                            ? 'status-packed'
                            : ($status == 'dikirim'
                                ? 'status-shipping'
                                : ($status == 'selesai'
                                    ? 'status-completed'
                                    : 'status-canceled'))) }}">

                    {!! $statusIcon[$status] ?? '' !!}
                    <span id="statusText">Pesanan {{ $status }}</span>
                </div>



                @php
                    $alamat = explode('|', $pesanan->pengiriman->alamat);

                    // Antisipasi jika data kurang
                    $nama = $alamat[0] ?? '';
                    $hp = $alamat[1] ?? '';
                    $alamatLengkap = $alamat[2] ?? '';
                    $alamatTambahan = $alamat[3] ?? '';
                    $labelAlamat = $alamat[4] ?? '';
                @endphp

                <div class="card shadow-sm mb-4 envelope-border position-relative">
                    <div class="card-body mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 fw-semibold">Alamat Pengiriman</h5>
                        </div>

                        <div class="row">
                            <!-- Kolom kiri -->
                            <div class="col-md-2">
                                <p class="mb-1 fw-semibold">{{ $nama }}</p>
                                <p class="mb-1 text-muted">{{ $hp }}</p>
                            </div>

                            <!-- Kolom kanan -->
                            <div class="col-md-10">
                                <p class="mb-1 fw-semibold">{{ $alamatLengkap }}</p>
                                <p class="mb-0 text-muted">{{ $alamatTambahan }}</p>
                                <p class="mb-0 text-muted">{{ $labelAlamat }}</p>
                            </div>
                        </div>
                    </div>
                </div>


                @if ($status == 'diproses')
                    <div class="card shadow-sm mb-4">
                        <div class="card-body d-flex justify-content-between align-items-center">

                            <!-- BAGIAN KIRI -->
                            <div class="fw-semibold text-dark">
                                Ingin membatalkan pesanan ini?
                            </div>

                            <!-- BAGIAN KANAN (HANYA MUNCUL JIKA dIPROSES) -->

                            <a href="#" id="btn-batal" class="text-danger fw-semibold text-decoration-none">
                                Batalkan pesanan
                            </a>

                        </div>
                    </div>
                @endif

                <!-- Modal -->
                <div id="modalBatal" class="modal-custom">
                    <div class="modal-content-custom">

                        <h5 class="fw-semibold mb-3">Alasan Pembatalan</h5>
                        <hr>

                        <form method="POST" action="/pesanan-batal/{{ $pesanan->id_pesanan }}">
                            @csrf
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
                                    <input type="radio" name="alasan" value="Lainnya" id="radioLainnya">
                                    <span>&nbsp;&nbsp;Lainnya</span>
                                </label>
                            </div>

                            <!-- Textarea muncul hanya kalau pilih "Lainnya" -->
                            <div id="textareaLainnya" class="mt-2" style="display:none;">
                                <textarea class="form-control" name="alasan_lain" rows="3" placeholder="Tulis alasan lain..."></textarea>
                            </div>

                            <div class="text-end mt-4">
                                <button type="button" id="btnCloseModal" class="btn btn-sm btn-secondary">
                                    Tutup
                                </button>
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Konfirmasi
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

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
                </style>

                <!-- 🔶 Card Produk Pesanan (Vertikal Stack) -->
                <div class="card shadow-sm  mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-semibold mb-0">Produk Pesanan</h6>
                    </div>
                    <div class="card-body">

                        @php
                            $subtotal = 0;
                        @endphp


                        @foreach ($pesanan->produk as $item)
                            @php
                                $total_harga = $item->jumlah * $item->produk->harga;
                                $subtotal += $total_harga;
                            @endphp
                            <div class="d-flex mb-3 pb-3 border-bottom">

                                <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                    class="rounded me-3" style="width:90px; height:90px; object-fit:cover;">

                                <div class="flex-grow-1 ml-3">
                                    <h6 class="fw-semibold mb-1">{{ $item->produk->nama_produk }}</h6>
                                    <p class="mb-1">Jumlah: {{ $item->jumlah }}</p>
                                    <div class="d-flex justify-content-between mb-0">
                                        <p class="mb-0">Harga: Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                        </p>

                                        <p class="mb-0 fw-semibold">
                                            Rp {{ number_format($total_harga, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <h6 class="fw-semibold mb-2">Catatan Pesanan</h6>

                        <p class="mb-0 text-dark">
                            {{ $pesanan->catatan ?? '— Tidak ada catatan' }}
                        </p>

                    </div>
                </div>


                <!-- 🔶 Rincian Pesanan (Vertikal) -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-semibold mb-0">Rincian Pesanan</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Nomor Pesanan</span>

                            <div class="d-flex align-items-center">
                                <span id="noPesananText" class="fw-semibold mr-2">
                                    {{ $pesanan->no_pesanan }}
                                </span>

                                <!-- Tombol salin kecil -->
                                <button id="btnSalinPesanan"
                                    style="
                                        border: 1px solid #ccc;
                                        background: #f8f9fa;
                                        padding: 2px 6px;
                                        font-size: 12px;
                                        border-radius: 4px;
                                        cursor: pointer;
                                    ">
                                    Salin
                                </button>
                            </div>
                        </div>


                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tanggal Pemesanan</span>
                            <span class="fw-semibold">
                                {{ \Carbon\Carbon::parse($pesanan->tgl_pesanan)->format('d M Y, H:i') }}
                            </span>
                        </div>
                        @if ($pesanan->status === 'dikirim' || $pesanan->status === 'selesai' )
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tanggal Pengiriman</span>

                                <span class="fw-semibold">
                                    {{ $pesanan->pengiriman?->tgl_kirim
                                        ? \Carbon\Carbon::parse($pesanan->pengiriman->tgl_kirim)->format('d M Y, H:i')
                                        : '-' }}
                                </span>
                            </div>
                        @endif

                        @if ($pesanan->pembayaran && $pesanan->pembayaran->tgl_pembayaran)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tanggal Pembayaran</span>
                                <span class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($pesanan->pembayaran->tgl_pembayaran)->format('d M Y, H:i') }}
                                </span>
                            </div>
                        @endif

                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-semibold">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Metode Pembayaran</span>
                            <span class="fw-semibold">{{ $pesanan->pembayaran->metode }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Biaya Pengiriman</span>
                            <span class="fw-semibold">Rp
                                {{ number_format($pesanan->pengiriman->ongkir ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Pengiriman</span>
                            <span class="fw-semibold"> {{ $pesanan->pengiriman->jasa_kirim ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-dark" style="font-weight: bold">Total Pembayaran</span>
                            <span class="text-dark" style="font-weight:bold">Rp
                                {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('btnSalinPesanan');
            const textEl = document.getElementById('noPesananText');

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const modal = document.getElementById("modalBatal");
            const btnOpen = document.getElementById("btn-batal");
            const btnClose = document.getElementById("btnCloseModal");

            const radioLainnya = document.getElementById("radioLainnya");
            const textareaLainnya = document.getElementById("textareaLainnya");

            // Buka modal
            btnOpen.addEventListener("click", function(e) {
                e.preventDefault();
                modal.style.display = "flex";
            });

            // Tutup modal
            btnClose.addEventListener("click", function() {
                modal.style.display = "none";
            });

            // Klik di luar modal menutup
            modal.addEventListener("click", function(e) {
                if (e.target === modal) {
                    modal.style.display = "none";
                }
            });

            // Listener radio → tampilkan textarea jika "lainnya" dipilih
            document.querySelectorAll("input[name='alasan']").forEach(radio => {
                radio.addEventListener("change", function() {
                    if (radioLainnya.checked) {
                        textareaLainnya.style.display = "block";
                    } else {
                        textareaLainnya.style.display = "none";
                    }
                });
            });

        });
    </script>
@endsection
