<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Kategori</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
  </head>

  <body class="bg-light">
    <div class="container py-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Daftar Kategori</h1>
            <a href="/gohappymart/nyoba/tambah" class="btn btn-success"
              >+ Tambah Kategori</a
            >
          </div>

          <?php if (!empty($data['nama'])): ?>
          <table class="table table-striped align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Kategori</th>
                <th scope="col" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($data['nama'] as $row): ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row->nama_kategori); ?></td>
                <td class="text-center">
                  <a
                    href="nyoba/detail/<?= $row->id_kategori; ?>"
                    class="btn btn-info btn-sm text-white"
                    >Detail</a
                  >
                  <a
                    href="nyoba/edit/<?= $row->id_kategori; ?>"
                    class="btn btn-warning btn-sm text-white"
                    >Edit</a
                  >
                  <a
                    href="nyoba/hapus/<?= $row->id_kategori; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                    >Hapus</a
                  >
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
          <div class="alert alert-warning text-center">
            Belum ada data kategori.
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
