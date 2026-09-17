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

// Lógica para procesar la cancelación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'cancelar_pedido') {
    $idPedido = intval($_POST['id_pedido'] ?? 0);
    
    if ($idPedido > 0) {
        $stmtCancel = $conexion->prepare("UPDATE pedido SET Estado = 'Cancelado' WHERE IdPedido = ? AND IdCliente = ? AND Estado != 'Cancelado'");
        $stmtCancel->bind_param("ii", $idPedido, $idCliente);
        
        if ($stmtCancel->execute()) {
            header("Location: mis_compras.php?cancelado=exitoso");
        } else {
            header("Location: mis_compras.php?cancelado=error");
        }
        $stmtCancel->close();
        exit();
    }
}

$query = "SELECT 
            p.IdPedido, 
            p.FechaPedido, 
            p.CostoTotal, 
            p.Estado,
            GROUP_CONCAT(
                CONCAT(pr.nombre_producto, ' (x', dp.Cantidad, ') - $', FORMAT(dp.PrecioUnitario, 0, 'de_DE')) 
                SEPARATOR '||'
            ) AS productos_detalle
          FROM pedido p
          INNER JOIN detalle_pedido dp ON p.IdPedido = dp.IdPedido
          INNER JOIN producto pr ON dp.IdProducto = pr.id_producto
          WHERE p.IdCliente = ?
          GROUP BY p.IdPedido
          ORDER BY p.FechaPedido DESC";

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $idCliente);
$stmt->execute();
$pedidos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Compras - Yantim</title>
    <link rel="stylesheet" href="css/mis_compras.css?v=2">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
</head>
<body class="fondo">

    <?php include "nav.php"; ?>

    <main class="compras-container">
        <div class="compras-header">
            <h2>Mis Compras <?php echo !empty($_SESSION['es_admin']) ? '(Admin)' : ''; ?></h2>
            <a href="index.php" class="btn-volver">← Volver</a>
        </div>

        <?php if (isset($_GET['pedido']) && $_GET['pedido'] === 'exitoso'): ?>
            <div class="alert-success">✓ ¡Tu compra ha sido procesada con éxito y el comprobante PDF se ha descargado!</div>
        <?php endif; ?>

        <?php if (isset($_GET['cancelado']) && $_GET['cancelado'] === 'exitoso'): ?>
            <div class="alert-success">✓ El pedido ha sido cancelado correctamente.</div>
        <?php endif; ?>

        <div class="buscador-container">
            <input type="text" id="inputBuscador" placeholder="🔍 Buscar por producto, ID de pedido..." onkeyup="filtrarTabla()">
        </div>

        <div class="tabla-wrapper">
            <table class="tabla-admin" id="tablaCompras">
                <thead>
                    <tr>
                        <th># Pedido</th>
                        <th>Fecha</th>
                        <th>Productos Comprados</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="tbodyCompras">
                    <?php if ($pedidos && $pedidos->num_rows > 0): ?>
                        <?php while ($row = $pedidos->fetch_assoc()): ?>
                            <tr class="fila-pedido">
                                <td class="col-id">#<?php echo $row['IdPedido']; ?></td>
                                <td class="col-fecha"><?php echo date('d/m/Y H:i', strtotime($row['FechaPedido'])); ?></td>
                                
                                <td class="col-productos">
                                    <ul class="lista-productos">
                                        <?php 
                                            $listaProductos = explode('||', $row['productos_detalle']);
                                            foreach ($listaProductos as $prodItem): 
                                        ?>
                                            <li class="item-producto"><?php echo htmlspecialchars($prodItem); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>

                                <td class="col-total">$<?php echo number_format($row['CostoTotal'], 0, ',', '.'); ?></td>
                                
                                <td class="col-estado">
                                    <div class="contenedor-estado">
                                        <span class="badge-estado state-<?php echo strtolower(str_replace(' ', '-', $row['Estado'])); ?>">
                                            <?php echo htmlspecialchars($row['Estado']); ?>
                                        </span>

                                        <?php if (strtolower(trim($row['Estado'])) !== 'cancelado' && strtolower(trim($row['Estado'])) !== 'entregado'): ?>
                                            <form method="POST" onsubmit="return confirm('¿Deseas cancelar este pedido?');" class="form-cancelar">
                                                <input type="hidden" name="accion" value="cancelar_pedido">
                                                <input type="hidden" name="id_pedido" value="<?php echo $row['IdPedido']; ?>">
                                                <button type="submit" class="btn-cancelar-pedido">Cancelar</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr id="sinComprasBase">
                            <td colspan="5" class="tabla-vacia">Aún no has registrado compras.</td>
                        </tr>
                    <?php endif; ?>
                    <tr id="sinCoincidencias" style="display: none;">
                        <td colspan="5" class="tabla-vacia">No se encontraron compras con el producto buscado.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <script>
    function filtrarTabla() {
        const input = document.getElementById('inputBuscador').value.toLowerCase().trim();
        const filas = document.querySelectorAll('.fila-pedido');
        const sinCoincidencias = document.getElementById('sinCoincidencias');
        let visibles = 0;

        filas.forEach(fila => {
            const textoFila = fila.innerText.toLowerCase();
            if (textoFila.includes(input)) {
                fila.style.display = '';
                visibles++;
            } else {
                fila.style.display = 'none';
            }
        });

        if (sinCoincidencias) {
            sinCoincidencias.style.display = (visibles === 0 && filas.length > 0) ? '' : 'none';
        }
    }
    </script>
</body>
</html>