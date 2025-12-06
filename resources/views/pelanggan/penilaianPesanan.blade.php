@extends('layouts/main-pelanggan-no-footer')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <div class="container py-5">
        <div class="row">
            <!-- 🔹 Sidebar Kiri -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
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
                <form action="{{ route('ulasan.store', $pesanan->id_pesanan) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Banner Penilaian -->
                    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body py-4" style="border-radius: 12px; border-left: 4px solid #0d6efd;">

                            <h4 class="fw-bold mb-2" style="color: #1e1e1e;">
                                Berikan Penilaian Anda
                            </h4>

                            <p class="mb-0 text-muted" style="font-size: 15px;">
                                Ulasan Anda membantu meningkatkan kualitas produk dan pelayanan agar pengalaman belanja Anda
                                semakin baik.
                            </p>

                        </div>
                    </div>

                    <!-- Card Penilaian Produk -->
                    <div class="card mb-4 shadow-sm border-0" style="border-radius: 10px;">
                        <div class="card-body" style="border-left: 4px solid #0d6efd; border-radius: 10px;">

                            <h5 class="fw-bold mb-3">Penilaian Produk</h5>

                            @foreach ($pesanan->produk as $item)
                                <!-- =============== PRODUK 1 =============== -->
                                <div class="p-3 mb-4 border rounded produk-card"
                                    style="border-radius: 8px; border-left: 3px solid #0d6efd;">

                                    <input type="hidden" name="produk_id[]" value="{{ $item->produk->id_produk }}">

                                    <div class="d-flex">
                                        <div style="width: 100px; height: 100px; border-radius: 8px; overflow: hidden;">
                                            <img src="{{ asset('storage/uploads/produk/' . $item->produk->gambar) }}"
                                                class="img-fluid" alt="Produk 1"
                                                style="width:90px; height:90px; object-fit:cover;">
                                        </div>

                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="fw-semibold mb-1">{{ $item->produk->nama_produk }}</h6>

                                            <div class="d-flex align-items-center">
                                                <label class="fw-semibold me-2 mr-1 mb-0">Rating:</label>

                                                <span class="rate-produk" data-value="1">&#9733;</span>
                                                <span class="rate-produk" data-value="2">&#9733;</span>
                                                <span class="rate-produk" data-value="3">&#9733;</span>
                                                <span class="rate-produk" data-value="4">&#9733;</span>
                                                <span class="rate-produk" data-value="5">&#9733;</span>

                                                <input type="hidden" name="rating_produk[]" class="rating-produk"
                                                    value="0">

                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <label class="fw-semibold">Ulasan Produk</label>
                                    <textarea class="form-control mb-3" rows="2" name="ulasan_produk[]"
                                        placeholder="Tulis ulasan untuk produk ini..."></textarea>


                                    <label class="fw-semibold">Foto/Video (Opsional)</label>

                                    <div class="upload-wrapper" data-index="{{ $loop->index }}">

                                        <!-- Upload Box -->
                                        <div class="upload-card d-flex flex-column align-items-center mb-3 justify-content-center p-3 border rounded upload-trigger"
                                            style="width: 100%; height: 130px; cursor: pointer; border-radius: 8px;">

                                            <input type="file" class="d-none upload-input"
                                                name="foto_produk[{{ $loop->index }}][]" accept="image/*,video/*" multiple>

                                            <div class="text-center">
                                                <i class="fa-regular fa-image" style="font-size: 34px; color: #999;"></i>
                                            </div>
                                            <p class="mt-2 mb-0 text-muted" style="font-size: 14px;">Tambah Foto</p>
                                        </div>

                                        <!-- Preview Container -->
                                        <div class="preview-container d-flex flex-wrap gap-2 mb-2 " style="gap: 2vh;"></div>

                                    </div>


                                </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- Card Penilaian Toko -->
                    <div class="card mb-4 shadow-sm border-0" style="border-radius: 10px;">
                        <div class="card-body" style="border-left: 4px solid #0d6efd; border-radius: 10px;">

                            <h5 class="fw-bold mb-3">Penilaian Toko</h5>

                            <div class="mb-3">
                                <label class="fw-semibold">Rating Pelayanan:</label>
                                <div class="mt-1">
                                    <span class="rate-toko" data-value="1">&#9733;</span>
                                    <span class="rate-toko" data-value="2">&#9733;</span>
                                    <span class="rate-toko" data-value="3">&#9733;</span>
                                    <span class="rate-toko" data-value="4">&#9733;</span>
                                    <span class="rate-toko" data-value="5">&#9733;</span>
                                    <input type="hidden" name="rating_toko" id="ratingToko" value="0">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-semibold">Ulasan Toko</label>
                                <textarea class="form-control" rows="3" name="ulasan_toko"
                                    placeholder="Bagaimana pengalamanmu berbelanja di toko ini?"></textarea>
                            </div>

                        </div>
                    </div>

                    <!-- Submit Box -->
                    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body py-4 d-flex justify-content-between align-items-center"
                            style="border-radius: 12px; border-left: 4px solid #0d6efd;">

                            <!-- Kiri: Pertanyaan -->
                            <div>
                                <h5 class="fw-bold mb-1">Sudah yakin dengan penilaian Anda?</h5>
                                <p class="text-muted mb-0" style="font-size: 14px;">
                                    Periksa kembali rating dan ulasan sebelum mengirim.
                                </p>
                            </div>

                            <!-- Kanan: Tombol -->
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold"
                                style="border-radius: 8px;">
                                Kirim Penilaian
                            </button>

                        </div>
                    </div>
                </form>



                <style>
                    .rate-produk {
                        font-size: 24px;
                        cursor: pointer;
                        margin-right: 4px;
                        color: #d1d1d1;
                        transition: color 0.2s;
                    }

                    .rate-produk.active {
                        color: #f1b500;
                    }

                    .rate-toko {
                        font-size: 24px;
                        cursor: pointer;
                        margin-right: 4px;
                        color: #d1d1d1;
                        transition: color 0.2s;
                    }

                    .rate-toko.active {
                        color: #f1b500;
                    }

                    .preview-box {
                        width: 110px;
                        height: 110px;
                        border-radius: 8px;
                        position: relative;
                        overflow: hidden;
                        border: 3px solid #cac5c5;
                    }

                    .preview-box img,
                    .preview-box video {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }

                    .preview-remove {
                        position: absolute;
                        top: 4px;
                        right: 4px;
                        background: rgba(0, 0, 0, 0.6);
                        color: white;
                        width: 22px;
                        height: 22px;
                        border-radius: 50%;
                        font-size: 14px;
                        text-align: center;
                        cursor: pointer;
                        line-height: 22px;
                    }

                    .loading-small {
                        position: absolute;
                        inset: 0;
                        background: rgba(255, 255, 255, 0.6);
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        font-size: 12px;
                        color: #333;
                        z-index: 10;
                    }

                    /* Circular progress bar */
                    .circular-progress {
                        width: 60px;
                        height: 60px;
                        position: relative;
                    }

                    .circular-progress svg {
                        transform: rotate(-90deg);
                        width: 100%;
                        height: 100%;
                    }

                    .circular-progress circle {
                        fill: none;
                        stroke-width: 6;
                        stroke-linecap: round;
                    }

                    .circular-progress .bg {
                        stroke: #ddd;
                    }

                    .circular-progress .progress {
                        stroke: #0d6efd;
                        stroke-dasharray: 2 * 3.1416 * 27;
                        /* 2πr dengan r = 27 */
                        stroke-dashoffset: 2 * 3.1416 * 27;
                        transition: stroke-dashoffset 0.3s linear;
                    }

                    .circular-progress .progress-text {
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        font-size: 12px;
                        font-weight: bold;
                    }
                </style>


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
        document.addEventListener("DOMContentLoaded", function() {

            const stars = document.querySelectorAll('.rate-toko');
            const target = document.getElementById('ratingToko');

            stars.forEach(star => {
                star.addEventListener('click', function() {

                    let value = this.getAttribute('data-value');
                    target.value = value;

                    stars.forEach(s => s.classList.remove('active'));
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add('active');
                    }
                });
            });

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Ambil semua container produk
            const productCards = document.querySelectorAll('.produk-card');

            productCards.forEach(card => {
                const stars = card.querySelectorAll('.rate-produk');
                const target = card.querySelector('.rating-produk');

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        let value = this.getAttribute('data-value');

                        target.value = value;

                        // Reset semua bintang pada produk ini
                        stars.forEach(s => s.classList.remove('active'));

                        // Set aktif sesuai value
                        for (let i = 0; i < value; i++) {
                            stars[i].classList.add('active');
                        }
                    });
                });
            });

        });
    </script>
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Simpan file berdasarkan index produk
            const fileStorage = {};

            document.querySelectorAll(".upload-wrapper").forEach(wrapper => {

                const index = wrapper.dataset.index;
                fileStorage[index] = []; // array file untuk produk ini

                const fileInput = wrapper.querySelector(".upload-input");
                const uploadTrigger = wrapper.querySelector(".upload-trigger");
                const previewContainer = wrapper.querySelector(".preview-container");

                uploadTrigger.addEventListener("click", () => fileInput.click());

                // Ketika memilih file baru
                fileInput.addEventListener("change", function() {

                    const newFiles = Array.from(this.files);

                    // Masukkan file asli ke storage
                    newFiles.forEach(file => fileStorage[index].push(file));

                    // Render preview
                    newFiles.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {

                            const box = document.createElement("div");
                            box.classList.add("preview-box");

                            let media;

                            if (file.type.startsWith("video")) {
                                media = document.createElement("video");
                                media.src = e.target.result;
                                media.controls = true;
                            } else {
                                media = document.createElement("img");
                                media.src = e.target.result;
                            }

                            const removeBtn = document.createElement("div");
                            removeBtn.classList.add("preview-remove");
                            removeBtn.innerHTML = "&times;";

                            removeBtn.onclick = () => {
                                box.remove();

                                // hapus file dari storage
                                fileStorage[index] = fileStorage[index].filter(f =>
                                    f !== file);

                                // rebuild input file
                                rebuildInput(fileInput, fileStorage[index]);
                            };

                            box.appendChild(media);
                            box.appendChild(removeBtn);
                            previewContainer.appendChild(box);
                        };

                        reader.readAsDataURL(file);
                    });

                    // Set input sesuai storage
                    rebuildInput(fileInput, fileStorage[index]);
                });
            });

            // rebuild input tanpa async
            function rebuildInput(input, filesArray) {
                const dataTransfer = new DataTransfer();

                filesArray.forEach(f => dataTransfer.items.add(f));

                input.files = dataTransfer.files;
            }

        });
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileStorage = {};

            document.querySelectorAll(".upload-wrapper").forEach(wrapper => {
                const index = wrapper.dataset.index;
                fileStorage[index] = [];

                const fileInput = wrapper.querySelector(".upload-input");
                const uploadTrigger = wrapper.querySelector(".upload-trigger");
                const previewContainer = wrapper.querySelector(".preview-container");

                uploadTrigger.addEventListener("click", () => fileInput.click());

                fileInput.addEventListener("change", function() {
                    const newFiles = Array.from(this.files);

                    newFiles.forEach(file => {
                        fileStorage[index].push(file);

                        // ==== buat box kosong ====
                        const box = document.createElement("div");
                        box.classList.add("preview-box");

                        // ==== media element sembunyi dulu ====
                        let media;
                        if (file.type.startsWith("video")) {
                            media = document.createElement("video");
                            media.controls = true;
                            media.style.display = "none";
                        } else {
                            media = document.createElement("img");
                            media.style.display = "none";
                        }
                        box.appendChild(media);
                        previewContainer.appendChild(box);

                        // ==== loading overlay circular progress ====
                        const loading = document.createElement("div");
                        loading.classList.add("loading-small");
                        loading.innerHTML = `
                            <div class="circular-progress">
                                <svg>
                                    <circle class="bg" cx="30" cy="30" r="27"></circle>
                                    <circle class="progress" cx="30" cy="30" r="27"></circle>
                                </svg>
                                <div class="progress-text">0%</div>
                            </div>
                        `;
                        box.appendChild(loading);

                        const progressCircle = loading.querySelector(".progress");
                        const progressText = loading.querySelector(".progress-text");
                        const radius = 27;
                        const circumference = 2 * Math.PI * radius;
                        progressCircle.style.strokeDasharray = circumference;
                        progressCircle.style.strokeDashoffset = circumference;

                        // ==== simulasi progress kelipatan 5% dengan jeda ====
                        let progress = 0;
                        const step = 5; // kelipatan 5%
                        const stepDelay = 1500; // jeda tiap step ms

                        const interval = setInterval(() => {
                            if (progress < 100) {
                                progress += step;
                                if (progress > 100) progress = 100;

                                progressText.textContent = progress + "%";
                                progressCircle.style.strokeDashoffset =
                                    circumference * (1 - progress / 100);
                            } else {
                                clearInterval(interval);
                            }
                        }, stepDelay);

                        // ==== baca file ====
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            media.src = e.target.result;
                            media.onload = () => {
                                const remainingSteps = (100 - progress) / step;
                                setTimeout(() => {
                                    loading.remove();
                                    media.style.display = "block";
                                }, remainingSteps * stepDelay);
                            };
                        };
                        reader.readAsDataURL(file);

                        // Tombol hapus
                        const removeBtn = document.createElement("div");
                        removeBtn.classList.add("preview-remove");
                        removeBtn.innerHTML = "&times;";
                        removeBtn.onclick = () => {
                            clearInterval(interval);
                            box.remove();
                            fileStorage[index] = fileStorage[index].filter(f => f !==
                                file);
                            rebuildInput(fileInput, fileStorage[index]);
                        };
                        box.appendChild(removeBtn);
                    });

                    rebuildInput(fileInput, fileStorage[index]);
                });
            });

            function rebuildInput(input, filesArray) {
                const dt = new DataTransfer();
                filesArray.forEach(f => dt.items.add(f));
                input.files = dt.files;
            }
        });
    </script>
@endsection
