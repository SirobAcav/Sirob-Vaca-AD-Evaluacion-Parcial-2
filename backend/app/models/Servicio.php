<?php
require_once "Database.php";

class Servicio extends Database {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM servicios ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM servicios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO servicios (nombre, costo) VALUES (?, ?)");
        $stmt->execute([$data['nombre'] ?? null, $data['costo'] ?? 0]);
        return ["id" => $this->db->lastInsertId()];
    }
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE servicios SET nombre = ?, costo = ? WHERE id = ?");
        return $stmt->execute([$data['nombre'] ?? null, $data['costo'] ?? 0, $id]);
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM servicios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
