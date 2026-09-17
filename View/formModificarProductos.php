<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../Model/Conexion.php");

$id = intval($_GET['Id']);
$sql = "SELECT * FROM producto WHERE id_producto = $id";
$resultado = $conexion->query($sql);
$row = $resultado->fetch_assoc();

$sql_categorias = "SELECT * FROM categorias";
$res_categorias = $conexion->query($sql_categorias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yantim - Actualizar Producto</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/formEditarProductos.css?v=1">
    <link rel="stylesheet" href="css/fondos-letras.css">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="fondo">

    <?php include "nav.php"; ?>

    <main class="formulario-contenedor">

        <form action="../Controller/ProductoController.php?accion=modificar" class="contenedor__form" method="POST" enctype="multipart/form-data" onsubmit="return confirm('¿Deseas actualizar este producto?');">
            
            <h2 class="h2--form">Actualizar Producto</h2>
            
            <input type="hidden" name="Id" value="<?php echo $row['id_producto']; ?>">


            <div class="grupo--input">
                <label for="nombre" class="label--form">Nombre del Producto</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($row['nombre_producto']); ?>" class="input--form" required>
            </div>


            <div class="grupo--input">
                <label for="categoria" class="label--form">Categoría</label>
                <select name="categoria" id="categoria" class="input--form select--form" required>
                    <?php while ($cat = $res_categorias->fetch_assoc()) { ?>
                        <option value="<?php echo $cat['id_categoria']; ?>" <?php echo ($cat['id_categoria'] == $row['id_categoria']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>


            <div class="grupo--input">
                <label for="descripcion" class="label--form">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="input--form textarea--form" required><?php echo htmlspecialchars($row['descripcion_producto']); ?></textarea>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="inventario" class="label--form">Inventario</label>
                    <input type="number" name="inventario" id="inventario" value="<?php echo $row['cantidad_producto']; ?>" class="input--form" required>
                </div>

                <div class="grupo--input">
                    <label for="precio" class="label--form">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" id="precio" value="<?php echo $row['costo_producto']; ?>" class="input--form" required>
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="foto_texto" class="label--form">Ruta actual de Imagen</label>
                    <input type="text" name="foto_texto" id="foto_texto" value="<?php echo htmlspecialchars($row['foto_producto']); ?>" class="input--form" required>
                </div>

                <div class="grupo--input">
                    <label for="foto_archivo" class="label--form">O Subir Archivo</label>
                    <input type="file" name="foto_archivo" id="foto_archivo" class="input--form input--file" accept="image/*">
                </div>
            </div>


            <div class="grupo--botones">
                <button type="submit" class="boton--form boton--guardar" >Actualizar</button>
                <a href="gestionProductos.php" class="boton--form boton--volver">Volver</a>
            </div>

        </form>
    </main>

    <script src="js/producto-editar-validador.js"></script>
</body>
</html>