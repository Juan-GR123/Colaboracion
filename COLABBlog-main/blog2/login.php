<?php

session_start();

require_once 'requires/conexion.php';
////ERROR DE CAMPO DE CORREO Y CONTRASEÑA VACIO/////
// Definición de variables y mensajes de error
$contra =  $email = "";
$contraErr = $emailErr = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Validación del correo electrónico
    if (empty($_POST["email"])) {
        $emailErr = "<br><i>El correo es obligatorio.";
        $_SESSION['errorEmail'] = $emailErr;
        unset($_SESSION['errorEmail']);
    } else {
       
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "<br><i>El formato del correo es inválido.";
            $_SESSION['errorEmail'] = $emailErr;
        }
    }
    //2.validacion de la contraseña
    if (empty($_POST["contra"])) {
        $contraErr = "<br><i>La contraseña es obligatoria.";
        $_SESSION['errorContra'] = $contraErr;
       
    } else {
        $contra = test_input($_POST["contra"]);
        unset($_SESSION['errorContra']);
    }
}
/////////////////////////////////////////////////////////

// 7. Definimos una variable de sesión para controlar los 3 intentos fallidos de inicio de sesión
$_SESSION['errorInicioSesion'] = $_SESSION['errorInicioSesion'] ?? 0;
$_SESSION['ultimoIntento'] = $_SESSION['ultimoIntento'] ?? time();
$_SESSION['loginExito'] = $_SESSION['loginExito'] ?? false;
$_SESSION['id_usuario_logueado'] = $_SESSION['id_usuario_logueado']  ?? 0;

// 6. Formulario de Inicio de Sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['botonLogin']) && $_SESSION['errorInicioSesion'] < 3) {
    // Comprobamos que el email es válido
    $email = filter_var(trim($_POST['emailLogin']), FILTER_VALIDATE_EMAIL);
    // Comprobamos que la contraeña es válida
    $password = trim($_POST['passwordLogin']);

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            $_SESSION['id_usuario_logueado']= $user['id'];
            if (password_verify($password, $user['password'])) {
                $_SESSION['errorInicioSesion'] = 0;
                $_SESSION['loginExito'] = true;
            } else {
                $_SESSION['errorPassLogin'] = "La contraseña no es correcta.";
                $_SESSION['errorInicioSesion']++;
                $_SESSION['ultimoIntento'] = time(); // Guardo la hora del ultimo intento fallido
            }
        } else {
            echo "El email no existe en nuestra Base de Datos";
        }
    } else {
        echo "El email o contraseña errónea";
    }
    header("Location: index.php");
    exit();
}

// 7. Controlamos los 3 intentos fallidos de inicio de sesión
echo "Error inicio sesion" . var_dump($_SESSION['errorInicioSesion']);
echo "ultimo intento: " . var_dump($_SESSION['ultimoIntento']);
if ($_SESSION['errorInicioSesion'] >= 3) {
    $tiempoRestante = time() - $_SESSION['ultimoIntento'];
    if ($tiempoRestante < 5) {
        // Bloqueo al usuario durante 5 segundos
        echo "<script> 
        setTimeout(function() {
            window.location.reload();
        }, 5000);
        </script>";
    } else {
        // Hacemos un reset de los errores si han pasado más de 5 segundos
        $_SESSION['errorInicioSesion'] = 0;
    }
}



// 2. Función para limpiar y validar los datos
function test_input($data){
    $data = trim($data); // Elimina espacios en blanco
    $data = stripslashes($data); // Elimina barras invertidas
    $data = htmlspecialchars($data); // Convierte caracteres especiales en entidades HTML
    return $data;
}

