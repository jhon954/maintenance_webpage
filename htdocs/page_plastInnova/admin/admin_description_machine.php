<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");

    $machine_id = mysqli_real_escape_string($conn, $_GET['machine']);
    $machine_data = getMachineDataBYID($conn, $machine_id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Máquina</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <?php 
    include_once 'admin_nav_header.php';
    // Name of the current page
    $activePage = basename($_SERVER['PHP_SELF']);
    renderNavbar($activePage);
    ?>
    <section class="card-body">
        <section class="row">
            <section class="col-md-6">
                <?php 
                    $img_dir_machine = "../img/machines/machineid{$machine_id}";
                    if (!is_dir($img_dir_machine)) {
                        mkdir($img_dir_machine, 0777, true); // 0777 permite todos los permisos
                    }
                    $directory_content = scandir($img_dir_machine);
                    $directory_content = array_diff($directory_content, array('.', '..'));

                    if ((!empty($machine_data['image_path'])) && (!empty($directory_content))): 
                ?>
                    <img src="<?php echo $img_dir_machine."/".$machine_data['image_path']; ?>" class="img-fluid" alt="Imagen de la máquina">
                <?php else: ?>
                    <p>No hay imagen disponible para esta máquina</p>
                <?php endif; ?>
                <!-- Formulario para subir o reemplazar la imagen -->
                <form action="../php/upload_image_machine.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="machine_id" value="<?php echo $machine_id; ?>">
                    <section class="form-group">
                        <label for="image_machine">Seleccionar imagen:</label>
                        <input type="file" class="form-control-file" id="image_machine" name="image_machine" accept="image/*">
                    </section>
                    <button type="submit" class="btn btn-primary">Subir imagen</button>
                </form>
            </section>
            <section class="col-md-6">
                <h4>Detalles de la máquina</h4>
                <form id="editMachineForm" action="../php/edit_machine.php" method="post">
                    <input type="hidden" name="machine_id" value="<?php echo $machine_id; ?>">
                    <section class="form-group mb-1">
                        <label for="state_machine">Estado de la máquina:</label>
                        <select class="form-control" id="state_machine" name="state_machine" disabled>
                            <?php $selectedState = $machine_data['state'];?>
                            <option value="active" <?php echo ($machine_data['state'] == 'active' ? 'selected' : ''); ?>>Activa</option>
                            <option value="inactive" <?php echo ($machine_data['state'] == 'inactive' ? 'selected' : ''); ?>>Inactiva</option>
                        </select>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('state_machine')">Editar</button>
                    </section>
                    <section class="form-group mb-1">
                        <label for="machine_number">Número máquina:</label>
                        <input type="text" class="form-control" id="machine_number" name="machine_number" value="<?php echo $machine_data['machine_number']; ?>" readonly>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('machine_number')">Editar</button>
                    </section>
                    <section class="form-group mb-1">
                        <label for="brand">Marca:</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $machine_data['brand']; ?>" readonly>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('brand')">Editar</button>
                    </section>
                    <section class="form-group mb-1">
                        <label for="model">Modelo:</label>
                        <input type="text" class="form-control" id="model" name="model" value="<?php echo $machine_data['model']; ?>" readonly>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('model')">Editar</button>
                    </section>
                    <section class="form-group mb-1">
                        <label for="serial_number">Número de Serie:</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo $machine_data['serial_number']; ?>" readonly>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('serial_number')">Editar</button>
                    </section>
                    <section class="form-group mb-1">
                        <label for="description">Descripción:</label>
                        <input type="text" class="form-control" id="description" rows="4" name="description" value="<?php echo $machine_data['description']; ?>" readonly>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('description')">Editar</button>
                    </section>
                    <section class="form-group mb-1" id="datasheet_section">
                        <label for="datasheet_url">URL del datasheet:</label>
                        <a href="<?php echo $machine_data['datasheet_url']; ?>" target="_blank" class="form-control" id="datasheet_url" readOnly><?php echo $machine_data['datasheet_url']; ?></a>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit_URL()">Editar</button>
                    </section>
                    <button type="submit" id="save_changes_btn" class="btn btn-primary" disabled>Guardar cambios</button>
                    <button type="button" id="discard_changes_btn" class="btn btn-secondary" onclick="discardChanges()" disabled>Descartar cambios</button>
                </form>
                <hr>
                <!-- Botón para crear una nueva tarea -->
                <a href="<?php echo "admin_create_task_calendar.php?machine=". $machine_id."&area=".$machine_data['id_area'] ?>" class="btn btn-success">Crear tarea</a>
                <a href="<?php echo "../everyone/maintenance_history_machine.php?machine=".$machine_id ?>" class="btn btn-info">Historial de mantenimiento</a>
                <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
            </section>
        </section>
    </section>

    <script>
        function enableEdit(fieldId) {
            var field = document.getElementById(fieldId);
            field.readOnly = false;
            document.getElementById('save_changes_btn').disabled = false;
            document.getElementById('discard_changes_btn').disabled = false;
            // Habilitar la edición del campo de estado
            document.getElementById('state_machine').disabled = false;
        }
        
        function enableEdit_URL() {
            var datasheetUrl = document.getElementById('datasheet_url').getAttribute('href');
            console.log(datasheetUrl);
            // Crear un nuevo elemento de entrada de texto
            var inputElement = document.createElement('input');
            inputElement.setAttribute('type', 'text');
            inputElement.setAttribute('class', 'form-control');
            inputElement.setAttribute('id', 'datasheet_url_input');
            inputElement.setAttribute('name', 'datasheet_url');
            inputElement.setAttribute('value', datasheetUrl);
            
            // Reemplazar el enlace con el campo de entrada de texto
            var datasheetSection = document.getElementById('datasheet_section');
            datasheetSection.innerHTML = '<label for="datasheet_url">URL del datasheet:</label>'; // Limpiar el contenido existente
            datasheetSection.appendChild(inputElement);
            // Insertar el botón después del campo de entrada de texto
            datasheetSection.insertAdjacentHTML('beforeend', '<button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit()">Editar</button>');            //var datasheetSection = document.getElementById('datasheet_section');

            document.getElementById('save_changes_btn').disabled = false;
            document.getElementById('discard_changes_btn').disabled = false;
            // Habilitar la edición del campo de estado
            document.getElementById('state_machine').disabled = false;

        }
        function discardChanges() {
            // Recargar la página para descartar los cambios y restaurar los valores originales de los campos
            location.reload();
        }
    </script>
</body>
</html>
