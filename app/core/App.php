<?php

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];
    protected $routes = [];

    public function __construct()
    {
        // Ambil semua route dari config
        $this->routes = require '../app/config/routes.php';

        // Parse URL
        $url = $this->parseURL();

        // ROUTE MATCHING (cari di routes.php)
        $routeKey = strtolower($url[0] ?? ''); // contoh: 'coba'
        if (array_key_exists($routeKey, $this->routes)) {
            $this->controller = $this->routes[$routeKey];
            unset($url[0]);
        }
        // fallback: cocokkan nama file controller langsung
        else if (isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }

        // Muat controller
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // METHOD
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // PARAMS
        $this->params = $url ? array_values($url) : [];

        // Jalankan controller & method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Fungsi parse URL
    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return ['']; // penting: biar bisa cocok ke '' di routes.php
    }
}
