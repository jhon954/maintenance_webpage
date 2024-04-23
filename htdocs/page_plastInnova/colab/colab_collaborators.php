<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Colaboradores</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Colaboradores</h2>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="colab_personal_page.php">Mi cuenta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="colab_areas.php">Máquinas</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="colab_collaborators.php">Colaboradores</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tareas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="tasks_colab.php">Tareas pendientes</a>
                            <a class="dropdown-item" href="tasks_colab_completed.php">Tareas completadas</a>
                            <a class="dropdown-item" href="../everyone/calendar_tasks.php">Calendario</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/close_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
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
                        <?php
                        // Consulta para obtener los colaboradores
                        $query = "SELECT * FROM collaborators";
                        $result = $conn->query($query);

                        // Iterar sobre cada colaborador y mostrarlo en una fila de la tabla
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>';
                            if (!empty($row['profile-photo'])) {
                                echo '<img src="' . $row['profile-photo'] . '" alt="Foto de perfil" class="img-thumbnail" style="max-width: 120px; max-height: 120px;">';
                            } else {
                                echo 'Perfil sin foto';
                            }
                            echo '</td>';
                            echo '<td>' . $row['job-title'] . '</td>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['surname'] . '</td>';
                            echo '<td>' . ($row['type-user']=="admin"?"Administrador":"Colaborador") . '</td>';
                            echo '<td>' . ($row['state']=="active"?"Activo":"Inactivo") . '</td>';
                            echo '</tr>';
                        }

                        // Liberar recursos
                        $result->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Script para establecer el valor del ID del colaborador en el campo de entrada oculto cuando se abre el modal -->
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
