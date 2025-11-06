<?php include __DIR__ . '/../users/layouts/header.php'; ?>

<div class="container mt-5 pt-5">
  <h2 class="text-center mb-4">Pelacakan Pesanan</h2>

  <form method="POST" action="/gohappymart/tracking" class="w-75 mx-auto mb-5">
    <div class="input-group">
      <input type="text" class="form-control" name="kode_pesanan" placeholder="Masukkan kode pesanan (contoh: GH12345)" required>
      <button type="submit" class="btn btn-primary">Lacak</button>
    </div>
  </form>

  <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <?php if (!empty($order)): ?>
      <div class="card shadow-sm p-4 w-75 mx-auto">
        <h5>Kode Pesanan: <?= htmlspecialchars($order->order_code); ?></h5>
        <p>Status: <strong><?= htmlspecialchars($order->status); ?></strong></p>
        <p>Tanggal Pesan: <?= htmlspecialchars($order->created_at); ?></p>
      </div>
    <?php else: ?>
      <div class="alert alert-danger w-75 mx-auto text-center">Kode pesanan tidak ditemukan.</div>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../users/layouts/footer.php'; ?>