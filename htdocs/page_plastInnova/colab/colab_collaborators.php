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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <!-- Bootstrap JS -->
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Colaboradores</h2>
            <?php 
            include_once 'colab_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead class="thead-dark">
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
                                    <img src="<?php echo !empty($collaborator['profile-photo']) ? $collaborator['profile-photo']:'Perfil sin foto'?>" alt="Foto de perfil" class="img-thumbnail" style="max-width: 120px; max-height: 120px;">
                                </td>
                                <td><?php echo $collaborator['job-title']?></td>
                                <td><?php echo $collaborator['name']?></td>
                                <td><?php echo $collaborator['surname']?></td>
                                <td><?php echo ($collaborator['type-user']=='admin'?'Administrador':'Colaborador')?></td>
                                <td><?php echo ($collaborator['state']=='active')?'Activo':(($collaborator['state']=='inactive')?'Inactivo':'Retirado')?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
