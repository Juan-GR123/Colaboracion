<?php
session_start();

require_once 'requires/conexion.php';

try {

    //Consulta para obtener todas las entradas
    $sql = "SELECT e.id, e.usuario_id, e.categoria_id, e.titulo, e.descripcion, e.fecha, c.nombre AS categoria_nombre
    FROM entradas e JOIN categorias c 
    ON e.categoria_id = c.id";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Editar</title>";
        echo "<link rel='stylesheet' href='assets/css/estilo.css'>";
        echo "</head>";
        echo "<body>";
    echo "<h1>Lista de Entradas</h1>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Usuario ID</th>
                <th>Categoría</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha</th>
            </tr>";
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) { //hago un fetch para recorrer una a una los resultados
        //de la consulta que he hecho anteriormente en la base de datos
        echo "<tr>
                <td>{$fila['id']}</td>
                <td>{$fila['usuario_id']}</td>
                <td>{$fila['categoria_nombre']}</td>
                <td>{$fila['titulo']}</td>
                <td>{$fila['descripcion']}</td>
                <td>{$fila['fecha']}</td>
              </tr>";
    }
    echo "</table>";
    echo "</body>";
} catch (PDOException $e) {
    // Manejo de errores
    echo "Error en la conexión: " . $e->getMessage();
}
