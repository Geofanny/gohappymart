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
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="4"></textarea>
    </div>

    <div class="mb-3">
      <label>Kategori</label>
      <div class="d-flex">
        <select name="id_kategori" id="id_kategori" class="form-select" style="flex:1;">
          <option value="">-- Pilih Kategori --</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat->id_kategori ?>"><?= htmlspecialchars($cat->nama_kategori) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="button" id="btnTambahKategori" class="btn btn-primary ms-2">+ Tambah</button>
        <button type="button" id="btnHapusKategori" class="btn btn-danger ms-2">🗑️ Hapus</button>
      </div>
      <small class="text-muted">*Pilih kategori lalu klik hapus untuk menghapusnya</small>
    </div>

    <div class="mb-3">
      <label>Gambar Produk</label>
      <input type="file" name="gambar" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Simpan Produk</button>
  </form>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formTambahKategori" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kategori Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="nama_kategori" class="form-control" placeholder="Nama kategori" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // buka modal tambah kategori
  $('#btnTambahKategori').click(function() {
    $('#modalTambahKategori').modal('show');
  });

  // submit kategori via AJAX
  $('#formTambahKategori').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
      url: '/gohappymart/admin-produk/storeCategory',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response) {
        if (response.status === 'success') {
          alert(response.message);
          $('#modalTambahKategori').modal('hide');

          // tambahkan kategori ke dropdown
          $('#id_kategori').append(
            $('<option>', { value: response.id, text: response.nama })
          ).val(response.id);
        } else {
          alert('⚠️ ' + response.message);
        }
      },
      error: function(xhr) {
        console.log(xhr.responseText);
        alert('❌ Terjadi kesalahan koneksi ke server.');
      }
    });
  });

  // hapus kategori via AJAX
  $('#btnHapusKategori').click(function() {
    const id = $('#id_kategori').val();
    const nama = $('#id_kategori option:selected').text();

    if (!id) {
      alert('⚠️ Pilih kategori yang ingin dihapus terlebih dahulu!');
      return;
    }

    if (!confirm(`Yakin ingin menghapus kategori "${nama}"?`)) return;

    $.ajax({
      url: '/gohappymart/admin-produk/deleteCategory',
      type: 'POST',
      data: { id_kategori: id },
      dataType: 'json',
      success: function(response) {
        if (response.status === 'success') {
          alert(response.message);
          $('#id_kategori option[value="'+id+'"]').remove();
        } else {
          alert('⚠️ ' + response.message);
        }
      },
      error: function(xhr) {
        console.log(xhr.responseText);
        alert('❌ Gagal menghubungi server.');
      }
    });
  });
});
</script>

<?php include __DIR__ . '/../../../users/layouts/footer.php'; ?>