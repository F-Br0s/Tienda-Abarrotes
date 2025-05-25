<?php
try {
    $conexion = new PDO("mysql:host=localhost;dbname=tienda_abarrotes", "tienda", "clave_segura");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>



