<?php
    include("../php/connect.php");

    $id_machine = $_GET['machine'];
    $area_id = $_GET['area'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Mantenimiento</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <h2 class="navbar-brand">Crear tarea</h2>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <section class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="personal_page_admin.php">Mi cuenta</a>
                        </li>
                        <li class="nav-item active">
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
        <section class="row justify-content-center">
            <section class="col-md-6">
                <section class="card">
                    <section class="card-header">
                        <h3 class="text-center">Solicitud de Mantenimiento</h3>
                    </section>
                    <section class="card-body">
                        <form action="../php/create_task.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_machine" value="<?php echo $id_machine; ?>">
                            <input type="hidden" name="area" value="<?php echo $area_id; ?>">
                            <section class="form-group">
                                <label for="description">Descripción del Problema:</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                            </section>
                            <section class="form-group">
                                <label for="priority">Prioridad:</label>
                                <select class="form-control" id="priority" name="priority" required>
                                    <option value="high">Alta</option>
                                    <option value="medium">Media</option>
                                    <option value="low" selected>Baja</option>
                                </select>
                            </section>
                            <section class="form-group">
                                <label for="images_task">Imágenes:</label>
                                <input type="file" class="form-control-file" id="images_task" name="images_task[]" accept="image/*" multiple>
                            </section>
                            <button type="submit" class="btn btn-primary btn-block">Enviar Solicitud</button>
                            <a href="javascript:history.back()" class="btn btn-secondary btn-block">Volver Atrás</a>
                        </form>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>
