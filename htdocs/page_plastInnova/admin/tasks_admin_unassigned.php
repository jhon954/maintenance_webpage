<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    $unassigned_tasks = getUnassignedTasks($conn);
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas sin asignar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Tareas sin asignar</h2>
            <?php 
            include_once 'admin_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section id="tasks_list">
        <h2>Tareas sin asignar</h2>
        <section class="container">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta">
                    <table class="table">
                        <thead class="text.muted">
                            <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Tipo de mantenimiento</th>
                            <th class="text-center">Prioridad</th>
                            <th class="text-center">Fecha programada</th>
                            <th class="text-center">Opciones</th>
                        </thead>
                        <tbody>
                            <?php foreach($unassigned_tasks as $task):
                                $machine = getMachineDataBYID($conn, $task['id_machine']);
                            ?>
                            <tr>
                                <td><?php echo $machine['brand'];?></td>
                                <td><?php echo $machine['model'];?></td>
                                <td><?php echo $task['id_area'];?></td>
                                <td><?php 
                                    if($task['maintenance_type'] == 'preventive'){echo 'Preventivo';}
                                    else if($task['maintenance_type'] == 'corrective'){echo 'Correctivo';}
                                    else if($task['maintenance_type'] == 'calibration'){echo 'Calibración';}
                                    else if($task['maintenance_type'] == 'other'){echo 'Otro';}
                                    else {echo 'Error';}
                                ?></td>
                                <td><?php echo ($task['priority'] == 'high') ? 'Alta' : (($task['priority'] == 'medium') ? 'Media' : 'Baja'); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($task['date_task'])); ?></td>
                                <td>
                                    <a href="<?php echo "../everyone/description_job_task.php?id-task=".$task['id']?>">Revisar</a>
                                    |
                                    <a href="<?php echo "admin_assign_task.php?id-task=".$task['id']?>">Asignar</a>
                                    |
                                    <a href="<?php echo "admin_edit_task.php?id-task=".$task['id']."&id-machine=".$task['id_machine']?>">Editar</a>
                                    |
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$task['id']?>">Eliminar</a>
                                </td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
</body>
</html>