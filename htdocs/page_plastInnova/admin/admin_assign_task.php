<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    $id_task=mysqli_real_escape_string($conn, $_GET['id-task']);
    $collaborators = getActiveCollaborators($conn);
    $previous_url = $_SERVER['HTTP_REFERER'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar tarea</title>
    <!-- styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->
    <link href="../css/styles_nav_bar.css" rel="stylesheet">
    <link href="../css/styles_assign_task.css" rel="stylesheet">
    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <section class="logo-container">
                <img src="../img/images_page/login.png" alt="Logo" class="logo">
            </section>
            <?php 
            include_once 'admin_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section class="container mt-5">
        <section class="row">
            <?php foreach ($collaborators as $colaborator):?>
            <section class="col-md-4">
                <section class="card mb-4">
                    <img src="<?php echo !empty($colaborator['profile-photo'])?$colaborator['profile-photo']:'../img/images_page/default_profile.jpeg'; ?>" class="card-img-top" alt="Foto de <?php echo $colaborator['name']; ?>">
                    <section class="card-body">
                        <h5 class="card-title text-center font-weight-bold border-bottom pb-2"><?php echo $colaborator['job-title']; ?></h5>
                        <h5 class="card-title text-center border-bottom pb-2"><?php echo $colaborator['name'].' '.$colaborator['surname']; ?></h5>
                        <a href="<?php echo "../php/assign_task.php?id-task=".$id_task."&id-colab=".$colaborator['id']."&url-b=".$previous_url?>" class="btn btn-block ba">Asignar Tarea</a>
                    </section>
                </section>
            </section>
            <?php endforeach ?>
        </section>
    </section>
    <section class="container mt-5">
        <a href="javascript:history.back()" class="btn btn-secondary btn-block mt-3 rounded-lg">Volver</a>
    </section>
</body>
</html>
