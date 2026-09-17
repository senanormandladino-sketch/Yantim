<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: Inicio_secion.php");
    exit();
}

require_once('../Model/Conexion.php');

$idCliente = $_SESSION['usuario']['id'];
$stmt = $conexion->prepare("SELECT * FROM clientes WHERE IdCliente = ?");
$stmt->bind_param("i", $idCliente);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Yantim</title>
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/fondos-letras.css">
</head>
<body class="fondo">
    
    <script src="js/perfil-validador.js"></script>

    <?php include "nav.php"; ?>

    <main class="perfil-card">
        <div class="perfil-header">
            <h2>Mi Perfil <?php echo !empty($_SESSION['es_admin']) ? '(Admin)' : ''; ?></h2>
            <a href="index.php" class="btn-volver">← Volver</a>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
            <div class="alert-success">✓ ¡Tus datos han sido actualizados correctamente!</div>
        <?php endif; ?>


        <form action="../Controller/UsuarioController.php?accion=actualizarPerfil" method="POST" onsubmit="return confirm('¿Deseas actualizar tu perfil?');" >
            <div class="grid-inputs">
                <div class="form-group">
                    <label>Primer Nombre:</label>
                    <input type="text" name="primer_nombre" class="form-input" value="<?php echo htmlspecialchars($usuario['PrimerNombre'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label>Segundo Nombre:</label>
                    <input type="text" name="segundo_nombre" class="form-input" value="<?php echo htmlspecialchars($usuario['SegundoNombre'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Primer Apellido:</label>
                    <input type="text" name="primer_apellido" class="form-input" value="<?php echo htmlspecialchars($usuario['PrimerApellido'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label>Segundo Apellido:</label>
                    <input type="text" name="segundo_apellido" class="form-input" value="<?php echo htmlspecialchars($usuario['SegundoApellido'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" class="form-input" value="<?php echo htmlspecialchars($usuario['FechaNacimiento'] ?? $usuario['fecha_nacimiento'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Teléfono / Celular:</label>
                    <input type="text" name="telefono" class="form-input" value="<?php echo htmlspecialchars($usuario['Telefono'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Documento (No editable):</label>
                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($usuario['NumeroDocumento'] ?? ''); ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico:</label>
                    <input type="email" name="correo" class="form-input" value="<?php echo htmlspecialchars($usuario['Correo'] ?? ''); ?>" required>
                </div>

                <div class="form-group full-width">
                    <label>Dirección:</label>
                    <input type="text" name="direccion" class="form-input" value="<?php echo htmlspecialchars($usuario['Direccion'] ?? $usuario['direccion'] ?? ''); ?>">
                </div>

                <div class="form-group full-width">
                    <label>Nueva Contraseña (dejar en blanco para mantener la actual):</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••">
                </div>

                <div class="full-width">
                    <button type="submit" class="btn-guardar">Guardar Cambios</button>
                </div>
            </div>
        </form>

        <div class="danger-zone">
            <h3>Eliminar Cuenta</h3>
            <p>Esta acción es irreversible. Se borrarán todos tus datos de la plataforma.</p>

            <form action="../Controller/UsuarioController.php?accion=eliminarCuenta" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta permanentemente?');">
                <button type="submit" class="btn-eliminar">Eliminar mi cuenta</button>
            </form>
        </div>
    </main>

</body>
</html>