<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");


    $id_task=$_GET['id-task'];
    $collaborators = getCollaborators($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colaboradores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<?php 
include_once 'admin_nav_header.php';
// Name of the current page
$activePage = basename($_SERVER['PHP_SELF']);
renderNavbar($activePage);
?>
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
        </section>
    </section>
    <section class="container mt-5">
        <a href="javascript:history.back()" class="btn btn-primary btn-block mt-3">Volver</a>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
