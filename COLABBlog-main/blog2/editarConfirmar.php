<?php
session_start();

require_once 'requires/conexion.php';
require_once 'requires/funciones.php';

$dsn = "mysql:host=localhost;dbname=blog;charset=utf8mb4";
$username = 'root';
$password = '';

$conexion = new PDO($dsn, $username, $password);
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$categorias = conseguirCategorias($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];

    // Obtener datos de la entrada
    $sql = "SELECT * FROM entradas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $entrada = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($entrada) {
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Editar</title>";
        echo "<link rel='stylesheet' href='assets/css/estilo.css'>";
        echo "</head>";
        echo "<body>";
        echo "<h1>Editar Entrada</h1>";
        echo "<aside>";
        echo "<div>";
        echo "<form method='POST' action='guardarEdicion.php'>
                <input type='text' name='id' value='{$entrada['id']}'>";
?>
        <label for="titulo">Categoría</label>
        <select name="titulo" id="titulo">
            <?php if (!empty($categorias)): ?>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['nombre'] ?>"><?= $categoria['nombre'] ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No hay categorías disponibles</option>
            <?php endif; ?>
        </select><br>
<?php

        echo "<br><label>Descripción:</label><br>
                <textarea name='descripcion' rows='10' cols='60'>{$entrada['descripcion']}</textarea><br>
                <button type='submit'>Guardar Cambios</button>
              </form>";
        echo "</div>";
        echo "</aside>";
        echo "</body>";
    } else {
        echo "Entrada no encontrada.";
    }
} else {
    echo "ID no proporcionado.";
}
