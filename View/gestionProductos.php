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
    <title>Yantim - Gestión de Productos</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css?v=1">
    <link rel="stylesheet" href="css/admin.css">
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
                <h1 class="h1--titulo">Gestión de Productos</h1>
                <div class="grupo--superior">
                    <input type="text" id="buscarProducto" onkeyup="filtrarTabla('buscarProducto', 'tablaProductos', 2)" placeholder="Buscar producto por nombre..." class="input--buscador">
                    <a href="formAgregarProductos.php" class="boton--agregar">+ AGREGAR PRODUCTO</a>
                </div>
            </div>

            <div class="contenedor--tabla">
                <table class="tabla--admin" id="tablaProductos">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Inventario</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_prod = $conexion->query("
                            SELECT p.*, c.nombre AS nombre_categoria 
                            FROM producto p 
                            INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                        ");
                        
                        while ($producto = $sql_prod->fetch_assoc()) {
                        ?>
                            <tr>
                                <td class="td--id"><?php echo $producto['id_producto']; ?></td>
                                <td class="td--foto">
                                    <img src="<?php echo htmlspecialchars($producto['foto_producto']); ?>" alt="Producto" class="img--producto--admin">
                                </td>
                                <td class="td--nombre"><strong><?php echo htmlspecialchars($producto['nombre_producto']); ?></strong></td>
                                <td class="td--categoria">
                                    <span class="badge--categoria"><?php echo htmlspecialchars($producto['nombre_categoria']); ?></span>
                                </td>
                                <td class="td--descripcion"><?php echo htmlspecialchars($producto['descripcion_producto']); ?></td>
                                <td class="td--inventario">
                                    <span class="badge--stock <?php echo $producto['cantidad_producto'] < 5 ? 'stock--bajo' : ''; ?>">
                                        <?php echo $producto['cantidad_producto']; ?> ud.
                                    </span>
                                </td>
                                <td class="td--precio">$<?php echo number_format($producto['costo_producto'], 0, '', '.'); ?></td>
                                <td class="td--acciones">
                                    <div class="grupo--acciones">
                                        <a href="formModificarProductos.php?Id=<?php echo $producto['id_producto']; ?>" class="boton--accion boton--editar">Editar</a>

                                        <a href="../Controller/ProductoController.php?accion=eliminar&Id=<?php echo $producto['id_producto']; ?>" class="boton--accion boton--eliminar" onclick="return confirm('¿Deseas eliminar este producto?')">Eliminar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
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
    </script>
</body>
</html>