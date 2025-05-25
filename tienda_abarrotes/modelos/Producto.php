

<?php
require_once __DIR__ . '/../config/db.php';

class Producto {
    private $conexion;

    public function __construct() {
        $this->conexion = db.php();
    }

    public function obtenerTodos() {
        $stmt = $this->conexion->prepare("SELECT * FROM productos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($nombre, $descripcion, $precio, $stock) {
        $stmt = $this->conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $descripcion, $precio, $stock]);
    }

    public function eliminar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM productos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}


