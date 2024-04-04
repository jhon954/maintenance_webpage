<?php

    $server = "localhost";
    $user = "root";
    $password = "";
    $BD = "main";

    $conn= mysqli_connect($server, $user, $password, $BD);

    if(!$conn){
        echo "Falló la conexión <br>";
        die("conection failed:" . mysqli_connect_error());
    }/*else{
        echo "Conexión exitosa";
    }*/

?>