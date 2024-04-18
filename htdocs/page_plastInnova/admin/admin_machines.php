<?php

    include("../php/connect.php");
    include("../php/validation_sesion.php");

    $area = $_GET['area'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Máquinas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Máquinas en <?php echo $area;?></h2>
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
                    <li class="nav-item">
                            <a class="nav-link" href="admin_collaborators.php">Colaboradores</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tareas
                        </a>
                        <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="tasks_admin_unassigned.php">Tareas sin asignar</a>
                            <a class="dropdown-item" href="tasks_admin.php">Tareas pendientes</a>
                            <a class="dropdown-item" href="tasks_completed_admin.php">Tareas completadas</a>
                            <a class="dropdown-item" href="../calendar_task.php">Calendario</a>
                        </section>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/close_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </section>
        </nav>
    </header>
    <section class="container">
        <section class="row">
            <?php
            // Consulta para obtener las máquinas en el área especificada
            $query = "SELECT * FROM machines WHERE id_area = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $area);
            $stmt->execute();
            $result = $stmt->get_result();

            // Iterar sobre cada máquina y mostrarla en una tarjeta en una columna
            while ($row = $result->fetch_assoc()) {
                echo '<section class="col-md-4">';
                echo '<section class="card mb-3">';
                echo '<section class="card-body">';
                echo '<h5 class="card-title">' . $row['brand'] . ' - ' . $row['model'] .'</h5>';
                echo '<p class="card-text">Número de máquina: ' . $row['machine_number'] . '</p>';
                echo '<p class="card-text">Estado: ' . (($row['state']=='active')?'Activo':'Inactivo') . '</p>';
                echo '<a href="admin_description_machine.php?area=' . urlencode($area) . '&machine='.urlencode($row['id']).'" class="btn btn-primary">Descripción</a>';
                echo '</section>';
                echo '</section>';
                echo '</section>';
            }

            // Cerrar la conexión y liberar recursos
            $stmt->close();
            $conn->close();
            ?>
            <section class="col-md-4">
                <section class="card mb-3">
                    <section class="card-body">
                        <h5 class="card-title">Agregar Nueva Máquina</h5>
                        <!-- Botón para abrir el modal -->
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addMachineModal">Agregar</a>
                    </section>
                </section>
            </section>
        </section>
        <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="addMachineModal" tabindex="-1" role="dialog" aria-labelledby="addMachineModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMachineModalLabel">Agregar Nueva Área</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar nueva área -->
                    <form action="../php/add_machine.php" method="post">
                    <input type="hidden" name="area_id" value="<?php echo $area; ?>">
                    <section class="form-group">
                        <label for="state_machine">Estado de la máquina:</label>
                        <select class="form-control" id="state_machine" name="state_machine">
                            <option value="active">Activa</option>
                            <option value="inactive">Inactiva</option>
                        </select>
                    </section>
                    <section class="form-group">
                        <label for="machine_number">Número máquina:</label>
                        <input type="text" class="form-control" id="machine_number" name="machine_number">
                    </section>
                    <section class="form-group">
                        <label for="brand">Marca:</label>
                        <input type="text" class="form-control" id="brand" name="brand">
                    </section>
                    <section class="form-group">
                        <label for="model">Modelo:</label>
                        <input type="text" class="form-control" id="model" name="model">
                    </section>
                    <section class="form-group">
                        <label for="serial_number">Número de Serie:</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number">
                    </section>
                    <section class="form-group">
                        <label for="description">Descripción:</label>
                        <input type="text" class="form-control" id="description" rows="4" name="description">
                    </section>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
