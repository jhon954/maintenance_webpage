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
                        <li class="nav-item active">
                            <a class="nav-link" href="tasks_admin_unassigned.php">Tareas sin asignar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tasks_admin.php">Tareas pendientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tasks_completed_admin.php">Tareas completadas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../php/close_sesion.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </section>
            </nav>
    </header>
    <div class="container mt-5">
        <div class="row">
            <?php
                // Aquí deberías obtener los colaboradores de la base de datos
                // Supongamos que $colaboradores es un array con los datos de los colaboradores
                foreach ($collaborators as $colaborador) {
                    // Aquí obtienes la información de cada colaborador, como su nombre y foto
                    $nombre = $colaborador['name'];
                    $id_colab=$colaborador['id'];
                    #$foto = $colaborador['foto']; // Supongamos que es una URL a la foto

                    // Ahora creamos una tarjeta para cada colaborador
            ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<?php echo $foto; ?>" class="card-img-top" alt="Foto de <?php echo $nombre; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $nombre; ?></h5>
                        <!-- Agrega un botón "Asignar Tarea" -->
                        <a href="<?php echo "../php/assign_task.php?id-task=".$id_task."&id-colab=".$id_colab?>" class="btn btn-primary btn-block">Asignar Tarea</a>
                    </div>
                </div>
            </div>
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
