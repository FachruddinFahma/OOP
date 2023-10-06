<?php
class Koneksi {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "user";
    public $koneksi;

    public function __construct() {
        try {
            $this->koneksi = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Koneksi gagal: " . $e->getMessage());
        }
    }

    public function getKoneksi() {
        return $this->koneksi;
    }
}
