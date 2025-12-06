<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrator Login | Go Happy Mart</title>
  <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600&display=swap">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Public Sans', sans-serif;
      margin: 0;
      background: #fff;
      display: flex;
      flex-direction: row;
      min-height: 100vh;
      color: #333;
    }

    /* ===== HERO SECTION (DESKTOP) ===== */
    .hero-section {
      flex: 1;
      background: linear-gradient(135deg, #e7f0ff, #cfdffb);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 60px 40px;
      border-right: 1px solid #ddd;
    }

    .hero-section img {
      width: 120px;
      margin-bottom: 25px;
      opacity: 0.95;
    }

    .hero-section h1 {
      font-size: 30px;
      font-weight: 700;
      color: #222;
      margin-bottom: 15px;
    }

    .hero-section p {
      font-size: 15px;
      color: #555;
      max-width: 360px;
      opacity: 0.8;
    }

    /* ===== LOGIN SECTION ===== */
    .login-section {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px 80px;
      background: #fff;
      position: relative;
      z-index: 1;
    }

    .login-section h2 {
      font-weight: 700;
      font-size: 26px;
      margin-bottom: 25px;
      color: #003366;
    }

    form {
      max-width: 400px;
      width: 100%;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: 500;
      color: #555;
      margin-bottom: 6px;
    }

    input {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 15px;
      transition: border-color 0.2s;
    }

    input:focus {
      border-color: #0056b3;
      outline: none;
    }

    .btn-login {
      width: 100%;
      background: #0056b3;
      color: #fff;
      border: none;
      padding: 12px 0;
      border-radius: 10px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-login:hover {
      background: #003d80;
    }

    .footer-text {
      margin-top: 30px;
      font-size: 13px;
      color: #888;
    }

    /* ===== MOBILE HEADER HERO ===== */
    .mobile-hero {
      display: none;
      position: relative;
      background: linear-gradient(135deg, #007bff, #0056b3);
      color: #fff;
      text-align: center;
      padding: 5px 20px 100px;
      overflow: hidden;
    }

    .mobile-hero img {
      width: 90px;
      margin-bottom: 15px;
    }

    .mobile-hero h1 {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .mobile-hero p {
      font-size: 14px;
      opacity: 0.9;
      max-width: 320px;
      margin: 0 auto;
    }

    .mobile-hero::after {
      content: "";
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 70px;
      background: #fff;
      border-top-left-radius: 80% 100%;
      border-top-right-radius: 80% 100%;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
      body {
        flex-direction: column;
      }

      .hero-section {
        display: none;
      }

      .mobile-hero {
        display: block;
      }

      .login-section {
        padding: 40px 25px;
        margin-top: -50px; /* biar form naik ke bawah lengkungan */
      }

      .login-section h2 {
        margin-top: -2vh;
      }

      form {
        margin: 0 auto;
      }
    }
  </style>
</head>

<body>
  <!-- HERO SECTION (DESKTOP) -->
  <div class="hero-section">
    <img src="{{ asset('assets-user/img/logo-toko.png') }}" alt="Go Happy Mart Logo">
    <h1>Administrator Panel</h1>
    <p>Kelola sistem, pantau performa, dan jalankan operasi Go Happy Mart dengan mudah.</p>
  </div>

  <!-- HERO SECTION (MOBILE/TABLET) -->
  <div class="mobile-hero">
    <h1>Go Happy Mart</h1>
    <p>Kelola sistem dan operasional dengan mudah di mana pun Anda berada.</p>
  </div>

  <!-- LOGIN FORM SECTION -->
  <div class="login-section">
    <h2>Login</h2>
    <form action="{{ route('admin.login.post') }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="Masukkan email admin" required>
      </div>
    
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" value="password123" placeholder="Masukkan password" required>
      </div>

      <button type="submit" class="btn-login">Login</button>

      <div class="footer-text">
        &copy; 2025 Go Happy Mart. All Rights Reserved.
      </div>
    </form>
  </div>
</body>
</html>
