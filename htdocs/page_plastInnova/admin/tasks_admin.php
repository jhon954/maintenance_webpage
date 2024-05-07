<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    $data_no_logged = getActiveTasksByDifferentSessionID($conn, $_SESSION['id']);
    $data_logged = getActiveTasksBySessionID($conn, $_SESSION['id']);
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
    <link href="../css/styles_tasks.css" rel="stylesheet">
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
    <section id="tasks_list_1">
        <h2 class="text-center">Tareas pendientes de <?php echo $_SESSION['name']?></h2>
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
                            <?php foreach($data_logged as $data):
                                $machine = getMachineDataBYID($conn, $data['id_machine']);
                                $collaborator = getCollaboratorDataBYID($conn, $data['id_collaborator']);
                                $assigned_collaborator_name = $collaborator['name'] . ' ' . $collaborator['surname'];
                                $area_name = getAreasByID($conn, $data['id_area']);
                            ?>
                            <tr>
                                <td class="align-middle"><?php echo $machine['brand']; ?></td>
                                <td class="align-middle"><?php echo $machine['model'];?></td>
                                <td class="align-middle"><?php echo $area_name['area_name'];?></td>
                                <td class="align-middle"><?php 
                                    if($data['maintenance_type'] == 'preventive'){echo 'Preventivo';}
                                    else if($data['maintenance_type'] == 'corrective'){echo 'Correctivo';}
                                    else if($data['maintenance_type'] == 'calibration'){echo 'Calibración';}
                                    else if($data['maintenance_type'] == 'other'){echo 'Otro';}
                                    else {echo 'Error';}
                                ?></td>
                                <td class="align-middle"><?php echo ($data['priority'] == 'high') ? 'Alta' : (($data['priority'] == 'medium') ? 'Media' : 'Baja'); ?></td>
                                <td class="align-middle"><?php echo date("d-m-Y", strtotime($data['date_task'])); ?></td>
                                <td class="align-middle"><?php echo $assigned_collaborator_name; ?></td>
                                <td class="button-grid">
                                    <a href="<?php echo "../everyone/description_job_task.php?id-task=".$data['id']?>" class="button-options">Revisar</a>
                                    <a href="<?php echo "admin_edit_task.php?id-task=".$data['id']."&id-machine=".$data['id_machine']?>" class="button-options">Editar</a>
                                    <a href="<?php echo "admin_assign_task.php?id-task=".$data['id']?>" class="button-options">Reasignar</a>
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$data['id']."&brand-machine=".$machine['brand']."&id-machine=".$machine['id']?>" class="button-options">Eliminar</a>
                                    <a href="<?php echo "admin_form_task_complete.php?id-task=".$data['id']."&brand-machine=".$machine['brand']."&id-machine=".$machine['id']?>" class="button-options">Completar</a>
                                </td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
    <section id="tasks_list_1">
        <h2 class="text-center">Tareas pendientes de otros colaboradores</h2>
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
                            <?php foreach($data_no_logged as $data):
                                $machine = getMachineDataBYID($conn, $data['id_machine']);
                                $collaborator = getCollaboratorDataBYID($conn, $data['id_collaborator']);
                                $assigned_collaborator_name = $collaborator['name'] . ' ' . $collaborator['surname'];
                                $area_name = getAreasByID($conn, $data['id_area']);
                            ?>
                            <tr>
                                <td class="align-middle"><?php echo $machine['brand'];?></td>
                                <td class="align-middle"><?php echo $machine['model'];?></td>
                                <td class="align-middle"><?php echo $area_name['area_name'];?></td>
                                <td class="align-middle"><?php 
                                    if($data['maintenance_type'] == 'preventive'){echo 'Preventivo';}
                                    else if($data['maintenance_type'] == 'corrective'){echo 'Correctivo';}
                                    else if($data['maintenance_type'] == 'calibration'){echo 'Calibración';}
                                    else if($data['maintenance_type'] == 'other'){echo 'Otro';}
                                    else {echo 'Error';}
                                ?></td>
                                <td class="align-middle"><?php echo ($data['priority'] == 'high') ? 'Alta' : (($data['priority'] == 'medium') ? 'Media' : 'Baja'); ?></td>
                                <td class="align-middle"><?php echo date("d-m-Y", strtotime($data['date_task'])); ?></td>
                                <td class="align-middle"><?php echo $assigned_collaborator_name; ?></td>
                                <td class="button-grid">
                                    <a href="<?php echo "../everyone/description_job_task.php?id-task=".$data['id']?>" class="button-options">Revisar</a>
                                    <a href="<?php echo "admin_edit_task.php?id-task=".$data['id']."&id-machine=".$data['id_machine']?>" class="button-options">Editar</a>
                                    <a href="<?php echo "admin_assign_task.php?id-task=".$data['id']?>" class="button-options">Reasignar</a>
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$data['id']."&brand-machine=".$machine['brand']."&id-machine=".$machine['id']?>" class="button-options">Eliminar</a>
                                    <a href="<?php echo "admin_form_task_complete.php?id-task=".$data['id']."&brand-machine=".$machine['brand']."&id-machine=".$machine['id']?>" class="button-options">Completar</a>
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
