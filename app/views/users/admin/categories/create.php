<?php include __DIR__ . '/../../../users/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Tambah Kategori</h2>

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>

    <form action="/gohappymart/admin-kategori/store" method="POST">
        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="/gohappymart/admin-kategori" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include __DIR__ . '/../../../users/layouts/footer.php'; ?>