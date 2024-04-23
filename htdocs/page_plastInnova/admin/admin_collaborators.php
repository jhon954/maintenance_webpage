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
<?php 
include_once 'admin_nav_header.php';
// Name of the current page
$activePage = basename($_SERVER['PHP_SELF']);
renderNavbar($activePage);
?>
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
                    <?php
                        // Iterar sobre cada colaborador y mostrarlo en una fila de la tabla
                        foreach ($collaborators as $row) {
                            echo '<tr>';
                            echo '<td>';
                            if (!empty($row['profile-photo'])) {
                                echo '<img src="' . $row['profile-photo'] . '" alt="Foto de perfil" class="img-thumbnail" style="max-width: 120px; max-height: 120px;">';
                            } else {
                                echo 'Perfil sin foto';
                            }
                            echo '</td>';
                            echo '<td>' . $row['nickname'] . '</td>';
                            echo '<td>' . $row['job-title'] . '</td>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['surname'] . '</td>';
                            echo '<td>' . ($row['type-user'] == "admin" ? "Administrador" : "Colaborador") . '</td>';
                            echo '<td>' . ($row['state'] == "active" ? "Activo" : "Inactivo") . '</td>';
                            echo '<td>
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-id="' . $row['id'] . '">Editar</a>
                            </td>';
                            echo '</tr>';
                        }
                        ?>
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
    <?php 
        $modals_html = generateCollaboratosModalHTML();
        echo $modals_html['modal_add_collaborator'];
        echo $modals_html['modal_edit_collaborator'];
    ?>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que abrió el modal
            var recipient = button.data('id'); // Extraer la información del atributo data-id del botón
            var modal = $(this);
            modal.find('.modal-body #editId').val(recipient); // Asignar el valor del ID del colaborador al campo de entrada oculto
        });
    </script>
</body>
</html>
