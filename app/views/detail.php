<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Kategori</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="mb-4 text-center">Detail Kategori</h1>

        <?php if ($data['kategori']): ?>
          <table class="table table-bordered">
            <tr>
              <th>ID Kategori</th>
              <td><?= $data['kategori']->id_kategori; ?></td>
            </tr>
            <tr>
              <th>Nama Kategori</th>
              <td><?= htmlspecialchars($data['kategori']->nama_kategori); ?></td>
            </tr>
          </table>

          <a href="/gohappymart/nyoba" class="btn btn-secondary mt-3">Kembali</a>
        <?php else: ?>
          <div class="alert alert-danger text-center">
            Data kategori tidak ditemukan!
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
