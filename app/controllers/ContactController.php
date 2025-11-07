<?php

class ContactController extends Controller
{

    // Method ini akan dipanggil saat URL /public/contact diakses
    public function index()
    {
        // Langsung memuat file view lengkap Anda
        $this->view('users/contact');
    }
}