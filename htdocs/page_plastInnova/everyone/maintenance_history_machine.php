<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    $id_machine =mysqli_real_escape_string($conn, $_GET['machine']);
    $history_data = getMaintenanceHistory($conn, $id_machine);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Mantenimiento</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Historial de mantenimiento</h2>
            <?php 
            include_once 'everyone_nav_header.php';
            renderNavbar($_SESSION['type_user']);
            ?>
        </nav>
    </header>
    <section class="container mt-4">
        <section class="row">
            <section class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>   
                            <th>Fecha y hora de finalización</th>
                            <th>Colaborador responsable</th>
                            <th>Descripción del trabajo realizado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($history_data as $data):
                            $collaborator = getCollaboratorDataBYID($conn, $data['id_collaborator']);
                        ?>
                        <tr>
                            <td><?php echo $data['finalization_task'];?></td>
                            <td><?php echo $collaborator['name']." ".$row2['surname'];?></td>
                            <td><?php echo $data['job_description'];?></td>
                            <td>
                                <a href="<?php echo "description_job_task.php?id-task=".$data['id']?>">Revisar</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
            </section>
        </section>
    </section>
</body>
</html>