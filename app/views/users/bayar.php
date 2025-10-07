<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Aroma Shop - Cart</title>
    <link
      rel="icon"
      href="/gohappymart/public/assets/users/img/Fevicon.png"
      type="image/png"
    />
    <link
      rel="stylesheet"
      href="/gohappymart/public/assets/users/vendors/bootstrap/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="/gohappymart/public/assets/users/vendors/fontawesome/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="/gohappymart/public/assets/users/vendors/themify-icons/themify-icons.css"
    />
    <link
      rel="stylesheet"
      href="/gohappymart/public/assets/users/vendors/linericon/style.css"
    />
    <link
      rel="stylesheet"
      href="/gohappymart/public/assets/users/vendors/owl-carousel/owl.theme.default.min.css"
    />
    <link
      rel="stylesheet"
      href="/gohappymart/public/assets/users/vendors/owl-carousel/owl.carousel.min.css"
    />
    <link
      rel="stylesheet"
      href="/gohappymart/public/assets/users/vendors/nice-select/nice-select.css"
    />
    <link
      rel="stylesheet"
      href="/gohappymart/public/assets/users/vendors/nouislider/nouislider.min.css"
    />

    <link
      rel="stylesheet"
      href="/gohappymart/public/assets/users/css/style.css"
    />
  </head>
  <body>
    <!--================ Start Header Menu Area =================-->
    <header class="header_area">
      <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container">
            <a class="navbar-brand logo_h" href="index.html"
              ><img src="/gohappymart/public/assets/users/img/logo.png" alt=""
            /></a>
            <button
              class="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <div
              class="collapse navbar-collapse offset"
              id="navbarSupportedContent"
            >
              <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item active submenu dropdown">
                  <a
                    href="#"
                    class="nav-link dropdown-toggle"
                    data-toggle="dropdown"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >Shop</a
                  >
                  <ul class="dropdown-menu">
                    <li class="nav-item">
                      <a class="nav-link" href="category.html">Shop Category</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="single-product.html"
                        >Product Details</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="checkout.html"
                        >Product Checkout</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="confirmation.html"
                        >Confirmation</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="cart.html">Shopping Cart</a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item submenu dropdown">
                  <a
                    href="#"
                    class="nav-link dropdown-toggle"
                    data-toggle="dropdown"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >Blog</a
                  >
                  <ul class="dropdown-menu">
                    <li class="nav-item">
                      <a class="nav-link" href="blog.html">Blog</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="register.html">Register</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="single-blog.html"
                        >Blog Details</a
                      >
                    </li>
                  </ul>
                </li>
                <li class="nav-item submenu dropdown">
                  <a
                    href="#"
                    class="nav-link dropdown-toggle"
                    data-toggle="dropdown"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >Pages</a
                  >
                  <ul class="dropdown-menu">
                    <li class="nav-item">
                      <a class="nav-link" href="login.html">Login</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="tracking-order.html"
                        >Tracking</a
                      >
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.html">Contact</a>
                </li>
              </ul>

              <ul class="nav-shop">
                <li class="nav-item">
                  <button><i class="ti-search"></i></button>
                </li>
                <li class="nav-item">
                  <button>
                    <i class="ti-shopping-cart"></i
                    ><span class="nav-shop__circle">3</span>
                  </button>
                </li>
                <li class="nav-item">
                  <a class="button button-header" href="#">Buy Now</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!--================ End Header Menu Area =================-->

    <!-- ================ start banner area ================= -->
    <section class="blog-banner-area" id="category">
      <div class="container h-100">
        <div class="blog-banner">
          <div class="text-center">
            <h1>Shopping Cart</h1>
            <nav aria-label="breadcrumb" class="banner-breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Shopping Cart
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>
    <!-- ================ end banner area ================= -->

    <!--================Cart Area =================-->
    <section class="cart_area">
      <div class="container">
        <!-- 🏠 Area Alamat Pengiriman -->
        <div class="shipping_address mb-4 p-4 border rounded bg-light">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">Alamat Pengiriman</h5>
            <a
              href="#"
              class="text-primary"
              data-toggle="modal"
              data-target="#editAddressModal"
              style="font-size: 0.9rem"
              >Edit</a
            >
          </div>

          <textarea id="addressField" class="form-control" rows="3" readonly>
