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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    
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
    <section class="card-body">
        <section class="row">
            <section class="col-md-4">
                <?php 
                    $machine_dir = createMachineImageDirectory($machine_id, $machine_data);
                    if (($machine_dir['directory_exists']) && (!empty($machine_data['image_path']))): 
                    $img_dir_machine = $machine_dir['directory_path'];
                ?>
                    <img src="<?php echo $img_dir_machine."/".$machine_data['image_path']; ?>" class="image-machine" alt="Imagen de la máquina">
                <?php else: ?>
                    <p>No hay imagen disponible para esta máquina</p>
                <?php endif; ?>
                <form action="../php/upload_image_machine.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="machine_id" value="<?php echo $machine_id; ?>">
                    <section class="form-group">
                        <label for="image_machine">Seleccionar imagen:</label>
                        <input type="file" class="form-control-file" id="image_machine" name="image_machine" accept="image/*">
                    </section>
                    <button type="submit" class="button-blue">Subir imagen</button>
                </form>
                <section class="input-qr">
                    <input type="hidden" name="url" id="url" value="<?php echo "?machine=". $machine_id."&area=".$machine_data['id_area'] ?>">
                    <button class="btn btn-primary qr" type="submit">Generar QR</button>
                    <section class="qr-code-container">
                        <section class="qr-code"></section>
                    </section>
                </section>
            </section>
            <section class="col-md-8">
                <h4>Detalles de la máquina</h4>
                <form id="editMachineForm" action="../php/edit_machine.php" method="post">
                    <input type="hidden" name="machine_id" value="<?php echo $machine_id; ?>">
                    <section class="row">
                        <section class="col-md-6">
                            <section class="form-group mb-1">
                                <label for="state_machine">Estado de la máquina:</label>
                                <select class="form-control" id="state_machine" name="state_machine" disabled>
                                    <?php $selectedState = $machine_data['state'];?>
                                    <option value="active" <?php echo ($machine_data['state'] == 'active' ? 'selected' : ''); ?>>Activa</option>
                                    <option value="inactive" <?php echo ($machine_data['state'] == 'inactive' ? 'selected' : ''); ?>>Inactiva</option>
                                </select>
                                <button type="button" class="button-edit" onclick="enableEdit('state_machine')">Editar</button>
                            </section>
                            <section class="form-group mb-1">
                                <label for="machine_number">Número máquina:</label>
                                <input type="text" class="form-control" id="machine_number" name="machine_number" value="<?php echo $machine_data['machine_number']; ?>" readonly>
                                <button type="button" class="button-edit" onclick="enableEdit('machine_number')">Editar</button>
                            </section>
                            <section class="form-group mb-1">
                                <label for="brand">Marca:</label>
                                <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $machine_data['brand']; ?>" readonly>
                                <button type="button" class="button-edit" onclick="enableEdit('brand')">Editar</button>
                            </section>
                            <section class="form-group mb-1">
                                <label for="model">Modelo:</label>
                                <input type="text" class="form-control" id="model" name="model" value="<?php echo $machine_data['model']; ?>" readonly>
                                <button type="button" class="button-edit" onclick="enableEdit('model')">Editar</button>
                            </section>
                        </section>
                        <section class="col-md-6">
                            <section class="form-group mb-1">
                                <label for="serial_number">Número de Serie:</label>
                                <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo $machine_data['serial_number']; ?>" readonly>
                                <button type="button" class="button-edit" onclick="enableEdit('serial_number')">Editar</button>
                            </section>
                            <section class="form-group mb-1">
                                <label for="description">Descripción:</label>
                                <!-- <input type="text" class="form-control" id="description" name="description" value="<?php echo $machine_data['description']; ?>" readonly> -->
                                <textarea class="form-control" id="description" name="description" rows="8" readonly><?php echo $machine_data['description']; ?></textarea>
                                <button type="button" class="button-edit" onclick="enableEdit('description')">Editar</button>
                            </section>
                        </section>
                        <section class="col-md-12">
                            <section class="form-group mb-1" id="datasheet_section">
                                <label for="datasheet_url">URL del datasheet:</label>
                                <a href="<?php echo $machine_data['datasheet_url']; ?>" target="_blank" class="form-control" id="datasheet_url" readOnly><?php echo $machine_data['datasheet_url']; ?></a>
                                <input type="hidden" class="form-control" id="datasheet_url_input" name="datasheet_url_input" value="">
                                <button type="button" class="button-edit" onclick="enableEdit_URL()">Editar</button>
                            </section>
                        </section>
                    </section>
                    <button type="submit" id="save_changes_btn" class="btn btn-primary" disabled>Guardar cambios</button>
                    <button type="button" id="discard_changes_btn" class="btn btn-secondary" onclick="discardChanges()" disabled>Descartar cambios</button>
                </form>
                <hr>
                <a href="<?php echo "admin_create_task_calendar.php?machine=". $machine_id."&area=".$machine_data['id_area'] ?>" class="btn btn-success">Crear tarea</a>
                <a href="<?php echo "../everyone/maintenance_history_machine.php?machine=".$machine_id ?>" class="btn btn-info">Historial de mantenimiento</a>
                <a href="<?php echo 'admin_machines.php?area='.$machine_data['id_area'] ?>" class="btn btn-secondary">Volver Atrás</a>
            </section>
        </section>
    </section>
    <script src="../scripts/qr_script.js"></script>
    <script src="../scripts/edit_description_machine.js"></script>
    
</body>
</html>
