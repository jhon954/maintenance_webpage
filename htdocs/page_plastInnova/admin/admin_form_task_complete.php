<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    $id_task = mysqli_real_escape_string($conn, $_GET['id-task']);
    $id_machine = mysqli_real_escape_string($conn, $_GET['id-machine']);
    $brand_machine = mysqli_real_escape_string($conn, $_GET['brand-machine']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Tarea</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<section class="container mt-5">
    <section class="row justify-content-center">
        <section class="col-md-8">
            <section class="card">
                <section class="card-header">
                    <h3 class="text-center">Completar Tarea</h3>
                </section>
                <section class="card-body">
                    <form action="<?php echo "../php/process_task_complete.php?id-task=".$id_task."&brand-machine=".$brand_machine."&id-machine=".$id_machine?>" method="POST" enctype="multipart/form-data">
                        <section class="form-group">
                        <label for="result_task">Tipo de mantenimiento:</label>
                        <select class="form-control" id="result_task" name="result_task" required>
                            <option value="" disabled selected>Seleccione un resultado de la tarea</option>
                            <option value="adjustment">Ajuste</option>
                            <option value="repair">Reparación</option>
                            <option value="start-up">Puesta en servicio</option>
                            <option value="out-of-service">Fuera de servicio</option>
                        </select>
                        </section>
                        <section class="form-group">
                        <label for="description_job">Descripción del trabajo realizado</label>
                        <textarea class="form-control" id="description_job" name="description_job" rows="4" required></textarea>
                        </section>
                        <section class="form-group">
                            <label for="images_job">Subir Imágenes</label>
                            <input type="file" class="form-control-file" id="images_job" name="images_job[]" accept="image/*" multiple>
                        </section>
                        <section class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Completar Tarea</button>
                        </section>
                        <a href="<?php echo 'tasks_admin.php'; ?>" class="btn btn-secondary btn-block">Volver</a>
                    </form>
                </section>
            </section>
        </section>
    </section>
</section>
</body>
</html>
