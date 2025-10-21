<?php
require_once __DIR__ . '/../config/database.php';

class Category {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        $this->db->query("SELECT * FROM kategori ORDER BY id_kategori DESC");
        $this->db->execute();
        return $this->db->resultObject();
    }

    public function create($nama_kategori) {
        $this->db->query("INSERT INTO kategori (nama_kategori) VALUES (?)");
        $this->db->bind("s", $nama_kategori);
        return $this->db->execute();
    }
}