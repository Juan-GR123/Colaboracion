<?php
session_start();
require_once 'requires/conexion.php';
$db = $pdo;

if (!$_SESSION['loginExito']) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];

    // Validar los datos 
    if (empty($nombre) || empty($apellidos) || empty($email)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Actualizar los datos del usuario en la base de datos
        $query = $db->prepare("UPDATE usuarios SET nombre = ?, apellidos = ?, email = ? WHERE id = ?");
        if ($query->execute([$nombre, $apellidos, $email, $idUsuario])) {
            $success = "Datos actualizados correctamente.";
        } else {
            $error = "Error al actualizar los datos.";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectUsuario'])) {
    $query = $db->prepare("SELECT nombre, apellidos, email FROM usuarios WHERE id = ?");
    $idUsuario = $_POST['selectUsuario'];
    $query->execute([$idUsuario]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $nombre = $result['nombre'];
    $apellidos = $result['apellidos'];
    $email = $result['email'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
</head>
<body>
    <h1>Seleccionar Usuario</h1>
    <form method="post" action="actualizarUsu.php">
        <select name="selectUsuario">
            <?php
            $result = $db->query("SELECT * FROM usuarios");
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
            }
            ?>
        </select>
        <button type="submit">Seleccionar</button>
    </form>

    
    <?php if (isset($idUsuario)): ?>
        <h1>Actualizar Usuario</h1>
        <form method="post" action="actualizarUsu.php">
            <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($idUsuario) ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
            <br>
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?= htmlspecialchars($apellidos) ?>">
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
            <br>
            <button type="submit">Actualizar</button>
        </form>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>
</body>
</html>
