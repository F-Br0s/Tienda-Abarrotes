<?php
session_start();
require 'config/db.php'; // Conexión a la BD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $password = hash('sha256', $_POST['password']);

    $sql = "SELECT u.id, u.nombre, u.rol_id, r.nombre AS rol
            FROM usuarios u
            INNER JOIN roles r ON u.rol_id = r.id
            WHERE u.correo = :correo AND u.password = :password
            LIMIT 1";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Guardar datos del usuario en la sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['rol_id'] = $usuario['rol_id'];

        header("Location: dashboard.php");
        exit;
    } else {
        header("Location: login.php?error=Credenciales incorrectas");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
