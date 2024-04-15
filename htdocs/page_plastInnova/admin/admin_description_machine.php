<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");

    // Obtener el ID de la máquina desde la URL
    $machine_id = $_GET['machine'];

    // Consulta para obtener los datos de la máquina
    $query = "SELECT * FROM machines WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $machine_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener los datos de la máquina
        $machine_data = $result->fetch_assoc();
    } else {
        // Mostrar un mensaje si no se encontró la máquina
        echo "No se encontró la máquina con el ID: " . $machine_id;
        exit(); // Salir del script
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Máquina</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Detalles de la máquina</h2>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <section class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="personal_page_admin.php">Mi cuenta</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="admin_areas.php">Máquinas</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tareas
                        </a>
                        <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="tasks_admin_unassigned.php">Tareas sin asignar</a>
                            <a class="dropdown-item" href="tasks_admin.php">Tareas pendientes</a>
                            <a class="dropdown-item" href="tasks_completed_admin.php">Tareas completadas</a>
                        </section>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/close_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </section>
        </nav>
    </header>
    <section class="card-body">
        <section class="row">
            <section class="col-md-6">
                <?php 
                    $img_dir_machine = "../img/machines/".$machine_data['model']."_".$machine_data['id'];
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
                    <input type="hidden" name="machine_model" value="<?php echo $machine_data['model']; ?>">
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
                    <section class="form-group">
                        <label for="state_machine">Estado de la máquina:</label>
                        <section id="stateSelect">
                        <?php $selectedState = $machine_data['state'];?>
                            <select class="form-control" id="state_machine" name="state_machine" disabled>
                                <option value="active" <?php echo ($machine_data['state'] == 'active' ? 'selected' : ''); ?>>Activa</option>
                                <option value="inactive" <?php echo ($machine_data['state'] == 'inactive' ? 'selected' : ''); ?>>Inactiva</option>
                            </select>
                        </section>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('state_machine')">Editar</button>
                    </section>
                    <section class="form-group">
                        <label for="machine_number">Número máquina:</label>
                        <input type="text" class="form-control" id="machine_number" name="machine_number" value="<?php echo $machine_data['machine_number']; ?>" readonly>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('machine_number')">Editar</button>
                    </section>
                    <section class="form-group">
                        <label for="brand">Marca:</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $machine_data['brand']; ?>" readonly>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('brand')">Editar</button>
                    </section>
                    <section class="form-group">
                        <label for="model">Modelo:</label>
                        <input type="text" class="form-control" id="model" name="model" value="<?php echo $machine_data['model']; ?>" readonly>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('model')">Editar</button>
                    </section>
                    <section class="form-group">
                        <label for="serial_number">Número de Serie:</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo $machine_data['serial_number']; ?>" readonly>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="enableEdit('serial_number')">Editar</button>
                    </section>
                    <button type="submit" id="save_changes_btn" class="btn btn-primary" disabled>Guardar cambios</button>
                    <button type="button" id="discard_changes_btn" class="btn btn-secondary" onclick="discardChanges()" disabled>Descartar cambios</button>
                </form>
                <hr>
                <!-- Botón para crear una nueva tarea -->
                <a href="../users/form_create_task.php?machine_id=<?php echo $machine_id; ?>" class="btn btn-success">Crear tarea</a>
                <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
            </section>
        </section>
    </section>

    <script>
        function enableEdit(fieldId) {
            // Habilitar la edición del campo específico
            document.getElementById(fieldId).readOnly = false;

            var selectedValue = document.getElementById(fieldId).value;

            document.getElementById('save_changes_btn').disabled = false;
            document.getElementById('discard_changes_btn').disabled = false;

            // Obtener el div que contiene el select
            var stateSelect = document.getElementById('stateSelect');

            // Crear un nuevo select editable
            var select = document.createElement('select');
            select.className = 'form-control';
            select.id = 'state_machine';
            select.name = 'state_machine';

            // Crear las opciones y establecer su valor y texto
            var option1 = document.createElement('option');
            option1.value = 'active';
            option1.text = 'Activa';
            select.appendChild(option1);

            var option2 = document.createElement('option');
            option2.value = 'inactive';
            option2.text = 'Inactiva';
            select.appendChild(option2);

            select.value = selectedValue;
            // Reemplazar el div original con el nuevo select
            stateSelect.parentNode.replaceChild(select, stateSelect);

            // Habilitar el nuevo select para editar
            select.disabled = false;
        }
        
        function discardChanges() {
            // Recargar la página para descartar los cambios y restaurar los valores originales de los campos
            location.reload();
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
