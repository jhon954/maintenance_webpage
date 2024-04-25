<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    $area = mysqli_real_escape_string($conn, $_GET['area']);
    $machines_data = getMachinesByArea($conn, $area);
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
            <h2 class="navbar-brand">Detalles de la máquina</h2>
            <?php 
            include_once 'colab_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section class="container">
        <section class="row">
            <?php foreach($machines_data as $machine_data): ?>
                <section class="col-md-4">
                    <section class="col mb-3">
                        <section class="card-body">
                            <h5 class="card-title"><?php echo $machine_data['brand'].' '.$machine_data['model'] ?></h5>
                            <p class="card-text">Número de máquina: <?php echo $machine_data['machine_number'] ?></p>
                            <p class="card-text">Estado: <?php echo ($machine_data['state']=='active'?'Activo':'Inactivo') ?></p>
                            <a href="<?php echo 'colab_description_machine.php?area'.urlencode($area).'&machine='.urlencode($machine_data['id']) ?>" class="btn btn-primary">Descripción</a>
                        </section>
                    </section>
                </section>
            <?php endforeach ?>
        </section>
        <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
    </section>
</body>
</html>
