<?php

    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    include("functions.php");

    $area = mysqli_real_escape_string($conn, $_GET['area']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Máquinas</title>
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
            <h2 class="navbar-brand">Máquinas en <?php echo $area;?></h2>
            <?php 
            include_once 'admin_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section class="container">
        <section class="row">
            <?php $machines_in_area = getMachinesByArea($conn, $area);
            foreach($machines_in_area as $machine):?>
                <section class="col-md-4">
                    <section class="card mb--3">
                        <section class="card-body">
                            <h5 class="card-title"><?php echo $machine['brand'].'-'.$machine['model']?></h5>
                            <p class="card-text">Número de máquina: <?php echo $machine['machine_number'] ?></p>
                            <p class="card-text">Estado: <?php echo ($machine['state']=='active'?'Activo':'Inactivo')?></p>
                            <a href=<?php echo 'admin_description_machine.php?area='.urlencode($area).'&machine='.urlencode($machine['id']) ?> class="btn btn-primary">Descripción</a>
                        </section>
                    </section>
                </section>
            <?php endforeach; ?>
            <section class="col-md-4">
                <section class="card mb-3">
                    <section class="card-body">
                        <h5 class="card-title">Agregar Nueva Máquina</h5>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addMachineModal">Agregar</a>
                    </section>
                </section>
            </section>
        </section>
        <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
    </section>
    <?php echo $modals_html = CreateMachineModal($area);?>
</body>
</html>
