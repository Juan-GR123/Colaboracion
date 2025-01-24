<?php 
session_start();

require_once 'requires/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    $sql = "UPDATE entradas SET titulo = :titulo, descripcion = :descripcion WHERE id = :id";
    $stmt = $pdo-> prepare($sql);
    $stmt -> bindParam(':titulo',$titulo);
    $stmt -> bindParam(':descripcion', $descripcion);
    $stmt -> bindParam(':id', $id);
    $stmt->execute();

    echo "Entrada actualizada correctamente.";
    echo "<a href='index.php'>Volver a la lista</a>";
} 

?>