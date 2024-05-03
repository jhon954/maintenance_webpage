<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    $data_logged = getCompletedTasksBySessionID($conn, $_SESSION['id']);
    $data_no_logged = getCompletedTasksByDifferentSessionID($conn, $_SESSION['id']);
    $previous_url = $_SERVER['HTTP_REFERER'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <!-- styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="../css/styles_nav_bar.css" rel="stylesheet">
    <!-- scripts -->
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
    <section id="tasks_completed_list_1">
        <h2 class="text-center">Tareas completadas <?php echo $_SESSION['name']?></h2>
        <section class="container" id="tasks_completed_list_2">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta1">
                    <table class="table">
                        <thead class="text.muted">
                            <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Tipo de mantenimiento</th>
                            <th class="text-center">Resultado de mantenimiento</th>
                            <th class="text-center">Colaborador asignado</th>
                            <th class="text-center">Fecha programada</th>
                            <th class="text-center">Fecha y hora de finalización</th>
                            <th class="text-center">Opciones</th>
                        </thead>
                        <tbody>
                        <?php foreach($data_logged as $data):
                                $machine = getMachineDataBYID($conn, $data['id_machine']);
                                $collaborator = getCollaboratorDataBYID($conn, $data['id_collaborator']);
                                $assigned_collaborator_name = $collaborator['name'] . ' ' . $collaborator['surname'];
                                $area_name = getAreasByID($conn, $data['id_area']);
                            ?>
                            <tr>
                                <td><?php echo $machine['brand'];?></td>
                                <td><?php echo $machine['model'];?></td>
                                <td><?php echo $area_name['area_name'];?></td>
                                <td><?php 
                                    if($data['maintenance_type'] == 'preventive'){echo 'Preventivo';}
                                    else if($data['maintenance_type'] == 'corrective'){echo 'Correctivo';}
                                    else if($data['maintenance_type'] == 'calibration'){echo 'Calibración';}
                                    else if($data['maintenance_type'] == 'other'){echo 'Otro';}
                                    else {echo 'Error';}
                                ?></td>
                                <td><?php 
                                    if($data['result_task'] == 'adjustment'){echo 'Ajuste';}
                                    else if($data['result_task'] == 'repair'){echo 'Reparación';}
                                    else if($data['result_task'] == 'start-up'){echo 'Puesta en marcha';}
                                    else if($data['result_task'] == 'out-of-service'){echo 'Fuera de servicio';}
                                    else {echo 'Error';}
                                ?></td>
                                <td><?php echo $assigned_collaborator_name; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($data['date_task'])); ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($data['finalization_task'])); ?></td>
                                <td>
                                    <a href="<?php echo "../everyone/description_job_task.php?id-task=".$data['id']?>">Revisar</a>
                                    |
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$data['id']."&brand-machine=".$machine['brand']."&id-machine=".$machine['id']?>">Eliminar</a>
                                </td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
    <section id="tasks_completed_list_3">
        <h2 class="text-center">Tareas completadas colaboradores</h2>
        <section class="container" id="tasks_completed_list_4">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta1">
                    <table class="table">
                        <thead class="text.muted">
                        <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Tipo de mantenimiento</th>
                            <th class="text-center">Resultado de mantenimiento</th>
                            <th class="text-center">Colaborador asignado</th>
                            <th class="text-center">Fecha programada</th>
                            <th class="text-center">Fecha y hora de finalización</th>
                            <th class="text-center">Opciones</th>
                        </thead>
                        <tbody>
                        <?php foreach($data_no_logged as $data):
                                $machine = getMachineDataBYID($conn, $data['id_machine']);
                                $collaborator = getCollaboratorDataBYID($conn, $data['id_collaborator']);
                                $assigned_collaborator_name = $collaborator['name'] . ' ' . $collaborator['surname'];
                                $area_name = getAreasByID($conn, $data['id_area']);
                            ?>
                            <tr>
                                <td><?php echo $machine['brand'];?></td>
                                <td><?php echo $machine['model'];?></td>
                                <td><?php echo $area_name['area_name'];?></td>
                                <td><?php 
                                    if($data['maintenance_type'] == 'preventive'){echo 'Preventivo';}
                                    else if($data['maintenance_type'] == 'corrective'){echo 'Correctivo';}
                                    else if($data['maintenance_type'] == 'calibration'){echo 'Calibración';}
                                    else if($data['maintenance_type'] == 'other'){echo 'Otro';}
                                    else {echo 'Error';}
                                ?></td>
                                <td><?php 
                                    if($data['result_task'] == 'adjustment'){echo 'Ajuste';}
                                    else if($data['result_task'] == 'repair'){echo 'Reparación';}
                                    else if($data['result_task'] == 'start-up'){echo 'Puesta en marcha';}
                                    else if($data['result_task'] == 'out-of-service'){echo 'Fuera de servicio';}
                                    else {echo 'Error';}
                                ?></td>
                                <td><?php echo $assigned_collaborator_name; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($data['date_task'])); ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($data['finalization_task'])); ?></td>
                                <td>
                                    <a href="<?php echo "../everyone/description_job_task.php?id-task=".$data['id']?>">Revisar</a>
                                    |
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$data['id']."&brand-machine=".$machine['brand']."&id-machine=".$machine['id']?>">Eliminar</a>
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