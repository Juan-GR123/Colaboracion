<?php
// 1. Iniciamos sesión
session_start();

require_once 'requires/conexion.php';
require_once 'requires/funciones.php';
require_once 'buscarEntradas.php';

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
            if (!empty($entradas)):
                foreach ($entradas as $entrada):

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
        <aside>
            <div class="search">
                <h3>Buscar</h3>
                <form method="POST" action="index.php">
                    <input type="text" name="query" placeholder="Buscar por título...">
                    <button type="submit">Buscar</button>
                </form>
            </div>
            <div class="search-results">
                <?php
                if (isset($_POST['query']) && !empty($_POST['query'])) {
                    $query = htmlspecialchars($_POST['query']);
                    $resultados = buscarEntradas($pdo, $query);
                    if (!empty($resultados)) {
                        foreach ($resultados as $resultado) {
                            ?>
                            <article class="entrada">
                                <a href="detallesEntrada.php?id=<?= $resultado['id'] ?>">
                                    <h2><?= $resultado['titulo'] ?></h2>
                                    <span class="fecha"><?= $resultado['categoria_nombre'] . ' | ' . $resultado['fecha'] ?></span>
                                    <p><?= substr($resultado['descripcion'], 0, 180) . "..." ?></p>
                                </a>
                            </article>
                            <?php
                        }
                    } else {
                        echo "<p>No se encontraron resultados para '$query'.</p>";
                    }
                }
                ?>
            </div>

            <?php if (!$_SESSION['loginExito']) { ?>
                <div class="login">
                    <h3>Identificate</h3>
                    <?php if (isset($_SESSION['errorPassLogin'])) { ?>
                        <span style="color: red">
                            <?php
                            echo $_SESSION['errorPassLogin'];
                            unset($_SESSION['errrPassLogin']);
                            ?>

                        </span>

                    <?php } ?>

                    <form method="POST" action="login.php">
                        <input type="email" name="emailLogin" placeholder="Email">
                        <span style="color: red;">
                            <?php
                            if (isset($_SESSION['errorEmail']) && !empty($_SESSION['errorEmail'])) {
                                echo $_SESSION['errorEmail'];
                                unset($_SESSION['errorEmail']); // Eliminar error tras mostrarlo
                            }
                            ?>
                        </span>
                        <input type="password" name="passwordLogin" placeholder="Contraseña">
                        <span style="color: red;">
                            <?php
                            if (isset($_SESSION['errorContra']) && !empty($_SESSION['errorContra'])) {
                                echo $_SESSION['errorContra'];
                                unset($_SESSION['errorContra']); // Eliminar error tras mostrarlo
                            }
                            ?>
                        </span>
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
                        <button type="submit" name="botonEliminar">Eliminar Entrada</button>
                    </form>
                    <form action="editar.php" method="POST">
                        <button type="submit" name="botonEditar">Editar Entrada</button>
                    </form>
                    <form method="POST" action="logout.php">
                        <button type="submit" name="botonCerrarSesion">Cerrar Sesión</button>
                    </form>
                </div>
            <?php } ?>

        </aside>
    </main>

    <?php
    require_once 'requires/pie.php';
    ?>

</body>

</html>