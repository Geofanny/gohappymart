<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Kategori</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="mb-4 text-center">Edit Kategori</h1>

        <?php if ($data['kategori']): ?>
        <form action="/gohappymart/nyoba/update" method="POST">
          <input type="hidden" name="id_kategori" value="<?= $data['kategori']->id_kategori; ?>">

          <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input 
              type="text" 
              name="nama_kategori" 
              class="form-control" 
              value="<?= htmlspecialchars($data['kategori']->nama_kategori); ?>" 
              required
            >
          </div>

          <button type="submit" name="update" class="btn btn-primary">Simpan</button>
          <a href="/gohappymart/nyoba" class="btn btn-secondary">Batal</a>
        </form>
        <?php else: ?>
          <div class="alert alert-danger text-center">
            Data kategori tidak ditemukan!
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
