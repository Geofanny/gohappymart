<?php 

class AuthController extends Controller{
    public function index(){
        $this->view('users/login');
    }
    public function regis(){
        $this->view('users/register');
    }
    public function lupa(){
        $this->view('users/forgotpasword');
    }
}
?>