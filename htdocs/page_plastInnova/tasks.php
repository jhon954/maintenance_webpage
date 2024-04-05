<?php
    include("php/connect.php");
    include("php/validation_sesion.php");
    $consulta = "SELECT * FROM tasks";
    $query1 = "SELECT * 
                FROM tasks T
                WHERE T.id_collaborator = '" . $_SESSION['id'] . "'
                ";
    $data1 = $conn->query($consulta);
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
        <nav class="menu">
            <ul>
                <li><a href="personal_page.php">Mi cuenta</a></li>
                <li><a href="tasks.php">Mis tareas</a></li>
                <li><a href="php/close_sesion.php">Cerrar Sesion</a></li>
            </ul>
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
                            <th class="text-center">Estado</th>
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
                                <td><?php echo $row2['marca'];?></td>
                                <td><?php echo $row2['model'];?></td>
                                <td><?php echo $row1['area'];?></td>
                                <td><?php echo $row1['description_task'];?></td>
                                <td><?php echo $row1['state'];?></td>
                                <td><?php echo $row1['creation_task'];?></td>
                                <td><a href="<?php echo "form_task_complete.php?id-task=".$row1['id']."&name-machine=".$row2['model']."&id-machine=".$row2['id']?>">Completar tarea</a></td>
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