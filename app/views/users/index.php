<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GO Happy Mart - Home</title>
	<link rel="icon" href="/gohappymart/public/assets/users/img/Fevicon_gohappymart.jpg" type="image/png">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/nice-select/nice-select.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/owl-carousel/owl.carousel.min.css">

  <link rel="stylesheet" href="/gohappymart/public/assets/users/css/style.css">
  <head>
  ...
  <style>
    /* CSS tombol overlay */
    .card-product__img {
      position: relative !important;
      overflow: hidden !important;
    }

    .card-product__imgOverlay {
      position: absolute !important;
      bottom: 1px !important;
      left: 50% !important;
      transform: translateX(-50%) !important;
      display: flex !important;
      justify-content: center !important;
      align-items: center !important;
      gap: 12px !important;
      padding: 0 !important;
      margin: 0 !important;
      list-style: none !important;
      opacity: 0 !important;
      transition: opacity 0.3s ease !important;
      z-index: 10 !important;
    }

    .card-product__img:hover .card-product__imgOverlay {
      opacity: 1 !important;
    }

    .card-product__imgOverlay button {
      background: #3758f9 !important;
      color: #fff !important;
      border: none !important;
      border-radius: 50% !important;
      width: 45px !important;
      height: 45px !important;
      font-size: 18px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      cursor: pointer !important;
      transition: 0.2s !important;
    }

    .card-product__imgOverlay button:hover {
      background: #2d4ae3 !important;
      transform: scale(1.05) !important;
    }

    .card-product__imgOverlay button:active {
      background: #1e34b7 !important;
      transform: scale(0.95) !important;
    }
  </style>
