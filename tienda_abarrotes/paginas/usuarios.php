<?php
session_start();
require_once '../config/db.php';
require_once '../navbar.php';

// Agregar usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol_id = $_POST['rol_id'];
    $clave = password_hash($_POST['clave'], PASSWORD_BCRYPT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, clave, rol_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $correo, $clave, $rol_id]);

    header("Location: usuarios.php");
    exit;
}

// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$_GET['eliminar']]);

    header("Location: usuarios.php");
    exit;
}

// Obtener usuarios
$usuarios = $conexion->query("SELECT u.id, u.nombre, u.correo, r.nombre AS rol FROM usuarios u JOIN roles r ON u.rol_id = r.id")->fetchAll(PDO::FETCH_ASSOC);
$roles = $conexion->query("SELECT * FROM roles")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
</head>
<body>
    <div class="container">
        <h2>Gestión de Usuarios</h2>

        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="correo" placeholder="Correo" required>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <select name="rol_id" required>
                <option value="">Rol</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="agregar">Agregar</button>
        </form>

        <h3>Lista de Usuarios</h3>
        <table border="1">
            <tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th><th>Acción</th></tr>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= $u['nombre'] ?></td>
                    <td><?= $u['correo'] ?></td>
                    <td><?= $u['rol'] ?></td>
                    <td><a href="usuarios.php?eliminar=<?= $u['id'] ?>" onclick="return confirm('¿Eliminar usuario?')">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
