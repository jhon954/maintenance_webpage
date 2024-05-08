<?php
    include ("../php/connect.php");
    include ("../php/validation_sesion.php");
    include("../php/queries.php");
    $machines_count_by_area = getMachineCountsByArea($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Áreas</title>
    <!-- styles -->
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
            include_once 'colab_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section class="container">
        <section class="row">
            <?php 
                foreach ($machines_count_by_area as $area_id=>$num_machines):
                $areas_by_id = getAreasByID($conn, $area_id); ?>
            <section class="col-md-4">
                <section class="card my-3">
                    <section class="card-body">
                        <h3 class="card-title-area"><?php echo $areas_by_id['area_name'] ?></h3>
                        <p class="card-text">Máquinas: <?php echo $num_machines?></p>
                        <a href="<?php echo 'colab_machines.php?area='.urlencode($area_id)?>" class="button-blue">Ver máquinas</a>
                    </section>
                </section>
            </section>
            <?php endforeach ?>
        </section>
    </section>
</body>
</html>
