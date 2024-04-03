<?php
    include("conexion.php");
    include("validarSesion.php");

    $consulta = "SELECT idFotos
                FROM fotos
                ORDER BY idFotos DESC
                LIMIT 1";
    $consulta = mysqli_query($conexion, $consulta);
    $consulta = mysqli_fetch_array($consulta);
    $idFoto = $consulta['idFotos'];

    ++$idFoto;
    
    $ubicacion = "images/$nickname/$idFoto.jpg";
    $archivo = $_FILES['archivo']['tmp_name'];

    if(move_uploaded_file($archivo, "../$ubicacion")){
        echo "El archivo ha sido subido correctamente";

        $consulta = "INSERT INTO fotos VALUES ('$idFoto', '$nickname', '$ubicacion')";
        if(mysqli_query($conexion, $consulta)){
            echo "Tu imagen ha sido guardada";
            header('Location: ../misFotos.php');
        }else{
            echo "Error: ".$consulta . "<br>". mysqli_error($conexion);
            echo "<a href='../misFotos.php'>Volver</a></div>";
        }
    }else{
        echo "Ha ocurrido un error, trate de nuevo";
        echo "<a href='../misFotos.php'>Volver</a></div>";
    }
?>