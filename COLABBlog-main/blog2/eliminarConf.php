<?php
session_start();

require_once 'requires/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Eliminar la entrada
    $sql = "DELETE FROM entradas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);//no entiendo porque hace falta poner el id dentro del execute?

    echo "Entrada eliminada correctamente.";
    echo "<a href='index.php'>Volver a la lista</a>";
}
?>