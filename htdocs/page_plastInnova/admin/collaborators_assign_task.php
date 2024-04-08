<?php
    include("../php/connect.php");

    $id_task=$_GET['id-task'];

    $query = "SELECT * FROM collaborators";
    $data = $conn->query($query);
    $collaborators = array();
    while ($row = $data->fetch_assoc()) {
        $collaborators[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colaboradores</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    <section class="container mt-5">
        <section class="row">
            <?php
                foreach ($collaborators as $colaborator) {
                    $name = $colaborator['name'];
                    $id_colab=$colaborator['id'];
                    $job_title=$colaborator['job-title'];
                    $photo = $colaborator['profile-photo']; 

            ?>
            <section class="col-md-4">
                <section class="card mb-4" style="display: flex; justify-content: center;">
                    <img src="<?php echo $photo; ?>" class="card-img-top" alt="Foto de <?php echo $nombre; ?>" style="max-height: 150px; max-width: 200px; align-self: center">
                    <section class="card-body">
                        <h5 class="card-title"><?php echo $job_title; ?></h5>
                        <h5 class="card-title"><?php echo $name; ?></h5>
                        <a href="<?php echo "../php/assign_task.php?id-task=".$id_task."&id-colab=".$id_colab?>" class="btn btn-primary btn-block">Asignar Tarea</a>
                    </section>
                </section>
            </section>
            <?php
                }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
