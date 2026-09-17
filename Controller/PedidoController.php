<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once(__DIR__ . '/../Model/Conexion.php');

class PedidoController {
    private mysqli $db;

    public function __construct(mysqli $conexion) {
        $this->db = $conexion;
    }

    public static function procesarAccion(mysqli $conexion): void {
        $controller = new self($conexion);
        $accion = $_REQUEST['accion'] ?? '';

        switch ($accion) {
            case 'actualizarEstado':
                $controller->actualizarEstado(intval($_POST['id_pedido'] ?? 0), trim($_POST['nuevo_estado'] ?? ''));
                break;
            case 'eliminar':
                $controller->eliminarPedido(intval($_GET['id'] ?? 0));
                break;
            case 'guardar':
            case 'procesar':
                $controller->guardarPedidoHandler();
                break;
            case 'obtenerDetalle':
                $controller->obtenerDetalleModal(intval($_GET['id'] ?? 0));
                break;
            default:
                break;
        }
    }
    
    public function actualizarEstado(int $idPedido, string $nuevoEstado): void {
        $stmt = $this->db->prepare("UPDATE pedido SET Estado = ? WHERE IdPedido = ?");
        $stmt->bind_param("si", $nuevoEstado, $idPedido);
        
        if ($stmt->execute()) {
            header("Location: ../View/gestionPedidos.php?msj=estado_actualizado");
        } else {
            echo "Error al actualizar el estado: " . $this->db->error;
        }
        $stmt->close();
        exit();
    }

    public function eliminarPedido(int $idPedido): void {
        $this->db->begin_transaction();
        try {
            $stmtDet = $this->db->prepare("DELETE FROM detalle_pedido WHERE IdPedido = ?");
            $stmtDet->bind_param("i", $idPedido);
            $stmtDet->execute();
            $stmtDet->close();

            $stmtPed = $this->db->prepare("DELETE FROM pedido WHERE IdPedido = ?");
            $stmtPed->bind_param("i", $idPedido);
            $stmtPed->execute();
            $stmtPed->close();

            $this->db->commit();
            header("Location: ../View/gestionPedidos.php?msj=pedido_eliminado");
        } catch (Exception $e) {
            $this->db->rollback();
            echo "Error al intentar eliminar el pedido: " . $e->getMessage();
        }
        exit();
    }

