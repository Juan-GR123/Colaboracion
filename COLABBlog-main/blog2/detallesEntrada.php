<?php
    session_start();

    require_once 'requires/conexion.php';

    if (isset($_GET['id'])) {
        $entrada_id = $_GET['id'];

        try {
            // Consulta para obtener la entrada específica
            $sql = "SELECT e.id, e.usuario_id, e.categoria_id, e.titulo, e.descripcion, e.fecha, c.nombre AS categoria_nombre
                    FROM entradas e 
                    JOIN categorias c ON e.categoria_id = c.id
                    WHERE e.id = :entrada_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':entrada_id', $entrada_id);
            $stmt->execute();

            $entrada = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($entrada) {
                ?>
                <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title><?= $entrada['titulo'] ?></title>
                    <link rel="stylesheet" href="assets/css/estilo.css">
                </head>
                <body>
                    <header>
                        <h1>Blog de Videojuegos</h1>
                        <nav id="menu">
                            <ul>
                                <li><a href="index.php">Inicio</a></li>
                                <li><a href="categoria.php?categoria_id=7">Acción</a></li>
                                <li><a href="categoria.php?categoria_id=3">Rol</a></li>
                                <li><a href="categoria.php?categoria_id=4">Deportes</a></li>
                                <li><a href="categoria.php?categoria_id=6">Responsabilidad</a></li>
                                <li><a href="contacto.php">Contacto</a></li>
                            </ul>
                        </nav>
                    </header>
                    <main>
                        <section class="content">
                            <article class="entrada">
                                <h2><?= $entrada['titulo'] ?></h2>
                                <span class="fecha"><?= $entrada['categoria_nombre'] . ' | ' . $entrada['fecha'] ?></span>
                                <p><?= $entrada['descripcion'] ?></p>
                            </article>
                        </section>
                    </main>
                </body>
                </html>
                <?php
                // echo "<head>";
                // echo "<meta charset='UTF-8'>";
                // echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
                // echo "<title>{$entrada['titulo']}</title>";
                // echo "<link rel='stylesheet' href='assets/css/estilo.css'>";
                // echo "</head>";
                // echo "<body>";
                // echo "<header>";
                // echo "<h1>Blog de Videojuegos</h1>";
                // echo "<nav id='menu'>";
                // echo "<ul>";
                // echo "<li><a href='index.php'>Inicio</a></li>";
                // echo "<li><a href='categoria.php?categoria_id=1'>Acción</a></li>";
                // echo "<li><a href='categoria.php?categoria_id=2'>Rol</a></li>";
                // echo "<li><a href='categoria.php?categoria_id=3'>Deportes</a></li>";
                // echo "<li><a href='categoria.php?categoria_id=4'>Responsabilidad</a></li>";
                // echo "<li><a href='contacto.php'>Contacto</a></li>";
                // echo "</ul>";
                // echo "</nav>";
                // echo "</header>";
                // echo "<main>";
                // echo "<section class='content'>";
                // echo "<article class='entrada'>";
                // echo "<h2>{$entrada['titulo']}</h2>";
                // echo "<span class='fecha'>{$entrada['categoria_nombre']} | {$entrada['fecha']}</span>";
                // echo "<p>{$entrada['descripcion']}</p>";
                // echo "</article>";
                // echo "</section>";
                // echo "</main>";
                // echo "</body>";
            } else {
                echo "Entrada no encontrada.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "ID de entrada no especificado.";
    }
?>