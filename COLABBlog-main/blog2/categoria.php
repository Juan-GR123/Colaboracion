<?php
session_start();

require_once 'requires/conexion.php';

if (isset($_GET['categoria_id'])) {
    $categoria_id = $_GET['categoria_id'];

    try {
        $sql = "SELECT e.id, e.usuario_id, e.categoria_id, e.titulo, e.descripcion, e.fecha, c.nombre AS categoria_nombre
                FROM entradas e 
                JOIN categorias c ON e.categoria_id = c.id
                WHERE e.categoria_id = :categoria_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->execute();

        $entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // echo "<head>";
        // echo "<meta charset='UTF-8'>";
        // echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        // echo "<title>Entradas de Categoría</title>";
        // echo "<link rel='stylesheet' href='assets/css/estilo.css'>";
        // echo "</head>";
        // echo "<body>";
        // echo "<h1>Entradas de la Categoría</h1>";
        // echo "<table border='1'>
        //         <tr>
        //             <th>ID</th>
        //             <th>Usuario ID</th>
        //             <th>Categoría</th>
        //             <th>Título</th>
        //             <th>Descripción</th>
        //             <th>Fecha</th>
        //         </tr>";
        // while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //     echo "<tr>
        //             <td>{$fila['id']}</td>
        //             <td>{$fila['usuario_id']}</td>
        //             <td>{$fila['categoria_nombre']}</td>
        //             <td>{$fila['titulo']}</td>
        //             <td>{$fila['descripcion']}</td>
        //             <td>{$fila['fecha']}</td>
        //           </tr>";
        // }
        // echo "</table>";
        // echo "</body>";
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
} else {
    echo "Categoría no especificada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entradas de Categoría</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <header>
        <h1>Blog de Videojuegos</h1>
        <nav id="menu">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="categoria.php?categoria_id=1">Acción</a></li>
                <li><a href="categoria.php?categoria_id=2">Rol</a></li>
                <li><a href="categoria.php?categoria_id=3">Deportes</a></li>
                <li><a href="categoria.php?categoria_id=4">Responsabilidad</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="content">
            <h2>Entradas de la Categoría</h2>
            <?php if (!empty($entradas)): ?>
                <?php foreach ($entradas as $entrada): ?>
                    <article class="entrada">
                        <a href="detallesEntrada.php?id=<?= $entrada['id'] ?>">
                            <h2><?= $entrada['titulo'] ?></h2>
                            <span class="fecha"><?= $entrada['categoria_nombre'] . ' | ' . $entrada['fecha'] ?></span>
                            <p><?= substr($entrada['descripcion'], 0, 180) . "..." ?></p>
                        </a>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay entradas en esta categoría.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>