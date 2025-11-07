<h2>Detail Pesanan #<?= $order['id'] ?></h2>
<p><strong>Nama Pelanggan:</strong> <?= $order['customer_name'] ?></p>
<p><strong>Total:</strong> Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></p>
<p><strong>Status:</strong> <?= $order['status'] ?></p>

<form action="/admin/orders/updateStatus" method="POST">
    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
    <label for="status">Ubah Status:</label>
    <select name="status">
        <option value="Menunggu" <?= $order['status'] === 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
        <option value="Dikirim" <?= $order['status'] === 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
        <option value="Selesai" <?= $order['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
        <option value="Dibatalkan" <?= $order['status'] === 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
    </select>
    <button type="submit">Simpan</button>
</form>

<a href="/admin/orders">← Kembali</a>