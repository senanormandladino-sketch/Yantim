<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once(__DIR__ . '/../Model/Conexion.php');

class ProductoController {
    private mysqli $db;

    public function __construct(mysqli $conexion) {
        $this->db = $conexion;
    }

    public static function procesarAccion(mysqli $conexion): void {
        $controller = new self($conexion);
        $accion = $_REQUEST['accion'] ?? '';

        switch ($accion) {
            case 'obtenerStock':
                $controller->obtenerStock(intval($_GET['id'] ?? 0));
                break;
            case 'agregar':
                $controller->agregarProducto($_POST);
                break;
            case 'modificar':
                $controller->modificarProducto($_POST);
                break;
            case 'eliminar':
                $controller->eliminarProducto(intval($_GET['Id'] ?? 0));
                break;
            default:
                break;
        }
    }

    public function obtenerStock(int $id): void {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json; charset=utf-8');

        if ($id > 0) {
            $stmt = $this->db->prepare("SELECT cantidad_producto FROM producto WHERE id_producto = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($fila = $resultado->fetch_assoc()) {
                echo json_encode(['stock' => (int)$fila['cantidad_producto']]);
            } else {
                echo json_encode(['error' => 'Producto no encontrado']);
            }
            $stmt->close();
        } else {
            echo json_encode(['error' => 'ID de producto no válido']);
        }
        exit();
    }

    private function procesarImagen(string $fileInput, string $fotoTexto): string {
        $ruta_foto = trim($fotoTexto);
        if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] === UPLOAD_ERR_OK) {
            $nombre_temporal = $_FILES[$fileInput]['tmp_name'];
            $nombre_original = $_FILES[$fileInput]['name'];
            $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
            $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (in_array($extension, $extensiones_permitidas)) {
                $carpeta_destino = "../Assets/Imagenes/";
                if (!file_exists($carpeta_destino)) {
                    mkdir($carpeta_destino, 0777, true);
                }
                $nuevo_nombre = time() . "_" . uniqid() . "." . $extension;
                if (move_uploaded_file($nombre_temporal, $carpeta_destino . $nuevo_nombre)) {
                    $ruta_foto = "../Assets/Imagenes/" . $nuevo_nombre;
                }
            }
        }
        return $ruta_foto;
    }

    public function agregarProducto(array $datos): void {
        $nombre      = trim($datos['nombre'] ?? '');
        $categoria   = intval($datos['categoria'] ?? 0);
        $descripcion = trim($datos['descripcion'] ?? '');
        $inventario  = intval($datos['inventario'] ?? 0);
        $precio      = floatval($datos['precio'] ?? 0);
        $ruta_foto   = $this->procesarImagen('foto_archivo', $datos['foto_texto'] ?? '');

        $stmt = $this->db->prepare("INSERT INTO producto (nombre_producto, id_categoria, descripcion_producto, cantidad_producto, costo_producto, foto_producto) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisids", $nombre, $categoria, $descripcion, $inventario, $precio, $ruta_foto);

        if ($stmt->execute()) {
            header("Location: ../View/gestionProductos.php?msj=insertado");
        } else {
            echo "Error al insertar el producto: " . $this->db->error;
        }
        $stmt->close();
        exit();
    }

    public function modificarProducto(array $datos = []): void {
        $id          = intval($datos['Id'] ?? 0);
        $nombre      = trim($datos['nombre'] ?? '');
        $categoria   = intval($datos['categoria'] ?? 0);
        $descripcion = trim($datos['descripcion'] ?? '');
        $inventario  = intval($datos['inventario'] ?? 0);
        $precio      = floatval($datos['precio'] ?? 0);
        $ruta_foto   = $this->procesarImagen('foto_archivo', $datos['foto_texto'] ?? '');

        $stmt = $this->db->prepare("UPDATE producto SET nombre_producto = ?, id_categoria = ?, descripcion_producto = ?, cantidad_producto = ?, costo_producto = ?, foto_producto = ? WHERE id_producto = ?");
        $stmt->bind_param("sisidsi", $nombre, $categoria, $descripcion, $inventario, $precio, $ruta_foto, $id);

        if ($stmt->execute()) {
            header("Location: ../View/gestionProductos.php?msj=actualizado");
        } else {
            echo "Error al actualizar el producto: " . $this->db->error;
        }
        $stmt->close();
        exit();
    }

    public function eliminarProducto(int $idProducto): void {
        $stmt = $this->db->prepare("DELETE FROM producto WHERE id_producto = ?");
        $stmt->bind_param("i", $idProducto);
        if ($stmt->execute()) {
            header("Location: ../View/gestionProductos.php");
        } else {
            echo "El registro no pudo ser eliminado";
        }
        $stmt->close();
        exit();
    }
}

ProductoController::procesarAccion($conexion);