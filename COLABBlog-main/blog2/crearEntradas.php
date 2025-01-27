<?php
session_start();

require_once 'requires/conexion.php';
require_once 'requires/funciones.php';

$dsn = "mysql:host=localhost;dbname=blog;charset=utf8mb4";
$username = 'root';
$password = '';
try{
    $conexion = new PDO($dsn, $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $categorias = conseguirCategorias($conexion);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : false;
        $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
        $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;
        $usuario = $_SESSION['id_usuario_logueado'];

        if($titulo && $descripcion && $categoria && $usuario){
            $sql = "INSERT INTO entradas (usuario_id, categoria_id, titulo, descripcion, fecha) VALUES (:usuario, :categoria, :titulo, :descripcion, CURDATE())";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->execute();
            header('Location: index.php');
        }else{
            $_SESSION['error'] = "Faltan datos";
            header('Location: crearEntradas.php');
        }
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog de Videojuegos</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
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
    <h2>CREAR NUEVA ENTRADA</h2>
    <form method="POST" action="crearEntradas.php">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" required>
        <br>
        <br>
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" required></textarea>
        <br>
        <br>
        <label for="categoria">Categoría</label>
        <select name="categoria" id="categoria">
            <?php if (!empty($categorias)): ?>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No hay categorías disponibles</option>
            <?php endif; ?>
        </select>
        <br>
        <br>
        <button type="submit">Crear entrada</button>
</body>

</html>