<?php
    #include("IniciarSesion.php");
    session_start();

    $login = $_SESSION['login'];

    if(!$login){
        echo $login;
        header('Location: index.html');
    }else{
        $nickname = $_SESSION['nickname'];
    }
?>