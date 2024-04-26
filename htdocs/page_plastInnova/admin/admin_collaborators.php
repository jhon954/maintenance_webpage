<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("../php/queries.php");
    include("functions.php");
    $collaborators= getCollaborators($conn);
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
            include_once 'admin_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section class="container mt-4">
        <section class="row">
            <section class="col-md-12">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Foto</th>
                            <th scope="col">Nickname</th>
                            <th scope="col">Título</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($collaborators as $collaborator): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo !empty($collaborator['profile-photo']) ? $collaborator['profile-photo']:'Perfil sin foto'?>" alt="Foto de perfil" class="img-thumbnail" style="max-width: 120px; max-height: 120px;">
                                </td>
                                <td><?php echo $collaborator['nickname']?></td>
                                <td><?php echo $collaborator['job-title']?></td>
                                <td><?php echo $collaborator['name']?></td>
                                <td><?php echo $collaborator['surname']?></td>
                                <td><?php echo ($collaborator['type-user']=='admin'?'Administrador':'Colaborador')?></td>
                                <td><?php echo ($collaborator['state']=='active')?'Activo':(($collaborator['state']=='inactive')?'Inactivo':'Retirado')?></td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm" 
                                    data-toggle="modal" 
                                    data-target="#editModal" 
                                    data-id="<?php echo $collaborator['id']?>" 
                                    data-name="<?php echo $collaborator['name']?>" 
                                    data-surname="<?php echo $collaborator['surname']?>" 
                                    data-title="<?php echo $collaborator['job-title']?>" 
                                    data-state="<?php echo $collaborator['state']?>">
                                    Editar datos
                                    </a>
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editPasswordModal" data-id="<?php echo $collaborator['id']?>">Editar contraseña</a>
                                </td>
                            </tr>  
                        <?php 
                        $modals_html = generateCollaboratosModalHTML();
                        echo $modals_html['modal_add_collaborator'];
                        echo $modals_html['modal_edit_collaborator'];
                        echo $modals_html['modal_edit_password_collaborator'];
                        endforeach?>
                    </tbody>
                </table>
            </section>
        </section>
        <section class="row mt-4">
            <section class="col-md-12">
                <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Agregar Colaborador</button>
            </section>
        </section>
    </section>
    <script>
    $('#editModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that activated the modal
    var id = button.data('id'); // Collaborator ID obtained from the data-id attribute of the button
    var name = button.data('name'); // Collaborator name obtained from the data-name attribute of the button
    var surname = button.data('surname'); // Collaborator surname obtained from the data-surname attribute of the button
    var title = button.data('title'); // Collaborator title obtained from the data-title attribute of the button
    var state = button.data('state'); // Collaborator status obtained from the data-status attribute of the button
    var modal = $(this);
    // Update the value of the hidden field with the collaborator's ID
    modal.find('#id_collaborator').val(id);
    // Update other fields with collaborator information
    modal.find('#name').val(name);
    modal.find('#surname').val(surname);
    modal.find('#job_title').val(title);
    modal.find('#state').val(state);
    });
    $('#editPasswordModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button to activate the modal
        var id = button.data('id'); // Collaborator ID from data-id atribiute
        var modal = $(this);
        modal.find('#id_collaborator_password').val(id); // Update the field ID
    });
    </script>
</body>
</html>
