<?php
    //Function to get the number of machines in every area
    function getMachineCountsByArea($conn) {
    $areas = array();

    // Consulta SQL para obtener el número de máquinas por área
    $query = "SELECT a.id AS id_area, COUNT(m.id) AS num_machines 
              FROM areas a 
              LEFT JOIN machines m ON a.id = m.id_area 
              GROUP BY a.id";

    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        // Guardar el número de máquinas y el ID del área en un array
        $stmt->bind_result($id_area, $num_machines);
        while ($stmt->fetch()) {
            $areas[$id_area] = $num_machines;
        }
        $stmt->close();
    } else {
        throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
    }

    return $areas;
    }



