<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah Pelanggan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="text-center mb-4">Tambah Pelanggan</h2>

        <form method="POST" action="/gohappymart/coba/tambahUser">
          <div class="mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" placeholder="Masukkan nama pelanggan" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
          </div>

          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="kelurahan" class="form-label">Kelurahan</label>
              <input type="text" name="kelurahan" id="kelurahan" class="form-control" placeholder="Masukkan kelurahan" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="kecamatan" class="form-label">Kecamatan</label>
              <input type="text" name="kecamatan" id="kecamatan" class="form-control" placeholder="Masukkan kecamatan" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="kota" class="form-label">Kota</label>
              <input type="text" name="kota" id="kota" class="form-control" placeholder="Masukkan kota" required>
            </div>
            <div class="col-md-6 mb-3">
  <label for="provinsi" class="form-label">Provinsi</label>
  <input type="text" name="provinsi" id="provinsi" class="form-control" placeholder="Masukkan provinsi" required>
</div>

            <div class="col-md-6 mb-3">
              <label for="kode_pos" class="form-label">Kode Pos</label>
              <input type="text" name="kode_pos" id="kode_pos" class="form-control" placeholder="Masukkan kode pos" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="Masukkan nomor HP" required>
          </div>

          <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
        </form>

      </div>
    </div>
  </div>
</body>
</html>
