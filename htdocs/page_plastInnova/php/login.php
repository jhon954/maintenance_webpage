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
            $_SESSION['job_title']=$consulta['job-title'];
            $_SESSION['type_user']=$consulta['type-user'];
            $_SESSION['state']=$consulta['state'];
            $_SESSION['profilePic']=$consulta['profile-photo'];
            if($consulta['type-user'] == "admin"){
                header('Location: ../admin/personal_page_admin.php');
            }else{
                header('Location: ../colab/personal_page.php');}
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