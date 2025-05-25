<?php
session_start();
require_once '../config/db.php';
require_once '../navbar.php';

// Obtener productos con su stock actual
$sql = "SELECT id, nombre, precio, stock FROM productos";
$stmt = $conexion->query($sql);
$inventario = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Inventario Actual</h2>

        <table border="1" cellpadding="5">
            <tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Precio ($)</th>
                <th>Stock Disponible</th>
            </tr>
            <?php foreach ($inventario as $producto): ?>
                <tr>
                    <td><?= $producto['id'] ?></td>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $producto['precio'] ?></td>
                    <td><?= $producto['stock'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
