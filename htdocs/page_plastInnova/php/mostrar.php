<?php
include("connect.php");

// Consulta para obtener las tareas
$sql = "SELECT description_task, date_task, finalization_task FROM tasks";
$result = $conn->query($sql);

// Arreglo para almacenar los eventos
$events = array();

// Generar eventos para cada tarea
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $event = array(
            "title" => $row["description_task"],
            "start" => $row["date_task"],
            "end" => $row["finalization_task"]
        );
        array_push($events, $event);
    }
}

//$conn->close();

// Convertir el arreglo de eventos a JSON
$jsonEvents = json_encode($events);

echo $jsonEvents;
?>
