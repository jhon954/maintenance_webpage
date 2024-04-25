<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");

    $task_id = mysqli_real_escape_string($conn, $_GET['id-task']);
    $id_machine = mysqli_real_escape_string($conn, $_GET['id-machine']);
    $task_data = getTaskByID($conn, $task_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Editar tarea</h2>
            <?php 
            include_once 'admin_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
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
                    <option value="unassigned" <?php if($task_data['state'] == 'unassigned') echo 'selected'; ?>>Sin asignar</option>
                    <option value="active" <?php if($task_data['state'] == 'active') echo 'selected'; ?>>Asignada y Pendiente</option>
                    <option value="completed" <?php if($task_data['state'] == 'completed') echo 'selected'; ?>>Completada</option>
                </select>
            </section>
            <section class="form-group">
                <label for="id_collaborator">Colaborador:</label>
                <select class="form-control" id="id_collaborator" name="id_collaborator">
                    <?php
                    $collaborators = getCollaborators($conn);
                    if (!empty($collaborators)) {
                        foreach($collaborators as $collaborator) {
                            echo "<option value='" . $collaborator["id"] . "'>" . $collaborator["name"] ." ". $collaborator["surname"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay colaboradores disponibles</option>";
                    }
                    ?>
                </select>
            </section>
            <section class="form-group">
                <label for="maintenance_type">Tipo de mantenimiento:</label>
                <select class="form-control" id="maintenance_type" name="maintenance_type">
                    <option value="preventive" <?php if($task_data['maintenance_type'] == 'preventive') echo 'selected'; ?>>Preventivo</option>
                    <option value="corrective" <?php if($task_data['maintenance_type'] == 'corrective') echo 'selected'; ?>>Correctivo</option>
                    <option value="completed" <?php if($task_data['maintenance_type'] == 'calibration') echo 'selected'; ?>>Calibración</option>
                    <option value="completed" <?php if($task_data['maintenance_type'] == 'other') echo 'selected'; ?>>Otro</option>
                </select>
            </section>
            <section class="form-group">
                <label for="description_task">Descripción de la Tarea:</label>
                <textarea class="form-control" id="description_task" name="description_task"><?php echo $task_data['description_task']; ?></textarea>
            </section>
            <section class="form-group">
                <label for="job_description">Descripción del Trabajo Completado:</label>
                <textarea class="form-control" id="job_description" name="job_description"><?php echo $task_data['job_description']; ?></textarea>
            </section>
            <section class="form-group">
                <label for="creation_task">Fecha de Creación:</label>
                <input type="datetime-local" class="form-control" id="creation_task" name="creation_task" value="<?php echo date('Y-m-d\TH:i', strtotime($task_data['creation_task'])); ?>">
            </section>
            <section class="form-group">
                <label for="date_task">Fecha Programada:</label>
                <input type="date" class="form-control" id="date_task" name="date_task" value="<?php echo date('Y-m-d', strtotime($task_data['date_task'])); ?>">
            </section>
            <section class="form-group">
                <label for="finalization_task">Fecha de Finalización:</label>
                <input type="datetime-local" class="form-control" id="finalization_task" name="finalization_task" value="<?php echo $task_data['finalization_task']; ?>">
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
</body>
</html>