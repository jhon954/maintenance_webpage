<?php
    include("php/conexion.php");


    if($nickname == $nicknameA){
        header('Location: miPerfil.php');
    }

    $consulta = "SELECT *
                FROM persona
                WHERE Nickname='$nicknameA'";
    $consulta = mysqli_query($conexion, $consulta);
    $consulta = mysqli_fetch_array($consulta);

    $nombreA = $consulta['Nombre'];
    $apellidosA =$consulta['Apellidos'];
    $edadA = $consulta['Edad'];
    $descripcionA = $consulta['Descripcion'];
    $fotoPerfilA = $consulta['FotoPerfil'];
?>