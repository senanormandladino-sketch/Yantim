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
    <title>Yantim - Gestión de Pedidos</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/modalAdmin.css">
    <link rel="stylesheet" href="css/modalDetalle.css">
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
                <h1 class="h1--titulo">Gestión de Pedidos</h1>
                <div class="grupo--superior">
                    <input type="text" id="buscarPedido" onkeyup="filtrarTabla('buscarPedido', 'tablaPedidos', 1)" placeholder="Buscar por Cliente o ID..." class="input--buscador">
                </div>
            </div>

            <div class="contenedor--tabla">
                <table class="tabla--admin" id="tablaPedidos">
                    <thead>
                        <tr>
                            <th scope="col">ID Pedido</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Total</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_pedidos = $conexion->query("
                            SELECT p.IdPedido, p.FechaPedido, p.CostoTotal, p.Estado,
                                   c.PrimerNombre, c.PrimerApellido, c.NumeroDocumento
                            FROM pedido p
                            INNER JOIN clientes c ON p.IdCliente = c.IdCliente
                            ORDER BY p.FechaPedido DESC
                        ");

                        while ($pedido = $sql_pedidos->fetch_assoc()) {
                            $nombreCliente = $pedido['PrimerNombre'] . ' ' . $pedido['PrimerApellido'];
                        ?>
                            <tr>
                                <td class="td--id">#<?php echo $pedido['IdPedido']; ?></td>
                                <td class="td--nombre">
                                    <strong><?php echo htmlspecialchars($nombreCliente); ?></strong><br>
                                    <small>Doc: <?php echo $pedido['NumeroDocumento']; ?></small>
                                </td>
                                <td class="td--fecha"><?php echo date("d/m/Y H:i", strtotime($pedido['FechaPedido'])); ?></td>
                                <td class="td--precio">$<?php echo number_format($pedido['CostoTotal'], 0, '', '.'); ?></td>
                                <td class="td--rol">
                                    <span class="badge--categoria">
                                        <?php echo htmlspecialchars($pedido['Estado']); ?>
                                    </span>
                                </td>
                                <td class="td--acciones">
                                    <div class="grupo--acciones">

                                        <button type="button" class="boton--accion boton--editar" 
                                                onclick="abrirModalEstado('<?php echo $pedido['IdPedido']; ?>', '<?php echo $pedido['Estado']; ?>')">
                                            Estado
                                        </button>
                                        

                                        <button type="button" class="boton--accion boton--rol" 
                                                onclick="verDetallePedido('<?php echo $pedido['IdPedido']; ?>')">
                                            Detalles
                                        </button>


                                        <a href="../Controller/PedidoController.php?accion=eliminar&id=<?php echo $pedido['IdPedido']; ?>" 
                                           class="boton--accion boton--eliminar" 
                                           onclick="return confirm('¿Estás seguro de que deseas eliminar este pedido? Esta acción borrará también sus detalles y no se puede deshacer.')">
                                            Eliminar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>


        <div id="modalEstado" class="modal--fondo">
            <div class="modal--contenedor">
                <span class="modal--cerrar" onclick="cerrarModalEstado()">&times;</span>
                <form action="../Controller/PedidoController.php?accion=actualizarEstado" class="contenedor__form" method="POST">
                    <h2 class="h2--form">Actualizar Estado</h2>
                    <input type="hidden" name="id_pedido" id="modal_id_pedido">

                    <div class="grupo--input">
                        <label for="nuevo_estado" class="label--form">Seleccionar Estado</label>
                        <select name="nuevo_estado" id="modal_nuevo_estado" class="input--form select--form" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Enviado">Enviado</option>
                            <option value="Entregado">Entregado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>

                    <div class="grupo--botones" style="display: flex; gap: 10px; margin-top: 15px;">
                        <button type="submit" class="boton--form boton--guardar">Guardar Cambios</button>
                        <button type="button" class="boton--form" onclick="cerrarModalEstado()" style="background-color: #64748b; color: white;">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>


        <div id="modalDetalle" class="modal--fondo">
            <div class="modal--contenedor" style="max-width: 600px;">
                <span class="modal--cerrar" onclick="cerrarModalDetalle()">&times;</span>
                <h2 class="h2--form">Detalle del Pedido #<span id="detalle_id_pedido"></span></h2>
                <div id="contenido_detalle" style="margin-top: 15px;">

                </div>
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

    function abrirModalEstado(idPedido, estadoActual) {
        document.getElementById('modal_id_pedido').value = idPedido;
        document.getElementById('modal_nuevo_estado').value = estadoActual;
        document.getElementById('modalEstado').style.display = 'flex';
    }

    function cerrarModalEstado() {
        document.getElementById('modalEstado').style.display = 'none';
    }

    function verDetallePedido(idPedido) {
        document.getElementById('detalle_id_pedido').innerText = idPedido;
        const contenedor = document.getElementById('contenido_detalle');
        contenedor.innerHTML = '<p>Cargando detalles...</p>';
        document.getElementById('modalDetalle').style.display = 'flex';

        fetch(`../Controller/PedidoController.php?accion=obtenerDetalle&id=${idPedido}`)
            .then(response => response.text())
            .then(html => {
                contenedor.innerHTML = html;
            })
            .catch(() => {
                contenedor.innerHTML = '<p>Error al cargar el detalle.</p>';
            });
    }

    function cerrarModalDetalle() {
        document.getElementById('modalDetalle').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target === document.getElementById('modalEstado')) cerrarModalEstado();
        if (event.target === document.getElementById('modalDetalle')) cerrarModalDetalle();
    }
    </script>

</body>
</html>