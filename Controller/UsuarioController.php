<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once(__DIR__ . '/../Model/Conexion.php');

class UsuarioController {
    private mysqli $db;

    public function __construct(mysqli $conexion) {
        $this->db = $conexion;
    }

    public static function procesarAccion(mysqli $conexion): void {
        $controller = new self($conexion);
        $accion = $_REQUEST['accion'] ?? '';

        switch ($accion) {
            case 'login':
                $controller->login(trim($_POST['correo'] ?? ''), trim($_POST['password'] ?? ''));
                break;
            case 'logout':
                $controller->logout();
                break;
            case 'agregar':
                $controller->agregarUsuario($_POST);
                break;
            case 'editar':
                $controller->editarUsuario($_POST);
                break;
            case 'cambiarRol':
                $controller->cambiarRol($_POST['numero_documento'] ?? '', $_POST['nuevo_rol'] ?? '');
                break;
            case 'eliminar':
                $controller->eliminarCliente(intval($_GET['Id'] ?? 0));
                break;
            case 'eliminarCuenta':
                $controller->eliminarCuenta($_SESSION['usuario']['id'] ?? 0);
                break;
            case 'actualizarPerfil':
                $controller->actualizarPerfil($_POST, !empty($_SESSION['es_admin']));
                break;
            case 'insertarPublico':
                $controller->insertarPublico($_POST);
                break;
            default:
                break;
        }
    }

    public function login(string $correo, string $password): void {

    if (ob_get_length()) {
        ob_clean();
    }

    header('Content-Type: application/json; charset=utf-8');


    $stmt = $this->db->prepare("SELECT * FROM clientes WHERE Correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        $stmt->close();
        echo json_encode([
            'success' => false,
            'error_type' => 'correo',
            'message' => 'El correo electrónico no está registrado.'
        ]);
        exit();
    }

    $cliente = $resultado->fetch_assoc();
    $stmt->close();


    if ($cliente['Contraseña'] !== $password) {
        echo json_encode([
            'success' => false,
            'error_type' => 'password',
            'message' => 'La contraseña es incorrecta.'
        ]);
        exit();
    }


    $_SESSION['usuario'] = [
        'id' => $cliente['IdCliente'],
        'nombre' => $cliente['PrimerNombre'],
        'correo' => $cliente['Correo'],
        'documento' => $cliente['NumeroDocumento']
    ];

    $stmtAdmin = $this->db->prepare("SELECT * FROM administrador WHERE numero_documento = ?");
    $stmtAdmin->bind_param("s", $cliente['NumeroDocumento']);
    $stmtAdmin->execute();
    $_SESSION['es_admin'] = ($stmtAdmin->get_result()->num_rows > 0);
    $stmtAdmin->close();

    session_write_close();


    echo json_encode([
        'success' => true,
        'message' => 'Inicio de sesión exitoso.',
        'redirect' => '../View/tienda.php'
    ]);
    exit();
}

    public function logout(): void {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
        header("Location: ../View/tienda.php");
        exit();
    }

