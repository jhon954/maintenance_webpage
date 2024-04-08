<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    $query1 = "SELECT * 
                FROM tasks T
                WHERE T.state='completed'";
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
                            <a class="nav-link" href="tasks_admin_unassigned.php">Tareas sin asignar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tasks_admin.php">Tareas pendientes</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="tasks_completed_admin.php">Tareas completadas</a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/close_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </section>
        </nav>
        </header>

    <section id="tasks_list">
        <h2>Mis tareas completadas</h2>

        <section class="container">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive table-hover" id="tablaConsulta">
                    <table class="table">
                        <thead class="text.muted">
                            <th class="text-center">Marca Máquina</th>
                            <th class="text-center">Modelo Máquina</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Fecha y hora de creación</th>
                            <th class="text-center">Fecha y hora de finalización</th>
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
                                <td><?php echo $row2['marca'];?></td>
                                <td><?php echo $row2['model'];?></td>
                                <td><?php echo $row1['area'];?></td>
                                <td><?php echo $row1['description_task'];?></td>
                                <td><?php echo ($row1['state'] == 'completed') ? "Completada" : $row1['state']; ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($row1['creation_task'])); ?></td>
                                <td><?php echo date("Y-m-d h:i:s A", strtotime($row1['finalization_task'])); ?></td>

                            </tr>
                                <?php }}?>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
    
</body>
</html>