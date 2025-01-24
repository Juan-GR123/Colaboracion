<?php

    function conseguirCategorias($conexion){

        try{

            $sql = "SELECT * FROM categorias";

            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();

        }catch(PDOException $PDOe){
            echo "Ha habido un error que te cagas al obtener las categorías: " . $PDOe->getMessage();
        }

    }

    function crearCategoria($conexion, $categoria){

        try{

            $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(":nombre", $categoria);
            $stmt->execute();

        }catch(PDOException $PDOe){
            echo "Ha habido un error que te cagas al crear la categoría: " . $PDOe->getMessage();
        }

    }

    function validarUsuario($pdo, $email, $password) {

        $sql = "SELECT * FROM usuarios WHERE email = :email AND password = :password";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':password' => $password,
        ]);

        return $stmt->fetch();
    
    }

?>