<?php
// Mulai session kalau dibutuhkan
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Tentukan BASEURL (ganti "gohappymart" sesuai nama folder project kamu)
define('BASEURL', 'http://localhost/gohappymart/public');

// Load semua inti aplikasi
require_once '../app/init.php';

// Jalankan aplikasi
$app = new App();