<?php
require_once __DIR__ . "/../models/Cliente.php";

class ClientesController {
    private $model;
    public function __construct(){ $this->model = new Cliente(); }

    public function index() { echo json_encode($this->model->getAll()); }
    public function show() {
        $id = $_GET['id'] ?? null;
        echo json_encode($this->model->getById($id));
    }
    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode($this->model->insert($data));
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
}
