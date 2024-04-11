<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");

    $query1_colab = "SELECT * 
                FROM tasks T
                WHERE T.state='completed' 
                AND T.id_collaborator != " . $_SESSION['id'];
    $query1_admin = "SELECT * 
                FROM tasks T
                WHERE T.state='completed'
                AND T.id_collaborator = " . $_SESSION['id'];
    
    $data1_colab = $conn->query($query1_colab);
    $data1_admin = $conn->query($query1_admin);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Tareas</title>
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

    <section id="tasks_completed_list_1">
        <h2 class="text-center">Tareas completadas colaboradores</h2>
        <section class="container" id="tasks_completed_list_2">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta1">
                    <table class="table">
                        <thead class="text.muted">
                            <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Descripción tarea</th>
                            <th class="text-center">Colaborador asignado</th>
                            <th class="text-center">Fecha y hora de creación</th>
                            <th class="text-center">Fecha y hora de finalización</th>
                            <th class="text-center">Opciones</th>
                        </thead>
                        <tbody>
                            <tr>
                                <?php while($row1_colab = $data1_colab->fetch_assoc()){
                                    $query2_colab = "SELECT * 
                                    FROM machines M
                                    WHERE M.id = '" . $row1_colab['id_machine'] . "'";
                                    $query3_colab = "SELECT name, surname
                                                FROM collaborators WHERE id='".$row1_colab['id_collaborator']."'";
                                    $data2_colab = mysqli_query($conn, $query2_colab);
                                    $data3_colab = mysqli_query($conn, $query3_colab);
                                    while(($row2_colab = mysqli_fetch_array($data2_colab)) && ($row3_colab = mysqli_fetch_array($data3_colab))){    
                                ?>
                                <td><?php echo $row2_colab['marca'];?></td>
                                <td><?php echo $row2_colab['model'];?></td>
                                <td><?php echo $row1_colab['id_area'];?></td>
                                <td><?php echo $row1_colab['description_task'];?></td>
                                <td><?php echo $row3_colab['name']." ".$row3_colab['surname']; ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($row1_colab['creation_task'])); ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($row1_colab['finalization_task'])); ?></td>
                                <td>
                                    <a href="<?php echo "../description_job_task.php?id-task=".$row1_colab['id']?>">Revisar tarea</a>
                                    |
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$row1_colab['id']?>">Eliminar</a>
                                </td>

                            </tr>
                                <?php }}?>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
    <section id="tasks_completed_list_3">
        <h2 class="text-center">Tareas completadas Administrador</h2>
        <section class="container" id="tasks_completed_list_4">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta1">
                    <table class="table">
                        <thead class="text.muted">
                            <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Descripción tarea</th>
                            <th class="text-center">Colaborador asignado</th>
                            <th class="text-center">Fecha y hora de creación</th>
                            <th class="text-center">Fecha y hora de finalización</th>
                            <th class="text-center">Opciones</th>
                        </thead>
                        <tbody>
                            <tr>
                                <?php while($row1_admin = $data1_admin->fetch_assoc()){
                                    $query2_admin = "SELECT * 
                                    FROM machines M
                                    WHERE M.id = '" . $row1_admin['id_machine'] . "'";
                                    $query3_admin = "SELECT name, surname
                                                FROM collaborators WHERE id='".$row1_admin['id_collaborator']."'";
                                    $data2_admin = mysqli_query($conn, $query2_admin);
                                    $data3_admin = mysqli_query($conn, $query3_admin);
                                    while(($row2_admin = mysqli_fetch_array($data2_admin)) && ($row3_admin = mysqli_fetch_array($data3_admin))){    
                                ?>
                                <td><?php echo $row2_admin['marca'];?></td>
                                <td><?php echo $row2_admin['model'];?></td>
                                <td><?php echo $row1_admin['id_area'];?></td>
                                <td><?php echo $row1_admin['description_task'];?></td>
                                <td><?php echo $row3_admin['name']." ".$row3_admin['surname']; ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($row1_admin['creation_task'])); ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($row1_admin['finalization_task'])); ?></td>
                                <td>
                                    <a href="<?php echo "../description_job_task.php?id-task=".$row1_admin['id']?>">Revisar tarea</a>
                                    |
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$row1_admin['id']?>">Eliminar</a>
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