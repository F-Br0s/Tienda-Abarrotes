<?php
session_start();
require_once '../config/db.php';
require_once '../navbar.php';

// Agregar compra
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $fecha = date('Y-m-d');

    $sql = "INSERT INTO compras (producto_id, cantidad, fecha) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$producto_id, $cantidad, $fecha]);

    header("Location: compras.php");
    exit;
}

// Eliminar compra
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM compras WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id]);

    header("Location: compras.php");
    exit;
}

// Obtener compras
$sql = "SELECT c.id, p.nombre AS producto, c.cantidad, c.fecha FROM compras c JOIN productos p ON c.producto_id = p.id";
$stmt = $conexion->query($sql);
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener productos para el select
$productos = $conexion->query("SELECT * FROM productos")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compras</title>
</head>
<body>
    <div class="container">
        <h2>Gestión de Compras</h2>

        <form method="POST">
            <select name="producto_id" required>
                <option value="">Seleccione producto</option>
                <?php foreach ($productos as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="cantidad" placeholder="Cantidad" required>
            <button type="submit" name="agregar">Registrar compra</button>
        </form>

        <h3>Listado de Compras</h3>
        <table border="1">
            <tr><th>ID</th><th>Producto</th><th>Cantidad</th><th>Fecha</th><th>Acción</th></tr>
            <?php foreach ($compras as $compra): ?>
                <tr>
                    <td><?= $compra['id'] ?></td>
                    <td><?= $compra['producto'] ?></td>
                    <td><?= $compra['cantidad'] ?></td>
                    <td><?= $compra['fecha'] ?></td>
                    <td><a href="compras.php?eliminar=<?= $compra['id'] ?>" onclick="return confirm('¿Eliminar compra?')">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
