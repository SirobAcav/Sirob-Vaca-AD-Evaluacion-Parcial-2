<?php
require_once "Database.php";

class Factura extends Database {
    public function getAll() {
        $stmt = $this->db->query("
            SELECT f.id, c.nombre AS cliente, v.placa AS vehiculo, s.nombre AS servicio, e.nombre AS empleado, f.total, f.fecha
            FROM facturas f
            LEFT JOIN clientes c ON c.id = f.cliente_id
            LEFT JOIN vehiculos v ON v.id = f.vehiculo_id
            LEFT JOIN empleados e ON e.id = f.empleado_id
            LEFT JOIN factura_servicios fs ON fs.factura_id = f.id
            LEFT JOIN servicios s ON s.id = fs.servicio_id
            ORDER BY f.id DESC
        ");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM facturas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getFacturaCompleta($id) {
        $stmt = $this->db->prepare("
            SELECT f.*, c.nombre AS cliente, v.placa AS vehiculo, e.nombre AS empleado
            FROM facturas f
            LEFT JOIN clientes c ON c.id = f.cliente_id
            LEFT JOIN vehiculos v ON v.id = f.vehiculo_id
            LEFT JOIN empleados e ON e.id = f.empleado_id
            WHERE f.id = ?
        ");
        $stmt->execute([$id]);
        $fact = $stmt->fetch();
        if (!$fact) return null;

        $s = $this->db->prepare("
            SELECT s.id, s.nombre, s.costo, fs.cantidad
            FROM factura_servicios fs
            LEFT JOIN servicios s ON s.id = fs.servicio_id
            WHERE fs.factura_id = ?
        ");
        $s->execute([$id]);
        $fact['servicios'] = $s->fetchAll();

        return $fact;
    }

    public function crearFactura($data) {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("INSERT INTO facturas (cliente_id, vehiculo_id, empleado_id, total, fecha) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$data['cliente_id'], $data['vehiculo_id'], $data['empleado_id'], $data['total']]);
            $facturaId = $this->db->lastInsertId();

            if (!empty($data['servicios']) && is_array($data['servicios'])) {
                $ins = $this->db->prepare("INSERT INTO factura_servicios (factura_id, servicio_id, cantidad) VALUES (?, ?, ?)");
                foreach ($data['servicios'] as $srv) {
                    $ins->execute([$facturaId, $srv['servicio_id'], $srv['cantidad'] ?? 1]);
                }
            }

            $this->db->commit();
            return ["id" => $facturaId];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ["error" => $e->getMessage()];
        }
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE facturas SET cliente_id=?, vehiculo_id=?, empleado_id=?, total=? WHERE id=?");
        return $stmt->execute([$data['cliente_id'] ?? null, $data['vehiculo_id'] ?? null, $data['empleado_id'] ?? null, $data['total'] ?? 0, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM facturas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
