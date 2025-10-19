<?php
require_once __DIR__ . '/../config/database.php';

class Category {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        $this->db->query("SELECT * FROM kategori");
        $this->db->execute();
        return $this->db->resultObject();
    }
}