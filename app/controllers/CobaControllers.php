<?php  

class CobaControllers extends Controller{
    public function index()
    {

        // $data['nama'] = $this->model('Coba')->getUser();

        // echo 'index coba aja';
        // $this->view('dashboard/admin/layouts/header');
        // $this->view('dashboard/admin/index');
        $this->view('dashboard/admin/index');
        // $this->view('dashboard/admin/layouts/footer');
    }
    public function superadmin()
    {
        // $this->view('dashboard/superadmin/layouts/header');
        $this->view('dashboard/superadmin/index');
        // $this->view('dashboard/superadmin/layouts/footer');
    }
    public function user()
    {
        $this->view('user');
    }
    public function tambahUser() {
        if (isset($_POST['tambah'])) {
            // var_dump($_POST);
            // die;
            $nama = trim($_POST['nama_pelanggan']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $alamat_jalan = trim($_POST['alamat']); // Jl. Mawar No. 123
            $kelurahan = trim($_POST['kelurahan']);
            $kecamatan = trim($_POST['kecamatan']);
            $kota = trim($_POST['kota']);
            $provinsi = trim($_POST['provinsi']);
            $kode_pos = trim($_POST['kode_pos']);
            $no_hp = trim($_POST['no_hp']);
            $status = 'aktif';
    
            // Validasi sederhana
            if (
                $nama === '' || $email === '' || $password === '' ||
                $alamat_jalan === '' || $kelurahan === '' || $kecamatan === '' ||
                $kota === '' || $provinsi === '' || $kode_pos === '' || $no_hp === ''
            ) {
                echo "<script>alert('Semua field wajib diisi!');history.back();</script>";
                exit;
            }
    
            // Gabungkan alamat lengkap
            $alamat_lengkap = sprintf(
                "%s, Kel. %s, Kec. %s, %s, %s - %s",
                $alamat_jalan,
                $kelurahan,
                $kecamatan,
                $kota,
                $provinsi,
                $kode_pos
            );
    
            // Hash password biar aman
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Simpan lewat model
            $this->model('Pelanggan')->insertData(
                $nama,
                $email,
                $hashedPassword,
                $alamat_lengkap,
                $no_hp,
                $status
            );
    
            echo "<script>alert('Data pelanggan berhasil ditambahkan!');window.location.href='/gohappymart/coba/user';</script>";
            exit;
        } else {
            header('Location: /gohappymart/coba/user');
            exit;
        }
    }
    
    
}

?>