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
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Editar</title>";
        echo "<link rel='stylesheet' href='assets/css/estilo.css'>";
        echo "</head>";
        echo "<body>"; 
        echo "<h1>Editar Entrada</h1>";
        echo "<aside>";
        echo "<div>";
        echo "<form method='POST' action='guardarEdicion.php'>
                <input type='text' name='id' value='{$entrada['id']}'>
                <label>Título:</label><br>
                <input type='text' name='titulo' value='{$entrada['titulo']}'><br>
                <label>Descripción:</label><br>
                <textarea name='descripcion' rows='10' cols='60'>{$entrada['descripcion']}</textarea><br>
                <button type='submit'>Guardar Cambios</button>
              </form>";
        echo "</div>";
        echo "</aside>";
        echo "</body>";
    } else {
        echo "Entrada no encontrada.";
    }
} else {
    echo "ID no proporcionado.";
}
