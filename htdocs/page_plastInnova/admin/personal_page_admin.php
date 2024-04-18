<?php
    include("../php/validation_sesion.php");
    include("../php/connect.php");

    $query1 = "SELECT COUNT(*) AS total_tasks_complete
                FROM tasks
                WHERE id_collaborator = " . $_SESSION['id'] . "
                AND `state` = 'completed';
                ";

    $data1 = $conn->query($query1);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal</title>
     <!-- Bootstrap CSS -->
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                        <li class="nav-item active">
                            <a class="nav-link" href="personal_page_admin.php">Mi cuenta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_areas.php">Máquinas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_collaborators.php">Colaboradores</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tareas
                            </a>
                            <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="tasks_admin_unassigned.php">Tareas sin asignar</a>
                                <a class="dropdown-item" href="tasks_admin.php">Tareas pendientes</a>
                                <a class="dropdown-item" href="tasks_completed_admin.php">Tareas completadas</a>
                                <a class="dropdown-item" href="../calendar_task.php">Calendario</a>
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
            <section class="col-md-3">
                <img src="<?php echo $_SESSION['profilePic'];?>" class="img-fluid" alt="Foto de perfil">
                <form action="../php/change_profile.php" method="POST" enctype="multipart/form-data">
                    <section class="form-group">
                        <label for="archivo">Seleccionar nueva foto:</label>
                        <input type="file" class="form-control-file" id="archivo" name="archivo" accept=".jpeg, .jpg, .png" required>
                    </section>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </form>
            </section>
            <section class="col-md-9">
                <h2><?php echo $_SESSION['job_title']?></h2><br>
                <h2><?php echo $_SESSION['name']." ". $_SESSION['surname']?></h2><br>
                <h3>Tareas completadas: <?php 
                    echo $total_tasks_complete = ($data1->num_rows > 0) ? $data1->fetch_assoc()['total_tasks_complete'] : 0;
                ?></h3>
            </section>
        </section>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>