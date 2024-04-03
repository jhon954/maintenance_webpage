<?php

    include("conexion.php");

    $nickname = $_POST["nickname"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $edad = $_POST["edad"];
    $descripcion = $_POST["descripcion"];
    $email = $_POST["correo"];
    $password = $_POST["contraseña"];

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $fotoPerfil = "images/$nickname/perfil.jpg";

    $consultaId = "SELECT Nickname
                    FROM persona
                    WHERE Nickname = '$nickname' ";

    $consultaId = mysqli_query($conexion, $consultaId);
    $consultaId = mysqli_fetch_array($consultaId);
    if(!$consultaId){
        $sql = "INSERT INTO persona VALUES ('$nickname', '$nombre', '$apellidos', '$edad', '$descripcion', '$fotoPerfil', '$email', '$passwordHash')";
        if(mysqli_query($conexion, $sql)){
            mkdir("../images/$nickname");
            copy("../images/default.jpg", "../images/$nickname/perfil.jpg");

            echo "<br>Tu cuenta ha sido creada.";
            echo "<br> <div> <a href='../index.html' > Iniciar Sesion </a> </div>";
        }else{
            echo "Error: " .$sql . "<br>" . mysqli_error($conexion);
        }
    }else{
        echo "El Nickname ya existe";
        echo "<div> <a href = '../index.html'> Intentalo de nuevo. </a> </div>";
    }

    mysqli_close($conexion);
?>