<?php  

class BantuanController extends Controller{

    public function index()
    {
        // $data['nama'] = $this->model('Coba')->getAllData();
        $this->view('users/bantuan');
    }

    public function checkout()
    {
        $this->view('users/bayar');
    }

}



?>