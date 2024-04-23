<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");

    $id_task = $_GET['id-task'];

    $query1 = "SELECT 
            tasks.*, 
            collaborators.name AS collaborator_name, 
            collaborators.surname AS collaborator_surname, 
            machines.brand AS machine_brand, 
            machines.model AS machine_model 
        FROM 
            tasks 
        JOIN 
            collaborators ON tasks.id_collaborator = collaborators.id 
        JOIN 
            machines ON tasks.id_machine = machines.id 
        WHERE 
            tasks.id = '$id_task'";
    $data1 = $conn->query($query1);
    $row1 = $data1->fetch_assoc();    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la tarea</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Colaborador</h2>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <section class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="colab_personal_page.php">Mi cuenta</a>
                    </li>
                    <li class="nav-item">
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
                            <a class="dropdown-item" href="../everyone/calendar_tasks.php">Calendario</a>
                        </section>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/close_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </section>
        </nav>
    </header>
    <section class="container mt-5">
        <h1 class="text-center">Detalles de la tarea</h1>
        <section class="card">
            <section class="card-body">
                <h5 class="card-title">Prioridad</h5>
                <p class="card-text"><?php echo ($row1['priority'] == 'high') ? 'Alta' : (($row1['priority'] == 'medium') ? 'Media' : 'Baja');?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Área</h5>
                <p class="card-text"><?php echo $row1['id_area']?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Modelo de máquina</h5>
                <p class="card-text"><?php echo $row1['machine_model'];?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Marca de máquina</h5>
                <p class="card-text"><?php echo $row1['machine_brand'];?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Nombre del colaborador</h5>
                <p class="card-text"><?php echo $row1['collaborator_name']." ".$row1['collaborator_surname'];?></p>
            </section>
        </section>
        <section class="card">
            <section class="card-body">
                <h5 class="card-title">Tipo de mantenimiento</h5>
                <p class="card-text">
                    <?php 
                        if($row1['maintenance_type'] == 'preventive'){echo 'Preventivo';}
                        else if($row1['maintenance_type'] == 'corrective'){echo 'Correctivo';}
                        else if($row1['maintenance_type'] == 'calibration'){echo 'Calibración';}
                        else if($row1['maintenance_type'] == 'other'){echo 'Otro';}
                        else {echo 'Error';}
                    ?>
                </p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Descripción de la tarea</h5>
                <p class="card-text"><?php echo $row1['description_task'];?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Fecha de creación</h5>
                <p class="card-text"><?php echo date("d-m-Y h:i:s A", strtotime($row1['creation_task']));?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Fecha programada</h5>
                <p class="card-text"><?php echo date("d-m-Y", strtotime($row1['date_task']));?></p>
            </section>
        </section>
        <?php

            // Verificar si la página anterior es diferente de 'tareas.php' y 'tareasno.php'
            if ($row1['state'] == 'completed'): ?>
                <section class="card mt-3">
                    <section class="card-body">
                        <h5 class="card-title">Resultado de mantenimiento</h5>
                        <p class="card-text"><?php 
                                                if($row1['result_task'] == 'adjustment'){echo 'Ajuste';}
                                                else if($row1['result_task'] == 'repair'){echo 'Reparación';}
                                                else if($row1['result_task'] == 'start-up'){echo 'Puesta en marcha';}
                                                else if($row1['result_task'] == 'out-of-service'){echo 'Fuera de servicio';}
                                                else {echo 'Error';}
                                            ?></p>
                    </section>
                </section>
        <?php endif; 

            if ($row1['state'] == 'completed'): ?>
                <section class="card mt-3">
                    <section class="card-body">
                        <h5 class="card-title">Descripción del trabajo realizado</h5>
                        <p class="card-text"><?php echo $row1['job_description'];?></p>
                    </section>
                </section>
        <?php endif;
            // Verificar si la página anterior es diferente de 'tareas.php' y 'tareasno.php'
            if ($row1['state'] == 'completed'): ?>
                <section class="card mt-3">
                    <section class="card-body">
                        <h5 class="card-title">Fecha de finalización</h5>
                        <p class="card-text"><?php echo date("Y-m-d h:i:s A", strtotime($row1['finalization_task']));?></p>
                    </section>
                </section>
        <?php endif; ?>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Imágenes de la tarea</h5>
                <?php
                $img_dir_tasks = "../img/register_tasks_completed/{$row1['machine_brand']}-{$row1['id_machine']}-{$id_task}/";
                $img_dir_jobs = "../img/register_jobs_completed/{$row1['machine_brand']}-{$row1['id_machine']}-{$id_task}/";
                // Obtener las rutas de las imágenes de la tarea y del trabajo realizado desde la base de datos
                $images_task_json = $row1['images_task'];
                $images_task = json_decode($images_task_json, true); // El segundo parámetro true convierte el resultado en un array asociativo
                $images_job_json = $row1['images_job'];
                $images_job = json_decode($images_job_json, true); // El segundo parámetro true convierte el resultado en un array asociativo
                if (empty($images_task)) {
                    echo '<p>No hay imágenes disponibles.</p>';
                } else {
                    foreach ($images_task as $image_task) {
                        echo '<a href="' . $img_dir_tasks . $image_task . '" target="_blank">';
                        echo '<img src="'. $img_dir_tasks . $image_task . '" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">';
                        echo '</a>';
                    }
                }
                ?>
            </section>
        </section>
        <?php
            // Verificar si la página anterior es diferente de 'tasks_admin.php' y 'tasks_admin_unassigned.php'
            if ($row1['state'] == 'completed'): ?>
                <!-- Mostrar las imágenes del trabajo realizado -->
                <section class="card mt-3">
                    <section class="card-body">
                        <h5 class="card-title">Imágenes del trabajo realizado</h5>
                        <?php
                        if (empty($images_job)) {
                            echo '<p>No hay imágenes disponibles.</p>';
                        } else {
                            foreach ($images_job as $image_job) {
                                echo '<a href="' . $img_dir_jobs . $image_job . '" target="_blank">';
                                echo '<img src="'. $img_dir_jobs . $image_job . '" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">';
                                echo '</a>';
                            }
                        }
                        ?>
                    </section>
                </section>
        <?php endif; ?>
    </section>
    <section class="container mt-5">
        <a href="javascript:history.back()" class="btn btn-primary btn-block mt-3">Volver</a>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
