<?php
require_once 'requires/conexion.php';
function buscarEntradas($pdo, $query) {
    $sql = "SELECT e.*, c.nombre AS categoria_nombre FROM entradas e 
            INNER JOIN categorias c ON e.categoria_id = c.id 
            WHERE e.titulo LIKE :query OR e.descripcion LIKE :query 
            ORDER BY e.fecha DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['query' => "%$query%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}