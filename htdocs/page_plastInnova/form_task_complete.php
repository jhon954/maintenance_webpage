<?php
    include("php/connect.php");
    include("php/validation_sesion.php");
    $id_task = $_GET['id-task'];
    $id_machine = $_GET['id-machine'];
    $name_machine = $_GET['name-machine'];

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
                    <form action="<?php echo "php/process_task_complete.php?id-task=".$id_task."&name-machine=".$name_machine."&id-machine=".$id_machine?>" method="POST" enctype="multipart/form-data">
                        <section class="form-group">
                            <label for="description_job">Descripción del trabajo realizado</label>
                            <textarea class="form-control" id="description_job" name="description_job" rows="4" required></textarea>
                        </section>
                        <section class="form-group">
                            <label for="images_job">Subir Imágenes</label>
                            <input type="file" class="form-control-file" id="images_job" name="images_job[]" multiple>
                        </section>
                        <section class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Completar Tarea</button>
                        </section>
                    </form>
                </section>
            </section>
        </section>
    </section>
</section>
</body>
</html>
