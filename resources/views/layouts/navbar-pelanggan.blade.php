 <!--================ Start Header Menu Area =================-->
 <header class="header_area">
     <div class="main_menu">
         <nav class="navbar navbar-expand-lg navbar-light">
             <div class="container">
                <a class="navbar-brand logo_h d-flex align-items-center" style="gap: 10px;" href="/">
                    <img src="{{ asset('assets-user') }}/img/logo-toko.png" alt="Logo" width="50" class="me-2">
                    <span class="fw-bold fs-5" style="font-weight: 500">Go Happy Mart</span>
                  </a>                  
                 <button class="navbar-toggler" type="button" data-toggle="collapse"
                     data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                     aria-label="Toggle navigation">
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                 </button>
                 <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                     <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
                        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                            <a class="nav-link" href="/">Beranda</a>
                        </li>
                        <li class="nav-item submenu dropdown {{ Request::is('berita*') ? 'active' : '' }}">
                            <a href="/berita" class="nav-link">Berita</a>
                        </li>
                    
                        <li class="nav-item submenu dropdown {{ Request::is('tentang-kami') ? 'active' : '' }}">
                            <a href="/tentang-kami" class="nav-link">Tentang Kami</a>
                        </li>
                    
                        <li class="nav-item {{ Request::is('kontak') ? 'active' : '' }}">
                            <a class="nav-link" href="/kontak">Kontak</a>
                        </li>
                     </ul>

                     <ul class="nav-shop">
                         {{-- <li class="nav-item"><button><i class="ti-search"></i></button></li>
                         <li class="nav-item"><button><i class="ti-shopping-cart"></i><span
                                     class="nav-shop__circle">3</span></button> </li>
                         <li class="nav-item">
                             <button>
                                 <i class="ti-heart"></i>
                                 <span class="nav-shop__circle">3</span>
                             </button>
                         </li>
                         <li class="nav-item">
                            <button class="btn-bantuan">
                                <i class="ti-help-alt" style="font-size: 18px; color: #333;margin-right: 5vh;"></i>
                            </button>
                        </li> --}}
                        @php
                        use Illuminate\Support\Facades\Auth;
                    @endphp
                    
                    @if (Auth::guard('pelanggan')->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false"
                            style="
                                font-weight:600;
                                color:#fff;
                                background-color:#007bff;
                                border:1px solid #007bff;
                                border-radius:30px;
                                padding:6px 16px;
                                transition:all 0.3s ease;
                                gap:10px;
                                box-shadow:0 2px 6px rgba(0,0,0,0.15);
                            "
                            onmouseover="this.style.backgroundColor='#0069d9';"
                            onmouseout="this.style.backgroundColor='#007bff';"
                        >
                            <i class="fas fa-user-circle" style="font-size:20px; color:#fff;"></i>
                            <span style="font-size:14px; color:#fff;">
                                {{ Str::limit(Auth::guard('pelanggan')->user()->nama_pelanggan, 16) }}
                            </span>
                        </a>
                    
                        <ul class="dropdown-menu dropdown-menu-custom mt-2" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item-custom" href="/profil">
                                    Profil
                                </a>
                                <a class="dropdown-item-custom" href="/pesanan">
                                    Pesanan Saya
                                </a>
                                <a class="dropdown-item-custom" href="/logout">
                                    Keluar
                                </a>
                            </li>
                        </ul>
                    
                        <style>
                            /* 🔹 Style khusus dropdown buatan sendiri */
                            .dropdown-menu-custom {
                                border-radius: 12px;
                                min-width: 170px;
                                font-size: 14px;
                                border: 1px solid #f1f1f1;
                                padding: -6px; /* hilangkan padding besar dari template */
                                background-color: #fff;
                                text-align: left !important;
                            }
                    
                            .dropdown-item-custom {
                                display: flex;
                                align-items: center;
                                justify-content: flex-start;
                                gap: 8px;
                                padding: 6px;
                                color: #333;
                                text-decoration: none;
                                transition: all 0.2s ease;
                                border-radius: 6px;
                                font-weight: 500;
                            }
                    
                            .dropdown-item-custom i {
                                width: 18px;
                                text-align: left;
                            }
                    
                            .dropdown-item-custom:hover {
                                background-color: #f0f4ff;
                                color: #0d6efd !important;
                            }
                    
                            .dropdown-item-custom.text-danger:hover {
                                background-color: #ffe6e6;
                                color: #dc3545 !important;
                            }
                    
                            /* 🔹 Hapus padding/center bawaan li */
                            .dropdown-menu-custom li {
                                margin: 0;
                                padding: 0;
                                text-align: left !important;
                            }
                        </style>
                    </li>
                    
                    
                    @else
                        <li class="nav-item">
                            <a class="button button-header btn-signup" href="/login">Masuk</a>
                        </li>
                    @endif
                    
                         <style>
                             .btn-signup {
                                 background-color: #007bff;
                                 /* Warna background tombol */
                                 color: #fff !important;
                                 padding: 8px 18px;  
                                 /* Warna teks */
                             }

                             .btn-signup:hover {
                                 background-color: #0056b3;
                                 /* Warna saat hover */
                                 transform: translateY(-2px);
                                 box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
                             }
                         </style>
                     </ul>
                 </div>
             </div>
         </nav>
     </div>
 </header>
 <!--================ End Header Menu Area =================-->
