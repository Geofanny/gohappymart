<?php include __DIR__ . '/layouts/header.php'; ?>

<!--================ Banner Area =================-->
<section class="blog-banner-area py-4" id="category" style="background-color:#f6f8f9; margin-bottom: 40px;">
  <div class="container text-center">
    <div class="blog-banner">
      <h2 class="mb-2" style="font-size:30px; font-weight:800;">Tentang GoHappyMart</h2>
      <nav aria-label="breadcrumb" class="banner-breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="/gohappymart/">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tentang</li>
        </ol>
      </nav>
    </div>
  </div>
</section>
<!--================ End Banner Area =================-->

<!--================ About Section =================-->
<section class="about-area section_gap pt-4 pb-5">
  <div class="container text-center">

    <!-- Gambar + Deskripsi -->
    <div class="row align-items-center justify-content-center">
      <!-- Gambar toko -->
      <div class="col-lg-5 mb-4 mb-lg-0">
        <img src="/gohappymart/public/assets/users/img/toko.jpg" alt="Toko GoHappyMart"
             class="img-fluid rounded shadow"
             style="margin-top:30px; max-height:350px; object-fit:cover;">
      </div>

      <!-- Deskripsi toko -->
      <div class="col-lg-7">
        <h2 class="mb-3">Selamat Datang di <span class="text-primary">GoHappyMart</span></h2>
        <p class="lead text-justify">
          GoHappyMart adalah platform e-commerce UMKM yang berfokus pada kemudahan belanja online untuk produk lokal berkualitas.
          Kami hadir untuk membantu pelaku usaha kecil menengah menjangkau lebih banyak pelanggan dan meningkatkan penjualan melalui teknologi digital.
        </p>
        <p class="text-justify">
          Kami percaya setiap produk lokal memiliki nilai dan cerita unik. Dengan GoHappyMart, kami menjembatani antara pelaku UMKM dan konsumen agar bisa saling mendukung serta tumbuh bersama.
        </p>
      </div>
    </div>

    <!-- Visi & Misi -->
    <div class="row mt-5 justify-content-center">
      <div class="col-lg-10">
        <h3 class="mb-4 text-center">Visi & Misi Kami</h3>
        <div class="card shadow border-0">
          <div class="card-body p-5">
            <div class="row text-center">
              <div class="col-md-6 border-end">
                <i class="ti-eye text-primary" style="font-size:24px;"></i>
                <h5 class="fw-bold mt-2">Visi</h5>
                <p class="mb-0">
                  Menjadi platform e-commerce terbaik untuk mendukung UMKM lokal agar mampu bersaing di pasar nasional dan global.
                </p>
              </div>
              <div class="col-md-6">
                <i class="ti-target text-success" style="font-size:24px;"></i>
                <h5 class="fw-bold mt-2">Misi</h5>
                <ul class="list-unstyled text-start d-inline-block mx-auto text-start">
                  <li>🌟 Memberdayakan pelaku UMKM melalui teknologi digital.</li>
                  <li>🤝 Membangun hubungan kuat antara penjual dan pembeli.</li>
                  <li>🚀 Menyediakan pengalaman belanja yang mudah, cepat, dan aman.</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Form Kontak -->
    <div class="row mt-5 justify-content-center">
      <div class="col-lg-8">
        <div class="card p-4 border-0 shadow-sm">
          <h4 class="text-center mb-3">Hubungi Kami</h4>

          <!-- FORM KE WHATSAPP -->
          <form onsubmit="kirimWA(event)">
            <div class="form-group mb-3">
              <input type="text" id="nama" class="form-control" placeholder="Nama Lengkap Anda" required>
            </div>
            <div class="form-group mb-3">
              <input type="email" id="email" class="form-control" placeholder="Alamat Email Anda" required>
            </div>
            <div class="form-group mb-3">
              <textarea id="pesan" class="form-control" rows="4" placeholder="Tulis pesan Anda..." required></textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary px-4">Kirim Pesan</button>
            </div>
          </form>

          <script>
            function kirimWA(event) {
              event.preventDefault();

              const nama = document.getElementById("nama").value.trim();
              const email = document.getElementById("email").value.trim();
              const pesan = document.getElementById("pesan").value.trim();

              if (!nama || !email || !pesan) {
                alert("Harap isi semua kolom terlebih dahulu!");
                return;
              }

              // 🔹 Ganti nomor di bawah ini dengan nomor WhatsApp admin (tanpa tanda +)
              const nomor = "6285946048191";

              const text =
                `Halo GoHappyMart! 👋%0A` +
                `Saya ingin menghubungi Anda.%0A%0A` +
                `*Nama:* ${nama}%0A` +
                `*Email:* ${email}%0A` +
                `*Pesan:* ${pesan}`;

              const url = `https://wa.me/${nomor}?text=${text}`;
              alert("Membuka WhatsApp..."); // konfirmasi kecil
              window.open(url, "_blank");
            }
          </script>
        </div>
      </div>
    </div>

  </div>
</section>
<!--================ End About Section =================-->

<?php include __DIR__ . '/layouts/footer.php'; ?>

<!-- Sedikit CSS tambahan -->
<style>
  footer {
    padding-top: 30px !important;
    padding-bottom: 15px !important;
  }

  .blog-banner-area {
    padding-top: 25px !important;
    padding-bottom: 25px !important;
  }

  .about-area p {
    text-align: justify;
  }

  /* Biar form tidak terlalu lebar di HP */
  @media (max-width: 576px) {
    .about-area .card {
      padding: 20px !important;
    }
  }
</style>