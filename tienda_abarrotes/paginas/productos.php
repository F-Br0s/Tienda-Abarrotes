<?php
session_start();
require_once '../config/db.php';
require_once '../navbar.php';

// Agregar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$nombre, $precio, $stock]);

    header("Location: productos.php");
    exit;
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id]);

    header("Location: productos.php");
    exit;
}

// Editar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "UPDATE productos SET nombre = ?, precio = ?, stock = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$nombre, $precio, $stock, $id]);

    header("Location: productos.php");
    exit;
}

// Obtener productos
$sql = "SELECT * FROM productos";
$stmt = $conexion->query($sql);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Gestión de Productos</h2>

        <!-- Formulario agregar producto -->
        <form method="POST">
            <h3>Agregar nuevo producto</h3>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="number" step="0.01" name="precio" placeholder="Precio" required>
            <input type="number" name="stock" placeholder="Stock" required>
            <button type="submit" name="agregar">Agregar</button>
        </form>

        <h3>Lista de productos</h3>
        <table border="1" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio ($)</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $producto['id'] ?></td>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $producto['precio'] ?></td>
                    <td><?= $producto['stock'] ?></td>
                    <td>
                        <!-- Formulario para editar -->
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                            <input type="text" name="nombre" value="<?= $producto['nombre'] ?>" required>
                            <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required>
                            <input type="number" name="stock" value="<?= $producto['stock'] ?>" required>
                            <button type="submit" name="editar">Actualizar</button>
                        </form>
                        <!-- Enlace para eliminar -->
                        <a href="productos.php?eliminar=<?= $producto['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
