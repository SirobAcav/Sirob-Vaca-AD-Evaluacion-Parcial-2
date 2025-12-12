<?php
class Conexion {
    private static $host = "localhost";
    private static $db   = "taller_mecanico";
    private static $user = "root";
    private static $pass = "";
    private static $charset = "utf8";

    public static function conectar() {
        try {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;
            $pdo = new PDO($dsn, self::$user, self::$pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            return $pdo;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Error en la conexión: " . $e->getMessage()]);
            exit;
        }
    }
}
