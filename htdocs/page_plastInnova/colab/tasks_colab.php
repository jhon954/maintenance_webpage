<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");

    $query_colab = "SELECT * 
                FROM tasks T
                WHERE T.state='active'
                ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
    if($data_colab = $conn->query($query_colab)){}else{echo "Error first query";}

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
                <h2 class="navbar-brand">Colaborador</h2>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <section class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="colab_personal_page.php">Mi cuenta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="colab_areas.php">Máquinas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="colab_collaborators.php">Colaboradores</a>
                        </li>
                        <li class="nav-item dropdown active">
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
    <section id="tasks_list_1">
        <h2 class="text-center">Tareas pendientes</h2>
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
