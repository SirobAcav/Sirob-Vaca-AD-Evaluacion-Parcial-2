<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

$method = $_SERVER["REQUEST_METHOD"];
$request = explode("/", trim($_SERVER["REQUEST_URI"], "/"));

$baseIndex = array_search("public", $request);
if ($baseIndex !== false) $request = array_slice($request, $baseIndex + 1);

$resource = $request[0] ?? "";
$param1 = $request[1] ?? null;
$param2 = $request[2] ?? null;

if ($param1 && is_numeric($param1)) $_GET['id'] = intval($param1);

require_once __DIR__ . "/../app/controllers/ClientesController.php";
require_once __DIR__ . "/../app/controllers/VehiculosController.php";
require_once __DIR__ . "/../app/controllers/EmpleadosController.php";
require_once __DIR__ . "/../app/controllers/ServiciosController.php";
require_once __DIR__ . "/../app/controllers/FacturasController.php";

$controllers = [
    "clientes" => new ClientesController(),
    "vehiculos" => new VehiculosController(),
    "empleados" => new EmpleadosController(),
    "servicios" => new ServiciosController(),
    "facturas" => new FacturasController()
];

if (!isset($controllers[$resource])) {
    http_response_code(404);
    echo json_encode(["error" => "Recurso no encontrado"]);
    exit;
}

$controller = $controllers[$resource];

if ($resource === "facturas" && $param1 === "pdf" && is_numeric($param2)) {
    header_remove("Content-Type");
    $controller->pdf($param2);
    exit;
}

switch ($method) {
    case "GET":
        if (isset($_GET['id'])) $controller->show();
        else $controller->index();
        break;
    case "POST":
        $controller->store();
        break;
    case "PUT":
        $controller->update();
        break;
    case "DELETE":
        $controller->delete();
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
}
