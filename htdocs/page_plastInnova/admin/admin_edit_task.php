<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");

    $task_id = $_GET['id-task'];
    $id_machine = $_GET['id-machine'];

    $query1 = "SELECT * FROM tasks WHERE id='$task_id'";
    $result1 = $conn->query($query1);
    $row1_edit_page = $result1->fetch_assoc();

    $state = $row1_edit_page['state'];
    $id_collaborator = $row1_edit_page['id_collaborator'];
    $description_task = $row1_edit_page['description_task'];
    $job_description = $row1_edit_page['job_description'];
    $creation_task = $row1_edit_page['creation_task'];
    $finalization_task = $row1_edit_page['finalization_task'];
    $assigned = $row1_edit_page['assigned'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
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
    <section class="container">
        <h1>Editar Tarea</h1>
        <form method="post" action="../php/edit_task.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $task_id; ?>">
            <input type="hidden" name="id_machine" value="<?php echo $id_machine; ?>">
            <section class="form-group">
                <label for="state">Estado:</label>
                <select class="form-control" id="state" name="state">
                    <option value="active" <?php if($state == 'active') echo 'selected'; ?>>Pendiente</option>
                    <option value="completed" <?php if($state == 'completed') echo 'selected'; ?>>Completada</option>
                </select>
            </section>
            <section class="form-group">
                <label for="id_collaborator">Colaborador:</label>
                <select class="form-control" id="id_collaborator" name="id_collaborator">
                    <?php
                    // Realizar la consulta para obtener los colaboradores
                    $query_collaborators = "SELECT id, name, surname FROM collaborators";
                    $result_collaborators = $conn->query($query_collaborators);

                    // Verificar si hay resultados y mostrar las opciones del select
                    if ($result_collaborators->num_rows > 0) {
                        while($row = $result_collaborators->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>" . $row["name"] ." ". $row["surname"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay colaboradores disponibles</option>";
                    }
                    ?>
                </select>
            </section>
            <section class="form-group">
                <label for="description_task">Descripción de la Tarea:</label>
                <textarea class="form-control" id="description_task" name="description_task"><?php echo $description_task; ?></textarea>
            </section>
            <section class="form-group">
                <label for="job_description">Descripción del Trabajo Completado:</label>
                <textarea class="form-control" id="job_description" name="job_description"><?php echo $job_description; ?></textarea>
            </section>
            <section class="form-group">
                <label for="assigned">Asignada:</label>
                <select class="form-control" id="assigned" name="assigned">
                    <option value="Yes" <?php if($assigned == 'Yes') echo 'selected'; ?>>Sí</option>
                    <option value="No" <?php if($assigned == 'No') echo 'selected'; ?>>No</option>
                </select>
            </section>
            <section class="form-group">
                <label for="creation_task">Fecha de Creación:</label>
                <input type="datetime-local" class="form-control" id="creation_task" name="creation_task" value="<?php echo date('Y-m-d\TH:i', strtotime($creation_task)); ?>">
            </section>
            <section class="form-group">
                <label for="finalization_task">Fecha de Finalización:</label>
                <input type="datetime-local" class="form-control" id="finalization_task" name="finalization_task" value="<?php echo date('Y-m-d\TH:i', strtotime($finalization_task)); ?>">
            </section>
            <section class="form-group">
                <label for="images_job">Subir Imágenes del Trabajo</label>
                <input type="file" class="form-control-file" id="images_job" name="images_job[]" multiple>
            </section>
            <section class="form-group">
                <label for="images_task">Subir Imágenes de la tarea</label>
                <input type="file" class="form-control-file" id="images_task" name="images_task[]" multiple>
            </section>
            <button type="submit" class="btn btn-primary" name="submit">Guardar Cambios</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
        </form>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>