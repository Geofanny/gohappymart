<?php include __DIR__ . '/../../../users/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Edit Produk</h2>
    <form action="/gohappymart/admin-produk/update/<?= $product->id_produk ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" value="<?= htmlspecialchars($product->nama_produk) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" value="<?= $product->harga ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" value="<?= $product->stok ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="id_kategori" class="form-select">
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c->id_kategori ?>" <?= ($product->id_kategori == $c->id_kategori) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c->nama_kategori) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($product->deskripsi) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Gambar Sekarang:</label><br>
            <?php if ($product->gambar): ?>
                <img src="/gohappymart/public/uploads/<?= $product->gambar ?>" width="100" class="mb-2">
            <?php endif; ?>
            <input type="file" name="gambar" class="form-control">
            <input type="hidden" name="gambar_lama" value="<?= $product->gambar ?>">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="/gohappymart/admin-produk" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include __DIR__ . '/../../../users/layouts/footer.php'; ?>