<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../Model/Conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yantim - Agregar Usuario</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/formAgregarUsuario.css">
    <link rel="stylesheet" href="css/fondos-letras.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="fondo">

    <?php include "nav.php"; ?>

    <main class="formulario-contenedor">

        <form action="../Controller/UsuarioController.php?accion=agregar" class="contenedor__form" method="POST" onsubmit="return confirm('¿Deseas agregar este usuario?');">
            
            <h2 class="h2--form">Agregar Nuevo Usuario</h2>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="tipo_doc" class="label--form">Tipo Documento</label>
                    <select name="tipo_doc" id="tipo_doc" class="input--form select--form" required>
                        <option value="CC" selected>Cédula de Ciudadanía</option>
                        <option value="TI">Tarjeta de Identidad</option>
                        <option value="CE">Cédula de Extranjería</option>
                        <option value="PASAPORTE">Pasaporte</option>
                    </select>
                </div>
                <div class="grupo--input">
                    <label for="num_doc" class="label--form">N° Documento</label>
                    <input type="number" name="num_doc" id="num_doc" placeholder="Ej: 10203040" class="input--form" required>
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="primer_nombre" class="label--form">Primer Nombre</label>
                    <input type="text" name="primer_nombre" id="primer_nombre" placeholder="Primer Nombre" class="input--form" required>
                </div>
                <div class="grupo--input">
                    <label for="segundo_nombre" class="label--form">Segundo Nombre</label>
                    <input type="text" name="segundo_nombre" id="segundo_nombre" placeholder="Opcional" class="input--form">
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="primer_apellido" class="label--form">Primer Apellido</label>
                    <input type="text" name="primer_apellido" id="primer_apellido" placeholder="Primer Apellido" class="input--form" required>
                </div>
                <div class="grupo--input">
                    <label for="segundo_apellido" class="label--form">Segundo Apellido</label>
                    <input type="text" name="segundo_apellido" id="segundo_apellido" placeholder="Opcional" class="input--form">
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="correo" class="label--form">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" maxlength="100" placeholder="correo@ejemplo.com" class="input--form" required>
                </div>
                <div class="grupo--input">
                    <label for="telefono" class="label--form">Teléfono</label>
                    <input type="number" name="telefono" id="telefono" placeholder="Ej: 3001234567" class="input--form" required>
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="contrasena" class="label--form">Contraseña</label>
                    <input type="password" name="contrasena" id="contrasena" placeholder="******" min="8" class="input--form" required>
                </div>
                <div class="grupo--input">
                    <label for="rol" class="label--form">Rol</label>
                    <select name="rol" id="rol" class="input--form select--form" required>
                        <option value="cliente" selected>Cliente</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="fecha_nac" class="label--form">Fecha Nacimiento</label>
                    <input type="date" name="fecha_nac" id="fecha_nac" class="input--form" required>
                </div>
                <div class="grupo--input">
                    <label for="direccion" class="label--form">Dirección</label>
                    <input type="text" name="direccion" id="direccion" maxlength="30" placeholder="Calle 12 # 34-56" class="input--form" required>
                </div>
            </div>


            <div class="grupo--botones">
                <button type="submit" class="boton--form boton--guardar">Registrar Usuario</button>
                <a href="gestionUsuarios.php" class="boton--form boton--volver">Volver</a>
            </div>

        </form>
    </main>
    <script src="js/usuario-validador.js"></script>
</body>
</html>