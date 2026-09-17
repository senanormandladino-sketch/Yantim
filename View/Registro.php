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
    <title>Yantim - Registro</title>
    <link rel="stylesheet" href="css/fondos-letras.css?v=1">
    <link rel="stylesheet" href="css/Registro.css?v=1">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body class="fondo body">

    <script src="js/registro-validador.js"></script>

    <script>
        function actualizarSelect() {
            const select = document.getElementById('tipo_doc');

            if (select.options[0].value === "Seleccione su tipo de DNI") {
                select.remove(0);
            }
        }

    </script>

    <?php include "nav.php"; ?>

    <div class="formulario-contenedor">

        <form action="../Controller/UsuarioController.php?accion=insertarPublico" class="contenedor__form" method="POST">
            
            <h2 class="h2--form">Regístrate</h2>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="tipo_doc" class="label--form">Tipo de Documento</label>
                    <select name="tipo_doc" id="tipo_doc" class="input--form select--form" onclick="actualizarSelect()" required>
                        <option disabled selected>Seleccione su tipo de DNI</option>
                        <option value="CC">Cédula de Ciudadanía</option>
                        <option value="CE">Cédula de Extranjería</option>
                        <option value="TI">Tarjeta de Identidad</option>
                        <option value="PAS">Pasaporte</option>
                    </select>
                </div>

                <div class="grupo--input">
                    <label for="documento" class="label--form">N° de Documento</label>
                    <input type="number" name="documento" id="documento" placeholder="Ej: 1020304050" class="input--form" required>
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="primer_nombre" class="label--form">Primer Nombre</label>
                    <input type="text" name="primer_nombre" id="primer_nombre" placeholder="Juan" class="input--form" required>
                </div>

                <div class="grupo--input">
                    <label for="segundo_nombre" class="label--form">Segundo Nombre</label>
                    <input type="text" name="segundo_nombre" id="segundo_nombre" placeholder="Carlos" class="input--form">
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="primer_apellido" class="label--form">Primer Apellido</label>
                    <input type="text" name="primer_apellido" id="primer_apellido" placeholder="Pérez" class="input--form" required>
                </div>

                <div class="grupo--input">
                    <label for="segundo_apellido" class="label--form">Segundo Apellido</label>
                    <input type="text" name="segundo_apellido" id="segundo_apellido" placeholder="Gómez" class="input--form">
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="correo" class="label--form">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" placeholder="correo@ejemplo.com" class="input--form" required>
                </div>

                <div class="grupo--input">
                    <label for="telefono" class="label--form">Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" placeholder="3144131736" class="input--form" required>
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="direccion" class="label--form">Dirección</label>
                    <input type="text" name="direccion" id="direccion" placeholder="Calle 123 #45-67" class="input--form" required>
                </div>

                <div class="grupo--input">
                    <label for="fecha_nac" class="label--form">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nac" id="fecha_nac" class="input--form" required>
                </div>
            </div>


            <div class="grupo--input">
                <label for="password" class="label--form">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="••••••••••••" class="input--form" required>
            </div>


            <div class="grupo--botones">
                <button type="submit" class="boton--form boton--guardar">Registrarse</button>
            </div>

        </form>
    </div>
</body>
</html>
  
       