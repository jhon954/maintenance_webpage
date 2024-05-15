<?php
include ("../php/connect.php");
include("../php/validation_sesion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Tareas</title>
    <!-- styles -->
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.2/main.min.css' rel='stylesheet' />
    <link href="../css/styles_nav_bar.css" rel="stylesheet">
    <link href="../css/styles_calendar_tasks.css" rel="stylesheet">
    <!-- scripts -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
    <script src="../scripts/calendar_tasks.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <section class="logo-container">
                <img src="../img/images_page/login.png" alt="Logo" class="logo">
            </section>
            <?php 
            include_once 'everyone_nav_header.php';
            renderNavbar($_SESSION['type_user']);
            ?>
        </nav>
    </header>
    <section class="container mt-3">
        <section class="calendar-container">
            <section id='calendar'></section>
        </section>
        <a href="javascript:history.back()" class="btn btn-secondary btn-block">Volver Atrás</a>
    </section>
</body>
</html>
