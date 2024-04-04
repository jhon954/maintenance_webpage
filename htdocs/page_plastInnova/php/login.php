<?php

    include("connect.php");

    session_start();

    $_SESSION['login'] = false;

    $user = $_POST["username"];
    $password = $_POST["password"];

    $consulta = "SELECT *
                FROM collaborators
                WHERE name='$user'";
    $consulta = mysqli_query($conn, $consulta);
    $consulta = mysqli_fetch_array($consulta);

    if($consulta){
        if($password==$consulta['password']){
            $_SESSION['login'] = true;
            $_SESSION['id']=$consulta['id'];
            $_SESSION['name']=$consulta['name'];
            $_SESSION['surname']=$consulta['surname'];
            $_SESSION['kind_user']=$consulta['kind_user'];
            $_SESSION['state']=$consulta['state'];

            header('Location: ../personal_page.php');
            #echo "Sesion iniciada";
        }else{
            echo "Contraseña Incorrecta.";
            echo "<br><a href = '../index.html'> Intentalo de nuevo. </a></div>";
        }
    }else{
        echo "Usuario no encontrado.";
        echo "<br><a href = '../index.html'> Intentalo de nuevo. </a></div>";
    }
    mysqli_close($conn);
?>