    public function guardarPedidoHandler(): void {
        while (ob_get_level()) ob_end_clean();
        ob_start();
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['usuario'])) {
            ob_clean();
            echo json_encode(['status' => 'error', 'message' => 'Sesión no iniciada']);
            exit();
        }

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (empty($data['items']) || empty($data['total'])) {
            ob_clean();
            echo json_encode(['status' => 'error', 'message' => 'Datos de pedido incompletos']);
            exit();
        }

        $usuarioSesion = $_SESSION['usuario'];
        $idCliente = is_array($usuarioSesion) 
            ? ($usuarioSesion['IdCliente'] ?? $usuarioSesion['id'] ?? $usuarioSesion['id_usuario'] ?? null) 
            : $usuarioSesion;

        if (!$idCliente) {
            ob_clean();
            echo json_encode(['status' => 'error', 'message' => 'No se pudo identificar el cliente en la sesión']);
            exit();
        }

        $this->guardarPedido($data, (int)$idCliente);
    }

    private function guardarPedido(array $data, int $idCliente): void {
    $nombreCompleto = 'Cliente';
    $email = 'No registrado';
    $telefono = 'No registrado';
    $documento = 'No registrado';
    $direccion = 'No registrada';

    try {
        $stmtUser = $this->db->prepare("SELECT TipoDocumento, NumeroDocumento, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, Correo, Telefono, Direccion FROM clientes WHERE IdCliente = ? LIMIT 1");
        if ($stmtUser) {
            $stmtUser->bind_param("i", $idCliente);
            $stmtUser->execute();
            $resUser = $stmtUser->get_result();
            
            if ($row = $resUser->fetch_assoc()) {
                $nombres = trim(($row['PrimerNombre'] ?? '') . ' ' . ($row['SegundoNombre'] ?? ''));
                $apellidos = trim(($row['PrimerApellido'] ?? '') . ' ' . ($row['SegundoApellido'] ?? ''));
                $nombreCompleto = trim("$nombres $apellidos");
                $email = $row['Correo'] ?? 'No registrado';
                $telefono = $row['Telefono'] ?? 'No registrado';
                $direccion = $row['Direccion'] ?? 'No registrada';
                if (!empty($row['NumeroDocumento'])) {
                    $documento = ($row['TipoDocumento'] ?? 'DOC') . " " . $row['NumeroDocumento'];
                }
            }
            $stmtUser->close();
        }
    } catch (Exception $e) {}

    $total = floatval($data['total']);
    $estado = 'Pendiente';

    $this->db->begin_transaction();
    try {

        $stmtStock = $this->db->prepare("UPDATE producto SET cantidad_producto = cantidad_producto - ? WHERE id_producto = ? AND cantidad_producto >= ?");
        
        foreach ($data['items'] as $item) {
            $idProd = intval($item['id_producto']);
            $cant = intval($item['cantidad']);

            $stmtStock->bind_param("iii", $cant, $idProd, $cant);
            $stmtStock->execute();


            if ($stmtStock->affected_rows === 0) {
                throw new Exception("Stock insuficiente para el producto ID: " . $idProd);
            }
        }
        $stmtStock->close();


        $stmt = $this->db->prepare("INSERT INTO pedido (IdCliente, FechaPedido, CostoTotal, Estado) VALUES (?, NOW(), ?, ?)");
        $stmt->bind_param("ids", $idCliente, $total, $estado);
        $stmt->execute();
        $idPedido = $stmt->insert_id;
        $stmt->close();


        $stmtDetalle = $this->db->prepare("INSERT INTO detalle_pedido (IdPedido, IdProducto, Cantidad, PrecioUnitario) VALUES (?, ?, ?, ?)");
        foreach ($data['items'] as $item) {
            $idProd = intval($item['id_producto']);
            $cant = intval($item['cantidad']);
            $prec = floatval($item['precio']);
            $stmtDetalle->bind_param("iiid", $idPedido, $idProd, $cant, $prec);
            $stmtDetalle->execute();
        }
        $stmtDetalle->close();


        $this->db->commit();
        ob_clean();
        echo json_encode([
            'status' => 'success',
            'id_pedido' => $idPedido,
            'cliente_completo' => $nombreCompleto,
            'email' => $email,
            'telefono' => $telefono,
            'documento' => $documento,
            'direccion' => $direccion
        ]);
    } catch (Exception $e) {

        $this->db->rollback();
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'Error en BD: ' . $e->getMessage()]);
    }
    exit();
}

    public function obtenerDetalleModal(int $idPedido): void {
        $stmt = $this->db->prepare("SELECT dp.Cantidad, dp.PrecioUnitario, p.nombre_producto, p.foto_producto FROM detalle_pedido dp INNER JOIN producto p ON dp.IdProducto = p.id_producto WHERE dp.IdPedido = ?");
        $stmt->bind_param("i", $idPedido);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $total_general = 0;
            ?>
            <div class="contenedor--detalle-modal">
                <table class="tabla--detalle">
                    <thead>
                        <tr>
                            <th class="th--izquierda">Producto</th>
                            <th class="th--centro">Cant.</th>
                            <th class="th--derecha">Precio Unit.</th>
                            <th class="th--derecha">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = $resultado->fetch_assoc()): 
                            $subtotal = $item['Cantidad'] * $item['PrecioUnitario'];
                            $total_general += $subtotal;
                        ?>
                            <tr>
                                <td class="td--producto-info">
                                    <?php if (!empty($item['foto_producto'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['foto_producto']); ?>" alt="Producto" class="img--detalle-producto">
                                    <?php endif; ?>
                                    <span class="nombre--producto-detalle"><?php echo htmlspecialchars($item['nombre_producto']); ?></span>
                                </td>
                                <td class="td--centro"><?php echo $item['Cantidad']; ?></td>
                                <td class="td--derecha">$<?php echo number_format($item['PrecioUnitario'], 0, '', '.'); ?></td>
                                <td class="td--derecha td--subtotal">$<?php echo number_format($subtotal, 0, '', '.'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="contenedor--total-pedido">
                <span class="label--total-pedido">Total del Pedido:</span>
                <span class="monto--total-pedido">$<?php echo number_format($total_general, 0, '', '.'); ?></span>
            </div>
            <?php
        } else {
            echo '<p class="mensaje--vacio-modal">No se encontraron productos registrados en este pedido.</p>';
        }
        $stmt->close();
    }
}


PedidoController::procesarAccion($conexion);