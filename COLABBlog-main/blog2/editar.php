<?php 

session_start();

require_once 'requires/conexion.php';


try {
    // Obtener todas las entradas
    $sql = "SELECT id,usuario_id, titulo, descripcion, fecha FROM entradas";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Mostrar entradas en una tabla
    echo "<h1>Dime la entrada que deseas editar</h1>";
    echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Opciones</th>
        </tr>";
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if($fila['usuario_id']==$_SESSION['id_usuario_logueado']){
            echo "<tr>
            <td>{$fila['id']}</td>
            <td>{$fila['titulo']}</td>
            <td>{$fila['descripcion']}</td>
            <td>{$fila['fecha']}</td>
            <td>
                  <form method='POST' action='editarConfirmar.php'>
                        <input type='hidden' name='id' value='{$fila['id']}'>
                        <button type='submit'>Editar</button>
                    </form>
            </td>
          </tr>";
        }
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>