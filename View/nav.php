<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navegación</title>
    <link rel="stylesheet" href="css/nav.css?v=1">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
</head>
<body>
    <header class="header--navbar">
    <nav class="navbar">

        <div class="navbar--logo">
            <a href="index.php">
                <img src="../Assets/Imagenes/logo-yantim.png" alt="YANTIM Logo" class="img--logo">
            </a>
        </div>


        <ul class="navbar--menu">
            <li><a href="index.php" class="nav--link">Inicio</a></li>
            <li><a href="Nosotros.php" class="nav--link">Nosotros</a></li>
            <li><a href="Contactanos.php" class="nav--link">Contáctanos</a></li>

            <?php if (isset($_SESSION['usuario'])): ?>
                <li><a href="tienda.php" class="nav--link">Tienda</a></li>
                <li><a href="mis_compras.php" class="nav--link">Mis Compras</a></li>

                <?php if (!empty($_SESSION['es_admin'])): ?>

                    <li class="dropdown--perfil" id="dropdownAdmin">
                        <button class="nav--link link--admin btn--admin-dropdown" onclick="toggleDropdownAdmin(event)">
                            Administración <span class="flecha--down">▼</span>
                        </button>
                        <div class="dropdown--contenido">
                            <a href="gestionProductos.php" class="dropdown--item">Gestionar Productos</a>
                            <a href="gestionUsuarios.php" class="dropdown--item">Gestionar Usuarios</a>
                            <a href="gestionPedidos.php" class="dropdown--item">Gestionar Pedidos</a>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>


        <div class="navbar--acciones">
            <?php if (isset($_SESSION['usuario'])): ?>
                <div class="dropdown--perfil" id="dropdownPerfil">
                    <button class="btn--perfil-dropdown" onclick="toggleDropdownPerfil(event)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>
                            <?php 
                                echo htmlspecialchars($_SESSION['usuario']['nombre']); 
                                if (!empty($_SESSION['es_admin'])) {
                                    echo " (Admin)";
                                }
                            ?>
                        </span>
                        <span class="flecha--down">▼</span>
                    </button>

                    <div class="dropdown--contenido">
                        <a href="perfil.php" class="dropdown--item">Mi Perfil</a>
                        <hr class="dropdown--divisor">

                        <a href="../Controller/UsuarioController.php?accion=logout" class="dropdown--item item--logout">Cerrar Sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="Registro.php" class="btn--registrate">Regístrate</a>
                <a href="Inicio_secion.php" class="btn--iniciar">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<script>
function toggleDropdownPerfil(event) {
    event.stopPropagation();
    cerrarMenu('dropdownAdmin');
    const dropdown = document.getElementById('dropdownPerfil');
    alternarMenu(dropdown);
}

function toggleDropdownAdmin(event) {
    event.stopPropagation();
    cerrarMenu('dropdownPerfil');
    const dropdown = document.getElementById('dropdownAdmin');
    alternarMenu(dropdown);
}

function alternarMenu(dropdown) {
    if (!dropdown) return;
    if (dropdown.classList.contains('active')) {
        cerrarElemento(dropdown);
    } else {
        dropdown.classList.remove('closing');
        dropdown.classList.add('active');
    }
}

function cerrarElemento(dropdown) {
    dropdown.classList.remove('active');
    dropdown.classList.add('closing');
    setTimeout(() => {
        dropdown.classList.remove('closing');
    }, 200);
}

function cerrarMenu(id) {
    const el = document.getElementById(id);
    if (el && el.classList.contains('active')) {
        cerrarElemento(el);
    }
}

document.addEventListener('click', function (event) {
    const dropPerfil = document.getElementById('dropdownPerfil');
    const dropAdmin = document.getElementById('dropdownAdmin');
    if (dropPerfil && dropPerfil.classList.contains('active') && !dropPerfil.contains(event.target)) {
        cerrarElemento(dropPerfil);
    }
    if (dropAdmin && dropAdmin.classList.contains('active') && !dropAdmin.contains(event.target)) {
        cerrarElemento(dropAdmin);
    }
});
</script>
</body>
</html>