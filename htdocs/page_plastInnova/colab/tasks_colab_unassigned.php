<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");

    $tasks_unassigned_id_logged = getUnassignedTasks($conn);
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<?php 
include_once 'colab_nav_header.php';
$activePage = basename($_SERVER['PHP_SELF']);
renderNavbar($activePage);
?>
    <section id="tasks_list_1">
        <h2 class="text-center">Tareas sin asignar</h2>
        <section class="container" id="tasks_list_2">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta1">
                    <table class="table">
                        <thead class="text.muted">
                            <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Tipo de mantenimiento</th>
                            <th class="text-center">Prioridad</th>
                            <th class="text-center">Fecha Programada</th>
                            <th class="text-center">Colaborador asignado</th>
                            <th class="text-center">Opciones</th>
                        </thead>
                        <tbody>
                            <?php foreach($tasks_unassigned_id_logged as $task): ?>
                            <?php 
                                $machine = getMachineDataBYID($conn, $task['id_machine']);
                                $collaborator_data = getCollaboratorDataBYID($conn, $task['id_collaborator']);
                                $assigned_collaborator_name = ($collaborator_data) ? $collaborator_data['name'] . ' ' . $collaborator_data['surname'] : "No asignado";
                                $maintenance_type = ['preventive' => 'Preventivo','corrective' => 'Correctivo',
                                                    'calibration' => 'Calibración','other' => 'Otro'];
                                $priority = ['high' => 'Alta','medium' => 'Media','low' => 'Baja'];
                            ?>
                            <tr>
                                <td><?php echo $machine['brand'];?></td>
                                <td><?php echo $machine['model'];?></td>
                                <td><?php echo $machine['id_area'];?></td>    
                                <td><?php echo isset($maintenance_type[$task['maintenance_type']]) ? $maintenance_type[$task['maintenance_type']] : 'Error'; ?></td>
                                <td><?php echo isset($priority[$task['priority']]) ? $priority[$task['priority']] : 'Error'; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($task['date_task'])); ?></td>
                                <td><?php echo $assigned_collaborator_name ?></td>
                                <td>
                                    <a href="<?php echo "../everyone/description_job_task.php?id-task=" . $task['id']?>">Revisar</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>