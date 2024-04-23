<?php
    //Function to get the number of machines in every area
    function getMachineCountsByArea($conn, $id_area=null, $num_machines=null) {
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
    
    //Function to get the collaborators and return an array
    function getCollaborators($conn){
        $collaborators = array();
        $query = "SELECT * FROM collaborators";
        $stmt = $conn->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row=$result->fetch_assoc()) {
                $collaborators[] = $row;
            }
            $stmt->close();
        }else{
            throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
        }
        return $collaborators;
    }

    function getMachineData($conn, $machine_id){
        $machine_data = array();
        $query = "SELECT * FROM machines WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $machine_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtener los datos de la máquina
            $machine_data = $result->fetch_assoc();
        } else {
            // Mostrar un mensaje si no se encontró la máquina
            echo "No se encontró la máquina con el ID: " . $machine_id;
        }
        $stmt->close();
        return $machine_data;
    }

    
