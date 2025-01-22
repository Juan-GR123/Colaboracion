<?php
function listarEntradas(){
    require_once 'requires/conexion.php';
    $stmt = $pdo->prepare("SELECT * FROM entradas ORDER BY fecha DESC");
    $stmt->execute();
    $resultadoEntradas = $stmt->fetchAll();
    return $resultadoEntradas;
}
?>