<?php
require_once('../Model/Conexion.php');

$id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = $conexion->query("SELECT * FROM producto WHERE id_producto = $id_producto");
$producto = $sql->fetch_assoc();

if (!$producto) {
    header("Location: catalogo.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['nombre_producto']); ?> - Comprar</title>
    <link rel="stylesheet" href="css/comprar.css?v=1">
    <link rel="stylesheet" href="css/carrito.css">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
</head>
<body class="body--detalle">

    <div id="btn--abrir-carrito" class="carrito--flotante">
        <span class="icono--carrito">🛒</span>
        <span id="carrito--contador">0</span>
    </div>

    <div id="carrito--sidebar" class="carrito--sidebar">
        <div class="carrito--header">
            <h2>Carrito de Compras</h2>
            <button id="btn--cerrar-carrito" class="btn--cerrar">&times;</button>
        </div>

        <div id="carrito--items" class="carrito--items"></div>

        <div class="carrito--footer">
            <div class="carrito--subtotal">
                <span>Subtotal (<span id="carrito--total-productos">0</span> productos):</span>
                <strong id="carrito--precio-total">$0</strong>
            </div>
            <button type="button" class="btn--proceder-pago" id="btnProcesarPagoCarrito">Proceder al pago</button>
        </div>
    </div>

    <main class="contenedor--detalle">
        <a href="javascript:history.back()" class="boton--volver">
            &#8592; Volver al catálogo
        </a>

        <div class="card--detalle">
            <div class="detalle--imagen-box">
                <img src="<?php echo htmlspecialchars($producto['foto_producto']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" class="detalle--imagen">
            </div>

            <div class="detalle--info">
                <span class="id--productos">ID: <?php echo $producto['id_producto']; ?></span>
                <h1 class="titulo--detalle"><?php echo htmlspecialchars($producto['nombre_producto']); ?></h1>
                
                <p class="precio--detalle" id="precioDinamico" data-precio-unitario="<?php echo $producto['costo_producto']; ?>">
                    $<?php echo number_format($producto['costo_producto'], 0, '', '.'); ?>
                </p>

                <p class="descripcion--productos"><?php echo ucfirst(htmlspecialchars($producto['descripcion_producto'])); ?></p>
                <p class="stock--productos">Disponibles: <?php echo $producto['cantidad_producto']; ?></p>

                <form id="formCompraIndividual" class="form--compra">
                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                    
                    <div class="modal--cantidad-box">
                        <label for="cantidad">Cantidad:</label>
                        <div class="controles--cantidad">
                            <button type="button" class="btn--cantidad" onclick="restar()">-</button>
                            <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="<?php echo $producto['cantidad_producto']; ?>" class="input--cantidad" readonly>
                            <button type="button" class="btn--cantidad" onclick="sumar(<?php echo $producto['cantidad_producto']; ?>)">+</button>
                        </div>
                    </div>

                    <div class="acciones--producto">
                        <button type="submit" id="btnComprarAhora" class="boton--comprar">Finalizar Compra</button>
                        <button 
                            class="boton--carrito"
                            data-id="<?php echo $producto['id_producto']; ?>"
                            data-nombre="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"
                            data-precio="<?php echo $producto['costo_producto']; ?>"
                            data-foto="<?php echo htmlspecialchars($producto['foto_producto']); ?>"
                            data-stock="<?php echo $producto['cantidad_producto']; ?>">
                            Agregar al Carrito
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const precioElem = document.getElementById('precioDinamico');
        const inputCantidad = document.getElementById('cantidad');
        const precioUnitario = parseFloat(precioElem.getAttribute('data-precio-unitario'));

        function actualizarPrecioVista() {
            const cantidad = parseInt(inputCantidad.value) || 1;
            const total = precioUnitario * cantidad;
            precioElem.textContent = '$' + total.toLocaleString('es-CO');
        }

        function restar() {
            if (parseInt(inputCantidad.value) > 1) {
                inputCantidad.value = parseInt(inputCantidad.value) - 1;
                actualizarPrecioVista();
            }
        }

        function sumar(maxStock) {
            if (parseInt(inputCantidad.value) < maxStock) {
                inputCantidad.value = parseInt(inputCantidad.value) + 1;
                actualizarPrecioVista();
            }
        }
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="js/pedidos.js"></script>
    <script src="js/carrito.js"></script>
    
    <script>

    document.getElementById('formCompraIndividual')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const productoIndividual = [{
            id_producto: <?php echo $producto['id_producto']; ?>,
            nombre: '<?php echo addslashes($producto['nombre_producto']); ?>',
            precio: <?php echo $producto['costo_producto']; ?>,
            cantidad: parseInt(document.getElementById('cantidad').value) || 1
        }];

        procesarPagoPedido(productoIndividual);
    });


    document.getElementById('btnProcesarPagoCarrito')?.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const arrayCarrito = JSON.parse(localStorage.getItem('carrito')) || [];

        if (!arrayCarrito || arrayCarrito.length === 0) {
            alert('El carrito está vacío.');
            return;
        }

        const itemsParaEnviar = arrayCarrito.map(item => ({
            id_producto: item.id || item.id_producto,
            nombre: item.nombre,
            precio: parseFloat(item.precio),
            cantidad: parseInt(item.cantidad)
        }));

        procesarPagoPedido(itemsParaEnviar);
    });
    </script>
</body>
</html>