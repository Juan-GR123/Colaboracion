<?php

// 1. Iniciamos sesión
session_start();

require_once 'requires/conexion.php';
require_once 'funciones.php';

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
    <header>
        <h1>Blog de Videojuegos</h1>
        <nav id="menu">
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Acción</a></li>
                <li><a href="#">Rol</a></li>
                <li><a href="#">Deportes</a></li>
                <li><a href="#">Responsabilidad</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="content">
            
        <h2>Últimas entradas</h2>
        <?php
            $entradas = conseguirUltimasEntradas($pdo, 5);
            if(!empty($entradas)):
                foreach($entradas as $entrada):
        ?>
            <article class="entrada">
                <a href="entrada.php?id=<?= $entrada['id'] ?>">
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
    <button>Ver todas las entradas</button>
</section>
        </section>
        <aside>
            <div class="search">
                <h3>Buscar</h3>
                <input type="text" placeholder="Buscar...">
                <button>Buscar</button>
            </div>
            <?php if (!$_SESSION['loginExito']) { ?>
                <div class="login">
                    <h3>Identificate</h3>
                    <?php if (isset($_SESSION['errorPassLogin']))
                        echo $_SESSION['errorPassLogin']; ?>
                    <form method="POST" action="login.php">
                        <input type="email" name="emailLogin" placeholder="Email" value="<?= $_COOKIE['emailLogin'] ?? '' ?>">
                        <input type="password" name="passwordLogin" placeholder="Contraseña" value="<?= $_COOKIE['passwordLogin'] ?? '' ?>">
                        <p style="display: flex;">
                            <input type="checkbox" id="checkboxLogin" name="checkboxLogin" value="<?= $_COOKIE['passwordLogin'] ?? '' ?>">
                            <label for="checkboxLogin">Recuérdame</label>
                        </p>
                        <button type="submit" name="botonLogin">Entrar</button>
                    </form>
                </div>
                <div class="register">
                    <h3>Registrate</h3>
                    <?php if (isset($_SESSION['success_message']))
                        echo $_SESSION['success_message']; ?>
                    <form method="POST" action="registro.php">
                        <input type="text" name="nombreRegistro" placeholder="Nombre">
                        <input type="text" name="apellidosRegistro" placeholder="Apellidos">
                        <input type="email" name="emailRegistro" placeholder="Email">
                        <input type="password" name="passwordRegistro" placeholder="Contraseña">
                        <button type="submit" name="botonRegistro">Registrar</button>
                    </form>
                </div>
                
            <?php } else { ?>
                <div>
                    <form method="POST" action="crearEntradas.php">
                        <button type="submit" name="botonCrear">Crear Entrada</button>
                    </form>
                    <form method="POST" action="eliminar.php">
                        <button type="submit" name="botonEliminar">Eliminar</button>
                    </form>
                    <form action="editar.php" method="POST">
                        <button type="submit" name="botonEditar">Editar</button>
                    </form>
                    <form method="POST" action="logout.php">
                        <button type="submit" name="botonCerrarSesion">Cerrar Sesión</button>
                    </form>
                </div>
            <?php } ?>

            <?php 
             if (isset($_SESSION['success_message2'])){
                echo $_SESSION['success_message2'];
             }
            ?>
            
        </aside>
    </main>
</body>

</html>