<?php
    include ("../php/connect.php");
    include ("../php/validation_sesion.php");

    $areas=array();
    
    // Consulta para obtener el número de máquinas por área
    $query1 = "SELECT a.id AS id_area, COUNT(m.id) AS num_machines 
           FROM areas a 
           LEFT JOIN machines m ON a.id = m.id_area 
           GROUP BY a.id";


    // Ejecutar la consulta
    $result1 = $conn->query($query1);

    if ($result1->num_rows > 0) {
        // Recorrer los resultados y almacenar el número de máquinas por área en el array $areas
        while ($row1 = $result1->fetch_assoc()) {
            $areas[$row1['id_area']] = $row1['num_machines'];
        }
    } else {
        //echo "Error";
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Áreas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <h2 class="navbar-brand">Máquinas por área</h2>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <section class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="colab_personal_page.php">Mi cuenta</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="colab_areas.php">Máquinas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="colab_collaborators.php">Colaboradores</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tareas
                            </a>
                            <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="tasks_colab.php">Tareas pendientes</a>
                                <a class="dropdown-item" href="tasks_colab_completed.php">Tareas completadas</a>
                                <a class="dropdown-item" href="../everyone/calendar_tasks.php">Calendario</a>
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
            // Iterar sobre cada área y mostrarla en una columna
            foreach ($areas as $area=>$num_machines) {      
                // Mostrar el título del área y el número de máquinas
                echo '<section class="col-md-4">';
                echo '<section class="card mb-3">';
                echo '<section class="card-body">';
                echo '<h5 class="card-title">'.$area.'</h5>';
                echo '<p class="card-text">Máquinas: ' . $num_machines . '</p>';
                echo '<a href="colab_machines.php?area=' . urlencode($area) . '" class="btn btn-primary mr-2">Ver Máquinas</a>';

                echo '</section>';
                echo '</section>';
                echo '</section>';
            }
            ?>
        </section>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
