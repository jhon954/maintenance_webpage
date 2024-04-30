<?php
include ("../php/connect.php");
include ("../php/validation_sesion.php");
include ("../php/queries.php");
include ("functions.php");
$areas=getMachineCountsByArea($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Áreas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles_nav_bar.css" rel="stylesheet">
    <link href="../css/styles_areas_page.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
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

    <section class="container">
        <section class="row">
            <?php
            // Generate HTML and Modals
            if(!empty($areas)) {
            foreach ($areas as $area => $num_machines) {
                $html = generateAreaHTML($area, $num_machines);
                echo $html['areaHTML'];
                echo $html['modalEditHTML'];
                echo $html['modalAddHTML'];
            }}
            else{
                $html = generateAreaHTMLWithoutMachines();
                echo $html['areaHTML'];
                echo $html['modalAddHTML'];
            }
            ?>
            <section class="col-md-4">
                <section class="card my-3">
                    <section class="card-body">
                        <h5 class="card-title">Agregar Nueva Área</h5>
                        <a href="#" class="button-red" data-toggle="modal" data-target="#addAreaModal">Agregar</a>
                    </section>
                </section>
            </section>
        </section>
    </section>
</body>
</html>
