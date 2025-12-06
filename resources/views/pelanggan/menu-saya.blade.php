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
                                <a href="/pesanan" class="nav-link {{ Request::is('pesanan-saya') ? 'active' : '' }}">
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

                <!-- Nav Tabs -->
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold" id="profil-tab" 
                            data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab">
                            <i class="fas fa-user me-1"></i>&nbsp; Profil
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="password-tab" 
                            data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                            <i class="fas fa-key me-1"></i>&nbsp; Ubah Password
                        </button>
                    </li>
                </ul>
            
                <div class="tab-content" id="profileTabsContent">
            
                    <!-- TAB PROFIL -->
                    <div class="tab-pane fade show active" id="profil" role="tabpanel">
            
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body p-4">
            
                                <h3 class="fw-semibold mb-2">Profil Saya</h3>
                                <hr class="mt-0 mb-4">
            
                                <div class="profile-form">
            
                                    <!-- Username -->
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-2 fw-semibold label-col">Username</div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control form-control-sm" name="username"
                                                   value="{{ Auth::guard('pelanggan')->user()->username }}">
                                        </div>
                                    </div>
            
                                    <!-- Email -->
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-2 fw-semibold label-col">Email</div>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control form-control-sm" name="email"
                                                   value="{{ Auth::guard('pelanggan')->user()->email }}">
                                        </div>
                                    </div>
            
                                    <!-- No HP -->
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-2 fw-semibold label-col">No. HP</div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control form-control-sm" name="no_hp"
                                                   value="{{ Auth::guard('pelanggan')->user()->no_hp }}">
                                        </div>
                                    </div>
            
                                    <!-- Jenis Kelamin -->
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-2 fw-semibold label-col m-0 d-flex align-items-center">
                                            Jenis Kelamin
                                        </label>
                                        <div class="col-md-10">
                                            <div class="d-flex align-items-center" style="column-gap: 40px;">

                                                <!-- Laki-Laki -->
                                                <div class="form-check d-flex align-items-center">
                                                    <input class="form-check-input" type="radio" name="jk" id="jk_l"
                                                        value="Laki-Laki" style="margin-top:0;"
                                                        {{ Auth::guard('pelanggan')->user()->jk == 'L' ? 'checked' : '' }}>
                                                    <label class="form-check-label ms-2" for="jk_l"
                                                        style="line-height:1;">Laki-Laki</label>
                                                </div>
        
                                                <!-- Perempuan -->
                                                <div class="form-check d-flex align-items-center">
                                                    <input class="form-check-input" type="radio" name="jk" id="jk_p"
                                                        value="Perempuan" style="margin-top:0;"
                                                        {{ Auth::guard('pelanggan')->user()->jk == 'P' ? 'checked' : '' }}>
                                                    <label class="form-check-label ms-2" for="jk_p"
                                                        style="line-height:1;">Perempuan</label>
                                                </div>
        
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                            Simpan Perubahan
                                        </button>
                                    </div>
            
                                </div>
            
                            </div>
                        </div>
            
                    </div>
            
                    <!-- TAB UBAH PASSWORD -->
                    <div class="tab-pane fade" id="password" role="tabpanel">
            
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body p-4">
            
                                <h3 class="fw-semibold mb-2">Ubah Password</h3>
                                <hr class="mt-0 mb-4">
            
                                <div class="profile-form">
            
                                    <!-- Password Lama -->
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3 fw-semibold label-col">Password Lama</div>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control form-control-sm" name="password_lama">
                                        </div>
                                    </div>
            
                                    <!-- Password Baru -->
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3 fw-semibold label-col">Password Baru</div>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control form-control-sm" name="password_baru">
                                        </div>
                                    </div>
            
                                    <!-- Konfirmasi Password -->
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3 fw-semibold label-col">Konfirmasi</div>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control form-control-sm" name="password_konfirmasi">
                                        </div>
                                    </div>
            
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                            Update Password
                                        </button>
                                    </div>
            
                                </div>
            
                            </div>
                        </div>
            
                    </div>
            
                </div>
            
            </div>
            
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                
                    const tabButtons = document.querySelectorAll("#profileTabs .nav-link");
                    const tabPanes = document.querySelectorAll(".tab-pane");
                
                    tabButtons.forEach(button => {
                        button.addEventListener("click", function () {
                
                            // ==== HILANGKAN ACTIVE DI SEMUA BUTTON ====
                            tabButtons.forEach(btn => btn.classList.remove("active"));
                
                            // ==== HILANGKAN ACTIVE DI SEMUA TAB ====
                            tabPanes.forEach(pane => {
                                pane.classList.remove("active", "show");
                            });
                
                            // ==== AKTIFKAN BUTTON YANG DIKLIK ====
                            this.classList.add("active");
                
                            // Target tab
                            const targetSelector = this.getAttribute("data-bs-target");
                            const targetPane = document.querySelector(targetSelector);
                
                            // ==== TAMPILKAN TAB YANG SESUAI ====
                            if (targetPane) {
                                targetPane.classList.add("active");
                
                                // Delay dikit biar animasi fade jalan
                                setTimeout(() => {
                                    targetPane.classList.add("show");
                                }, 10);
                            }
                        });
                    });
                
                });
                </script>
                
            



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
    <script>
        console.log('Halaman Akun Pelanggan dimuat');
    </script>
@endsection
