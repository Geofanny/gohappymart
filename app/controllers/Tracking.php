<?php
class Tracking extends Controller
{
    public function index()
    {
        $data['judul'] = 'Pelacakan Pesanan';
        $order = null;

        // Jika user menekan tombol "Lacak"
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['kode_pesanan'])) {
            $kode = trim($_POST['kode_pesanan']);
            $order = $this->model('Order_model')->getOrderByCode($kode);
        }

        // kirim variabel ke view
        include __DIR__ . '/../views/tracking/index.php';
    }
}