Jl. Mawar No. 123, Kel. Sukamaju, Kec. Cipayung, Jakarta Timur, DKI Jakarta - 13870
      </textarea
          >
        </div>

        <!-- 🛒 Keranjang Versi Card -->
        <div class="cart_inner">
  <div class="row">
    <!-- 🧩 Kolom kiri: daftar produk -->
    <div class="col-lg-8">
      <div class="row">
        <!-- Card Produk 1 -->
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex">
              <img
                src="/gohappymart/public/assets/users/img/cart/cart1.png"
                class="rounded mr-3"
                alt="Produk"
                width="80"
              />
              <div>
                <h6 class="card-title mb-1">
                  Minimalistic shop for multipurpose use
                </h6>
                <p class="mb-2 text-muted">
                  Harga: <strong>$360.00</strong>
                </p>

                <div class="d-flex align-items-center">
                  <button
                    class="btn btn-outline-secondary btn-sm px-2"
                    onclick="var result = document.getElementById('sst'); var sst = result.value; if(!isNaN(sst) && sst > 1) result.value--; return false;"
                  >
                    <i class="lnr lnr-chevron-down"></i>
                  </button>
                  <input
                    type="text"
                    id="sst"
                    name="qty"
                    class="form-control form-control-sm mx-2 text-center"
                    style="width: 50px"
                    value="1"
                  />
                  <button
                    class="btn btn-outline-secondary btn-sm px-2"
                    onclick="var result = document.getElementById('sst'); var sst = result.value; if(!isNaN(sst)) result.value++; return false;"
                  >
                    <i class="lnr lnr-chevron-up"></i>
                  </button>
                </div>

                <p class="mt-2 mb-0">Total: <strong>$720.00</strong></p>
              </div>
            </div>
          </div>
        </div>

        <!-- Card Produk 2 -->
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex">
              <img
                src="/gohappymart/public/assets/users/img/cart/cart1.png"
                class="rounded mr-3"
                alt="Produk"
                width="80"
              />
              <div>
                <h6 class="card-title mb-1">
                  Minimalistic shop for multipurpose use
                </h6>
                <p class="mb-2 text-muted">
                  Harga: <strong>$360.00</strong>
                </p>

                <div class="d-flex align-items-center">
                  <button
                    class="btn btn-outline-secondary btn-sm px-2"
                    onclick="var result = document.getElementById('sst2'); var sst = result.value; if(!isNaN(sst) && sst > 1) result.value--; return false;"
                  >
                    <i class="lnr lnr-chevron-down"></i>
                  </button>
                  <input
                    type="text"
                    id="sst2"
                    name="qty"
                    class="form-control form-control-sm mx-2 text-center"
                    style="width: 50px"
                    value="1"
                  />
                  <button
                    class="btn btn-outline-secondary btn-sm px-2"
                    onclick="var result = document.getElementById('sst2'); var sst = result.value; if(!isNaN(sst)) result.value++; return false;"
                  >
                    <i class="lnr lnr-chevron-up"></i>
                  </button>
                </div>

                <p class="mt-2 mb-0">Total: <strong>$720.00</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 📦 Metode Pengiriman -->
