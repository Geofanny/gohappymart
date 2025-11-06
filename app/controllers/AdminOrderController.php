<?php

class AdminOrderController extends Controller
{
    public function index()
    {
        $data['judul'] = 'Admin - Daftar Pesanan';
        $data['orders'] = $this->model('Order_model')->getAllOrders();

        $this->view('users/admin/orders/index', $data);
    }
}