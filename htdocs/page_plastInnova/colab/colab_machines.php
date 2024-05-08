<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    $area_id = mysqli_real_escape_string($conn, $_GET['area']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Máquinas</title>
    <!-- styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles_nav_bar.css" rel="stylesheet">
    <link href="../css/styles_machines_page.css" rel="stylesheet">
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
        <?php $machines_in_area = getMachinesByArea($conn, $area_id);
        foreach($machines_in_area as $machine):?>
            <section class="col-md-4">
                <section class="card my-3">
                    <section class="card-body">
                        <h5 class="card-title"><?php echo "<strong>".$machine['brand']."</strong>"." - "."<strong><em>".$machine['model']."</em></strong>"?></h5>
                        <p class="card-text">Número de máquina: <?php echo $machine['machine_number'] ?></p>
                        <p class="card-text">Estado: <strong><?php echo ($machine['state']=='active'?'Activo':'Inactivo')?></strong></p>
                        <a href=<?php echo 'colab_description_machine.php?machine='.urlencode($machine['id']) ?> class="button-blue">Descripción</a>
                    </section>
                </section>
            </section>
        <?php endforeach; ?>
        </section>
        <a href="colab_areas.php" class="btn btn-secondary">Volver Atrás</a>
    </section>
</body>
</html>
