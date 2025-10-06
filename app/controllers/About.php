<?php

class About extends Controller
{
    public function index()
    {
        $data['judul'] = 'Tentang Kami';

        // Tampilkan header
        $this->view('templates/header', $data);

        // Tampilkan isi utama halaman
        $this->view('about/index', $data);

        // Tampilkan footer
        $this->view('templates/footer');
    }
}