<?php

// 1. Iniciamos sesión
session_start();

require_once 'requires/conexion.php';
require_once 'requires/funciones.php';

$_SESSION['loginExito'] = $_SESSION['loginExito'] ?? false;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog de Videojuegos</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>

<body>
    
    <?php
        require_once 'requires/cabecera.php';
    ?>

    <main>
        <section class="content">
            
        <h2>Últimas entradas</h2>
        <?php
            $entradas = conseguirUltimasEntradas($pdo, 5);
            if(!empty($entradas)):
                foreach($entradas as $entrada):

        ?>
            <article class="entrada">
                <a href="detallesEntrada.php?id=<?= $entrada['id'] ?>">
                    <h2><?= $entrada['titulo'] ?></h2>
                    <span class="fecha"><?= $entrada['categoria_nombre'] . ' | ' . $entrada['fecha'] ?></span>
                    <p><?= substr($entrada['descripcion'], 0, 180) . "..." ?></p>
                </a>
            </article>
    <?php
        endforeach;
    else:
    ?>
        <p>No hay entradas disponibles.</p>
    <?php
    endif;
    ?>
     <form action="listarTEntradas.php" method="POST">
            <button type="submit" name="botonEntradas">Ver todas las entradas</button>
    </form>
</section>
        </section>
        
        <?php
            require_once 'requires/lateral.php';
        ?>

    </main>

    <?php
        require_once 'requires/pie.php';
    ?>
    
</body>

</html>