<div class="mb-3">
  <h5 class="mb-3">Metode Pengiriman</h5>
  <div class="row">
    <!-- JNE -->
    <div class="col-12 col-md-4 mb-3">
      <div class="card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="shippingMethod" id="jne" value="jne" checked>
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-1">JNE - Reguler</h6>
            <small class="text-muted d-block">Estimasi: 2–3 hari</small>
            <div class="fw-semibold text-primary">Rp15.000</div>
          </div>
          
        </div>
      </div>
    </div>

    <!-- POS -->
    <div class="col-12 col-md-4 mb-3">
      <div class="card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="shippingMethod" id="pos" value="pos">
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-1">POS Indonesia - Ekspres</h6>
            <small class="text-muted d-block">Estimasi: 1–2 hari</small>
          <div class="fw-semibold text-primary">Rp20.000</div>
          </div>
        </div>
      </div>
    </div>

    <!-- GoSend -->
    <div class="col-12 col-md-4 mb-3">
      <div class="card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="shippingMethod" id="gosend" value="gosend">
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-1">GoSend - Same Day</h6>
            <small class="text-muted d-block">Estimasi: Hari ini</small>
          <div class="fw-semibold text-primary">Rp25.000</div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 💳 Metode Pembayaran -->
<div class="mb-3">
  <h5 class="mb-3">Metode Pembayaran</h5>
  <div class="row">
    <!-- COD -->
    <div class="col-12 col-md-4 mb-3">
      <div class="card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="paymentMethod" id="cod" value="cod" checked>
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-1">Bayar di Tempat (COD)</h6>
            <small class="text-muted d-block">Bayar langsung ke kurir</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Transfer -->
    <div class="col-12 col-md-4 mb-3">
      <div class="card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="paymentMethod" id="transfer" value="transfer">
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-1">Transfer Bank</h6>
            <small class="text-muted d-block">BCA, BRI, Mandiri</small>
          </div>
        </div>
      </div>
    </div>

    <!-- E-Wallet -->
    <div class="col-12 col-md-4 mb-3">
      <div class="card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="paymentMethod" id="ewallet" value="ewallet">
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-1">E-Wallet</h6>
            <small class="text-muted d-block">GoPay, OVO, DANA</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

     
    </div>

    <!-- 📦 Kolom kanan: Order Box -->
    <div class="col-lg-4">
  <div class="order_box shadow-sm p-4">
    <h4 class="mb-3">Ringkasan Pesanan</h4>

    <ul class="list list-unstyled border-bottom pb-2 mb-3">
      <li class="d-flex justify-content-between">
        <span>Fresh Blackberry (x2)</span>
        <strong>Rp720.000</strong>
      </li>
      <li class="d-flex justify-content-between">
        <span>Fresh Tomatoes (x2)</span>
        <strong>Rp720.000</strong>
      </li>
      <li class="d-flex justify-content-between">
        <span>Fresh Broccoli (x2)</span>
        <strong>Rp720.000</strong>
      </li>
    </ul>

    <!-- Ringkasan -->
    <ul class="list list-unstyled">
      <li class="d-flex justify-content-between">
        <span>Subtotal</span>
        <strong id="subtotal">Rp2.160.000</strong>
      </li>
      <li class="d-flex justify-content-between">
        <span>Metode Pengiriman</span>
        <strong id="shippingMethodText">JNE - Reguler</strong>
      </li>
      <li class="d-flex justify-content-between">
        <span>Ongkos Kirim</span>
        <strong id="shippingCost">Rp15.000</strong>
      </li>
      <li class="d-flex justify-content-between">
        <span>Metode Pembayaran</span>
        <strong id="paymentMethodText">COD</strong>
      </li>
      <li class="d-flex justify-content-between border-top mt-2 pt-2">
        <span>Total</span>
        <strong id="totalPrice">Rp2.175.000</strong>
      </li>
    </ul>

    <div class="mt-4 text-center">
      <a href="#" class="btn btn-primary w-100">Proceed to Checkout</a>
    </div>
  </div>
</div>
  </div>
