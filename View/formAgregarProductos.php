<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../Model/Conexion.php");


$sql_categorias = "SELECT * FROM categorias";
$res_categorias = $conexion->query($sql_categorias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yantim - Agregar Producto</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/formAgregarProductos.css">
    <link rel="stylesheet" href="css/fondos-letras.css">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="fondo">

    <?php include "nav.php"; ?>

    <main class="formulario-contenedor">

        <form action="../Controller/ProductoController.php?accion=agregar" class="contenedor__form" method="POST" enctype="multipart/form-data" onsubmit="return confirm('¿Deseas agregar este producto este producto?');">
            
            <h2 class="h2--form">Agregar Producto</h2>


            <div class="grupo--input">
                <label for="nombre" class="label--form">Nombre del Producto</label>
                <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre" class="input--form" required>
            </div>


            <div class="grupo--input">
                <label for="categoria" class="label--form">Categoría</label>
                <select name="categoria" id="categoria" class="input--form select--form" required>
                    <option value="" disabled selected>Seleccione una categoría</option>
                    <?php while ($cat = $res_categorias->fetch_assoc()) { ?>
                        <option value="<?php echo $cat['id_categoria']; ?>">
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>


            <div class="grupo--input">
                <label for="descripcion" class="label--form">Descripción</label>
                <textarea name="descripcion" id="descripcion" placeholder="Ingrese la descripción" class="input--form textarea--form" required></textarea>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="inventario" class="label--form">Inventario</label>
                    <input type="number" name="inventario" id="inventario" placeholder="Cantidad" class="input--form" required>
                </div>

                <div class="grupo--input">
                    <label for="precio" class="label--form">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" id="precio" placeholder="0.00" class="input--form" required>
                </div>
            </div>


            <div class="fila--doble">
                <div class="grupo--input">
                    <label for="foto_texto" class="label--form">Ruta o URL de Imagen</label>
                    <input type="text" name="foto_texto" id="foto_texto" placeholder="../Assets/Imagenes/ejemplo.jpg" class="input--form">
                </div>

                <div class="grupo--input">
                    <label for="foto_archivo" class="label--form">O Subir Archivo</label>
                    <input type="file" name="foto_archivo" id="foto_archivo" class="input--form input--file" accept="image/*">
                </div>
            </div>


            <div class="grupo--botones">
                <button type="submit" class="boton--form boton--guardar">Guardar Producto</button>
                <a href="gestionProductos.php" class="boton--form boton--volver">Volver</a>
            </div>

        </form>
    </main>

    <script src="js/producto-validador.js"></script>
</body>
</html>