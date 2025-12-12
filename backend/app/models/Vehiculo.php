<?php
require_once "Database.php";

class Vehiculo extends Database {
    public function getAll() {
        $stmt = $this->db->query("SELECT v.*, c.nombre AS cliente FROM vehiculos v LEFT JOIN clientes c ON c.id = v.cliente_id ORDER BY v.id DESC");
        return $stmt->fetchAll();
    }
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT v.*, c.nombre AS cliente FROM vehiculos v LEFT JOIN clientes c ON c.id = v.cliente_id WHERE v.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO vehiculos (cliente_id, marca, modelo, placa) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['cliente_id'] ?? null, $data['marca'] ?? null, $data['modelo'] ?? null, $data['placa'] ?? null]);
        return ["id" => $this->db->lastInsertId()];
    }
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE vehiculos SET cliente_id = ?, marca = ?, modelo = ?, placa = ? WHERE id = ?");
        return $stmt->execute([$data['cliente_id'] ?? null, $data['marca'] ?? null, $data['modelo'] ?? null, $data['placa'] ?? null, $id]);
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM vehiculos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
