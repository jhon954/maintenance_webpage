<?php
    include("php/connect.php");
    include("php/validation_sesion.php");

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
                    $img_dir_machine = "img/machines/".$machine_data['model']."_".$machine_data['id'];
                    
                    $directory_content = scandir($img_dir_machine);
                    $directory_content = array_diff($directory_content, array('.', '..'));

                    if ((!empty($machine_data['image_path'])) && (!empty($directory_content))): 
                ?>
                    <img src="<?php echo "img/machines/neoden4_1/".$machine_data['image_path']; ?>" class="img-fluid" alt="Imagen de la máquina">
                <?php else: ?>
                    <p>No hay imagen disponible para esta máquina</p>
                <?php endif; ?>
                <!-- Formulario para subir o reemplazar la imagen -->
                <form action="php/upload_image_machine.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="machine_id" value="<?php echo $machine_id; ?>">
                    <section class="form-group">
                        <label for="image_machine">Seleccionar imagen:</label>
                        <input type="file" class="form-control-file" id="image_machine" name="image_machine" accept="image/*">
                    </section>
                    <button type="submit" class="btn btn-primary">Subir imagen</button>
                </form>
            </section>
            <section class="col-md-6">
                <!-- Detalles de la máquina -->
                <p class="card-text"><strong>Marca:</strong> <?php echo $machine_data['brand']; ?></p>
                <p class="card-text"><strong>Modelo:</strong> <?php echo $machine_data['model']; ?></p>
                <p class="card-text"><strong>Número de Serie:</strong> <?php echo $machine_data['serial_number']; ?></p>
                <!-- Agregar más detalles según sea necesario -->
            </section>
        </section>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
