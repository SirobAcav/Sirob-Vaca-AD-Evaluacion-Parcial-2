<?php
require_once __DIR__ . "/../models/Factura.php";
require_once __DIR__ . "/../../libs/fpdf.php";
require_once __DIR__ . "/../pdf/fpdfFactura.php";

class FacturasController {
    private $model;
    public function __construct(){ $this->model = new Factura(); }

    public function index() { echo json_encode($this->model->getAll()); }

    public function show() {
        $id = $_GET['id'] ?? null;
        echo json_encode($this->model->getFacturaCompleta($id));
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode($this->model->crearFactura($data));
    }

    public function update() {
        $id = $_GET['id'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode($this->model->update($id, $data));
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        echo json_encode($this->model->delete($id));
    }

    public function pdf($id = null) {
        if (!$id) $id = $_GET['id'] ?? null;
        $fact = $this->model->getFacturaCompleta($id);
        if (!$fact) {
            http_response_code(404);
            echo "Factura no encontrada";
            return;
        }
        $pdf = new PDF_Factura();
        $pdf->generar($fact);
    }
}
