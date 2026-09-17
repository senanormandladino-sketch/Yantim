<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../Model/Conexion.php");


if (!isset($_GET['Id']) || empty($_GET['Id'])) {
    header("Location: administradores.php");
    exit();
}

$id_cliente = intval($_GET['Id']);


$sql = "SELECT * FROM clientes WHERE IdCliente = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "No se encontró ningún registro con el ID: " . $id_cliente;
    exit();
}

$usuario = $resultado->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yantim - Editar Usuario</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/formEditarUsuario.css">
    <link rel="stylesheet" href="css/fondos-letras.css">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="fondo">

    <?php include "nav.php"; ?>

    <main class="formulario-contenedor">

        <form action="../Controller/UsuarioController.php?accion=editar" class="contenedor__form" method="POST" onsubmit="return confirm('¿Deseas editar este usuario?');">
            
            <h2 class="h2--form">Editar Usuario</h2>


            <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($usuario['IdCliente']); ?>">


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="tipo_doc" class="label--form">Tipo Documento</label>
                    <select name="tipo_doc" id="tipo_doc" class="input--form select--form" required>
                        <option value="CC" <?php echo ($usuario['TipoDocumento'] == 'CC') ? 'selected' : ''; ?>>Cédula de Ciudadanía</option>
                        <option value="TI" <?php echo ($usuario['TipoDocumento'] == 'TI') ? 'selected' : ''; ?>>Tarjeta de Identidad</option>
                        <option value="CE" <?php echo ($usuario['TipoDocumento'] == 'CE') ? 'selected' : ''; ?>>Cédula de Extranjería</option>
                        <option value="PASAPORTE" <?php echo ($usuario['TipoDocumento'] == 'PASAPORTE') ? 'selected' : ''; ?>>Pasaporte</option>
                    </select>
                </div>
                <div class="grupo--input">
                    <label for="num_doc" class="label--form">N° Documento</label>
                    <input type="number" name="num_doc" id="num_doc" value="<?php echo htmlspecialchars($usuario['NumeroDocumento']); ?>" class="input--form" required>
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="primer_nombre" class="label--form">Primer Nombre</label>
                    <input type="text" name="primer_nombre" id="primer_nombre" maxlength="20" value="<?php echo htmlspecialchars($usuario['PrimerNombre']); ?>" class="input--form" required>
                </div>
                <div class="grupo--input">
                    <label for="segundo_nombre" class="label--form">Segundo Nombre</label>
                    <input type="text" name="segundo_nombre" id="segundo_nombre" maxlength="20" value="<?php echo htmlspecialchars($usuario['SegundoNombre'] ?? ''); ?>" placeholder="Opcional" class="input--form">
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="primer_apellido" class="label--form">Primer Apellido</label>
                    <input type="text" name="primer_apellido" id="primer_apellido" maxlength="20" value="<?php echo htmlspecialchars($usuario['PrimerApellido']); ?>" class="input--form" required>
                </div>
                <div class="grupo--input">
                    <label for="segundo_apellido" class="label--form">Segundo Apellido</label>
                    <input type="text" name="segundo_apellido" id="segundo_apellido" maxlength="20" value="<?php echo htmlspecialchars($usuario['SegundoApellido'] ?? ''); ?>" placeholder="Opcional" class="input--form">
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="correo" class="label--form">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" maxlength="100" value="<?php echo htmlspecialchars($usuario['Correo']); ?>" class="input--form" required>
                </div>
                <div class="grupo--input">
                    <label for="telefono" class="label--form">Teléfono</label>
                    <input type="number" name="telefono" id="telefono" value="<?php echo htmlspecialchars($usuario['Telefono']); ?>" class="input--form" required>
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="fecha_nac" class="label--form">Fecha Nacimiento</label>
                    <input type="date" name="fecha_nac" id="fecha_nac" value="<?php echo htmlspecialchars($usuario['FechaNacimiento']); ?>" class="input--form" required>
                </div>
                <div class="grupo--input">
                    <label for="direccion" class="label--form">Dirección</label>
                    <input type="text" name="direccion" id="direccion" maxlength="30" value="<?php echo htmlspecialchars($usuario['Direccion']); ?>" class="input--form" required>
                </div>
            </div>


            <div class="grupo--botones">
                <button type="submit" class="boton--form boton--guardar">Actualizar Usuario</button>
                <a href="gestionUsuarios.php" class="boton--form boton--volver">Volver</a>
            </div>

        </form>
    </main>
    <script src="js/usuario-editar-validador.js"></script>
</body>
</html>