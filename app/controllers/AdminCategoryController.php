<?php
require_once __DIR__ . '/../models/Category.php';

class AdminCategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    // Tampilkan daftar kategori
    public function index() {
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../views/users/admin/categories/index.php';
    }

    // Form tambah kategori
    public function create() {
        require_once __DIR__ . '/../views/users/admin/categories/create.php';
    }

    // Simpan kategori baru
    public function store() {
        $nama = $_POST['nama_kategori'] ?? '';
        $nama = trim($nama);

        if ($nama === '') {
            // bisa alihkan kembali atau tampilkan error sederhana
            $_SESSION['flash_error'] = 'Nama kategori wajib diisi.';
            header('Location: /gohappymart/admin-kategori/create');
            exit;
        }

        $this->categoryModel->create($nama);
        header('Location: /gohappymart/admin-kategori');
        exit;
    }

    // Form edit kategori
    public function edit($id = null) {
        if (!$id) {
            echo "<div style='color:red;text-align:center;margin-top:20px;'>ID kategori tidak ditemukan.</div>";
            return;
        }

        $category = $this->categoryModel->getById($id);
        if (!$category) {
            echo "<div style='color:red;text-align:center;margin-top:20px;'>Kategori tidak ditemukan.</div>";
            return;
        }

        require_once __DIR__ . '/../views/users/admin/categories/edit.php';
    }

    // Update kategori
    public function update($id) {
        $nama = $_POST['nama_kategori'] ?? '';
        $nama = trim($nama);

        if ($nama === '') {
            $_SESSION['flash_error'] = 'Nama kategori wajib diisi.';
            header('Location: /gohappymart/admin-kategori/edit/' . $id);
            exit;
        }

        $this->categoryModel->update($id, $nama);
        header('Location: /gohappymart/admin-kategori');
        exit;
    }

    // Hapus kategori
    public function delete($id = null) {
        if (!$id) {
            echo "<div style='color:red;text-align:center;margin-top:20px;'>ID kategori tidak ditemukan.</div>";
            return;
        }

        // NOTE: produk punya FK ke kategori (ON DELETE SET NULL). Jika DB diatur seperti itu, hapus kategori aman.
        $this->categoryModel->delete($id);
        header('Location: /gohappymart/admin-kategori');
        exit;
    }
}