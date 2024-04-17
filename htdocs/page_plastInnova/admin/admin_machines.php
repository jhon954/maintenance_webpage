<?php

    include("../php/connect.php");
    include("../php/validation_sesion.php");

    $area = $_GET['area'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Máquinas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h2 class="navbar-brand">Máquinas en <?php echo $area;?></h2>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <section class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="personal_page_admin.php">Mi cuenta</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="admin_areas.php">Máquinas</a>
                    </li>
                    <li class="nav-item">
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
        <section class="row">
            <?php
            // Consulta para obtener las máquinas en el área especificada
            $query = "SELECT * FROM machines WHERE id_area = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $area);
            $stmt->execute();
            $result = $stmt->get_result();

            // Iterar sobre cada máquina y mostrarla en una tarjeta en una columna
            while ($row = $result->fetch_assoc()) {
                echo '<section class="col-md-4">';
                echo '<section class="card mb-3">';
                echo '<section class="card-body">';
                echo '<h5 class="card-title">' . $row['brand'] . ' - ' . $row['model'] .'</h5>';
                echo '<p class="card-text">Número de máquina: ' . $row['machine_number'] . '</p>';
                echo '<p class="card-text">Estado: ' . (($row['state']=='active')?'Activo':'Inactivo') . '</p>';
                echo '<a href="admin_description_machine.php?area=' . urlencode($area) . '&machine='.urlencode($row['id']).'" class="btn btn-primary">Descripción</a>';
                echo '</section>';
                echo '</section>';
                echo '</section>';
            }

            // Cerrar la conexión y liberar recursos
            $stmt->close();
            $conn->close();
            ?>
        </section>
        <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
