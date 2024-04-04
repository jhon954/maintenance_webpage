<?php
    session_start();

    $login = $_SESSION['login'];

    if(!$login){
        echo $login;
        header('Location: index.html');
    }else{
        $name = $_SESSION['name'];
    }
?>