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