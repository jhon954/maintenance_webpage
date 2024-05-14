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
    <!-- styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="../css/styles_nav_bar.css" rel="stylesheet">
    <link href="../css/styles_unassigned_tasks.css" rel="stylesheet">
    <!-- script -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                            <?php if(!empty($unassigned_tasks)): 
                                    foreach($unassigned_tasks as $task):
                                        $machine = getMachineDataBYID($conn, $task['id_machine']);
                                        $area_name = getAreasByID($conn, $task['id_area'])
                            ?>
                            <tr>
                                <td class="align-middle"><?php echo $machine['brand'];?></td>
                                <td class="align-middle"><?php echo $machine['model'];?></td>
                                <td class="align-middle"><?php echo $area_name['area_name'];?></td>
                                <td class="align-middle"><?php 
                                    if($task['maintenance_type'] == 'preventive'){echo 'Preventivo';}
                                    else if($task['maintenance_type'] == 'corrective'){echo 'Correctivo';}
                                    else if($task['maintenance_type'] == 'calibration'){echo 'Calibración';}
                                    else if($task['maintenance_type'] == 'other'){echo 'Otro';}
                                    else {echo 'Error';}
                                ?></td>
                                <td class="align-middle"><?php echo ($task['priority'] == 'high') ? 'Alta' : (($task['priority'] == 'medium') ? 'Media' : 'Baja'); ?></td>
                                <td class="align-middle"><?php echo date("d-m-Y", strtotime($task['date_task'])); ?></td>
                                <td class="button-grid">
                                    <a href="<?php echo "../everyone/description_job_task.php?id-task=".$task['id']?>" class="button-options">Revisar</a>
                                    <a href="<?php echo "admin_edit_task.php?id-task=".$task['id']."&id-machine=".$task['id_machine']?>" class="button-options">Editar</a>
                                    <a href="<?php echo "admin_assign_task.php?id-task=".$task['id']?>" class="button-options">Asignar</a>
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$task['id']."&brand-machine=".$machine['brand']."&id-machine=".$machine['id']?>" class="button-options">Eliminar</a>
                                </td>
                            </tr>
                            <?php endforeach;
                                else:
                            ?>
                            <tr>
                                <td colspan="7">No hay tareas disponibles</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
</body>
</html>