<?php
session_start();

require_once 'requires/conexion.php';


try{
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
    <title>Crear Entradas</title>
</head>
<body>
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
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
            <?php endforeach; ?>
            <!-- <option value="1">Accion</option>
            <option value="2">Rol</option>
            <option value="3">Deportes</option>
            <option value="4">Responsabilidad</option> -->
        </select>
        <br>
        <br>
        <button type="submit">Crear entrada</button>
</body>

</html>