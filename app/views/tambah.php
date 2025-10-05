<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kategori</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="text-center mb-4">Tambah Kategori</h2>

        <form method="POST" action="/gohappymart/nyoba/insert">
          <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Masukkan nama kategori" required>
          </div>
          <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
          <a href="/gohappymart/nyoba" class="btn btn-secondary">Kembali</a>
        </form>

      </div>
    </div>
  </div>
</body>
</html>
