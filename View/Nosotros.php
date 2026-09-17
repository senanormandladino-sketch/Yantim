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
    <title>Yantim - Nosotros</title>
    <link rel="stylesheet" href="css/nosotros.css?v=1">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body class="body">
    <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yantim - Nosotros</title>
    <link rel="stylesheet" href="css/nosotros.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css?v=1">
    <link rel="stylesheet" href="css/fondos-letras.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body class="body">

    <?php

    include "nav.php";

?>

    <div class="titulo-1">
        <h1 class="titulos-uni">Conoce sobre YANTIM</h1>
    </div>

    <main class="contenedor--nosotros--general">
        

        <section>
            <h2 class="titulos-uni titulos-2">Cómo nació nuestra empresa</h2>
            <div class="contenedor--nosotros">
                <p class="texto-rt">
                    Ferretería Yantim nació fruto del esfuerzo y la visión de un grupo de emprendedores locales apasionados por el mundo de la construcción y el mejoramiento del hogar. Todo comenzó como un pequeño negocio familiar con el objetivo de ofrecer herramientas, materiales y asesoría de calidad a los profesionales y vecinos de la comunidad.
                    <br><br>
                    Desde sus inicios, Yantim se destacó por su atención personalizada, su compromiso con la satisfacción del cliente y su espíritu innovador. El nombre <strong>“Yantim”</strong> surge de la fuerza y valores que guían a la empresa: honestidad, esfuerzo y servicio.
                    <br><br>
                    Con el paso del tiempo, Yantim amplió su catálogo de productos, incorporando marcas reconocidas y soluciones modernas para el sector ferretero, industrial y doméstico. Hoy, Ferretería Yantim continúa creciendo, manteniendo su esencia familiar y su compromiso con el progreso de la comunidad, apostando por la innovación, la sostenibilidad y la mejora constante.
                </p>
                <img src="../Assets/Imagenes/fondo.jpg" alt="Construcción y herramientas" class="imgcons"> 
            </div>
        </section>


        <section>
            <h2 class="titulos-uni titulos-2">Misión</h2>
            <div class="contenedor--mision--vision">
                <p class="texto-rt">
                    Nuestra misión es ofrecer soluciones ferreteras de calidad para profesionales y hogares, brindando herramientas y materiales confiables a través de un servicio cercano, ágil y seguro. Trabajamos para garantizar una experiencia de compra eficiente tanto en tienda física como online, manteniendo altos estándares, precios justos y asesoría experta que ayude a nuestros clientes a construir, reparar y crear con confianza.
                </p>
            </div>

            <h2 class="titulos-uni titulos-2">Visión</h2>
            <div class="contenedor--mision--vision">
                <p class="texto-rt">
                    Ser una empresa líder en el sector ferretero, reconocida por ofrecer soluciones integrales y confiables para profesionales, empresas y hogares. Aspiramos a consolidarnos como la ferretería online y física de referencia, destacando por nuestra calidad, variedad y disponibilidad de productos, así como por un servicio cercano, eficiente y orientado a las necesidades reales de nuestros clientes.
                    <br><br>
                    Buscamos innovar continuamente en nuestros procesos, incorporando nuevas tecnologías, herramientas y plataformas digitales que permitan una experiencia de compra ágil, transparente y segura.
                    <br><br>
                    A largo plazo, queremos expandir nuestras operaciones, fortalecer alianzas con proveedores estratégicos y convertir a YANTIM en un referente regional por su compromiso con la calidad, la atención personalizada y el desarrollo de soluciones que impulsen el progreso de nuestros clientes y comunidades.
                </p>
            </div>
        </section>


        <section>
            <h2 class="titulos-uni titulos-2">Nuestros valores</h2>
            <div class="valores-nosotros">
                <ul class="lista--val">
                    <li class="elementos--valores">Compromiso con la calidad</li>
                    <li class="elementos--valores">Atención al cliente</li>
                    <li class="elementos--valores">Integridad y honestidad</li>
                    <li class="elementos--valores">Innovación constante</li>
                    <li class="elementos--valores">Responsabilidad social</li>
                </ul>
            </div>
        </section>


        <section>
            <h2 class="titulos-uni titulos-2">Nuestros colores</h2>
            <div class="colores--nosotros">
                <div class="card-color">
                    <h3 class="subtitulos-gris">Gris</h3>
                    <p class="texto-rt">Representa el metal, las herramientas y la maquinaria, lo cual transmite fuerza, durabilidad y confianza. Es un color neutral y elegante que da equilibrio visual y transmite seriedad, solidez y experiencia técnica.</p>
                </div>
                
                <div class="card-color">
                    <h3 class="subtitulos-naranja">Naranja</h3> 
                    <p class="texto-rt">El color naranja representa energía, dinamismo y acción, transmitiendo la cercanía y rapidez con la que YANTIM ofrece soluciones a sus clientes.</p> 
                </div>

                <div class="card-color">
                    <h3 class="subtitulos-negro">Negro</h3> 
                    <p class="texto-rt">El negro expresa fuerza, solidez y modernidad, reforzando la confianza y la calidad de la marca.</p> 
                </div>

                <div class="card-color">
                    <h3 class="subtitulos-blanco">Blanco</h3> 
                    <p class="texto-rt">El blanco transmite claridad, orden y transparencia, permitiendo una imagen limpia y resaltando los demás elementos del diseño.</p> 
                </div>
            </div>
        </section>


        <section>
            <h2 class="titulos-uni titulos-2">Nuestro logo</h2>
            <div class="logo--ex">
                <div class="texto-rt">
                    <p><strong>• La llave inglesa (en naranja):</strong> Representa el trabajo manual, la reparación, precisión y soluciones prácticas. Es una herramienta universal que asocia a YANTIM con la capacidad de resolver. El naranja refuerza energía y dinamismo.</p>
                    <br>
                    <p><strong>• El engranaje (en gris):</strong> Simboliza maquinaria, estructura y funcionamiento en conjunto. Muestra que YANTIM entiende el sistema completo de tus proyectos con calidad, durabilidad y profesionalismo.</p>
                    <br>
                    <p><strong>• El texto “YANTIM” (en negro):</strong> Transmite fuerza, autoridad, confianza y estabilidad. La tipografía en mayúsculas comunica robustez, claridad y seriedad.</p>
                    <br>
                    <p><strong>• El fondo blanco:</strong> Representa limpieza, orden y transparencia, permitiendo que la marca se proyecte organizada y moderna.</p>
                </div> 
                <div class="logo-container">
                    <img src="../Assets/Imagenes/logo-yantim.png" alt="Logo de la ferreteria YANTIM" class="logo--yantim">
                </div>
            </div> 
        </section>

    </main>
    <?php include "footer.php"; ?>

</body>
</html>
</html>                                                