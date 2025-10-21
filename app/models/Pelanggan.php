<?php  
class Pelanggan {
    private $db;
    private $table = 'pelanggan';

    public function __construct() {
        $this->db = new Database();
    }

    // Ambil semua data pelanggan
    public function getAllData() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id_pelanggan DESC";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->resultObject();
    }

    // Ambil data pelanggan berdasarkan ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_pelanggan = ?";
        $this->db->query($query);
        $this->db->bind('i', $id);
        $this->db->execute();
        return $this->db->singleObject();
    }

    // Tambah pelanggan baru
    public function insertData($nama, $email, $password, $alamat, $no_hp, $status = 'aktif') {
        $query = "INSERT INTO " . $this->table . " 
                  (nama_pelanggan, email, password, alamat, no_hp, tanggal_daftar, status)
                  VALUES (?, ?, ?, ?, ?, NOW(), ?)";
        $this->db->query($query);
        $this->db->bind('ssssss', $nama, $email, $password, $alamat, $no_hp, $status);
        return $this->db->execute();
    }

    // Update data pelanggan
    public function updateData($id, $nama, $email, $password, $alamat, $no_hp, $status) {
        $query = "UPDATE " . $this->table . " 
                  SET nama_pelanggan = ?, email = ?, password = ?, alamat = ?, no_hp = ?, status = ?
                  WHERE id_pelanggan = ?";
        $this->db->query($query);
        $this->db->bind('ssssssi', $nama, $email, $password, $alamat, $no_hp, $status, $id);
        return $this->db->execute();
    }

    // Hapus pelanggan
    public function deleteData($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_pelanggan = ?";
        $this->db->query($query);
        $this->db->bind('i', $id);
        return $this->db->execute();
    }
}
?>
