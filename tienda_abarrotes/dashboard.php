<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: errores/401.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    <p>Tu rol: <strong><?= htmlspecialchars($_SESSION['rol']) ?></strong></p>
</div>
</body>
</html>
