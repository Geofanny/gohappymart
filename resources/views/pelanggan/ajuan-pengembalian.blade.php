@extends('layouts/main-pelanggan-no-footer')

@section('content')
    <style>
        /* Overlay modal */
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

        /* Konten modal */
        .custom-modal-content {
            background-color: #fff;
            border-radius: 8px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.2s ease-in-out;
            display: flex;
            flex-direction: column;
        }

        /* Header modal */
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
            font-size: 1.1rem;
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

        /* Body modal */
        .modal-body {
            padding: 15px 20px;
            font-size: 0.95rem;
            color: #333;
        }

        /* Actions / footer modal */
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 15px 20px;
            border-top: 1px solid #e5e5e5;
        }

        /* Radio item styling */
        .modal-body .mb-2 label {
            cursor: pointer;
        }

        /* Textarea untuk "Lainnya" */
        #textareaAlasanLainnya,
        #textareaSolusiLainnya {
            display: none;
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

        /* Hover effect untuk list group item (opsional) */
        .modal-body .list-group-item:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>
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

                <!-- Status Pengembalian -->
                <div class="status-pengembalian mb-3 p-3 border rounded bg-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 text-white">Ajukan Pengembalian</h5>
                            <p class="mb-0" style="color: #CFE8FF;">
                                <strong>No. Pesanan #{{ $pesanan->no_pesanan }}</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('pengembalian.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_pesanan" value="{{ $pesanan->id_pesanan }}">
                    <input type="hidden" name="alasan" id="inputAlasan">
                    <input type="hidden" name="solusi" id="inputSolusi">
                    <input type="hidden" name="deskripsi" id="inputDeskripsi">

                    <input type="hidden" name="produk[]" class="produk-terpilih">

                    <!-- Card 2: Produk Pesanan -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-3">Produk Pesanan</h5>
                            <ul class="list-group list-group-flush">
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach ($pesanan->produk as $item)
                                    @php
                                        $total_harga = $item->jumlah * $item->produk->harga;
                                        $subtotal += $total_harga;
                                    @endphp
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">

                                            {{-- Kolom kiri --}}
                                            <div class="d-flex" style="width: 100%;">
                                                <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                                    class="rounded me-3" style="width:90px; height:90px; object-fit:cover;">

                                                <div class="flex-grow-1 ml-2">
                                                    <h6 class="fw-semibold mb-1 mt-2">{{ $item->produk->nama_produk }}</h6>
                                                    <p>Jumlah: {{ $item->jumlah }}</p>

                                                    {{-- Baris harga dan subtotal --}}
                                                    <div class="d-flex justify-content-between"
                                                        style="width:100%; margin-top: -2.5vh;">
                                                        <p class="mb-0">
                                                            Harga: Rp
                                                            {{ number_format($item->produk->harga, 0, ',', '.') }}
                                                        </p>

                                                        <p class="mb-0 fw-semibold text-danger text-end">
                                                            Rp {{ number_format($total_harga, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Checkbox kanan --}}
                                            <input type="checkbox" class="form-check-input select-item ms-3"
                                                data-produk="{{ $item->produk->id_produk }}">
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Card 3: Alasan -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2 alasan-btn"
                                style="cursor:pointer;">
                                <h5><span>Alasan</span></h5>
                                <span class="alasan-selected"><i class="fas fa-chevron-right"></i></span>
                            </div>
                            <hr>
                            <div>
                                <label class="form-label">Detail Alasan</label>
                                <textarea class="form-control" id="deskripsiTextarea" rows="3" placeholder="Jelaskan lebih detail..."></textarea>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center solusi-btn"
                                style="cursor:pointer;">
                                <h5><span>Solusi</span></h5>
                                <span class="solusi-selected"><i class="fas fa-chevron-right"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Solusi -->
                    {{-- <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center solusi-btn"
                                style="cursor:pointer;">
                                <h5><span>Solusi</span></h5>
                                <span class="solusi-selected"><i class="fas fa-chevron-right"></i></span>
                            </div>
                            <hr>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between">
                                    <span>Email Pelanggan</span>
                                    <span>customer@example.com</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>No. HP Pelanggan</span>
                                    <span>081234567890</span>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Modal Solusi -->
                    <div id="modalSolusi" class="custom-modal">
                        <div class="custom-modal-content">
                            <div class="modal-header">
                                <h5>Pilih Solusi</h5>
                                <span class="close-btn">&times;</span>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group" id="listSolusi"></ul>
                            </div>
                            <div class="modal-actions">
                                <button type="button" class="btn btn-sm btn-secondary text-white close-btn">Batal</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Alasan -->
                    <div id="modalAlasan" class="custom-modal">
                        <div class="custom-modal-content">
                            <div class="modal-header">
                                <h5>Pilih Alasan</h5>
                                <span class="close-btn">&times;</span>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group" id="listAlasan">
                                    <li class="list-group-item alasan-item">Pesanan tidak sesuai deskripsi</li>
                                    <li class="list-group-item alasan-item">Pesanan diterima dalam kondisi rusak</li>
                                    <li class="list-group-item alasan-item">Pesanan salah dikirim</li>
                                    <li class="list-group-item alasan-item">Jumlah pesanan kurang</li>
                                </ul>
                            </div>
                            <div class="modal-actions">
                                <button type="button"
                                    class="btn btn-sm btn-secondary text-white close-btn">Batal</button>
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Ajukan Pengembalian</button>
                </form>
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
        const alasanBtn = document.querySelector('.alasan-btn');
        const modalAlasan = document.getElementById('modalAlasan');
        const alasanSelectedSpan = document.querySelector('.alasan-selected');
        const solusiSelectedSpan = document.querySelector('.solusi-selected');
        const solusiBtn = document.querySelector('.solusi-btn');
        const modalSolusi = document.getElementById('modalSolusi');
        const listSolusi = document.getElementById('listSolusi');

        let selectedAlasan = null;

        // Map solusi 2 opsi per alasan
        const solusiMap = {
            "Pesanan tidak sesuai deskripsi": ["Tukar barang"],
            "Pesanan diterima dalam kondisi rusak": ["Ganti barang", "Pengembalian dana"],
            "Pesanan salah dikirim": ["Tukar barang"],
            "Jumlah pesanan kurang": ["Kirim tambahan", "Tukar barang"]
        };

        // Set awal solusi "disabled"
        solusiBtn.style.pointerEvents = "none";
        solusiBtn.style.opacity = "0.6";

        // Buka modal Alasan
        alasanBtn.addEventListener('click', () => modalAlasan.style.display = 'flex');

        document.getElementById('deskripsiTextarea').addEventListener('input', function() {
            document.getElementById('inputDeskripsi').value = this.value;
        });

        // Pilih alasan dari list group
        document.querySelectorAll('.alasan-item').forEach(item => {
            item.addEventListener('click', () => {
                selectedAlasan = item.textContent;
                // Ganti simbol > dengan alasan yang dipilih
                alasanSelectedSpan.innerHTML = selectedAlasan;
                modalAlasan.style.display = 'none';

                document.getElementById('inputAlasan').value = selectedAlasan;

                // Reset solusi ketika alasan berubah
                solusiSelectedSpan.innerHTML = '<i class="fas fa-chevron-right"></i>';

                // Aktifkan card solusi
                solusiBtn.style.pointerEvents = "auto";
                solusiBtn.style.opacity = "1";
            });
        });

        // Buka modal Solusi
        solusiBtn.addEventListener('click', () => {
            if (!selectedAlasan) return; // aman, sudah disable

            listSolusi.innerHTML = '';

            solusiMap[selectedAlasan].forEach(s => {
                const li = document.createElement('li');
                li.classList.add('list-group-item', 'solusi-item');
                li.textContent = s;
                listSolusi.appendChild(li);

                li.addEventListener('click', () => {
                    solusiSelectedSpan.innerHTML = s;
                    modalSolusi.style.display = 'none';
                    document.getElementById('inputSolusi').value = s;
                });
            });

            modalSolusi.style.display = 'flex';
        });

        document.querySelectorAll('.select-item').forEach(cb => {
            cb.addEventListener('change', () => {
                let selected = [];

                document.querySelectorAll('.select-item:checked').forEach(c => {
                    selected.push(c.getAttribute('data-produk'));
                });

                // Clear existing hidden input
                document.querySelectorAll('.produk-terpilih').forEach(e => e.remove());

                // Add new hidden input
                selected.forEach(id => {
                    let input = document.createElement('input');
                    input.type = "hidden";
                    input.name = "produk[]";
                    input.value = id;
                    input.classList.add('produk-terpilih');
                    document.querySelector('form').appendChild(input);
                });
            });
        });


        // Close modal
        document.querySelectorAll('.custom-modal .close-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.target.closest('.custom-modal').style.display = 'none';
            });
        });
    </script>
@endsection
