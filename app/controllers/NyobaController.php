<?php  

class NyobaController extends Controller{

    // Tampil semua data
    public function index()
    {
        $data['nama'] = $this->model('Coba')->getAllData();
        $this->view('coba',$data);
    }
    // detail data
    public function detail($id = null){
        if ($id === null) {
            die("ID kategori tidak ditemukan!");
        }

        $data['kategori'] = $this->model('Coba')->getById($id);
        $this->view('detail', $data);
    }
    // Menampilkan form tambah
    public function tambah() {
        $this->view('tambah');
    }
    // Insert data atau tambah data
    public function insert() {
        if (isset($_POST['tambah'])) {
            $nama = trim($_POST['nama_kategori']);

            // kalau input namanya kosong bakal ke handle
            if ($nama === '') {
                echo "<script>alert('Nama kategori tidak boleh kosong!');history.back();</script>";
                exit;
            }

            // ini dari model pake function insertData
            $this->model('Coba')->insertData($nama);
            echo "<script>alert('Data berhasil ditambahkan!');window.location.href='/gohappymart/nyoba';</script>";
            exit;
        } else {
            // kalau langsung akses tanpa submit
            header('Location: /gohappymart/nyoba/create');
            exit;
        }
    }

    // Menampilkan form edit
    public function edit($id = null) {
        // cek jika ada yang kirim id nya kosong atau id nya ga ada
        if ($id === null) {
            echo "<script>alert('ID tidak ditemukan!');window.location.href='/gohappymart/nyoba';</script>";
            exit;
        }

        // dari model
        $data['kategori'] = $this->model('Coba')->getById($id);
        $this->view('edit', $data);
    }

    // Update data
    public function update() {
        if (isset($_POST['update'])) {

            // ambil id yang dikirim dan inputan yang di masukkan
            $id = $_POST['id_kategori'];
            $nama = trim($_POST['nama_kategori']);

            if ($nama === '') {
                echo "<script>alert('Nama kategori tidak boleh kosong!');history.back();</script>";
                exit;
            }

            if ($this->model('Coba')->updateData($id, $nama)) {
                echo "<script>alert('Data berhasil diperbarui!');window.location.href='/gohappymart/nyoba';</script>";
                exit;
            } else {
                echo "<script>alert('Gagal memperbarui data!');history.back();</script>";
                exit;
            }
        } else {
            header('Location: /gohappymart/nyoba');
            exit;
        }
    }

    // Hapus Data
    public function hapus($id)
    {
        if ($this->model('Coba')->deleteData($id)) {
            header('Location: /gohappymart/nyoba');
            exit;
        } else {
            echo "Gagal menghapus data.";
        }
    }


}

?>