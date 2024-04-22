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
                        <a class="nav-link" href="colab_personal_page.php">Mi cuenta</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="colab_areas.php">Máquinas</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="colab_collaborators.php">Colaboradores</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tareas
                        </a>
                        <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="tasks_colab.php">Tareas pendientes</a>
                            <a class="dropdown-item" href="tasks_colab_completed.php">Tareas completadas</a>
                            <a class="dropdown-item" href="colab_calendar.php">Calendario</a>
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
            </section>
            <section class="col-md-6">
                <h4>Detalles de la máquina</h4>
                <section class="form-group">
                    <label for="state_machine">Estado de la máquina:</label>
                    <input type="text" class="form-control" id="state" name= "state" value="<?php echo ($machine_data['state']=='active'?'Activa':'Inactiva'); ?>" readonly>
                </section>
                <section class="form-group">
                    <label for="machine_number">Número máquina:</label>
                    <input type="text" class="form-control" id="machine_number" name="machine_number" value="<?php echo $machine_data['machine_number']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label for="brand">Marca:</label>
                    <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $machine_data['brand']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label for="model">Modelo:</label>
                    <input type="text" class="form-control" id="model" name="model" value="<?php echo $machine_data['model']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label for="serial_number">Número de Serie:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo $machine_data['serial_number']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label for="description">Descripción:</label>
                    <input type="text" class="form-control" id="description" rows="4" name="description" value="<?php echo $machine_data['description']; ?>" readonly>
                </section>
                <hr>
                <!-- Botón para crear una nueva tarea -->
                <a href="<?php echo "../maintenance_history_machine.php?machine=".$machine_id ?>" class="btn btn-info">Historial de mantenimiento</a>
                <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
            </section>
        </section>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