</head>
<body>
  <!--================ Start Header Menu Area =================-->
	<header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand logo_h" href="index.html"><img src="/gohappymart/public/assets/users/img/logo_gohappymart.jpg" style="height:85px; width:auto alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <li class="nav-item active"><a class="nav-link" href="index.html">Home</a></li>
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Shop</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="category.html">Shop Category</a></li>
                  <li class="nav-item"><a class="nav-link" href="single-product.html">Product Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="checkout.html">Product Checkout</a></li>
                  <li class="nav-item"><a class="nav-link" href="confirmation.html">Confirmation</a></li>
                  <li class="nav-item"><a class="nav-link" href="cart.html">Shopping Cart</a></li>
                </ul>
							</li>
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Blog</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                  <li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a></li>
                </ul>
							</li>
							<li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Pages</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                  <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
                  <li class="nav-item"><a class="nav-link" href="tracking-order.html">Tracking</a></li>
                </ul>
              </li>
              <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
            </ul>

            <ul class="nav-shop">
              <li class="nav-item"><button><i class="ti-search"></i></button></li>
              <li class="nav-item"><button><i class="ti-shopping-cart"></i><span class="nav-shop__circle">3</span></button> </li>
              <li class="nav-item"><a class="button button-header" href="#">Buy Now</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
	<!--================ End Header Menu Area =================-->

  <main class="site-main">
    
    <!--================ Hero banner start =================-->
    <section class="hero-banner">
      <div class="container">
        <div class="row no-gutters align-items-center pt-60px">
          <div class="col-5 d-none d-sm-block">
            <div class="hero-banner__img">
              <img class="img-fluid" src="/gohappymart/public/assets/users/img/home/hero-banner.png" alt="">
            </div>
          </div>
          <div class="col-sm-7 col-lg-6 offset-lg-1 pl-4 pl-md-5 pl-lg-0">
            <div class="hero-banner__content">
              <h5 class="mb-2" style="opacity: 0.9;">💧 Bersih, Cepat, dan Praktis!</h5>
              <h1 style="font-weight: 800; line-height: 1.2; color: #87cefa;">
                Belanja <span style="color:#00008b; text-shadow: 2px 2px 4px rgba(100,150,255,0.4);">Perlengkapan Laundry</span><br>Jadi Lebih Mudah
              </h1>
              <p>Dapatkan semua perlengkapan laundry terbaik tanpa ribet — tinggal klik, langsung bersih.</p>
              <a class="button button-hero" href="category.php">Lihat Produk</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================ Hero banner start =================-->

    <!--================ Category Section Start =================-->
    <section class="section-margin mt-0" style="background-color: #fbfeffff; padding: 60px 0;">
      <div class="container">
        
        <div class="section-intro pb-4">
          <h2 class="mb-4" style="font-size:26px; font-weight:700; color:#333;">Kategori</h2>
        </div>

        <div class="row text-center justify-content-center">
          <?php
            require_once __DIR__ . '/../../config/database.php';
            $db = new Database();
            $db->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
            $db->execute();
            $kategori = $db->resultObject();
          ?>

          <?php if (!empty($kategori)): ?>
            <?php foreach ($kategori as $kat): ?>
              <div class="col-4 col-sm-3 col-md-2 mb-4">
                <div class="category-item">
                  <a href="category.php" style="text-decoration:none;">
                    <div class="category-icon" 
                      style="width:85px; height:85px; background:white; border-radius:50%; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin:0 auto;">
                        <img src="/gohappymart/public/assets/users/img/<?php echo htmlspecialchars($kat->img ?? 'default.png'); ?>" 
                          alt="<?php echo htmlspecialchars($kat->nama_kategori); ?>" 
                          style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <p class="category-name mt-2 mb-0" 
                      style="font-size:13px; color:#333; font-weight:500;">
                      <?php echo htmlspecialchars($kat->nama_kategori); ?>
                    </p>
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12 text-center">
              <p>Belum ada kategori tersedia.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!--================ Category Section End =================-->


    <!-- ================ trending product section start ================= -->  
    <section class="section-margin calc-60px">
      <div class="container">
        <div class="section-intro pb-60px">
          <p>Produk Ter Populer Go Happy Mart</p>
          <h2>Produk <span class="section-intro__style">Populer💕</span></h2>
        </div>

        <div class="row justify-content-start g-4">
          <?php
            require_once __DIR__ . '/../../config/database.php';
            $db = new Database();

            $db->query("
              SELECT 
                p.*, 
                k.nama_kategori,
                SUM(d.jumlah) AS total_terjual
              FROM produk p
              JOIN pesanan_produk d ON p.id_produk = d.id_produk
              LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
              WHERE p.status = 'aktif'
              GROUP BY p.id_produk
              HAVING total_terjual > 0
              ORDER BY total_terjual DESC
              LIMIT 8
            ");
            $db->execute();
            $produk_populer = $db->resultObject();
          ?>

          <?php if (!empty($produk_populer)): ?>
            <?php foreach ($produk_populer as $p): ?>
              <div class="col-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                <div class="card text-center card-product" style="border:none; box-shadow:none; border-radius:0px; overflow:hidden; background:#fff; height: 370px;">
                  <div class="card-product__img position-relative" 
                    style="border:none; box-shadow:none; background:none;">
                    <img 
                      src="/gohappymart/public/assets/users/img/<?php echo $p->gambar; ?>" 
                      alt="<?php echo $p->nama_produk; ?>" 
                      class="img-fluid"
                      style="height: 250px; object-fit: cover; width: 100%; border:none; outline:none; box-shadow:none;"
                    >
                    <ul class="card-product__imgOverlay">
                      <li><button class="icon_btn"><i class="ti-search"></i></button></li>
                      <li><button class="icon_btn"><i class="ti-shopping-cart"></i></button></li>
                      <li><button class="icon_btn"><i class="ti-heart"></i></button></li>
                    </ul>
                  </div>
                  <div class="card-body" style="padding-top: 8px; padding-bottom: 8px; line-height: 1.1;">
                    <p class="text-muted mb-1" style="margin: 10px 0 0 0; font-size: 14px;">
                      <?php echo $p->nama_kategori; ?>
                    </p>
                    <h4 class="card-product__title" style="font-size: 18px; margin: 4px 0 2px 0; line-height: 1.3;">
                      <a href="single-product.php" style="text-decoration:none;">
                        <?php echo $p->nama_produk; ?>
                      </a>
                    </h4>
                    <br>
                    <p class="card-product__price" style="margin-top: 2px; font-size: 15px; line-height: 1.2;">
                      <strong>Rp <?php echo number_format($p->harga, 0, ',', '.'); ?></strong>
                    </p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <!-- ================ trending product section end ================= -->  


    <!-- ================ Berita Start ================= -->
     <section class="section-margin calc-60px" style="background-color: #e9f3ff; padding: 60px 0;">
      <div class="container">
        <div class="section-intro pb-60px text-center berita-intro">
          <p>Kabar Terbaru Dari GoHappyMart</p>
          <h2>Berita <span class="section-intro__style">Terkini</span></h2>
        </div>


        <?php
          require_once __DIR__ . '/../../config/database.php';
          $db = new Database();

          $db->query("
            SELECT 
              b.id_berita,
              b.judul,
              b.isi,
              b.tanggal_publikasi,
              u.nama_user
            FROM berita b
            LEFT JOIN users u ON b.id_user = u.id_user
            WHERE b.status = 'publish'
            ORDER BY b.tanggal_publikasi DESC
            LIMIT 3
          ");
          $db->execute();
          $berita = $db->resultObject();
        ?>

        <div class="row">
          <?php if (!empty($berita)): ?>
            <?php foreach ($berita as $news): ?>
              <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm" 
                    style="border-radius:10px; overflow:hidden; background-color: #fff;">
              
                    <!-- 🖼️ Gambar Berita -->
                    <img 
                      src="/gohappymart/public/assets/users/img/default-news.jpg" 
                      alt="<?= htmlspecialchars($news->judul) ?>" 
                      style="width:100%; height:220px; object-fit:cover;"
                    >

                    <div class="card-body" style="padding: 20px;">
                      <div class="d-flex mb-2" style="font-size: 14px; color: #777;">
                        <span>By <?= htmlspecialchars($news->nama_user ?? 'Admin') ?></span>
                      </div>

                      <!-- 📰 Judul -->
                      <h5 class="card-title" style="font-weight:bold; color:#222;">
                        <?= htmlspecialchars($news->judul) ?>
                      </h5>

                      <!-- ✏️ Isi Singkat -->
                      <p class="card-text" style="color:#555;">
                        <?php
                          $words = explode(' ', strip_tags($news->isi));
                          echo implode(' ', array_slice($words, 0, 20)) . (count($words) > 20 ? '...' : '');
                        ?>
                      </p>

                      <!-- 🔗 Read More -->
                      <a href="single-blog.php?id=<?= $news->id_berita ?>" 
                        class="text-primary" style="text-decoration:none;">
                        Read More →
                      </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12 text-center">
              <p>Belum ada berita yang dipublikasikan.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <!-- ================ Berita end ================= --> 

    <!-- ================ Promo Produk Start ================= --> 
    <section class="section-margin calc-60px">
      <div class="container">
        <div class="section-intro pb-60px">
          <p>Promo Produk</p>
          <h2>Best <span class="section-intro__style">Promo🔥</span></h2>
        </div>

        <?php
          require_once __DIR__ . '/../../config/database.php';
          $db = new Database();

          $db->query("
            SELECT DISTINCT 
              pr.id_promo,
              pr.nama_promo,
              pr.tipe,
              pr.nilai_diskon,
              pr.tanggal_mulai,
              pr.tanggal_selesai,
              p.id_produk,
              p.nama_produk,
              p.harga,
              p.gambar,
              k.nama_kategori
            FROM promo pr
            JOIN promo_produk pp ON pr.id_promo = pp.id_promo
            JOIN produk p ON pp.id_produk = p.id_produk
            LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
            WHERE pr.status = 'aktif'
          ");
          $db->execute();
          $promo_produk = $db->resultObject();
        ?>

        <div class="row justify-content-start g-4">
          <?php foreach ($promo_produk as $row): 
            // Hitung harga setelah diskon
            $harga_asli = (float)$row->harga;
            $nilai_diskon = (float)$row->nilai_diskon;
            $tipe = strtolower(trim($row->tipe));

              if ($tipe === 'persentase') {
                $harga_diskon = $harga_asli - ($harga_asli * $nilai_diskon / 100);
              } elseif ($tipe === 'nominal') {
                $harga_diskon = $harga_asli - $nilai_diskon;
              } else {
                $harga_diskon = $harga_asli; // fallback kalo tipe gak dikenali
              }
          ?>
          <div class="col-6 col-md-4 col-lg-3 d-flex align-items-stretch">
            <div class="card text-center card-product" style="border:none; box-shadow:none; border-radius:0px; overflow:hidden; background:#fff; height: 375px;">
              <div class="card-product__img position-relative" 
                style="border:none; box-shadow:none; background:none;">
                  <img
                    src="/gohappymart/public/assets/users/img/<?php echo $row->gambar; ?>"
                      alt="<?php echo $row->nama_produk; ?>"
                      class="img-fluid"
                      style="height: 250px; object-fit: cover; width: 100%; border:none; outline:none; box-shadow:none;"
                    >
                    <ul class="card-product__imgOverlay">
                      <li><button class="icon_btn"><i class="ti-search"></i></button></li>
                      <li><button class="icon_btn"><i class="ti-shopping-cart"></i></button></li>
                      <li><button class="icon_btn"><i class="ti-heart"></i></button></li>
                    </ul>
              </div>

                <div class="card-body" style="padding-top: 8px; padding-bottom: 8px; line-height: 1.1;">
                    <p class="text-muted mb-1" style="margin: 10px 0 0 0; font-size: 14px;">
                      <?php echo $row->nama_kategori; ?>
                    </p>
                    <h4 class="card-product__title" style="font-size: 18px; margin: 4px 0 2px 0; line-height: 1.3;">
                      <a href="single-product.php" style="text-decoration:none;">
                        <?php echo $row->nama_produk; ?>
                      </a>
                    </h4>
                    <br>
                    <span style="text-decoration: line-through; color: #888; line-height: 1.2;">
                      Rp <?php echo number_format($row->harga, 0, ',', '.') ?>
                    </span>
                    <p class="card-product__price" style="color:#d90429; font-weight:bold;">
                      Rp <?php echo number_format(max($harga_diskon, 0), 0, ',', '.') ?>
                    </p>
                </div>
            </div>
          </div>
          <?php endforeach; ?>

        </div>
      </div>
    </section>
    <!-- ================ Promo Produk end ================= --> 

    <!-- ================ Testimoni Start ================= --> 
    <section class="testimoni section-margin">
      <div class="container">
        <div class="section-intro pb-60px text-center">
          <p>Apa Kata Mereka</p>
          <h2>Testimoni <span class="section-intro__style">Pelanggan</span></h2>
        </div>

        <div class="row">
          <?php
            require_once __DIR__ . '/../../config/database.php';
            $db = new Database();

            $db->query("
              SELECT 
                t.id_testimoni,
                t.rating,
                t.komentar,
                t.tanggal_testimoni,
                p.nama_produk,
                p.gambar,
                pl.nama_pelanggan
              FROM testimoni t
              LEFT JOIN pesanan_produk pp ON t.id_pesanan_produk = pp.id_pesanan_produk
              LEFT JOIN pesanan ps ON pp.id_pesanan = ps.id_pesanan
              LEFT JOIN pelanggan pl ON ps.id_pelanggan = pl.id_pelanggan
              LEFT JOIN produk p ON pp.id_produk = p.id_produk
              ORDER BY t.tanggal_testimoni DESC
              LIMIT 3
            ");

            $db->execute();
            $testimoni = $db->resultObject();
          ?>

          <?php if (!empty($testimoni)): ?>
            <?php foreach ($testimoni as $row): ?>
              <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                <div class="card card-blog" style="padding: 20px; border: 1px solid #eee; border-radius: 15px;">
                  <div class="card-body text-center" style="margin: 0 auto 15px auto;">

                  <?php if (!empty($row->gambar)): ?>
                    <img src="/gohappymart/public/assets/users/img/<?= $row->gambar ?>" alt="<?= $row->nama_produk ?>" 
                      style="width:150px; height:200px; object-fit: cover; border-radius: 20px;">
                    <?php endif; ?>


                  <!-- ⭐ Bagian Rating -->
                  <div class="mb-3" style="margin-top: 15px;">
                    <?php 
                      $maxStars = 5;
                      for ($i = 1; $i <= $maxStars; $i++): 
                        if ($i <= $row->rating): ?>
                          <i class="ti-star" style="color: #FFD700;"></i>
                        <?php else: ?>
                          <i class="ti-star" style="color: #ccc;"></i>
                        <?php endif;
                      endfor;
                    ?>
                  </div>

                  <!-- 💬 Pelanggan -->
                  <p style="margin-top: 8px; font-weight: 600; color: #333;">
                    — <?= htmlspecialchars($row->nama_pelanggan) ?>
                  </p>


                  <!-- 🛍️ Nama Produk -->
                  <p style="font-style: italic; color: #555;">“<?= htmlspecialchars($row->komentar) ?>”</p>
                    <p class="mt-3 mb-0" style="font-weight: bold; color: #222;">
                      <?= htmlspecialchars($row->nama_produk ?? 'Produk Tidak Diketahui') ?>
                    </p>


                  <small class="text-muted">
                    <?= date('d M Y', strtotime($row->tanggal_testimoni)) ?>
                  </small>

                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12 text-center">
            <p>Belum ada testimoni pelanggan.</p>
          </div>
        <?php endif; ?>

        </div>
      </div>
    </section>
    <!--================ Testimoni End  =================-->

  </main>


  <!--================ Start footer Area  =================-->	
	<footer class="footer">
		<div class="footer-area">
			<div class="container">
				<div class="row section_gap">
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="single-footer-widget tp_widgets">
							<h4 class="footer_title large_title">Tentang Kami</h4>
							<p>
								GoHappyMart menyediakan berbagai perlengkapan laundry berkualitas — mulai dari detergen, pewangi, hingga plastik laundry.
							</p>
							<p>
								Cocok untuk bisnis laundry maupun pemakaian pribadi di rumah, karena wangi dan kebersihannya tahan lama! 
							</p>
						</div>
					</div>
					<div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
						<div class="single-footer-widget tp_widgets">
							<h4 class="footer_title">Quick Links</h4>
							<ul class="list">
								<li><a href="index.php">Home</a></li>
								<li><a href="keranjang.php">Shop</a></li>
								<li><a href="blog.php">Blog</a></li>
								<li><a href="category.php">Product</a></li>
								<li><a href="contact.php">Contact</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-6 col-sm-6">
						<div class="single-footer-widget instafeed">
							<h4 class="footer_title">Gallery</h4>
							<ul class="list instafeed d-flex flex-wrap">

              <?php
                require_once __DIR__ . '/../../config/database.php';
                $db = new Database();

                // Ambil beberapa gambar produk secara acak
                $db->query("SELECT nama_produk, gambar FROM produk WHERE gambar IS NOT NULL AND gambar != '' LIMIT 6");
                $db->execute();
                $galeri = $db->resultObject();
              ?>

                <?php if (!empty($galeri)): ?>
                  <?php foreach ($galeri as $row): ?>
                    <li>
                      <img 
                        src="/gohappymart/public/assets/users/img/<?= htmlspecialchars($row->gambar) ?>" 
                        alt="<?= htmlspecialchars($row->nama_produk) ?>" 
                        style="width:70px; height:70px; object-fit:cover; margin:2px;">
                      </li>
                  <?php endforeach; ?>
                  <?php else: ?>
                    <li><p>Tidak ada gambar.</p></li>
                <?php endif; ?>
							</ul>
						</div>
					</div>
					<div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6">
						<div class="single-footer-widget tp_widgets">
							<h4 class="footer_title">Contact Us</h4>
							<div class="ml-40">
								<p class="sm-head">
									<span class="fa fa-location-arrow"></span>
									Head Office
								</p>
								<p>123, Main Street, Your City</p>
	
								<p class="sm-head">
									<span class="fa fa-phone"></span>
									Phone Number
								</p>
								<p>
									+123 456 7890 <br>
									+123 456 7890
								</p>
	
								<p class="sm-head">
									<span class="fa fa-envelope"></span>
									Email
								</p>
								<p>
									free@infoexample.com <br>
									www.infoexample.com
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row d-flex">
					<p class="col-lg-12 footer-text text-center">
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by Kelompok 2</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
				</div>
			</div>
		</div>
	</footer>
	<!--================ End footer Area  =================-->



  <script src="/gohappymart/public/assets/users/vendors/jquery/jquery-3.2.1.min.js"></script>
  <script src="/gohappymart/public/assets/users/vendors/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="/gohappymart/public/assets/users/vendors/skrollr.min.js"></script>
  <script src="/gohappymart/public/assets/users/vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="/gohappymart/public/assets/users/vendors/nice-select/jquery.nice-select.min.js"></script>
  <script src="/gohappymart/public/assets/users/vendors/jquery.ajaxchimp.min.js"></script>
  <script src="/gohappymart/public/assets/users/vendors/mail-script.js"></script>
  <script src="/gohappymart/public/assets/users/js/main.js"></script>
</body>
</html>