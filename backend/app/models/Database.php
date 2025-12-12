<?php
require_once __DIR__ . "/../../config/conexion.php";

class Database {
    protected $db;
    public function __construct() {
        $this->db = Conexion::conectar();
    }
}
