<?php include __DIR__ . '/../../../users/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Tambah Produk</h2>
    <form action="/gohappymart/admin-produk/store" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="id_kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c->id_kategori ?>"><?= htmlspecialchars($c->nama_kategori) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="/gohappymart/admin-produk" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include __DIR__ . '/../../../users/layouts/footer.php'; ?>