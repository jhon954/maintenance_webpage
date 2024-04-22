<?php
include ("../php/connect.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Tareas</title>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.2/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            editable: true,
            selectable: true,
            allDaySlot: false,
            events: '../php/show_data_calendar.php',
            
        });
        calendar.render();
        });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand {
            color: #ffffff;
            font-weight: bold;
        }
        .btn-secondary {
            margin-top: 10px;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        #calendar {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .modal-header {
            background-color: #007bff;
            color: #ffffff;
            border-bottom: none;
        }
        .modal-title {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <h2 class="navbar-brand">Calendario de tareas</h2>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <section class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="colab_personal_page.php">Mi cuenta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="colab_areas.php">Máquinas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="colab_collaborators.php">Colaboradores</a>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tareas
                            </a>
                            <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="tasks_colab.php">Tareas pendientes</a>
                                <a class="dropdown-item" href="tasks_colab_completed.php">Tareas completadas</a>
                                <a class="dropdown-item" href="colab_calendar.php">Calendario</a>
                            </section>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../php/close_sesion.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </section>
            </nav>
    </header>
    <div id='calendar'></div>
    </div>
    <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
    
</body>
</html>
