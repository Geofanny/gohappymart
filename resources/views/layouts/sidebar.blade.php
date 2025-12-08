<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand d-flex align-items-center text-decoration-none"
                style="gap: 10px; margin-left:-12px">

                <!-- Logo -->
                <div class="d-flex align-items-center justify-content-center" style="height: 48px;">
                    <img src="{{ asset('../assets/images/logo-toko.png') }}" alt="Logo Toko" class="img-fluid"
                        style="height: 45px; width: auto; object-fit: contain;">
                </div>

                <!-- Nama Toko -->
                <span class="text-dark"
                    style="font-family: 'Baloo 2', 'Poppins', sans-serif;
               font-size: 1.4rem;
               font-weight: 600;
               letter-spacing: 0.3px;
               line-height: 1;
               display: flex;
               align-items: center;
               height: 45px;">
                    Go Happy Mart
                </span>
            </a>

        </div>
        <div class="navbar-content">
            <ul class="pc-navbar mb-2">

                @if(Auth::user()->role === 'admin')
                    <li class="pc-item">
                        <a href="/dashboard/admin" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role === 'superadmin')
                    <li class="pc-item">
                        <a href="/dashboard/superadmin" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role === 'superadmin')
                    <li class="pc-item pc-caption">
                        <label>Toko</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    
                    <li class="pc-item">
                        <a href="/dashboard/toko/profil" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-building-store"></i></span>
                            <span class="pc-mtext">Profil Toko</span>
                        </a>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-box"></i></span>
                            <span class="pc-mtext">Katalog</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/dashboard-admin/produk">Produk</a></li>
                            <li class="pc-item"><a class="pc-link" href="/dashboard-admin/kategori">Kategori</a></li>
                            <li class="pc-item"><a class="pc-link" href="/dashboard-admin/stok">Stok</a></li>
                        </ul>
                    </li>
                    
                    <li class="pc-item">
                        <a href="/dashboard/daftarAdmin" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-users"></i></span>
                            <span class="pc-mtext">Admin</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="/dashboard/rating/toko" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-star"></i></span>
                            <span class="pc-mtext"> Rating</span>
                        </a>
                    </li>
                    
                    <li class="pc-item">
                        <a href="/dashboard-superadmin/regulasi" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                            <span class="pc-mtext">Kebijakan</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role === 'admin')
                    <li class="pc-item pc-caption">
                        <label>Manajemen</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
        
                    <li class="pc-item pc-hasmenu">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-box"></i></span>
                            <span class="pc-mtext">Katalog</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/dashboard-admin/produk">Produk</a></li>
                            <li class="pc-item"><a class="pc-link" href="/dashboard-admin/kategori">Kategori</a></li>
                            <li class="pc-item"><a class="pc-link" href="/dashboard-admin/stok">Stok</a></li>
                        </ul>
                    </li>

                    <li class="pc-item">
                        <a href="/dashboard/pelanggan" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-users"></i>
                            </span>
                            <span class="pc-mtext">Pelanggan</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role === 'admin')
                    <li class="pc-item">
                        <a href="/dashboard/berita" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-news"></i></span>
                            <span class="pc-mtext">Berita</span>
                        </a>
                    </li>
                @endif

            
                @if(Auth::user()->role === 'admin')
                    <li class="pc-item pc-caption">
                        <label>Pemesanan</label>
                        <i class="ti ti-dashboard"></i>
                    </li>

                    <li class="pc-item"><a class="pc-link" href="/dashboard/pesanan">
                        <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span>
                        <span class="pc-mtext">Pesanan</span>
                    </a></li>

                    <li class="pc-item"><a class="pc-link" href="/dashboard/pengiriman">
                        <span class="pc-micon"><i class="ti ti-truck"></i></span>
                        <span class="pc-mtext">Pengiriman</span>
                    </a></li>

                    <li class="pc-item"><a class="pc-link" href="/dashboard/pembayaran">
                        <span class="pc-micon"><i class="ti ti-cash"></i></span>
                        <span class="pc-mtext">Pembayaran</span>
                    </a></li>

                    <li class="pc-item">
                        <a class="pc-link" href="/dashboard/pengembalian">
                        <span class="pc-micon"><i class="ti ti-report"></i></span>
                        <span class="pc-mtext">Pengembalian</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Promo</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item">
                        <a href="/produk-promo" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-ticket"></i></span>
                            <span class="pc-mtext">Diskon</span>
                        </a>
                    </li>
                    
                    <li class="pc-item">
                        <a href="/flashsale" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-alarm"></i></span>
                            <span class="pc-mtext">Flash Sale</span>
                        </a>
                    </li>
                    
                    <li class="pc-item">
                        <a href="/bigsale" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-flame"></i></span>
                            <span class="pc-mtext">Big Sale</span>
                        </a>
                    </li>
                    
                    
                @endif
                
                @if(Auth::user()->role === 'superadmin')
                    <li class="pc-item pc-caption">
                        <label>Promo</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#" class="pc-link"><span class="pc-micon"><i class="ti ti ti-ticket"></i></span><span
                                class="pc-mtext"> Diskon</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/dashboard-superadmin/diskon">Daftar Diskon</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="/produk-promo">Diskon Produk</a></li>
                            <li class="pc-item"><a class="pc-link" href="/flashsale">Flash Sale</a></li>
                            <li class="pc-item"><a class="pc-link" href="/bigsale">Big Sale</a></li>
                        </ul>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Laporan</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item">
                        <a href="/dashboard/laporan/keuangan" class="pc-link">
                            <span class="pc-micon"><i class="ti ti ti-file-invoice"></i></span>
                            <span class="pc-mtext">Keuangan</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role === 'admin')
                    <li class="pc-item pc-caption">
                        <label>Review & Bantuan</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item">
                        <a href="/dashboard/rating" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-star"></i></span>
                            <span class="pc-mtext"> Rating</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="/dashboard-admin/faq" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-message-circle"></i></span>
                            <span class="pc-mtext"> FAQ</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Laporan</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item">
                        <a href="/dashboard/laporan/penjualan" class="pc-link">
                            <span class="pc-micon"><i class="ti ti ti-file-invoice"></i></span>
                            <span class="pc-mtext">Penjualan</span>
                        </a>
                    </li>
                @endif
            </ul>
           
        </div>
    </div>
</nav>
