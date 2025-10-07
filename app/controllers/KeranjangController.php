<?php  

class KeranjangController extends Controller{

    public function index()
    {
        // $data['nama'] = $this->model('Coba')->getAllData();
        $this->view('users/keranjang');
    }

    public function checkout()
    {
        $this->view('users/bayar');
    }

}



?>