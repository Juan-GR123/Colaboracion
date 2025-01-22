<?php 
session_start();

require_once 'requires/conexion.php';


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../blog2/assets/css/estilo.css">
</head>

<body>
    <div class="contacto">
        <h3>Contacto</h3>
        <form action="contacto.php" method="POST">
            <input type="text" name="nombreContacto" placeholder="Nombre">
            <input type="email" name="emailContacto" placeholder="Email">
            <input type="text" name="asuntoContacto" placeholder="Asunto">
            <textarea name="MensajeContacto" placeholder="Mensaje"></textarea>
            <button type="submit" name="botonContacto">Enviar</button>
        </form>
    </div>
</body>

</html>

