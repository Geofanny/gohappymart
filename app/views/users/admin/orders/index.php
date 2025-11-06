<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mt-4">
  <h2 class="mb-3">Daftar Pesanan</h2>

  <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark text-center">
      <tr>
        <th>No</th>
        <th>Kode Pesanan</th>
        <th>Status</th>
        <th>Tanggal Pesan</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($orders)): ?>
        <?php $no = 1; foreach ($orders as $order): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= htmlspecialchars($order->order_code) ?></td>
            <td><?= htmlspecialchars($order->status) ?></td>
            <td><?= htmlspecialchars($order->created_at) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="4" class="text-center">Belum ada pesanan.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>