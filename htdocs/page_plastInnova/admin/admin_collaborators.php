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
            <section class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="personal_page_admin.php">Mi cuenta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_areas.php">Máquinas</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="admin_collaborators.php">Colaboradores</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tareas
                        </a>
                        <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="tasks_admin_unassigned.php">Tareas sin asignar</a>
                            <a class="dropdown-item" href="tasks_admin.php">Tareas pendientes</a>
                            <a class="dropdown-item" href="tasks_completed_admin.php">Tareas completadas</a>
                            <a class="dropdown-item" href="../calendar_task.php">Calendario</a>
                        </section>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/close_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </section>
        </nav>
    </header>
    <section class="container">
        <table class="table">
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
                    echo '<td><img src="' . $row['profile-photo'] . '" alt="Foto de perfil" style="width: 120px;"></td>';
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
    </section>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
