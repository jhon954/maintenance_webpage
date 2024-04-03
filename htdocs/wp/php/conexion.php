<?php

    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $BD = "redsocial";

    $conexion= mysqli_connect($servidor, $usuario, $contrasena, $BD);

    if(!$conexion){
        echo "Falló la conexión <br>";
        die("conection failed:" . mysqli_connect_error());
    }/*else{
        echo "Conexión exitosa";
    }*/

?>