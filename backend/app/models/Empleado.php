<?php
require_once "Database.php";

class Empleado extends Database {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM empleados ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM empleados WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO empleados (nombre, cargo) VALUES (?, ?)");
        $stmt->execute([$data['nombre'] ?? null, $data['cargo'] ?? null]);
        return ["id" => $this->db->lastInsertId()];
    }
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE empleados SET nombre = ?, cargo = ? WHERE id = ?");
        return $stmt->execute([$data['nombre'] ?? null, $data['cargo'] ?? null, $id]);
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM empleados WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
