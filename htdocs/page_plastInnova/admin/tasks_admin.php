<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");

    // Consulta para obtener las tareas pendientes de colaboradores
    $query1 = "SELECT * 
    FROM tasks T
    WHERE T.state='active'
    AND T.assigned='No'
    ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
    $query_colab = "SELECT * 
                FROM tasks T
                WHERE T.state='active'
                AND T.id_collaborator != " . $_SESSION['id']."
                ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
    if($data_colab = $conn->query($query_colab)){}else{echo "Error first query";}

    // Consulta para obtener las tareas pendientes del administrador
    $query_admin = "SELECT * 
                    FROM tasks T
                    WHERE T.state='active'
                    AND T.id_collaborator = " . $_SESSION['id']."
                    ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
    if($data_admin = $conn->query($query_admin)){}else{echo 'Error second query';}

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
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <h2 class="navbar-brand">Administrador</h2>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <section class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="admin_personal_page.php">Mi cuenta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_areas.php">Máquinas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_collaborators.php">Colaboradores</a>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tareas
                            </a>
                            <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="tasks_admin_unassigned.php">Tareas sin asignar</a>
                                <a class="dropdown-item" href="tasks_admin.php">Tareas pendientes</a>
                                <a class="dropdown-item" href="tasks_completed_admin.php">Tareas completadas</a>
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
    <section id="tasks_list_1">
        <h2 class="text-center">Tareas pendientes de colaboradores</h2>
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
                            <tr>
                                <?php
                                    while(($row_colab = $data_colab->fetch_assoc())){
                                        $colab_query2 = "SELECT * 
                                        FROM machines M
                                        WHERE M.id = '" . $row_colab['id_machine'] . "'";
                                        $data_colab2 = $conn->query($colab_query2);
                                        while(($row_colab2 = mysqli_fetch_array($data_colab2))){
                                            $query_collaborator_name = "SELECT name, surname FROM collaborators WHERE id = " . $row_colab['id_collaborator'];
                                            $data_collaborator_name = $conn->query($query_collaborator_name);
                                            $row_collaborator_name = $data_collaborator_name->fetch_assoc();
                                            $assigned_collaborator_name = ($row_collaborator_name) ? $row_collaborator_name['name'] . ' ' . $row_collaborator_name['surname'] : "No asignado";
                                ?>
                                <td><?php echo $row_colab2['brand'];?></td>
                                <td><?php echo $row_colab2['model'];?></td>
                                <td><?php echo $row_colab['id_area'];?></td>
                                <td><?php 
                                    if($row_colab['maintenance_type'] == 'preventive'){echo 'Preventivo';}
                                    else if($row_colab['maintenance_type'] == 'corrective'){echo 'Correctivo';}
                                    else if($row_colab['maintenance_type'] == 'calibration'){echo 'Calibración';}
                                    else if($row_colab['maintenance_type'] == 'other'){echo 'Otro';}
                                    else {echo 'Error';}
                                ?></td>
                                <td><?php echo ($row_colab['priority'] == 'high') ? 'Alta' : (($row_colab['priority'] == 'medium') ? 'Media' : 'Baja'); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_colab['date_task'])); ?></td>
                                <td><?php echo $assigned_collaborator_name; ?></td>
                                <td>
                                    <a href="<?php echo "../everyone/description_job_task.php?id-task=".$row_colab['id']?>">Revisar</a>
                                    |
                                    <a href="<?php echo "admin_form_task_complete.php?id-task=".$row_colab['id']."&brand-machine=".$row_colab2['brand']."&id-machine=".$row_colab2['id']?>">Completar</a>
                                    |
                                    <a href="<?php echo "admin_assign_task.php?id-task=".$row_colab['id']?>">Reasignar</a>
                                    |
                                    <a href="<?php echo "admin_edit_task.php?id-task=".$row_colab['id']."&id-machine=".$row_colab['id_machine']?>">Editar</a>
                                    |
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$row_colab['id']?>">Eliminar</a>
                                </td>
                            </tr>
                                <?php }}?>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
    
    <section class="container mt-5">
        <h2 class="text-center">Tareas pendientes del administrador</h2>
        <section id="tasks_list_3">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta2">
                    <table class="table">
                        <thead class="text.muted">
                            <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Tipo de mantenimiento</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Fecha Programada</th>
                            <th class="text-center">Colaborador asignado</th>
                            <th class="text-center">Opciones</th>
                        </thead>
                        <tbody>
                            <tr>
                                <?php while($row_admin = $data_admin->fetch_assoc()){
                                    $query2_admin = "SELECT * 
                                    FROM machines M
                                    WHERE M.id = '" . $row_admin['id_machine'] . "'";
                                $data_admin2 = mysqli_query($conn, $query2_admin);
                                while(($row_admin2 = mysqli_fetch_array($data_admin2))){
                                    $query_admin_name = "SELECT name, surname FROM collaborators WHERE id = " . $row_admin['id_collaborator'];
                                    $data_admin_name = $conn->query($query_admin_name);
                                    $row_admin_name = $data_admin_name->fetch_assoc();
                                    $assigned_admin_name = ($row_admin_name) ? $row_admin_name['name'] . ' ' . $row_admin_name['surname'] : "No asignado";   
                                ?>
                                <td><?php echo $row_admin2['brand'];?></td>
                                <td><?php echo $row_admin2['model'];?></td>
                                <td><?php echo $row_admin['id_area'];?></td>
                                <td><?php 
                                    if($row_admin['maintenance_type'] == 'preventive'){echo 'Preventivo';}
                                    else if($row_admin['maintenance_type'] == 'corrective'){echo 'Correctivo';}
                                    else if($row_admin['maintenance_type'] == 'calibration'){echo 'Calibración';}
                                    else if($row_admin['maintenance_type'] == 'other'){echo 'Otro';}
                                    else {echo 'Error';}
                                ?></td>
                                <td><?php echo ($row_admin['priority'] == 'high') ? 'Alta' : (($row_admin['priority'] == 'medium') ? 'Media' : 'Baja'); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_admin['date_task'])); ?></td>
                                <td><?php echo $assigned_admin_name; ?></td>
                                <td>
                                    <a href="<?php echo "../everyone/description_job_task.php?id-task=".$row_admin['id']?>">Revisar</a>
                                    |
                                    <a href="<?php echo "admin_form_task_complete.php?id-task=".$row_admin['id']."&brand-machine=".$row_admin2['brand']."&id-machine=".$row_admin2['id']?>">Completar</a>
                                    |
                                    <a href="<?php echo "admin_assign_task.php?id-task=".$row_admin['id']?>">Reasignar</a>
                                    |
                                    <a href="<?php echo "admin_edit_task.php?id-task=".$row_admin['id']."&id-machine=".$row_admin['id_machine']?>">Editar</a>
                                    |
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$row_admin['id']?>">Eliminar</a>
                                </td>
                            </tr>
                                <?php }}?>
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
