<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- navbar.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Mi Tienda</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="productos.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="productos.php">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="ventas.php">Ventas</a></li>
                <li class="nav-item"><a class="nav-link" href="compras.php">Compras</a></li>
                <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuarios</a></li>


            <?= $_SESSION['usuario'] ?? 'Invitado'; ?> (<?= $_SESSION['rol'] ?? 'Sin rol'; ?>)
                <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar ses¡ón</a></li>

            </ul>
        </div>
    </div>
</nav>

