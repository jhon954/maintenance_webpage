<?php
    include("../php/connect.php");
    include("../php/validation_sesion.php");
    include("functions.php");

    $id_machine = mysqli_real_escape_string($conn, $_GET['machine']);
    $area_id = mysqli_real_escape_string($conn, $_GET['area']);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Mantenimiento</title>
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
    <?php 
    include_once 'admin_nav_header.php';
    // Name of the current page
    $activePage = basename($_SERVER['PHP_SELF']);
    renderNavbar($activePage);
    ?>
    <section id='calendar'></section>
    <?php 
        $modals_html = generateCreateTaskModalHTML($id_machine, $area_id);
        echo $modals_html['modal_create_task'];
    ?>
    <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
</body>
</html>
