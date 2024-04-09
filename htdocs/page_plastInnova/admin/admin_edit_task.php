<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");

    $task_id = $_GET['id-task'];
    $id_machine = $_GET['id-machine'];

    $query1 = "SELECT * FROM tasks WHERE id='$task_id'";
    $result1 = $conn->query($query1);
    $row1 = $result1->fetch_assoc();

    $state = $row1['state'];
    $id_collaborator = $row1['id_collaborator'];
    $description_task = $row1['description_task'];
    $job_description = $row1['job_description'];
    $creation_task = $row1['creation_task'];
    $finalization_task = $row1['finalization_task'];
    $assigned = $row1['assigned'];
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
                <label for="images_job">Subir Imágenes</label>
                <input type="file" class="form-control-file" id="images_job" name="images_job[]" multiple>
            </section>
            <button type="submit" class="btn btn-primary" name="submit">Guardar Cambios</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
        </form>
    </section>
</body>
</html>
