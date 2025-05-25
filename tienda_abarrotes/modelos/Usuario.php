<?php
require_once __DIR__ . '/../config/db.php';

class Usuario {
    private $conexion;

    public function __construct() {
        $this->conexion = db();
    }

    public function obtenerTodos() {
        $stmt = $this->conexion->prepare("SELECT u.*, r.nombre AS rol FROM usuarios u JOIN roles r ON u.rol_id = r.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($nombre, $correo, $password, $rol_id) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conexion->prepare("INSERT INTO usuarios (nombre, correo, password, rol_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $correo, $hash, $rol_id]);
    }

    public function eliminar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
