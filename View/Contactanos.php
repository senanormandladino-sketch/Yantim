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
    <title>Yantim - Contactanos</title>
    <link rel="stylesheet" href="css/contactanos.css?v=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../Assets/Imagenes/yantim-favicon.ico" type="image/x-icon">
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
    <section class="contacto-section">
  <div class="contacto-container">
    <div class="contacto-info">
      <h2>Contáctanos</h2>
      <p>¿Tienes dudas con tus pedidos o necesitas asesoría con nuestros productos? Déjanos un mensaje y te responderemos a la brevedad.</p>
      
      <div class="info-item">
        <i class="fas fa-map-marker-alt"></i>
        <span>Calle 70 A Sur # 15-44 Este, Bogotá, Colombia</span>
      </div>
      <div class="info-item">
        <i class="fas fa-phone-alt"></i>
        <span>+57 314 413 1737</span>
      </div>
      <div class="info-item">
        <i class="fas fa-envelope"></i>
        <span>contacto@yamtin.com</span>
      </div>
    </div>

    <form class="contacto-form" action="#" method="POST">
      <div class="form-group">
        <label for="nombre">Nombre Completo</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
      </div>
      
      <div class="form-group">
        <label for="correo">Correo Electrónico</label>
        <input type="email" id="correo" name="correo" placeholder="tu@correo.com" required>
      </div>

      <div class="form-group">
        <label for="asunto">Asunto</label>
        <input type="text" id="asunto" name="asunto" placeholder="Motivo de consulta" required>
      </div>

      <div class="form-group">
        <label for="mensaje">Mensaje</label>
        <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje aquí..." required></textarea>
      </div>

      <button type="submit" class="btn-enviar">Enviar Mensaje</button>
    </form>
  </div>
</section>
     <?php include "footer.php"; ?>
     <script src="js/contacto-validador.js"></script>
</body>
</html>