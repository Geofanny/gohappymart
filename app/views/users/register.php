<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aroma Shop - Register</title>
	<link rel="icon" href="/gohappymart/public/assets/users/img/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/themify-icons/themify-icons.css">
	<link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/linericon/style.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/nice-select/nice-select.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/nouislider/nouislider.min.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/css/style.css">

  <style>
    /* 🌈 Bagian kiri (panel promosi) dengan efek gradasi lembut */
    .login_box_img {
      background: linear-gradient(135deg, #4a6cf7, #6a45ff);
      border-radius: 15px 0 0 15px;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 60px 40px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .login_box_img .hover h4 {
      font-weight: 700;
      font-size: 26px;
      margin-bottom: 15px;
    }

    .login_box_img .hover p {
      font-size: 15px;
      line-height: 1.6;
      opacity: 0.9;
    }

    .login_box_img .button-account {
      border: 2px solid #fff;
      border-radius: 30px;
      padding: 10px 25px;
      color: #fff;
      background: transparent;
      transition: 0.3s ease;
      display: inline-block;
      margin-top: 25px;
      font-weight: 500;
    }

    .login_box_img .button-account:hover {
      background-color: #fff;
      color: #4a6cf7;
    }

    /* 🧾 Bagian kanan (form register) */
    .login_form_inner {
      background-color: #ffffff;
      padding: 50px 40px;
      border-radius: 0 15px 15px 0;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
    }

    .login_form_inner h3 {
      font-weight: 700;
      color: #333;
      text-align: center;
      margin-bottom: 25px;
    }

    .form-control {
      border-radius: 30px;
      padding: 12px 20px;
      border: 1px solid #ccc;
      transition: 0.3s;
    }

    .form-control:focus {
      border-color: #4a6cf7;
      box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.2);
    }

    .button-register {
      background: #e63946;
      border: none;
      border-radius: 30px;
      padding: 12px 0;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: 0.3s;
    }

    .button-register:hover {
      background: #d62828;
      transform: translateY(-2px);
    }

    /* 🔘 Tombol Google */
    .google-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      border: 1px solid #ddd;
      border-radius: 30px;
      padding: 12px 0;
      font-weight: 500;
      background-color: #fff;
      width: 100%;
      transition: all 0.3s ease;
    }

    .google-btn img {
      width: 22px;
      height: 22px;
    }

    .google-btn:hover {
      background-color: #f8f8f8;
      transform: translateY(-1px);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .google-separator {
      display: flex;
      align-items: center;
      text-align: center;
      color: #999;
      font-size: 14px;
      margin: 20px 0;
    }

    .google-separator::before,
    .google-separator::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid #ddd;
    }

    .google-separator:not(:empty)::before {
      margin-right: 10px;
    }

    .google-separator:not(:empty)::after {
      margin-left: 10px;
    }

    /* 📱 Responsif untuk mobile */
    @media (max-width: 768px) {
      .login_box_img {
        border-radius: 15px 15px 0 0;
        padding: 40px 20px;
      }

      .login_form_inner {
        border-radius: 0 0 15px 15px;
        padding: 40px 20px;
      }
    }
  </style>
</head>
<body>
	<header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-light">
        <div class="container d-flex justify-content-start align-items-center">
          <a class="navbar-brand logo_h" href="index.html">
            <img src="/gohappymart/public/assets/users/img/logo.png" alt="Aroma Logo">
          </a>
        </div>
      </nav>
    </div>
  </header>
  
<section class="login_box_area section-margin" style="margin-top: 0; padding-top: 0;">
	<div class="container" style="margin-top: 0; padding-top: 0;">
		<div class="row align-items-center justify-content-center">
			<div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
				<div class="login_box_img">
					<div class="hover">
						<h4>Sudah punya akun?</h4>
						<p>Temukan alat cuci baju berkualitas dan produk laundry terbaik untuk hasil cucian bersih, wangi, dan tahan lama.</p>
						<a class="button button-account" href="login.html">Login Sekarang</a>
					</div>
				</div>
			</div>

			<div class="col-lg-6 col-md-12">
				<div class="login_form_inner register_form_inner">
					<h3>Buat Akun Baru</h3>
					<form class="row login_form" action="#/" id="register_form">
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" id="name" name="name" placeholder="Username">
						</div>
						<div class="col-md-12 form-group">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
						</div>
						<div class="col-md-12 form-group">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password">
						</div>
						<div class="col-md-12 form-group">
							<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
						</div>
						<div class="col-md-12 form-group d-flex align-items-center">
							<input type="checkbox" id="f-option2" name="selector" style="margin-right:10px;">
							<label for="f-option2" class="m-0">Keep me logged in</label>
						</div>

						<div class="col-md-12 form-group">
							<button type="submit" value="submit" class="button button-register w-100">Register</button>
						</div>

            <div class="col-md-12 form-group">
              <div class="google-separator">or</div>
              <button type="button" class="google-btn">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google logo">
                <span>Register with Google</span>
              </button>
            </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

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
