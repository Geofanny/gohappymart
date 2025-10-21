<?php  

class KeranjangController extends Controller{

    public function index()
    {
        $this->view('users/keranjang');
    }

    public function checkout()
    {
        $data['pelanggan'] = $this->model('Pelanggan')->getById(1);
        $this->view('users/bayar',$data);
    }

    public function getProvinces()
    {
        require_once 'app/Helpers/RajaOngkirHelper.php';

        $data = RajaOngkirHelper::getProvinces();

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function getCities()
{
    require_once 'app/Helpers/RajaOngkirHelper.php';

    // Ambil data dari POST
    $province = $_POST['province'] ?? '';

    if (!$province) {
        http_response_code(400);
        echo json_encode(['error' => 'Province is required']);
        return;
    }

    $data = RajaOngkirHelper::getCities($province);

    header('Content-Type: application/json');
    echo json_encode($data);
}

    



}



?>