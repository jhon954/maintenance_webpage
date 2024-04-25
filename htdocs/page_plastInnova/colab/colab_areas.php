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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Máquinas por área</h2>
            <?php 
            include_once 'colab_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section class="container">
        <section class="row">
            <?php foreach ($machines_count_by_area as $area_machines=>$num_machines): ?>
            <section class="col-md-4">
                <section class="card mb-3">
                    <section class="card-body">
                        <h5 class="card-title"><?php echo $area_machines ?></h5>
                        <p class="card-text">Máquinas: <?php echo $num_machines?></p>
                        <a href="<?php echo 'colab_machines.php?area='.urlencode($area_machines)?>" class="btn btn-primary mr-2">Ver máquinas</a>
                    </section>
                </section>
            </section>
            <?php endforeach ?>
        </section>
    </section>
</body>
</html>
