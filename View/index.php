<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yantim - Inicio</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/fondos-letras.css">
    <link rel="stylesheet" href="css/style-letras.css">
    <link rel="stylesheet" href="css/footer.css?v=1">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body class="body">
    <body class="body">
    <?php

    include "nav.php";

?>
    <div class="fondo fondo--index div--fondo">
        <h1 class="h1--titulo">Yantim tu ferreteria de confianza, Consigue las mejores herramientas y materiales aqui.</h1>
        <a href="tienda.php" class="a--titulo">
            <button class="boton--titulo">Compra ahora</button>
        </a>
    </div>
    <div class="contenedor--titulo-catalogo">
        <h2 class="h2--catalogo">Catalogo de productos</h2>
    </div>
    <div class="contenedor--catalogo">
        <div class="contenedor--herramientas">
            <div class="contenedor--img">
                <img src="../Assets/Imagenes/icon_herramientas .png" alt="icono de herramientas" class="img--herramientas">
                <h3 class="h3--catalogo"><a href="tienda.php" class="a--catalogo" id="herramienta">Herramientas</a></h3>
            </div>
            <ul class="lista--catalogo">
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Manuales:</span></a> martillos, mazos, destornilladores, sierras, cinceles, formones, espátulas, cepillos de carpintero, cintas métricas, niveles, escuadras, llaves, alicates, pinzas, remachadoras, mordazas, cúteres, tijeras, limas y lijas.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Eléctricas e inalámbricas:</span></a> taladros, rotomartillos, sierras (circular, de calar, sable), amoladoras, lijadoras y pistolas de calor.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Accesorios:</span></a> brocas, puntas y baterías de repuesto.</p></li>
            </ul>
        </div>
        <div class="contenedor--herramientas">
            <div class="contenedor--img">
                <img src="../Assets/Imagenes/icon_materiales.png" alt="icono de herramientas" class="img--herramientas">
                <h3 class="h3--catalogo"><a href="tienda.php" class="a--catalogo" id="materiales">Materiales de construccion</a></h3>
            </div>
            <ul class="lista--catalogo">
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Fijaciones y anclajes:</span></a> tornillos, clavos, tuercas, pernos, arandelas y remaches.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Cables y cuerdas:</span></a> alambre, cuerda de nylon y tensores.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Aridos:</span></a> cemento, cal, arena y yeso.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Materiales básicos:</span></a> tejas, ladrillos, bloques, madera y perfiles metálicos.</p></li>
            </ul>
        </div>
    </div>
    <div class="contenedor--catalogo">
        <div class="contenedor--herramientas">
            <div class="contenedor--img">
                <img src="../Assets/Imagenes/icon_plomeria.png" alt="icono de herramientas" class="img--herramientas">
                <h3 class="h3--catalogo"><a href="tienda.php" class="a--catalogo">Plomeria y fontaneria</a></h3>
            </div>
            <ul class="lista--catalogo">
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Tubos y conexiones:</span></a> PVC, cobre, CPVC y accesorios (codos, tes, coples).</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Selladores y cintas:</span></a> cinta de teflón, masilla y selladores.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Equipos para baño y cocina:</span></a> grifos, llaves, fregaderos y accesorios.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Herramientas:</span></a> cortatubos, destapacaños y llaves ajustables.</p></li>
            </ul>
        </div>
        <div class="contenedor--herramientas">
            <div class="contenedor--img">
                <img src="../Assets/Imagenes/icon_elec.png" alt="icono de herramientas" class="img--herramientas">
                <h3 class="h3--catalogo"><a href="tienda.php" class="a--catalogo">Electricidad</a></h3>
            </div>
            <ul class="lista--catalogo">
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Cableado:</span></a> cables de cobre y aluminio de distintos calibres.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Interruptores y enchefes:</span></a> tomacorrientes, extensiones y adaptadores.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Iluminacion:</span></a> bombillas, focos, lámparas y linternas.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Herramientas electricas:</span></a> multímetros, pelacables, cinta aislante y destornilladores aislados.</p></li>
            </ul>
        </div>
    </div>
    <div class="contenedor--catalogo contenedor--catalogo-center">
        <div class="contenedor--herramientas">
            <div class="contenedor--img">
                <img src="../Assets/Imagenes/icon_pintura.png" alt="icono de herramientas" class="img--herramientas img--pintura">
                <h3 class="h3--catalogo"><a href="tienda.php" class="a--catalogo">Pintura y quimicos</a></h3>
            </div>
            <ul class="lista--catalogo">
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Pinturas y esmaltes:</span></a> para interior y exterior, selladores, aerosoles y barnices.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Quimicos y adhesivos:</span></a> siliconas, pegamentos, cintas y solventes.</p></li>
                <li><p class="p--catalogo"><a href="tienda.php" class="a--catalogo"><span class="palabra--resaltada">Accesorios:</span></a> brochas, rodillos, bandejas, espátulas y lijas.</p></li>
            </ul>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>