<?php include __DIR__ . '/../../../users/layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3">Daftar Produk</h2>
    <a href="/gohappymart/admin-produk/create" class="btn btn-primary mb-3">Tambah Produk</a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php $no = 1; foreach ($products as $p): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($p->nama_produk) ?></td>
                        <td><?= htmlspecialchars($p->nama_kategori ?? '-') ?></td>
                        <td>Rp <?= number_format($p->harga, 0, ',', '.') ?></td>
                        <td class="text-center"><?= $p->stok ?></td>
                        <td class="text-center">
                            <a href="/gohappymart/admin-produk/show/<?= $p->id_produk ?>" class="btn btn-info btn-sm">Lihat</a>
                            <a href="/gohappymart/admin-produk/edit/<?= $p->id_produk ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/gohappymart/admin-produk/delete/<?= $p->id_produk ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">Belum ada produk.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../../../users/layouts/footer.php'; ?>