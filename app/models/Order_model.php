<?php
class Order_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getOrderByCode($kode)
    {
        $query = "SELECT * FROM orders WHERE order_code = ? LIMIT 1";
        $this->db->query($query);
        $this->db->bind("s", $kode);
        $this->db->execute();
        return $this->db->singleObject(); // hasil object
    }
}