<?php

    class BerandaController extends Controller{

        public function index()
    {
        // $data['nama'] = $this->model('Coba')->getAllData();
        $this->view('users/index');
    }

    }


?>