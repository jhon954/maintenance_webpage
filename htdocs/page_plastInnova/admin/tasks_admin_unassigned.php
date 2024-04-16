<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");

    /*$query1 = "SELECT * 
                FROM tasks T
                WHERE T.state='active'
                AND T.assigned='No'";**/
    $query1 = "SELECT * 
    FROM tasks T
    WHERE T.state='active'
    AND T.assigned='No'
    ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
    $data1 = $conn->query($query1);
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
                        <li class="nav-item">
                            <a class="nav-link" href="admin_areas.php">Máquinas</a>
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

    <section id="tasks_list">
        <h2>Mis tareas</h2>

        <section class="container">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta">
                    <table class="table">
                        <thead class="text.muted">
                            <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Prioridad</th>
                            <th class="text-center">Fecha Creación</th>
                            <th class="text-center">Opciones</th>
                        </thead>
                        <tbody>
                            <tr>
                                <?php while($row1 = $data1->fetch_assoc()){
                                    $query2 = "SELECT * 
                                    FROM machines M
                                    WHERE M.id = '" . $row1['id_machine'] . "'";
                                $data2 = mysqli_query($conn, $query2);
                                while($row2 = mysqli_fetch_array($data2) ){    
                                ?>
                                <td><?php echo $row2['brand'];?></td>
                                <td><?php echo $row2['model'];?></td>
                                <td><?php echo $row1['id_area'];?></td>
                                <td><?php echo $row1['description_task'];?></td>
                                <td><?php echo ($row1['priority'] == 'high') ? 'Alta' : (($row1['priority'] == 'medium') ? 'Media' : 'Baja'); ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($row1['creation_task'])); ?></td>
                                <td>
                                    <a href="<?php echo "../description_job_task.php?id-task=".$row1['id']?>">Revisar</a>
                                    |
                                    <a href="<?php echo "admin_assign_task.php?id-task=".$row1['id']?>">Asignar</a>
                                    |
                                    <a href="<?php echo "admin_edit_task.php?id-task=".$row1['id']."&id-machine=".$row1['id_machine']?>">Editar</a>
                                    |
                                    <a href="<?php echo "../php/delete_task.php?id-task=".$row1['id']?>">Eliminar</a>
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