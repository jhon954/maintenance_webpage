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

    function getMachineDataBYID($conn, $machine_id){
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

    function getActiveTasksBySessionID($conn, $session_id){
        $query = "SELECT * 
        FROM tasks T
        WHERE T.state='active' AND T.id_collaborator=$session_id
        ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    function getActiveTasksByDifferentSessionID($conn, $session_id){
        $query = "SELECT * 
        FROM tasks T
        WHERE T.state='active' AND T.id_collaborator!=$session_id
        ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    function getCompletedTasksBySessionID($conn, $session_id){
        $query = "SELECT * 
        FROM tasks T
        WHERE T.state='completed' AND T.id_collaborator=$session_id
        ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    function getCompletedTasksByDifferentSessionID($conn, $session_id){
        $query = "SELECT * 
        FROM tasks T
        WHERE T.state='completed' AND T.id_collaborator!=$session_id
        ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    function getUnassignedTasks($conn){
        $query = "SELECT * 
        FROM tasks T
        WHERE T.state='unassigned'
        ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }
    function getCollaboratorDataBYID($conn, $id_collaborator){
        $query = "SELECT * FROM collaborators WHERE id = $id_collaborator ";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $collaborator_data = array();
        if ($result->num_rows > 0) {
            // Obtener los datos de la máquina
            $collaborator_data = $result->fetch_assoc();
        } else {
            // Mostrar un mensaje si no se encontró la máquina
            echo "No se encontró el colaborador con el ID: " . $id_collaborator;
        }
        $stmt->close();
        return $collaborator_data;
    }

    