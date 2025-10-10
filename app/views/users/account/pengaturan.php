<?php include 'app/views/users/layouts/header.php'; ?>

<div class="container mt-5">
  <div class="card shadow-sm p-4">
    <h3 class="mb-4 text-center">Pengaturan Akun</h3>

    <form method="POST" action="/gohappymart/akun/update" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama" name="nama" 
               value="<?= $_SESSION['user']['nama'] ?? ''; ?>" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" 
               value="<?= $_SESSION['user']['email'] ?? ''; ?>" required>
      </div>

      <div class="mb-3">
        <label for="telepon" class="form-label">Nomor Telepon</label>
        <input type="text" class="form-control" id="telepon" name="telepon" 
               value="<?= $_SESSION['user']['telepon'] ?? ''; ?>">
      </div>

      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $_SESSION['user']['alamat'] ?? ''; ?></textarea>
      </div>

      <div class="mb-3">
        <label for="foto" class="form-label">Foto Profil</label><br>
        <img src="/gohappymart/public/uploads/<?= $_SESSION['user']['foto'] ?? 'default.png'; ?>" 
             alt="Foto Profil" width="100" class="rounded mb-2" style="object-fit: cover;"><br>
        <input type="file" class="form-control" id="foto" name="foto" accept=".jpg,.jpeg,.png">
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="notifikasi" name="notifikasi" 
               <?= (($_SESSION['user']['notifikasi'] ?? 0) == 1) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="notifikasi">
          Aktifkan notifikasi email
        </label>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
        <a href="/gohappymart/akun" class="btn btn-secondary px-4">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php include 'app/views/users/layouts/footer.php'; ?>