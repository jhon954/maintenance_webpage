<?php
    session_start();
    $_SESION = array();


    session_destroy();
    header('Location: ../index.php');