<?php
    function getMachineCountsByArea($conn, $id_area=null,$area_name=null, $num_machines=null) {
    $areas = array();

    // Consulta SQL para obtener el número de máquinas por área
    $query = "SELECT a.id AS id_area, a.area_name AS area_name, 
                COUNT(m.id) AS num_machines 
                FROM areas a 
                LEFT JOIN machines m ON a.id = m.id_area 
                GROUP BY a.id";


    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        // Guardar el número de máquinas y el ID del área en un array
        $stmt->bind_result($id_area, $area_name, $num_machines);
        while ($stmt->fetch()) {
            $areas[$id_area] = $num_machines;
        }
        $stmt->close();
    } else {
        throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
    }

    return $areas;
    }
    function getAreasByID($conn, $id_area){
        $areas = array();
        $query = "SELECT area_name FROM areas WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_area);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtener los datos de la máquina
            $areas = $result->fetch_assoc();
        } else {
            // Mostrar un mensaje si no se encontró la máquina
            echo "No se encontró la máquina con el ID: " . $id_area;
        }
        $stmt->close();
        return $areas;
    }
    function getCollaborators($conn){
        $collaborators = array();
        $query = "SELECT * FROM collaborators 
                    WHERE nickname != 'admin'";
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
        $query = " SELECT t.*, m.brand, m.model, c.name, c.surname, a.area_name FROM tasks AS t
                    JOIN machines AS m ON t.id_machine = m.id 
                    JOIN collaborators AS c ON t.id_collaborator = c.id
                    JOIN areas AS a ON m.id_area = a.id
                    WHERE t.state='active' AND t.id_collaborator = ?
                    ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $session_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }
    function getActiveTasksByDifferentSessionID($conn, $session_id){
        $query = " SELECT t.*, m.brand, m.model, c.name, c.surname, c.nickname, a.area_name FROM tasks AS t
                    JOIN machines AS m ON t.id_machine = m.id 
                    JOIN collaborators AS c ON t.id_collaborator = c.id
                    JOIN areas AS a ON m.id_area = a.id
                    WHERE t.state='active' AND t.id_collaborator != ? AND c.nickname!= 'admin'
                    ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $session_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }
    function getCompletedTasksBySessionID($conn, $session_id){
        // $query = "SELECT * 
        // FROM tasks T
        // WHERE T.state='completed' AND T.id_collaborator=?
        // ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
        $query = " SELECT t.*, m.brand, m.model, c.name, c.surname, a.area_name FROM tasks AS t
        JOIN machines AS m ON t.id_machine = m.id 
        JOIN collaborators AS c ON t.id_collaborator = c.id
        JOIN areas AS a ON t.id_collaborator = a.id
        WHERE t.state='completed' AND t.id_collaborator = ?
        ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $session_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }
    function getCompletedTasksByDifferentSessionID($conn, $session_id){
        $query = " SELECT t.*, m.brand, m.model, c.name, c.surname, c.nickname, a.area_name FROM tasks AS t
        JOIN machines AS m ON t.id_machine = m.id 
        JOIN collaborators AS c ON t.id_collaborator = c.id
        JOIN areas AS a ON t.id_area = a.id
        WHERE t.state='completed' AND t.id_collaborator !=? AND c.nickname != 'admin'
        ORDER BY FIELD(T.priority, 'high', 'medium', 'low')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $session_id);
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
        $query = "SELECT * FROM collaborators WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $id_collaborator);
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
    function getTaskByID($conn, $id_task){
        $query = "SELECT * FROM tasks WHERE id=$id_task";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $task = array();
        if ($result->num_rows > 0) {
            // Obtener los datos de la máquina
            $task = $result->fetch_assoc();
        } else {
            // Mostrar un mensaje si no se encontró la máquina
            echo "No se encontró la tarea con el ID: " . $id_task;
        }
        $stmt->close();
        return $task;
    }
    function getMachinesByArea($conn,$id_area){
        $query = "SELECT * FROM machines WHERE id_area = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $id_area);
        $stmt->execute();
        $result = $stmt->get_result();
        $machines=array();
        if($result->num_rows>0){
            while ($row = $result->fetch_assoc()) {
                $machines[] = $row;
            }
        }else{
        }
        $stmt->close();
        return $machines;
    }
    function getTaskJoinColabMachineByID($conn, $id_task){
        $query = "SELECT 
            tasks.*, 
            collaborators.name AS collaborator_name, 
            collaborators.surname AS collaborator_surname, 
            machines.brand AS machine_brand, 
            machines.model AS machine_model 
        FROM 
            tasks 
        JOIN 
            collaborators ON tasks.id_collaborator = collaborators.id 
        JOIN 
            machines ON tasks.id_machine = machines.id 
        WHERE 
            tasks.id = ?";
        $stmt = $conn->prepare($query);
        $stmt ->bind_param("s", $id_task);
        $stmt->execute();
        $result = $stmt->get_result();
        $task = array();
        if($result->num_rows>0){
            $task = $result->fetch_assoc();
        }else{
            echo "No se encontraron maquinas en el area: ".$id_task;
        }
        $stmt->close();
        return $task;
    }
    function getMaintenanceHistory($conn, $id_machine){
        $query = "SELECT id,finalization_task, id_collaborator, result_task 
                FROM tasks 
                WHERE id_machine = ? AND state='completed'";
        $stmt = $conn->prepare($query);
        $stmt ->bind_param("i", $id_machine);
        $stmt->execute();
        $result = $stmt->get_result();
        $history = array();
        if($result->num_rows>0){
            while ($row = $result->fetch_assoc()) {
                $history[] = $row;
            }
        }else{
        }
        $stmt->close();
        return $history;
    }