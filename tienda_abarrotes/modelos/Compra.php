<?php
require_once __DIR__ . '/../config/db.php';

class Compra {
    private $conexion;

    public function __construct() {
        $this->conexion = db();
    }

    public function obtenerTodas() {
        $stmt = $this->conexion->prepare("SELECT * FROM compras");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($fecha, $total) {
        $stmt = $this->conexion->prepare("INSERT INTO compras (fecha, total) VALUES (?, ?)");
        return $stmt->execute([$fecha, $total]);
    }

    public function eliminar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM compras WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
