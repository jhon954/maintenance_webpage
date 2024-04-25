<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    include("functions.php");
    $id_task = mysqli_real_escape_string($conn, $_GET['id-task']);
    $tasks_data = getTaskJoinColabMachineByID($conn, $id_task);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la tarea</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Detalles de la tarea</h2>
            <?php 
            include_once 'everyone_nav_header.php';
            renderNavbar($_SESSION['type_user']);
            ?>
        </nav>
    </header>
    <section class="container mt-5">
        <section class="card">
            <section class="card-body">
                <h5 class="card-title">Prioridad</h5>
                <p class="card-text"><?php echo ($tasks_data['priority'] == 'high') ? 'Alta' : (($tasks_data['priority'] == 'medium') ? 'Media' : 'Baja');?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Área</h5>
                <p class="card-text"><?php echo $tasks_data['id_area']?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Modelo de máquina</h5>
                <p class="card-text"><?php echo $tasks_data['machine_model'];?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Marca de máquina</h5>
                <p class="card-text"><?php echo $tasks_data['machine_brand'];?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Nombre del colaborador</h5>
                <p class="card-text"><?php echo $tasks_data['collaborator_name']." ".$tasks_data['collaborator_surname'];?></p>
            </section>
        </section>
        <section class="card">
            <section class="card-body">
                <h5 class="card-title">Tipo de mantenimiento</h5>
                <p class="card-text">
                    <?php 
                        if($tasks_data['maintenance_type'] == 'preventive'){echo 'Preventivo';}
                        else if($tasks_data['maintenance_type'] == 'corrective'){echo 'Correctivo';}
                        else if($tasks_data['maintenance_type'] == 'calibration'){echo 'Calibración';}
                        else if($tasks_data['maintenance_type'] == 'other'){echo 'Otro';}
                        else {echo 'Error';}
                    ?>
                </p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Descripción de la tarea</h5>
                <p class="card-text"><?php echo $tasks_data['description_task'];?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Fecha de creación</h5>
                <p class="card-text"><?php echo date("d-m-Y h:i:s A", strtotime($tasks_data['creation_task']));?></p>
            </section>
        </section>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Fecha programada</h5>
                <p class="card-text"><?php echo date("d-m-Y", strtotime($tasks_data['date_task']));?></p>
            </section>
        </section>
        <?php
            if ($tasks_data['state'] == 'completed'): ?>
                <section class="card mt-3">
                    <section class="card-body">
                        <h5 class="card-title">Resultado de mantenimiento</h5>
                        <p class="card-text"><?php 
                                                if($tasks_data['result_task'] == 'adjustment'){echo 'Ajuste';}
                                                else if($tasks_data['result_task'] == 'repair'){echo 'Reparación';}
                                                else if($tasks_data['result_task'] == 'start-up'){echo 'Puesta en marcha';}
                                                else if($tasks_data['result_task'] == 'out-of-service'){echo 'Fuera de servicio';}
                                                else {echo 'Error';}
                                            ?></p>
                    </section>
                </section>
        <?php endif; 
            if ($tasks_data['state'] == 'completed'): ?>
                <section class="card mt-3">
                    <section class="card-body">
                        <h5 class="card-title">Descripción del trabajo realizado</h5>
                        <p class="card-text"><?php echo $tasks_data['job_description'];?></p>
                    </section>
                </section>
        <?php endif;
            if ($tasks_data['state'] == 'completed'): ?>
                <section class="card mt-3">
                    <section class="card-body">
                        <h5 class="card-title">Fecha de finalización</h5>
                        <p class="card-text"><?php echo date("Y-m-d h:i:s A", strtotime($tasks_data['finalization_task']));?></p>
                    </section>
                </section>
        <?php endif; ?>
        <section class="card mt-3">
            <section class="card-body">
                <h5 class="card-title">Imágenes de la tarea</h5>
                <?php
                $img_dir_tasks = getTasksImageDirectory($tasks_data['machine_brand'],$tasks_data['id_machine'], $id_task);
                $img_dir_jobs = getJobsCompletedImageDirectory($tasks_data['machine_brand'],$tasks_data['id_machine'], $id_task);
                $images_task_json = $tasks_data['images_task'];
                $images_task = json_decode($images_task_json, true);
                $images_job_json = $tasks_data['images_job'];
                $images_job = json_decode($images_job_json, true);
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
            if ($tasks_data['state'] == 'completed'): ?>
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
</body>
</html>
