<?php
session_start();

class AkunController
{
    // Halaman profil
    public function index()
    {
        require_once 'app/views/users/account/profile.php';
    }

    // Halaman pengaturan akun
    public function pengaturan()
    {
        require_once 'app/views/users/account/pengaturan.php';
    }

    // Proses update data akun
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $telepon = $_POST['telepon'] ?? '';
            $alamat = $_POST['alamat'] ?? '';
            $notifikasi = isset($_POST['notifikasi']) ? 1 : 0;

            // Ambil foto lama
            $fotoBaru = $_SESSION['user']['foto'] ?? 'default.png';

            // Folder penyimpanan foto
            $uploadDir = 'public/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Cek jika user upload foto baru
            if (!empty($_FILES['foto']['name'])) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $namaFile = 'user_' . time() . '.' . $ext;
                $pathFile = $uploadDir . $namaFile;

                $allowed = ['jpg', 'jpeg', 'png'];
                if (in_array(strtolower($ext), $allowed)) {
                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $pathFile)) {
                        $fotoBaru = $namaFile;
                    }
                }
            }

            // Simpan ke session (sementara)
            $_SESSION['user'] = [
                'nama' => $nama,
                'email' => $email,
                'telepon' => $telepon,
                'alamat' => $alamat,
                'notifikasi' => $notifikasi,
                'foto' => $fotoBaru
            ];

            // Arahkan balik ke halaman profil
            header("Location: /gohappymart/akun");
            exit;
        }
    }
}