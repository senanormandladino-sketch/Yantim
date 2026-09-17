<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require("../Model/Conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yantim - Gestión de Usuarios</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css?v=1">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/modalAdmin.css">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="body">

    <?php include "nav.php"; ?>

    <div class="contenedor--admin">
        <section class="seccion--panel">
            <div class="encabezado--seccion">
                <h1 class="h1--titulo">Gestión de Usuarios</h1>
                <div class="grupo--superior">
                    <input type="text" id="buscarCliente" onkeyup="filtrarTabla('buscarCliente', 'tablaClientes', 2)" placeholder="Buscar usuario por nombre..." class="input--buscador">
                    <a href="agregarUsuario.php" class="boton--agregar">+ AGREGAR USUARIO</a>
                </div>
            </div>

            <div class="contenedor--tabla">
                <table class="tabla--admin" id="tablaClientes">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Documento</th>
                            <th scope="col">Nombre completo</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col">Nacimiento</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_cli = $conexion->query("
                            SELECT c.*, 
                                CASE 
                                    WHEN a.numero_documento IS NOT NULL THEN 'Cliente / Administrador'
                                    ELSE 'Cliente'
                                END AS RolUsuario,
                                CASE 
                                    WHEN a.numero_documento IS NOT NULL THEN 1
                                    ELSE 0
                                END AS EsAdmin
                            FROM clientes c
                            LEFT JOIN administrador a ON c.NumeroDocumento = a.numero_documento
                        ");

                        while ($cliente = $sql_cli->fetch_assoc()) {
                            $nombreCompleto = $cliente['PrimerNombre'] . ' ' . $cliente['PrimerApellido'];
                        ?>
                            <tr>
                                <td class="td--id"><?php echo $cliente['IdCliente']; ?></td>
                                <td class="td--documento">
                                    <span class="tipo--doc"><?php echo htmlspecialchars($cliente['TipoDocumento']); ?></span><br>
                                    <strong><?php echo htmlspecialchars($cliente['NumeroDocumento']); ?></strong>
                                </td>
                                <td class="td--nombre-completo">
                                    <?php echo htmlspecialchars($cliente['PrimerNombre'] . " " . $cliente['SegundoNombre']); ?><br>
                                    <strong><?php echo htmlspecialchars($cliente['PrimerApellido'] . " " . $cliente['SegundoApellido']); ?></strong>
                                </td>
                                <td class="td--correo"><?php echo htmlspecialchars($cliente['Correo']); ?></td>
                                <td class="td--telefono"><?php echo htmlspecialchars($cliente['Telefono']); ?></td>
                                <td class="td--rol">
                                    <span class="badge--rol <?php echo ($cliente['RolUsuario'] === 'Cliente / Administrador') ? 'rol--admin' : 'rol--cliente'; ?>">
                                        <?php echo htmlspecialchars($cliente['RolUsuario']); ?>
                                    </span>
                                </td>
                                <td class="td--password">••••••••</td>
                                <td class="td--fecha"><?php echo htmlspecialchars($cliente['FechaNacimiento']); ?></td>
                                <td class="td--direccion"><?php echo htmlspecialchars($cliente['Direccion']); ?></td>
                                <td class="td--acciones">
                                    <div class="grupo--acciones">
                                        <a href="editarUsuario.php?Id=<?php echo $cliente['IdCliente']; ?>" class="boton--accion boton--editar">Editar</a>
                                        <button type="button" 
                                                class="boton--accion boton--rol" 
                                                onclick="abrirModalRol('<?php echo $cliente['IdCliente']; ?>', '<?php echo $cliente['NumeroDocumento']; ?>', '<?php echo htmlspecialchars($nombreCompleto); ?>', '<?php echo $cliente['EsAdmin']; ?>')">
                                            Cambiar Rol
                                        </button>

                                        <a href="../Controller/UsuarioController.php?accion=eliminar&Id=<?php echo $cliente['IdCliente']; ?>" class="boton--accion boton--eliminar" onclick="return confirm('¿Deseas eliminar este cliente?')">Eliminar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>


        <div id="modalRol" class="modal--fondo">
            <div class="modal--contenedor">
                <span class="modal--cerrar" onclick="cerrarModalRol()">&times;</span>

                <form action="../Controller/UsuarioController.php?accion=cambiarRol" class="contenedor__form" method="POST">
                    <h2 class="h2--form">Cambiar Rol</h2>
                    <input type="hidden" name="id_cliente" id="modal_id_cliente">
                    <input type="hidden" name="numero_documento" id="modal_numero_documento">

                    <div class="grupo--input">
                        <label class="label--form">Usuario:</label>
                        <input type="text" id="modal_nombre_usuario" class="input--form" readonly style="background-color: #e2e8f0 !important; cursor: not-allowed;">
                    </div>

                    <div class="grupo--input">
                        <label for="modal_nuevo_rol" class="label--form">Seleccionar Rol</label>
                        <select name="nuevo_rol" id="modal_nuevo_rol" class="input--form select--form" required>
                            <option value="cliente">Cliente (Acceso estándar)</option>
                            <option value="admin">Cliente / Administrador (Acceso total)</option>
                        </select>
                    </div>

                    <div class="grupo--botones" style="display: flex; gap: 10px; margin-top: 15px;">
                        <button type="submit" class="boton--form boton--guardar">Guardar</button>
                        <button type="button" class="boton--form" onclick="cerrarModalRol()" style="background-color: #64748b; color: white;">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function filtrarTabla(inputId, tablaId, columnaIndex) {
        const input = document.getElementById(inputId);
        const filter = input.value.toLowerCase();
        const tabla = document.getElementById(tablaId);
        const filas = tabla.getElementsByTagName("tr");

        for (let i = 1; i < filas.length; i++) {
            const celda = filas[i].getElementsByTagName("td")[columnaIndex];
            if (celda) {
                const texto = celda.textContent || celda.innerText;
                filas[i].style.display = (texto.toLowerCase().indexOf(filter) > -1) ? "" : "none";
            }
        }
    }

    function abrirModalRol(id, documento, nombre, esAdmin) {
        document.getElementById('modal_id_cliente').value = id;
        document.getElementById('modal_numero_documento').value = documento;
        document.getElementById('modal_nombre_usuario').value = nombre;
        document.getElementById('modal_nuevo_rol').value = (esAdmin == 1) ? 'admin' : 'cliente';
        document.getElementById('modalRol').style.display = 'flex';
    }

    function cerrarModalRol() {
        document.getElementById('modalRol').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('modalRol');
        if (event.target === modal) {
            cerrarModalRol();
        }
    }
    </script>
</body>
</html>