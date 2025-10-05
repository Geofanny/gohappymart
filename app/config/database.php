<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "gohappymart";
    private $conn;
    private $stmt;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    // Siapkan query dengan placeholder (?)
    public function query($query) {
        $this->stmt = $this->conn->prepare($query);
        if (!$this->stmt) {
            die("Error prepare: " . $this->conn->error);
        }
        return $this;
    }

    // Binding parameter dinamis
    public function bind($types, ...$values) {
        $this->stmt->bind_param($types, ...$values);
    }

    // Eksekusi statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Ambil semua data (object)
    public function resultObject() {
        $result = $this->stmt->get_result();
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }

    // Ambil satu data (object)
    public function singleObject() {
        $result = $this->stmt->get_result();
        return $result->fetch_object();
    }
}

?>