<?php
require_once __DIR__ . '/../config/database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        $this->db->query("
            SELECT p.*, k.nama_kategori 
            FROM produk p
            LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
            ORDER BY p.id_produk DESC
        ");
        $this->db->execute();
        return $this->db->resultObject();
    }

    public function getById($id) {
        $this->db->query("
            SELECT p.*, k.nama_kategori 
            FROM produk p
            LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
            WHERE p.id_produk = ?
            LIMIT 1
        ");
        $this->db->bind("i", $id);
        $this->db->execute();
        return $this->db->singleObject();
    }

    public function create($nama, $harga, $stok, $deskripsi, $gambar, $id_kategori) {
        $this->db->query("
            INSERT INTO produk (nama_produk, harga, stok, deskripsi, gambar, id_kategori, status, tanggal_ditambahkan)
            VALUES (?, ?, ?, ?, ?, ?, 'aktif', NOW())
        ");
        $this->db->bind("siissi", $nama, $harga, $stok, $deskripsi, $gambar, $id_kategori);
        return $this->db->execute();
    }

    public function update($id, $nama, $harga, $stok, $deskripsi, $gambar, $id_kategori) {
        $this->db->query("
            UPDATE produk 
            SET nama_produk=?, harga=?, stok=?, deskripsi=?, gambar=?, id_kategori=? 
            WHERE id_produk=?
        ");
        $this->db->bind("siissii", $nama, $harga, $stok, $deskripsi, $gambar, $id_kategori, $id);
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM produk WHERE id_produk = ?");
        $this->db->bind("i", $id);
        return $this->db->execute();
    }
}