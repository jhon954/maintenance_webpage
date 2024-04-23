<?php
    include("../php/connect.php");

    $id_machine = $_GET['machine'];
    $area_id = $_GET['area'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Mantenimiento</title>
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
            editable: false,
            selectable: true,
            allDaySlot: false,
            events: '../php/show_data_calendar.php',
            dateClick: function(info) {
            var a = info.dateStr;
            const fechaComoCadena = a;
            var numeroDia = new Date(fechaComoCadena).getDay();
            if (numeroDia == 6) {
                alert('No hay');
            } else {
                $('#maintenance_form #maintenance_date').val(fechaComoCadena);
                $('#modal_reservas').modal("show");
            }
            }
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
                <h2 class="navbar-brand">Crear tarea</h2>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <section class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="admin_personal_page.php">Mi cuenta</a>
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
    <div id='calendar'></div>
    <!-- Modal -->
    <div class="modal fade" id="modal_reservas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Programar mantenimiento</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <!-- Aquí irá el formulario -->
            <form id="maintenance_form" action="../php/create_task.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_machine" value="<?php echo $id_machine; ?>">
                <input type="hidden" name="area" value="<?php echo $area_id; ?>">
                <div class="form-group">
                <label for="maintenance_date">Fecha de Mantenimiento:</label>
                <input type="text" class="form-control" id="maintenance_date" name="maintenance_date" required readonly>
                </div>
                <div class="form-group">
                <label for="maintenance_type">Tipo de mantenimiento:</label>
                <select class="form-control" id="maintenance_type" name="maintenance_type" required>
                    <option value="" disabled selected>Seleccione tipo de mantenimiento</option>
                    <option value="preventive">Preventivo</option>
                    <option value="corrective">Correctivo</option>
                    <option value="calibration">Calibración</option>
                    <option value="other">Otro</option>
                </select>
                </div>
                <div class="form-group">
                <label for="description">Descripción del Problema:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                <label for="priority">Prioridad:</label>
                <select class="form-control" id="priority" name="priority" required>
                    <option value="high">Alta</option>
                    <option value="medium">Media</option>
                    <option value="low" selected>Baja</option>
                </select>
                </div>
                <div class="form-group">
                <label for="images_task">Imágenes:</label>
                <input type="file" class="form-control-file" id="images_task" name="images_task[]" accept="image/*" multiple>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Enviar Solicitud</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
    
</body>
</html>
