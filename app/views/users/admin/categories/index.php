<?php include __DIR__ . '/../../../users/layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3">Daftar Kategori</h2>

    <a href="/gohappymart/admin-kategori/create" class="btn btn-primary mb-3">Tambah Kategori</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:80px">No</th>
                <th>Nama Kategori</th>
                <th style="width:180px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): $no = 1; ?>
                <?php foreach ($categories as $c): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($c->nama_kategori) ?></td>
                        <td class="text-center">
                            <a href="/gohappymart/admin-kategori/edit/<?= $c->id_kategori ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/gohappymart/admin-kategori/delete/<?= $c->id_kategori ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3" class="text-center">Belum ada kategori.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../../../users/layouts/footer.php'; ?>