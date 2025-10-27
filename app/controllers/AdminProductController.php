<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../config/database.php';

class AdminProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    // ==================== PRODUK CRUD ====================

    public function index() {
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../views/users/admin/products/index.php';
    }

    public function create() {
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../views/users/admin/products/create.php';
    }

    public function store() {
        $nama_produk = $_POST['nama_produk'] ?? '';
        $harga = $_POST['harga'] ?? 0;
        $stok = $_POST['stok'] ?? 0;
        $deskripsi = $_POST['deskripsi'] ?? '';
        $id_kategori = !empty($_POST['id_kategori']) ? $_POST['id_kategori'] : null;
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

    public function edit($id = null) {
        if ($id === null) {
            echo "<div style='color:red;text-align:center;margin-top:20px;'>ID produk tidak ditemukan.</div>";
            return;
        }
        $product = $this->productModel->getById($id);
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../views/users/admin/products/edit.php';
    }

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

    public function delete($id = null) {
        if ($id === null) {
            echo "<div style='color:red;text-align:center;margin-top:20px;'>ID produk tidak ditemukan.</div>";
            return;
        }

        $this->productModel->delete($id);
        header('Location: /gohappymart/admin-produk');
        exit;
    }

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

    // ==================== KATEGORI (AJAX) ====================

    public function storeCategory() {
        header('Content-Type: application/json');
        ob_clean();

        try {
            $nama = $_POST['nama_kategori'] ?? '';

            if (empty($nama)) {
                echo json_encode(['status' => 'error', 'message' => 'Nama kategori tidak boleh kosong.']);
                return;
            }

            $db = new Database();
            $db->query("INSERT INTO kategori (nama_kategori) VALUES (?)");
            $db->bind("s", $nama);
            $success = $db->execute();

            if ($success) {
                $conn = new mysqli("localhost", "root", "", "gohappymart");
                $lastId = $conn->insert_id;
                $conn->close();

                echo json_encode([
                    'status' => 'success',
                    'id' => $lastId,
                    'nama' => $nama,
                    'message' => 'Kategori berhasil ditambahkan.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal menambahkan kategori ke database.'
                ]);
            }
        } catch (Throwable $e) {
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
        exit;
    }

    public function deleteCategory() {
        header('Content-Type: application/json');
        ob_clean();

        try {
            $id = $_POST['id_kategori'] ?? null;
            if (!$id) {
                echo json_encode(['status' => 'error', 'message' => 'ID kategori tidak ditemukan.']);
                return;
            }

            $db = new Database();
            $db->query("DELETE FROM kategori WHERE id_kategori = ?");
            $db->bind("i", $id);
            $db->execute();

            echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil dihapus.']);
        } catch (Throwable $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus kategori: ' . $e->getMessage()]);
        }
        exit;
    }
}