<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yantim - Tienda</title>
    <link rel="stylesheet" href="css/footer.css?v=1">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/pruebas.css">
    <link rel="stylesheet" href="css/carrito.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
</head>
<body class="body">
    <?php include "nav.php"; ?>

    <div class="seccion--busqueda">
      <div class="contenedor--buscador">
        <input type="text" id="buscador-input" class="input--buscar" placeholder="Buscar herramienta o material...">
      </div>

      <div class="contenedor--categorias-principales">
        <button class="btn--categoria principal activo" data-filtro="todos">Todos</button>
        <?php
        require('../Model/Conexion.php'); 
        $sql_principales = $conexion->query("SELECT * FROM categorias WHERE id_categoria <= 5");
        while ($cat_principal = $sql_principales->fetch_assoc()) {
        ?>
          <button class="btn--categoria principal" data-filtro="<?php echo $cat_principal['id_categoria']; ?>">
            <?php echo $cat_principal['nombre']; ?>
          </button>
        <?php } ?>
      </div>
    </div>

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

    <div class="contenedor--catalogo">
      <?php
      $sql = $conexion->query("SELECT * FROM producto"); 
      while ($resultado = $sql->fetch_assoc()) { 
        $sinStock = (intval($resultado['cantidad_producto']) <= 0);
      ?>
        <div class="producto--catalogo <?php echo $sinStock ? 'agotado' : ''; ?>" data-principal="<?php echo $resultado['id_categoria']; ?>">
          
          <?php if ($sinStock): ?>
            <span class="badge-sin-stock">Agotado</span>
          <?php endif; ?>

          <img src="<?php echo $resultado['foto_producto']; ?>" alt="" class="img--productos">
          <p class="id--productos"><?php echo $resultado['id_producto']; ?></p>
          
          <?php if ($sinStock): ?>
            <h3 class="h3--productos"><?php echo $resultado['nombre_producto']; ?></h3>
          <?php elseif (isset($_SESSION['usuario'])): ?>
            <a href="comprar.php?id=<?php echo $resultado['id_producto']; ?>" class="a--comprar">
              <h3 class="h3--productos"><?php echo $resultado['nombre_producto']; ?></h3>
            </a>
          <?php else: ?>
            <a href="Inicio_secion.php" onclick="alert('Debes iniciar sesión para comprar.')" class="a--comprar">
              <h3 class="h3--productos"><?php echo $resultado['nombre_producto']; ?></h3>
            </a>
          <?php endif; ?>
          
          <p class="p--precio" id="precio">$<?php echo number_format($resultado['costo_producto'], 0, '', '.'); ?></p>
          <p class="descripcion--productos"><?php echo ucfirst($resultado['descripcion_producto']); ?></p>
          
          <p class="stock--productos">
            <?php echo $sinStock ? 'Sin existencias' : 'Quedan ' . $resultado['cantidad_producto']; ?>
          </p>
          
          <div class="acciones--producto">
            <?php if ($sinStock): ?>
              <button class="boton--comprar btn-disabled" disabled>Agotado</button>
              <button class="boton--carrito btn-disabled" disabled>Sin Stock</button>
            <?php elseif (isset($_SESSION['usuario'])): ?>
              <a href="comprar.php?id=<?php echo $resultado['id_producto']; ?>" class="boton--comprar">Comprar ahora</a>
              
              <button class="boton--carrito" 
                data-id="<?php echo $resultado['id_producto']; ?>"
                data-nombre="<?php echo $resultado['nombre_producto']; ?>"
                data-precio="<?php echo $resultado['costo_producto']; ?>"
                data-foto="<?php echo $resultado['foto_producto']; ?>"
                data-stock="<?php echo $resultado['cantidad_producto']; ?>">Agregar al carrito</button>
            <?php else: ?>
              <a href="Inicio_secion.php" class="boton--comprar" onclick="alert('Debes iniciar sesión para comprar productos.')">Comprar ahora</a>
              
              <a href="Inicio_secion.php" class="boton--carrito" style="text-decoration:none; text-align:center; display:inline-block;" onclick="alert('Debes iniciar sesión para agregar productos al carrito.')">Agregar al carrito</a>
            <?php endif; ?>
          </div>
        </div>
      <?php } ?>
    </div>

    <?php include "footer.php"; ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="js/pedidos.js"></script>
    <script src="js/carrito.js"></script>
    <script src="js/filtrosNuevos.js"></script>

    <script>
        document.getElementById('btnProcesarPagoCarrito')?.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const carritoGuardado = JSON.parse(localStorage.getItem('carrito')) || [];
            const carritoValido = carritoGuardado.filter(item => item && (item.id || item.id_producto));

            if (carritoValido.length === 0) {
                alert('El carrito está vacío.');
                return;
            }

            const itemsCarrito = carritoValido.map(item => ({
                id_producto: item.id || item.id_producto,
                nombre: item.nombre || item.nombre_producto,
                precio: parseFloat(item.precio || item.costo_producto),
                cantidad: parseInt(item.cantidad) || 1
            }));

            procesarPagoPedido(itemsCarrito);

        });
    </script>
</body>
</html>