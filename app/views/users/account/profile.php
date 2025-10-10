<?php include 'app/views/users/layouts/header.php'; ?>

<div class="container mt-5">
  <div class="card shadow-sm p-4">
    <h3 class="mb-4 text-center">Profil Saya</h3>

    <div class="text-center">
        <img src="/gohappymart/public/uploads/<?= $_SESSION['user']['foto'] ?? 'default.png'; ?>" 
             alt="Foto Profil"
                style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #ddd; box-shadow: 0 0 6px rgba(0,0,0,0.2);">

    </div>

    <div class="text-center mb-4">
      <h5><?= $_SESSION['user']['nama'] ?? 'Nama Pengguna'; ?></h5>
      <p class="text-muted mb-1"><?= $_SESSION['user']['email'] ?? 'user@example.com'; ?></p>
      <p class="text-muted"><?= $_SESSION['user']['telepon'] ?? ''; ?></p>
    </div>

    <div class="text-center">
      <a href="/gohappymart/akun/pengaturan" class="btn btn-primary px-4">Edit Profil</a>
    </div>
  </div>
</div>

<?php include 'app/views/users/layouts/footer.php'; ?>