<?php
session_start();
require_once '../config/db.php';
require_once '../navbar.php';

// Agregar venta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $fecha = date('Y-m-d');

    // Insertar en tabla ventas
    $sqlVenta = "INSERT INTO ventas (fecha) VALUES (?)";
    $stmtVenta = $conexion->prepare($sqlVenta);
    $stmtVenta->execute([$fecha]);
    $idVenta = $conexion->lastInsertId();

    // Insertar en detalle_venta
    $sqlDetalle = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad) VALUES (?, ?, ?)";
    $stmtDetalle = $conexion->prepare($sqlDetalle);
    $stmtDetalle->execute([$idVenta, $id_producto, $cantidad]);

    header("Location: ventas.php");
    exit;
}

// Obtener productos para el selector
$stmtProductos = $conexion->query("SELECT id, nombre FROM productos");
$productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

// Obtener ventas con detalles
$sql = "SELECT v.id, v.fecha, p.nombre AS producto, dv.cantidad, p.precio
        FROM ventas v
        JOIN detalle_venta dv ON v.id = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id";
$stmtVentas = $conexion->query($sql);
$ventas = $stmtVentas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Gestión de Ventas</h2>

        <!-- Formulario agregar venta -->
        <form method="POST">
            <h3>Agregar nueva venta</h3>
            <label>Producto:</label>
            <select name="id_producto" required>
                <option value="">Seleccione un producto</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="cantidad" placeholder="Cantidad" required>
            <button type="submit" name="agregar">Registrar Venta</button>
        </form>

        <h3>Lista de ventas</h3>
        <table border="1" cellpadding="5">
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
            <?php if (!empty($ventas)): ?>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?= $venta['id'] ?></td>
                        <td><?= $venta['fecha'] ?></td>
                        <td><?= $venta['producto'] ?></td>
                        <td><?= $venta['cantidad'] ?></td>
                        <td>$<?= number_format($venta['precio'], 2) ?></td>
                        <td>$<?= number_format($venta['cantidad'] * $venta['precio'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No hay ventas registradas.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
