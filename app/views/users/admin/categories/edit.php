<?php include __DIR__ . '/../../../users/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Edit Kategori</h2>

    <form action="/gohappymart/admin-kategori/update/<?= $category->id_kategori ?>" method="POST">
        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" value="<?= htmlspecialchars($category->nama_kategori) ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="/gohappymart/admin-kategori" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include __DIR__ . '/../../../users/layouts/footer.php'; ?>