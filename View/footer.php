<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/footer.css?v=1">
    <title>Document</title>
</head>
<body>
    <footer class="footer--principal">
    <div class="contenedor--footer">

        <div class="columna--footer col--brand">
            <a href="index.php" class="footer--logo">
                <img src="../Assets/Imagenes/logo-yantim.png" alt="Logo Yantim Ferretería">
            </a>
            <p class="footer--descripcion">
                Tu ferretería de confianza. Calidad, herramientas profesionales y el mejor servicio para tus proyectos.
            </p>
        </div>


        <div class="columna--footer col--links">
            <h4 class="titulo--footer">Navegación</h4>
            <ul class="lista--links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="Nosotros.php">Nosotros</a></li>
                <li><a href="Contactanos.php">Contáctanos</a></li>
                <li><a href="Registro.php">Regístrate</a></li>
                <li><a href="Inicio_secion.php">Iniciar Sesión</a></li>
            </ul>
        </div>


        <div class="columna--footer col--contacto">
            <h4 class="titulo--footer">Contáctanos</h4>
            <div class="info--item">
                <span class="icono">✉</span>
                <a href="mailto:Yantim@gmail.com">Yantim@gmail.com</a>
            </div>
            <div class="info--item">
                <span class="icono">📞</span>
                <a href="tel:+573127648448">+57 312 764 8448</a>
            </div>
            <div class="info--item">
                <span class="icono">📍</span>
                <span>Atención al Cliente y Ventas</span>
            </div>
        </div>

    </div>


    <div class="footer--bottom">
        <p>&copy; <?php echo date('Y'); ?> Ferretería Yantim. Todos los derechos reservados.</p>
    </div>
</footer>
</body>
</html>