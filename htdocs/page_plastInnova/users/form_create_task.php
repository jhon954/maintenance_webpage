<?php
    include("../php/connect.php");
    include("functions.php");

    $machine_id = mysqli_real_escape_string($conn, $_GET['machine']);
    $area_id = mysqli_real_escape_string($conn, $_GET['area']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Mantenimiento</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles_calendar_tasks_users.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
    <script src="../scripts/calendar_create_tasks_users.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <section class="logo-container">
                <img src="../img/images_page/login.png" alt="Logo" class="logo">
            </section>
        </nav>
    </header>
    <section class="">
        <section class="container">
            <section class="calendar-container">
                <section id='calendar'></section>
            </section>
        </section>
    </section>
    <?php 
        $modals_html = generateCreateTaskModalHTML($machine_id, $area_id);
        echo $modals_html['modal_create_task'];
    ?>
</body>
</html>
