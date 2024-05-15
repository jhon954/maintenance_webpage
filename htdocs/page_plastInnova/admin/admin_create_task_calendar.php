<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("functions.php");
    $id_machine = mysqli_real_escape_string($conn, $_GET['machine']);
    $area_id = mysqli_real_escape_string($conn, $_GET['area']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear tarea</title>
    <!-- styles -->
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.2/main.min.css' rel='stylesheet' />
    <link href="../css/styles_nav_bar.css" rel="stylesheet">
    <link href="../css/styles_create_task_calendar.css" rel="stylesheet">
    <!-- scripts -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
    <script src="../scripts/create_task_calendar_admin.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <section class="logo-container">
                    <img src="../img/images_page/login.png" alt="Logo" class="logo">
            </section>
            <?php 
            include_once 'admin_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section class="container mt-4">
        <section class="calendar-container">
            <section id='calendar'></section>
        </section>
        <a href="<?php echo "admin_description_machine.php?area=".$area_id."&machine=".$id_machine ?>" class="btn btn-secondary btn-block">Volver</a>
    </section>
    <?php 
        $modals_html = generateCreateTaskModalHTML($id_machine, $area_id);
        echo $modals_html['modal_create_task'];
    ?>
</body>
</html>
