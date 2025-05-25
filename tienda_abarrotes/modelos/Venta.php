<?php
require_once __DIR__ . '/../config/db.php';

class Venta {
    private $conexion;

    public function __construct() {
        $this->conexion = db();
    }

    public function obtenerTodas() {
        $stmt = $this->conexion->prepare("SELECT * FROM ventas");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($fecha, $total) {
        $stmt = $this->conexion->prepare("INSERT INTO ventas (fecha, total) VALUES (?, ?)");
        return $stmt->execute([$fecha, $total]);
    }

    public function eliminar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM ventas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
