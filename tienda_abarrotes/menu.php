<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include 'navbar.php'; // Usa el menú común
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Menú Principal</h2>
    <div class="row g-4">

        <div class="col-md-4">
            <a href="paginas/productos.php" class="btn btn-primary w-100">
                🛒 Productos
            </a>
        </div>

        <div class="col-md-4">
            <a href="paginas/ventas.php" class="btn btn-success w-100">
                💵 Ventas
            </a>
        </div>

        <div class="col-md-4">
            <a href="paginas/compras.php" class="btn btn-warning w-100">
                📦 Compras
            </a>
        </div>

        <div class="col-md-4">
            <a href="paginas/inventario.php" class="btn btn-info w-100">
                📊 Inventario
            </a>
        </div>

        <div class="col-md-4">
            <a href="paginas/usuarios.php" class="btn btn-dark w-100">
                👤 Usuarios
            </a>
        </div>

        <div class="col-md-4">
            <a href="logout.php" class="btn btn-danger w-100">
                🔒 Cerrar Sesión
            </a>
        </div>

    </div>
</div>
</body>
</html>
