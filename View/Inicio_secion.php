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
    <title>Yantim - Inicio de Sesión</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/inicio_secion.css?v=1">
    <link rel="stylesheet" href="css/fondos-letras.css">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body class="fondo body">

    <script src="js/login-validador.js"></script>

    <?php include "nav.php"; ?>

    <div class="formulario-contenedor">

        <form action="../Controller/UsuarioController.php?accion=login" class="contenedor__form" method="POST">

            <h2 class="h2--form">Iniciar Sesión</h2>


            <div class="grupo--input">
                <label for="correo" class="label--form">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" placeholder="correo@ejemplo.com" class="input--form" required>
            </div>


            <div class="grupo--input">
                <label for="password" class="label--form">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="••••••••••••" class="input--form" required>
            </div>


            <div class="texto--registro">
                <p>¿No tienes una cuenta? <a href="Registro.php" class="link--registro">Regístrate</a></p>
            </div>


            <div class="grupo--botones">
                <button type="submit" class="boton--form boton--guardar">Iniciar Sesión</button>
            </div>

        </form>
    </div>

</body>
</html>