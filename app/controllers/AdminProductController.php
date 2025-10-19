<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class AdminProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    // Halaman daftar produk
    public function index() {
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();

        require_once __DIR__ . '/../views/users/admin/products/index.php';
    }

    // Form tambah produk
    public function create() {
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../views/users/admin/products/create.php';
    }

    // Simpan produk baru
    public function store() {
        $nama_produk = $_POST['nama_produk'] ?? '';
        $harga = $_POST['harga'] ?? 0;
        $stok = $_POST['stok'] ?? 0;
        $deskripsi = $_POST['deskripsi'] ?? '';
        $id_kategori = $_POST['id_kategori'] ?? null;
        $gambar = '';

        if (!empty($_FILES['gambar']['name'])) {
            $targetDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            $fileName = time() . '_' . basename($_FILES['gambar']['name']);
            move_uploaded_file($_FILES['gambar']['tmp_name'], $targetDir . $fileName);
            $gambar = $fileName;
        }

        $this->productModel->create($nama_produk, $harga, $stok, $deskripsi, $gambar, $id_kategori);
        header('Location: /gohappymart/admin-produk');
        exit;
    }

    // Form edit produk
    public function edit($id = null) {
        if ($id === null) {
            echo "<div style='color:red;text-align:center;margin-top:20px;'>ID produk tidak ditemukan.</div>";
            return;
        }

        $product = $this->productModel->getById($id);
        $categories = $this->categoryModel->getAll();

        require_once __DIR__ . '/../views/users/admin/products/edit.php';
    }

    // Update produk
    public function update($id) {
        $nama_produk = $_POST['nama_produk'] ?? '';
        $harga = $_POST['harga'] ?? 0;
        $stok = $_POST['stok'] ?? 0;
        $deskripsi = $_POST['deskripsi'] ?? '';
        $id_kategori = $_POST['id_kategori'] ?? null;
        $gambar = $_POST['gambar_lama'] ?? '';

        if (!empty($_FILES['gambar']['name'])) {
            $targetDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            $fileName = time() . '_' . basename($_FILES['gambar']['name']);
            move_uploaded_file($_FILES['gambar']['tmp_name'], $targetDir . $fileName);
            $gambar = $fileName;
        }

        $this->productModel->update($id, $nama_produk, $harga, $stok, $deskripsi, $gambar, $id_kategori);
        header('Location: /gohappymart/admin-produk');
        exit;
    }

    // Hapus produk
    public function delete($id = null) {
        if ($id === null) {
            echo "<div style='color:red;text-align:center;margin-top:20px;'>ID produk tidak ditemukan.</div>";
            return;
        }

        $this->productModel->delete($id);
        header('Location: /gohappymart/admin-produk');
        exit;
    }

    // Detail produk
    public function show($id = null) {
        if ($id === null) {
            echo "<div style='color:red;text-align:center;margin-top:20px;'>ID produk tidak ditemukan.</div>";
            return;
        }

        $product = $this->productModel->getById($id);

        if (!$product) {
            echo "<div style='color:red;text-align:center;margin-top:20px;'>Produk tidak ditemukan.</div>";
            return;
        }

        require_once __DIR__ . '/../views/users/admin/products/show.php';
    }
}