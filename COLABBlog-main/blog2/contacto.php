<?php
session_start();

require_once 'requires/conexion.php';

$errorEmail="";
$errorAsunto="";
$errorMensaje="";
$email="";
$mensaje="";
$asunto="";

//$stmt= $pdo->prepare("INSERT INTO contacto (email, asunto, mensaje) 
//                                 VALUES (:email, :asunto, :mensaje)");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['botonContacto'])) {
    echo "Dentro de añadir contacto";
    $email = $_POST['emailContacto'];

    $asunto = trim($_POST['asuntoContacto']);

    $mensaje= $_POST['MensajeContacto'];

    var_dump($email);

    if($email && $asunto && $mensaje){
        $stmt= $pdo->prepare("INSERT INTO contacto (email, asunto, mensaje)
        VALUES (:email, :asunto, :mensaje)");
       
       $stmt-> bindParam(':email',$email);
       $stmt-> bindParam(':asunto',$asunto);
       $stmt-> bindParam(':mensaje',$mensaje);
       $stmt->execute();
   
       $_SESSION['success_message2'] = "Registro realizado con éxito";
       header("Location: index.php");
       exit();
    }else{
      
    if (!$email) {
        $errorEmail="El email no esta completo";
        $_SESSION['errorEmail'] = $errorEmail;
    }

    if(!$asunto){
        $errorAsunto="El asunto no esta completo";
        $_SESSION['errorAsunto'] = $errorAsunto;
    }

    if(!$mensaje){
        $errorMensaje="El mensaje no esta completo";
        $_SESSION['errorMensaje'] = $errorMensaje;
    }
        
    }
   
   header("Location:contacto.php");
   exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<header>
<h1>Blog de Videojuegos</h1>
        <nav id="menu">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#">Acción</a></li>
                <li><a href="#">Rol</a></li>
                <li><a href="#">Deportes</a></li>
                <li><a href="#">Responsabilidad</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
</header>
<body>
    <aside>
        <div class="contacto">
            <h3>Contacto</h3>
            <form action="contacto.php" method="POST">
                <input type="email" name="emailContacto" placeholder="Email" value="<?php echo (isset($email)) ? $email: ""; ?>">
                <span><?php echo isset($_SESSION['errorEmail']) ? $_SESSION['errorEmail'] : ''; ?></span>
                <input type="text" name="asuntoContacto" placeholder="Asunto" value="<?php echo (isset($asunto)) ? $asunto: ""; ?>">
                <span><?php echo isset($_SESSION['errorAsunto']) ? $_SESSION['errorAsunto'] : ''; ?></span>
                <textarea name="MensajeContacto" placeholder="Mensaje" cols="50" rows="10"><?php echo isset($mensaje) ? $mensaje : ''; ?></textarea>
                <span><?php echo isset($_SESSION['errorMensaje']) ? $_SESSION['errorMensaje'] : ''; ?></span>
                <button type="submit" name="botonContacto" class="botonContacto">Enviar</button>
            </form>
        </div>
    </aside>

    <?php
    // Limpiar los mensajes de error después de mostrarlos
    unset($_SESSION['errorEmail']);
    unset($_SESSION['errorAsunto']);
    unset($_SESSION['errorMensaje']);
    ?>
</body>

</html>