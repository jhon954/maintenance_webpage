<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");

    // Consulta para obtener las tareas pendientes de colaboradores
    $query1 = "SELECT * 
                FROM tasks T
                WHERE T.state='active'
                AND T.assigned='Yes'
                AND T.id_collaborator != " . $_SESSION['id'];
    $data1 = $conn->query($query1);

    // Consulta para obtener las tareas pendientes del administrador
    $query_admin = "SELECT * 
                    FROM tasks T
                    WHERE T.state='active'
                    AND T.assigned='Yes'
                    AND T.id_collaborator = " . $_SESSION['id'];
    $data_admin = $conn->query($query_admin);

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
                            <a class="nav-link" href="personal_page_admin.php">Mi cuenta</a>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tareas
                            </a>
                            <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="tasks_admin_unassigned.php">Tareas sin asignar</a>
                                <a class="dropdown-item" href="tasks_admin.php">Tareas pendientes</a>
                                <a class="dropdown-item" href="tasks_completed_admin.php">Tareas completadas</a>
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
        <button class="btn btn-outline-primary btn-lg btn-block mb-3" id="toggleTasksBtn1">Mostrar/ocultar tareas</button>
        <section class="container" id="tasks_list_2">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta1">
                    <table class="table">
                        <thead class="text.muted">
                            <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Fecha Creación</th>
                            <th class="text-center">Colaborador asignado</th>
                            <th class="text-center">Opciones</th>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    while(($row1 = $data1->fetch_assoc())){
                                    $query2 = "SELECT * 
                                    FROM machines M
                                    WHERE M.id = '" . $row1['id_machine'] . "'";
                                $data2 = mysqli_query($conn, $query2);
                                while(($row2 = mysqli_fetch_array($data2))){
                                    $query_collaborator_name = "SELECT name, surname FROM collaborators WHERE id = " . $row1['id_collaborator'];
                                    $data_collaborator_name = $conn->query($query_collaborator_name);
                                    $row_collaborator_name = $data_collaborator_name->fetch_assoc();
                                    $assigned_collaborator_name = ($row_collaborator_name) ? $row_collaborator_name['name'] . ' ' . $row_collaborator_name['surname'] : "No asignado";
                                ?>
                                <td><?php echo $row2['marca'];?></td>
                                <td><?php echo $row2['model'];?></td>
                                <td><?php echo $row1['id_area'];?></td>
                                <td><?php echo $row1['description_task'];?></td>
                                <td><?php echo ($row1['state'] == 'active') ? "Pendiente" : $row1['state']; ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($row1['creation_task'])); ?></td>
                                <td><?php echo $assigned_collaborator_name; ?></td>
                                <td>
                                    <a href="<?php echo "../form_task_complete.php?id-task=".$row1['id']."&model-machine=".$row2['model']."&id-machine=".$row2['id']?>">Completar tarea</a>
                                    |
                                    <a href="<?php echo "admin_assign_task.php?id-task=".$row1['id']?>">Reasignar</a>
                                    |
                                    <a href="<?php echo "admin_edit_task.php?id-task=".$row1['id']?>">Editar</a>
                                    |
                                    <a href="<?php echo "collaborators_assign_task.php?id-task=".$row1['id']?>">Eliminar</a>
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
        <button class="btn btn-outline-primary btn-lg btn-block mb-3" id="toggleTasksBtn2">Mostrar/ocultar tareas</button>
        <section id="tasks_list_3" style="display: none;">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta2">
                    <table class="table">
                        <thead class="text.muted">
                            <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Fecha Creación</th>
                            <th class="text-center">Colaborador asignado</th>
                            <th class="text-center">Opciones</th>
                        </thead>
                        <tbody>
                            <tr>
                                <?php while($row_admin = $data_admin->fetch_assoc()){
                                    $query2_admin = "SELECT * 
                                    FROM machines M
                                    WHERE M.id = '" . $row_admin['id_machine'] . "'";
                                $data_admin2 = mysqli_query($conn, $query2);
                                while(($row_admin2 = mysqli_fetch_array($data_admin2))){
                                    $query_admin_name = "SELECT name, surname FROM collaborators WHERE id = " . $row_admin['id_collaborator'];
                                    $data_admin_name = $conn->query($query_admin_name);
                                    $row_admin_name = $data_admin_name->fetch_assoc();
                                    $assigned_admin_name = ($row_admin_name) ? $row_admin_name['name'] . ' ' . $row_admin_name['surname'] : "No asignado";   
                                ?>
                                <td><?php echo $row_admin2['marca'];?></td>
                                <td><?php echo $row_admin2['model'];?></td>
                                <td><?php echo $row_admin['id_area'];?></td>
                                <td><?php echo $row_admin['description_task'];?></td>
                                <td><?php echo ($row_admin['state'] == 'active') ? "Pendiente" : $row_admin['state']; ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($row_admin['creation_task'])); ?></td>
                                <td><?php echo $assigned_admin_name; ?></td>
                                <td>
                                    <a href="<?php echo "../form_task_complete.php?id-task=".$row_admin['id']."&model-machine=".$row_admin2['model']."&id-machine=".$row_admin2['id']?>">Completar tarea</a>
                                    |
                                    <a href="<?php echo "collaborators_assign_task.php?id-task=".$row_admin['id']?>">Reasignar</a>
                                    |
                                    <a href="<?php echo "admin_edit_task.php?id-task=".$row_admin['id']?>">Editar</a>
                                    |
                                    <a href="<?php echo "collaborators_assign_task.php?id-task=".$row_admin['id']?>">Eliminar</a>
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

    <script>
        document.getElementById('toggleTasksBtn1').addEventListener('click', function() {
            var tasksList2 = document.getElementById('tasks_list_2');
            if (tasksList2.style.display === 'none') {
                tasksList2.style.display = 'block';
            } else {
                tasksList2.style.display = 'none';
            }
        });

        document.getElementById('toggleTasksBtn2').addEventListener('click', function() {
            var tasksList3 = document.getElementById('tasks_list_3');
            if (tasksList3.style.display === 'none') {
                tasksList3.style.display = 'block';
            } else {
                tasksList3.style.display = 'none';
            }
        });
    </script>
</body>
</html>
