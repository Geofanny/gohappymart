<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>

  <link rel="icon" href="/gohappymart/public/assets/users/img/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/vendors/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="/gohappymart/public/assets/users/css/style.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #4a6cf7, #6a45ff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .forgot-box {
      background: #fff;
      width: 420px;
      padding: 50px 40px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      text-align: center;
      animation: fadeIn 0.6s ease;
    }

    .forgot-box img {
      width: 90px;
      margin-bottom: 20px;
    }

    .forgot-box h2 {
      font-weight: 700;
      color: #333;
      margin-bottom: 10px;
    }

    .forgot-box p {
      color: #666;
      font-size: 14px;
      margin-bottom: 30px;
      line-height: 1.5;
    }

    .forgot-box input[type="email"] {
      width: 100%;
      padding: 12px 18px;
      border-radius: 30px;
      border: 1px solid #ccc;
      font-size: 14px;
      transition: 0.3s;
    }

    .forgot-box input[type="email"]:focus {
      border-color: #4a6cf7;
      box-shadow: 0 0 0 3px rgba(74,108,247,0.2);
      outline: none;
    }

    .forgot-box button {
      width: 100%;
      background: #4a6cf7;
      color: #fff;
      border: none;
      border-radius: 30px;
      padding: 12px 0;
      font-size: 15px;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: 0.3s;
      margin-top: 15px;
    }

    .forgot-box button:hover {
      background: #3a57d1;
      transform: translateY(-2px);
    }

    .back-login {
      margin-top: 25px;
      display: inline-block;
      color: #4a6cf7;
      font-weight: 500;
      text-decoration: none;
      transition: 0.3s;
    }

    .back-login:hover {
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }

    @media (max-width: 500px) {
      .forgot-box {
        width: 90%;
        padding: 40px 20px;
      }
    }
  </style>
</head>

<body>
  <div class="forgot-box">
    <img src="https://cdn-icons-png.flaticon.com/512/906/906343.png" alt="Forgot Password Icon">
    <h2>Lupa Kata Sandi?</h2>
    <p>Masukkan alamat email akunmu. Kami akan mengirim tautan untuk mengatur ulang kata sandi kamu.</p>

    <form action="reset_link.php" method="POST">
      <input type="email" name="email" placeholder="Masukkan email kamu" required>
      <button type="submit">Kirim Tautan Reset</button>
    </form>

    <a href="login.php" class="back-login"><i class="fas fa-arrow-left"></i> Kembali ke Login</a>
  </div>
</body>
</html>
