<?php

    require_once 'requires/conexion.php';

    function conseguirUltimasEntradas($conexion, $limite = 5){
        $sql = "SELECT entradas.* , categorias.nombre AS categoria_nombre 
        FROM entradas
        INNER JOIN categorias ON entradas.categoria_id = categorias.id 
        ORDER BY entradas.id DESC 
        LIMIT $limite";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resulEntradas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resulEntradas;
    }
?>