</div>

    </section>

    <!-- 🪟 Modal Edit Alamat -->
    <div
      class="modal fade"
      id="editAddressModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="editAddressModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <!-- ✨ Tambah class ini -->
        <div class="modal-content">
          <form id="addressForm">
            <div class="modal-header">
              <h5 class="modal-title" id="editAddressModalLabel">
                Edit Alamat Pengiriman
              </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Tutup"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <textarea
                  class="form-control"
                  id="alamat"
                  rows="2"
                  required
                ></textarea>
              </div>

              <!-- 🧩 Kelurahan & Kecamatan dalam 1 baris -->
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="kelurahan">Kelurahan</label>
                  <input
                    type="text"
                    class="form-control"
                    id="kelurahan"
                    required
                  />
                </div>
                <div class="form-group col-md-6">
                  <label for="kecamatan">Kecamatan</label>
                  <input
                    type="text"
                    class="form-control"
                    id="kecamatan"
                    required
                  />
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="kota">Kota</label>
                  <input type="text" class="form-control" id="kota" required />
                </div>
                <div class="form-group col-md-6">
                  <label for="provinsi">Provinsi</label>
                  <input
                    type="text"
                    class="form-control"
                    id="provinsi"
                    required
                  />
                </div>
              </div>

              <div class="form-group">
                <label for="kodepos">Kode Pos</label>
                <input type="text" class="form-control" id="kodepos" required />
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="gray_btn" data-dismiss="modal">
                Batal
              </button>
              <button type="submit" class="primary-btn">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- 🧠 Script Update Alamat -->
    <script>
      document
        .getElementById("addressForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();

          const alamat = document.getElementById("alamat").value;
          const kelurahan = document.getElementById("kelurahan").value;
          const kecamatan = document.getElementById("kecamatan").value;
          const kota = document.getElementById("kota").value;
          const provinsi = document.getElementById("provinsi").value;
          const kodepos = document.getElementById("kodepos").value;

          // gabungkan ke satu teks
          const fullAddress = `${alamat}, Kel. ${kelurahan}, Kec. ${kecamatan}, ${kota}, ${provinsi} - ${kodepos}`;
          document.getElementById("addressField").value = fullAddress;

          // tutup modal
          const modal = bootstrap.Modal.getInstance(
            document.getElementById("editAddressModal")
          );
          modal.hide();
        });
    </script>

    <!--================End Cart Area =================-->

    <!--================ Start footer Area  =================-->
    <footer>
      <div class="footer-area footer-only">
        <div class="container">
          <div class="row section_gap">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="single-footer-widget tp_widgets">
                <h4 class="footer_title large_title">Our Mission</h4>
                <p>
                  So seed seed green that winged cattle in. Gathering thing made
                  fly you're no divided deep moved us lan Gathering thing us
                  land years living.
                </p>
                <p>
                  So seed seed green that winged cattle in. Gathering thing made
                  fly you're no divided deep moved
                </p>
              </div>
            </div>
            <div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
              <div class="single-footer-widget tp_widgets">
                <h4 class="footer_title">Quick Links</h4>
                <ul class="list">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">Shop</a></li>
                  <li><a href="#">Blog</a></li>
                  <li><a href="#">Product</a></li>
                  <li><a href="#">Brand</a></li>
                  <li><a href="#">Contact</a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
              <div class="single-footer-widget instafeed">
                <h4 class="footer_title">Gallery</h4>
                <ul class="list instafeed d-flex flex-wrap">
                  <li><img src="img/gallery/r1.jpg" alt="" /></li>
                  <li><img src="img/gallery/r2.jpg" alt="" /></li>
                  <li><img src="img/gallery/r3.jpg" alt="" /></li>
                  <li><img src="img/gallery/r5.jpg" alt="" /></li>
                  <li><img src="img/gallery/r7.jpg" alt="" /></li>
                  <li><img src="img/gallery/r8.jpg" alt="" /></li>
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
                    +123 456 7890 <br />
                    +123 456 7890
                  </p>

                  <p class="sm-head">
                    <span class="fa fa-envelope"></span>
                    Email
                  </p>
                  <p>
                    free@infoexample.com <br />
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
              Copyright &copy;
              <script>
                document.write(new Date().getFullYear());
              </script>
              All rights reserved | This template is made with
              <i class="fa fa-heart" aria-hidden="true"></i> by
              <a href="https://colorlib.com" target="_blank">Colorlib</a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
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
