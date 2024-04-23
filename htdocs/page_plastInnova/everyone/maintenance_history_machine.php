<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");

    $id_machine =$_GET['machine'];
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Mantenimientos</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Detalles de la máquina</h2>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <section class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ($_SESSION['type_user']=='admin'?"../admin/admin_personal_page.php":"../colab/colab_personal_page.php")?>">Mi cuenta</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo ($_SESSION['type_user']=='admin'?"../admin/admin_areas.php":"colab/colab_areas.php")?>">Máquinas</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="<?php echo ($_SESSION['type_user']=='admin'?"../admin/admin_collaborators.php":"colab/colab_collaborators.php")?>">Colaboradores</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tareas
                        </a>
                        <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo ($_SESSION['type_user']=='admin'?"../admin/tasks_admin_unassigned.php":"../colab/tasks_colab_unassigned.php")?>">Tareas sin asignar</a>
                            <a class="dropdown-item" href="<?php echo ($_SESSION['type_user']=='admin'?"../admin/tasks_admin.php":"../colab/tasks_colab.php")?>">Tareas pendientes</a>
                            <a class="dropdown-item" href="<?php echo ($_SESSION['type_user']=='admin'?"../admin/tasks_completed_admin.php.php":"../colab/tasks_colab_completed.php")?>">Tareas completadas</a>
                        </section>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/close_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </section>
        </nav>
    </header>
    <section class="container mt-4">
        <section class="row">
            <section class="col-md-12">
                <h3>Mantenimientos de la Máquina</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>   
                            <th>#</th>
                            <th>Fecha y hora de finalización</th>
                            <th>Colaborador responsable</th>
                            <th>Descripción del trabajo realizado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Realiza la consulta para obtener el historial de mantenimientos de la máquina con el ID
                            $query1 = "SELECT id,finalization_task, id_collaborator, job_description 
                                    FROM tasks 
                                    WHERE id_machine = ? AND state='completed'";
                            $stmt1 = $conn->prepare($query1);
                            $stmt1->bind_param("i", $id_machine);
                            $stmt1->execute();
                            $result1 = $stmt1->get_result();
                            
                            if ($result1->num_rows > 0) {
                                $counter = 1;
                                while ($row1 = $result1->fetch_assoc()) {
                                    $query2 = "SELECT name, surname FROM collaborators 
                                        WHERE id=?";
                                    $stmt2 = $conn->prepare($query2);
                                    $stmt2->bind_param("i", $row1['id_collaborator']);
                                    $stmt2->execute();
                                    $result2 = $stmt2->get_result();
                                    if ($result2->num_rows > 0) {
                                        while ($row2 = $result2->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $counter;?></td>
                            <td><?php echo $row1['finalization_task'];?></td>
                            <td><?php echo $row2['name']." ".$row2['surname'];?></td>
                            <td><?php echo $row1['job_description'];?></td>
                            <td>
                                <a href="<?php echo "description_job_task.php?id-task=".$row1['id']?>">Revisar</a>
                            </td>
                        </tr>       
                        <?php
                                        }
                                    }else{
                                        echo "<tr><td colspan='4'>No hay collaboradores con ese identificador.</td></tr>";
                                    }
                                    
                                    $counter++;
                                }
                            } else {
                                echo "<tr><td colspan='4'>No hay registros de mantenimiento para esta máquina.</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
            </section>
        </section>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>