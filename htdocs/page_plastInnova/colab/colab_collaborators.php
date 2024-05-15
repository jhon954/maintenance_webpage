<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    $collaborators = getCollaborators($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Colaboradores</title>
    <!-- styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles_nav_bar.css" rel="stylesheet">
    <link href="../css/styles_collaborators_page.css" rel="stylesheet"> 
    <!-- Bootstrap JS -->
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
            include_once 'colab_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section class="container mt-4">
        <section class="row">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <section class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-dark">
                            <tr>
                                <th scope="col">Foto</th>
                                <th scope="col">Título</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($collaborators as $collaborator): ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo !empty($collaborator['profile-photo']) ? $collaborator['profile-photo']:'../img/images_page/default_profile.jpeg'?>" alt="Foto de perfil" class="img-thumbnail" style="max-width: 120px; max-height: 120px;">
                                    </td>
                                    <td class="td1"><?php echo $collaborator['job-title']?></td>
                                    <td class="td1"><?php echo $collaborator['name']?></td>
                                    <td class="td1"><?php echo $collaborator['surname']?></td>
                                    <td class="td1"><?php echo ($collaborator['type-user']=='admin'?'Administrador':'Colaborador')?></td>
                                    <td class="td1"><?php echo ($collaborator['state']=='active')?'Activo':(($collaborator['state']=='inactive')?'Inactivo':'Retirado')?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
</body>
</html>