    public function agregarUsuario(array $datos): void {
        $tipo_doc         = trim($datos['tipo_doc'] ?? '');
        $num_doc          = intval($datos['num_doc'] ?? 0);
        $primer_nombre    = trim($datos['primer_nombre'] ?? '');
        $segundo_nombre   = !empty($datos['segundo_nombre']) ? trim($datos['segundo_nombre']) : NULL;
        $primer_apellido  = trim($datos['primer_apellido'] ?? '');
        $segundo_apellido = !empty($datos['segundo_apellido']) ? trim($datos['segundo_apellido']) : NULL;
        $correo           = trim($datos['correo'] ?? '');
        $telefono         = intval($datos['telefono'] ?? 0);
        $contrasena       = substr(trim($datos['contrasena'] ?? ''), 0, 10);
        $rol              = strtolower(trim($datos['rol'] ?? ''));
        $fecha_nac        = $datos['fecha_nac'] ?? '';
        $direccion        = trim($datos['direccion'] ?? '');

        $this->db->begin_transaction();
        try {
            $sql_cliente = "INSERT INTO clientes (TipoDocumento, NumeroDocumento, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, Correo, Telefono, Contraseña, FechaNacimiento, Direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_cli = $this->db->prepare($sql_cliente);
            $stmt_cli->bind_param("sisssssisss", $tipo_doc, $num_doc, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $correo, $telefono, $contrasena, $fecha_nac, $direccion);
            $stmt_cli->execute();
            $stmt_cli->close();

            if ($rol === 'administrador') {
                $sql_admin = "INSERT INTO administrador (tipo_documento, numero_documento, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, correo, direccion, telefono, contraseña, fecha_nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_admin = $this->db->prepare($sql_admin);
                $stmt_admin->bind_param("sisssssisss", $tipo_doc, $num_doc, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $correo, $direccion, $telefono, $contrasena, $fecha_nac);
                $stmt_admin->execute();
                $stmt_admin->close();
            }

            $this->db->commit();
            header("Location: ../View/gestionUsuarios.php?msj=usuario_agregado");
        } catch (Exception $e) {
            $this->db->rollback();
            echo "Error al registrar el usuario: " . $e->getMessage();
        }
        exit();
    }

    public function editarUsuario(array $datos): void {
        $id_cliente       = intval($datos['id_cliente'] ?? 0);
        $tipo_doc         = trim($datos['tipo_doc'] ?? '');
        $num_doc          = intval($datos['num_doc'] ?? 0);
        $primer_nombre    = trim($datos['primer_nombre'] ?? '');
        $segundo_nombre   = !empty($datos['segundo_nombre']) ? trim($datos['segundo_nombre']) : NULL;
        $primer_apellido  = trim($datos['primer_apellido'] ?? '');
        $segundo_apellido = !empty($datos['segundo_apellido']) ? trim($datos['segundo_apellido']) : NULL;
        $correo           = trim($datos['correo'] ?? '');
        $telefono         = intval($datos['telefono'] ?? 0);
        $fecha_nac        = $datos['fecha_nac'] ?? '';
        $direccion        = trim($datos['direccion'] ?? '');

        $this->db->begin_transaction();
        try {
            $sql_cliente = "UPDATE clientes SET TipoDocumento = ?, NumeroDocumento = ?, PrimerNombre = ?, SegundoNombre = ?, PrimerApellido = ?, SegundoApellido = ?, Correo = ?, Telefono = ?, FechaNacimiento = ?, Direccion = ? WHERE IdCliente = ?";
            $stmt_cli = $this->db->prepare($sql_cliente);
            $stmt_cli->bind_param("sisssssissi", $tipo_doc, $num_doc, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $correo, $telefono, $fecha_nac, $direccion, $id_cliente);
            $stmt_cli->execute();
            $stmt_cli->close();

            $check_admin = "SELECT * FROM administrador WHERE id_administrador = ? OR numero_documento = ?";
            $stmt_check = $this->db->prepare($check_admin);
            $stmt_check->bind_param("ii", $id_cliente, $num_doc);
            $stmt_check->execute();
            $res_check = $stmt_check->get_result();

            if ($res_check->num_rows > 0) {
                $sql_admin = "UPDATE administrador SET tipo_documento = ?, numero_documento = ?, primer_nombre = ?, segundo_nombre = ?, primer_apellido = ?, segundo_apellido = ?, correo = ?, telefono = ?, fecha_nacimiento = ?, direccion = ? WHERE id_administrador = ? OR numero_documento = ?";
                $stmt_admin = $this->db->prepare($sql_admin);
                $stmt_admin->bind_param("sisssssissii", $tipo_doc, $num_doc, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $correo, $telefono, $fecha_nac, $direccion, $id_cliente, $num_doc);
                $stmt_admin->execute();
                $stmt_admin->close();
            }
            $stmt_check->close();

            $this->db->commit();
            header("Location: ../View/gestionUsuarios.php?msj=usuario_actualizado");
        } catch (Exception $e) {
            $this->db->rollback();
            echo "Error al actualizar los datos: " . $e->getMessage();
        }
        exit();
    }

