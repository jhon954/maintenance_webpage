<?php

    $server = "localhost";
    $user = "root";
    $password = "1234";
    $BD = "maintenance_db";

    $conn= mysqli_connect($server, $user, $password, $BD);

    if(!$conn){
        echo "Falló la conexión <br>";
        die("conection failed:" . mysqli_connect_error());
    }
