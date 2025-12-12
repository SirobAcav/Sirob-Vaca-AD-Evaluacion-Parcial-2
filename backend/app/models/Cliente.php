<?php
require_once "Database.php";

class Cliente extends Database {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM clientes ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO clientes (nombre, telefono, email) VALUES (?, ?, ?)");
        $stmt->execute([$data['nombre'] ?? null, $data['telefono'] ?? null, $data['email'] ?? null]);
        return ["id" => $this->db->lastInsertId()];
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE clientes SET nombre = ?, telefono = ?, email = ? WHERE id = ?");
        return $stmt->execute([$data['nombre'] ?? null, $data['telefono'] ?? null, $data['email'] ?? null, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
