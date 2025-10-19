<?php include __DIR__ . '/../../../users/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Detail Produk</h2>
    <div class="card shadow-sm p-4">
        <div class="row">
            <div class="col-md-4 text-center">
                <?php if (!empty($product->gambar)): ?>
                    <img src="/gohappymart/public/uploads/<?= htmlspecialchars($product->gambar) ?>" class="img-fluid rounded">
                <?php else: ?>
                    <p><em>Tidak ada gambar</em></p>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <h4><?= htmlspecialchars($product->nama_produk) ?></h4>
                <p><strong>Kategori:</strong> <?= htmlspecialchars($product->nama_kategori ?? '-') ?></p>
                <p><strong>Harga:</strong> Rp <?= number_format($product->harga, 0, ',', '.') ?></p>
                <p><strong>Stok:</strong> <?= $product->stok ?></p>
                <p><strong>Deskripsi:</strong><br><?= nl2br(htmlspecialchars($product->deskripsi ?? '-')) ?></p>

                <div class="mt-3">
                    <a href="/gohappymart/admin-produk/edit/<?= $product->id_produk ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="/gohappymart/admin-produk/delete/<?= $product->id_produk ?>" onclick="return confirm('Yakin hapus produk ini?')" class="btn btn-danger btn-sm">Hapus</a>
                    <a href="/gohappymart/admin-produk" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../../users/layouts/footer.php'; ?>