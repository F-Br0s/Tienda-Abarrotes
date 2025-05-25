<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inicia la sesión si aún no está iniciada
session_start();

// Puedes redirigir a login si no hay sesión activa (luego lo ajustamos)
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include 'navbar.php'; // Carga el menú principal
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Tienda de Abarrotes</title>
    <link rel="stylesheet" href="assets/css/estilos.css"> <!-- si tienes uno -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido a la Tienda de Abarrotes</h1>
        <p>Desde aquí puedes gestionar productos, ventas, compras, usuarios y más.</p>
    </div>
</body>
</html>



