<?php
    include("php/connect.php");
    include("php/validation_sesion.php");
    $user = "name1";
    $consulta = "SELECT *
                FROM collaborators
                WHERE name='$user'";
    $consulta = mysqli_query($conn, $consulta);
    $consulta = mysqli_fetch_array($consulta);

    #var_dump($consulta);
    echo $_SESSION['nickname'];
    echo $consulta['nick'];
?>  