    public function cambiarRol(string $numDocumento, string $nuevoRol): void {
        $stmtCli = $this->db->prepare("SELECT * FROM clientes WHERE NumeroDocumento = ?");
        $stmtCli->bind_param("s", $numDocumento);
        $stmtCli->execute();
        $datosCliente = $stmtCli->get_result()->fetch_assoc();
        $stmtCli->close();

        if ($datosCliente) {
            $stmtCheck = $this->db->prepare("SELECT * FROM administrador WHERE numero_documento = ?");
            $stmtCheck->bind_param("s", $numDocumento);
            $stmtCheck->execute();
            $isAdmin = $stmtCheck->get_result()->num_rows > 0;
            $stmtCheck->close();

            if ($nuevoRol === 'admin' && !$isAdmin) {
                $stmtIns = $this->db->prepare("INSERT INTO administrador (tipo_documento, numero_documento, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, correo, telefono, contraseña, fecha_nacimiento, direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmtIns->bind_param("sssssssssss", $datosCliente['TipoDocumento'], $numDocumento, $datosCliente['PrimerNombre'], $datosCliente['SegundoNombre'], $datosCliente['PrimerApellido'], $datosCliente['SegundoApellido'], $datosCliente['Correo'], $datosCliente['Telefono'], $datosCliente['Contraseña'], $datosCliente['FechaNacimiento'], $datosCliente['Direccion']);
                $stmtIns->execute();
                $stmtIns->close();
            } else if ($nuevoRol === 'cliente' && $isAdmin) {
                $stmtDel = $this->db->prepare("DELETE FROM administrador WHERE numero_documento = ?");
                $stmtDel->bind_param("s", $numDocumento);
                $stmtDel->execute();
                $stmtDel->close();
            }
        }
        header("Location: ../View/gestionUsuarios.php?mensaje=rol_actualizado");
        exit();
    }

    public function eliminarCliente(int $idCliente): void {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE IdCliente = ?");
        $stmt->bind_param("i", $idCliente);
        if ($stmt->execute()) {
            header("Location: ../View/gestionUsuarios.php");
        } else {
            echo "El registro no pudo ser eliminado";
        }
        $stmt->close();
        exit();
    }

    public function eliminarCuenta(int $idCliente): void {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE IdCliente = ?");
        $stmt->bind_param("i", $idCliente);
        if ($stmt->execute()) {
            $this->logout();
            header("Location: ../View/Inicio_secion.php?mensaje=cuenta_eliminada");
            exit();
        }
        $stmt->close();
    }

    public function actualizarPerfil(array $datos, bool $esAdmin): void {
        $id = $_SESSION['usuario']['id'];
        $documento = $_SESSION['usuario']['documento'];
        $primerNombre = trim($datos['primer_nombre'] ?? '');
        $segundoNombre = trim($datos['segundo_nombre'] ?? '');
        $primerApellido = trim($datos['primer_apellido'] ?? '');
        $segundoApellido = trim($datos['segundo_apellido'] ?? '');
        $fechaNacimiento = trim($datos['fecha_nacimiento'] ?? '');
        $telefono = trim($datos['telefono'] ?? '');
        $correo = trim($datos['correo'] ?? '');
        $direccion = trim($datos['direccion'] ?? '');
        $password = trim($datos['password'] ?? '');

        if (!empty($password)) {
            $stmt = $this->db->prepare("UPDATE clientes SET PrimerNombre = ?, SegundoNombre = ?, PrimerApellido = ?, SegundoApellido = ?, FechaNacimiento = ?, Telefono = ?, Correo = ?, Direccion = ?, Contraseña = ? WHERE IdCliente = ?");
            $stmt->bind_param("sssssssssi", $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $fechaNacimiento, $telefono, $correo, $direccion, $password, $id);
        } else {
            $stmt = $this->db->prepare("UPDATE clientes SET PrimerNombre = ?, SegundoNombre = ?, PrimerApellido = ?, SegundoApellido = ?, FechaNacimiento = ?, Telefono = ?, Correo = ?, Direccion = ? WHERE IdCliente = ?");
            $stmt->bind_param("ssssssssi", $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $fechaNacimiento, $telefono, $correo, $direccion, $id);
        }
        $stmt->execute();
        $stmt->close();

        if ($esAdmin) {
            if (!empty($password)) {
                $stmtAdmin = $this->db->prepare("UPDATE administrador SET primer_nombre = ?, segundo_nombre = ?, primer_apellido = ?, segundo_apellido = ?, fecha_nacimiento = ?, correo = ?, direccion = ?, contraseña = ? WHERE numero_documento = ?");
                $stmtAdmin->bind_param("sssssssss", $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $fechaNacimiento, $correo, $direccion, $password, $documento);
            } else {
                $stmtAdmin = $this->db->prepare("UPDATE administrador SET primer_nombre = ?, segundo_nombre = ?, primer_apellido = ?, segundo_apellido = ?, fecha_nacimiento = ?, correo = ?, direccion = ? WHERE numero_documento = ?");
                $stmtAdmin->bind_param("ssssssss", $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $fechaNacimiento, $correo, $direccion, $documento);
            }
            $stmtAdmin->execute();
            $stmtAdmin->close();
        }

        $_SESSION['usuario']['nombre'] = $primerNombre;
        $_SESSION['usuario']['correo'] = $correo;
        session_write_close();
        header("Location: ../View/perfil.php?status=updated");
        exit();
    }

    public function insertarPublico(array $datos = []): void {
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['comprobar_campo'])) {
        header('Content-Type: application/json');
        
        $campo = $_GET['comprobar_campo'];
        $valor = trim($_GET['valor'] ?? '');

        $mapaCampos = [
            'documento' => 'NumeroDocumento',
            'correo'    => 'Correo',
            'telefono'  => 'Telefono'
        ];

        if (array_key_exists($campo, $mapaCampos) && !empty($valor)) {
            $columna = $mapaCampos[$campo];
            $stmt = $this->db->prepare("SELECT IdCliente FROM clientes WHERE $columna = ? LIMIT 1");
            $stmt->bind_param("s", $valor);
            $stmt->execute();
            $resultado = $stmt->get_result();

            echo json_encode(['duplicado' => $resultado->num_rows > 0]);
            $stmt->close();
        } else {
            echo json_encode(['duplicado' => false]);
        }
        exit();
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $check = $this->db->prepare("SELECT IdCliente FROM clientes WHERE NumeroDocumento = ? OR Correo = ? OR Telefono = ? LIMIT 1");
        $check->bind_param("sss", $datos['documento'], $datos['correo'], $datos['telefono']);
        $check->execute();
        
        if ($check->get_result()->num_rows > 0) {
            $check->close();
            echo "Error: El documento, correo o teléfono ya se encuentra registrado.";
            exit();
        }
        $check->close();

        
        $stmt = $this->db->prepare("INSERT INTO clientes(TipoDocumento, NumeroDocumento, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, Correo, Telefono, Contraseña, FechaNacimiento, Direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssssisss", $datos['tipo_doc'], $datos['documento'], $datos['primer_nombre'], $datos['segundo_nombre'], $datos['primer_apellido'], $datos['segundo_apellido'], $datos['correo'], $datos['telefono'], $datos['password'], $datos['fecha_nac'], $datos['direccion']);
        
        if ($stmt->execute()) {
            header("Location: ../View/index.php");
        } else {
            echo "Error al registrar cliente: " . $this->db->error;
        }
        $stmt->close();
        exit();
    }
}
}

UsuarioController::procesarAccion($conexion);