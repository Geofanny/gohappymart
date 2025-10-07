<?php  

class CobaControllers extends Controller{
    public function index()
    {

        // $data['nama'] = $this->model('Coba')->getUser();

        // echo 'index coba aja';
        // $this->view('dashboard/admin/layouts/header');
        // $this->view('dashboard/admin/index');
        $this->view('dashboard/mentahan/elements/icon-phosphor');
        // $this->view('dashboard/admin/layouts/footer');
    }
    public function superadmin()
    {
        // $this->view('dashboard/superadmin/layouts/header');
        $this->view('dashboard/superadmin/index');
        // $this->view('dashboard/superadmin/layouts/footer');
    }
}

?>