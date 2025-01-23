<?php 
session_start();

require_once 'requires/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];

     // Obtener datos de la entrada
     $sql = "SELECT * FROM entradas WHERE id = :id";
     $stmt = $pdo->prepare($sql);
     $stmt->execute(['id' => $id]);
     $entrada = $stmt->fetch(PDO::FETCH_ASSOC);

     if ($entrada) {
        echo "<h1>Editar Entrada</h1>";
        echo "<form method='POST' action='guardar_edicion.php'>
                <input type='text' name='id' value='{$entrada['id']}'>
                <label>Título:</label><br>
                <input type='text' name='titulo' value='{$entrada['titulo']}'><br>
                <label>Descripción:</label><br>
                <textarea name='descripcion'>{$entrada['descripcion']}</textarea><br>
                <button type='submit'>Guardar Cambios</button>
              </form>";
    } else {
        echo "Entrada no encontrada.";
    }
}else {
    echo "ID no proporcionado.";
}

?>