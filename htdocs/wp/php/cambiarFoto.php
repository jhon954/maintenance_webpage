<?php
    include("validarSesion.php");

    $ubicacion = "../images/".$nickname."/Perfil.jpg";

    $archivo = $_FILES['archivo']['tmp_name'];

    if(move_uploaded_file($archivo, $ubicacion)){
        echo "El archivo ha sido subido";
        header('Location: ../misFotos.php');
    }else{
        echo "Ha ocurrido un error, trate de nuevo";
        echo "<a href='../misFotos.php'>Volver</a></div>";
    }

?>