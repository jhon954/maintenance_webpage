<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    include("functions.php");
    $machine_id = mysqli_real_escape_string($conn, $_GET['machine']);
    $machine_data = getMachineDataBYID($conn, $machine_id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Máquina</title>
    <!-- styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles_nav_bar.css" rel="stylesheet">
    <link href="../css/styles_description_machine.css" rel="stylesheet">
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
    <section class="card-body">
        <section class="row">
        <section class="col-md-6">
                <?php 
                    $machine_dir = createMachineImageDirectory($machine_id, $machine_data);
                    if (($machine_dir['directory_exists']) && (!empty($machine_data['image_path']))): 
                    $img_dir_machine = $machine_dir['directory_path'];
                ?>
                    <img src="<?php echo $img_dir_machine."/".$machine_data['image_path']; ?>" class="img-fluid" alt="Imagen de la máquina">
                <?php else: ?>
                    <p>No hay imagen disponible para esta máquina</p>
                <?php endif; ?>
            </section>
            <section class="col-md-6">
                <h4>Detalles de la máquina</h4>
                <section class="form-group mb-1">
                    <label for="state_machine">Estado de la máquina:</label>
                    <input type="text" class="form-control" id="state" name= "state" value="<?php echo ($machine_data['state']=='active'?'Activa':'Inactiva'); ?>" readonly>
                </section>
                <section class="form-group mb-1">
                    <label for="machine_number">Número máquina:</label>
                    <input type="text" class="form-control" id="machine_number" name="machine_number" value="<?php echo $machine_data['machine_number']; ?>" readonly>
                </section>
                <section class="form-group mb-1">
                    <label for="brand">Marca:</label>
                    <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $machine_data['brand']; ?>" readonly>
                </section>
                <section class="form-group mb-1">
                    <label for="model">Modelo:</label>
                    <input type="text" class="form-control" id="model" name="model" value="<?php echo $machine_data['model']; ?>" readonly>
                </section>
                <section class="form-group mb-1">
                    <label for="serial_number">Número de Serie:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo $machine_data['serial_number']; ?>" readonly>
                </section>
                <section class="form-group mb-1">
                    <label for="description">Descripción:</label>
                    <input type="text" class="form-control" id="description" rows="4" name="description" value="<?php echo $machine_data['description']; ?>" readonly>
                </section>
                <hr>
                <a href="<?php echo "../everyone/maintenance_history_machine.php?machine=".$machine_id ?>" class="btn btn-info">Historial de mantenimiento</a>
                <a href=" <?php echo 'colab_machines.php?area='.$machine_data['id_area']?>" class="btn btn-secondary">Volver Atrás</a>
            </section>
        </section>
    </section>
</body>
</html>
