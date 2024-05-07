<?php
include("connect.php");
$maintenanceTitles = array(
    "preventive" => "Preventivo",
    "corrective" => "Correctivo",
    "calibration" => "Calibración",
    "other" => "Otro"
);
// Consulta para obtener las tareas
$sql = "SELECT state, maintenance_type, date_task, finalization_task FROM tasks";
$result = $conn->query($sql);

// Arreglo para almacenar los eventos
$events = array();

// Generar eventos para cada tarea
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $color = ($row["state"] == "active") ? "#81c9fa" : (($row["state"] == "unassigned") ? "#ff6c3e" : "#5ccb5f");
        $title = isset($maintenanceTitles[$row["maintenance_type"]]) ? $maintenanceTitles[$row["maintenance_type"]] : "Otro";    
        $event = array(
            "title" => $title,
            "start" => $row["date_task"],
            "end" => date("Y-m-d", strtotime($row["finalization_task"])),
            'backgroundColor' => $color,
            'textColor' => '#000000',
            'className' => 'centered-event'
        );
        array_push($events, $event);
        // echo $title;
    }
}

// Convertir el arreglo de eventos a JSON
$jsonEvents = json_encode($events);

echo $jsonEvents;
exit();
