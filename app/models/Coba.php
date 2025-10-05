<?php  
class Coba {
    private $db;
    private $table = 'kategori';

    // koneksiin ke database
    public function __construct() {
        $this->db = new Database();
    }

    // Ambil Semua Data
    public function getAllData() {
        $query = "SELECT * FROM " . $this->table;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->resultObject();
    }    

    // untuk detail data 
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_kategori = ?";
        $this->db->query($query);
        $this->db->bind('i', $id); // i = integer
        // (s = string, i = integer, d = double, b = blob)
        $this->db->execute();
        return $this->db->singleObject();
    }

    // Tambah Data
    public function insertData($nama_kategori) {
        $query = "INSERT INTO " . $this->table . " (nama_kategori) VALUES (?)";
        $this->db->query($query);
        $this->db->bind('s', $nama_kategori);
        // (s = string, i = integer, d = double, b = blob)
        return $this->db->execute();
    }

    // Update Data
    public function updateData($id, $nama_kategori)
    {
        $query = "UPDATE " . $this->table . " SET nama_kategori = ? WHERE id_kategori = ?";
        $this->db->query($query);
        $this->db->bind('si', $nama_kategori, $id); // gabungkan type string dan integer
        // (s = string, i = integer, d = double, b = blob)
        return $this->db->execute();
    }

    // Hapus data
    public function deleteData($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_kategori = ?";
        $this->db->query($query);
        $this->db->bind('i', $id);
        return $this->db->execute();
    }
    
}

?>