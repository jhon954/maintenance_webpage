<?php
include("connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_machine'], $_POST['area'], 
    $_POST['maintenance_date'], $_POST['maintenance_type'], $_POST['description'], 
    $_POST['priority'])) {
    // Retrieve POST data and sanitize
    $id_machine = htmlspecialchars($_POST['id_machine']);
    $area_request = htmlspecialchars($_POST['area']);
    $maintenance_date = htmlspecialchars($_POST['maintenance_date']);
    $maintenance_type = htmlspecialchars($_POST['maintenance_type']);
    $description_request = htmlspecialchars($_POST['description']);
    $priority = htmlspecialchars($_POST['priority']);
    $state = "unassigned";
    // Temporary collaborator ID (replace with logic to obtain collaborator ID)
    $id_collaborator = 1;

    // Get current date and time
    date_default_timezone_set('America/Bogota');
    $current_date_time = date("Y-m-d H:i:s");

    // Initialize images array
    $images = array();
    // Prepare and execute query to get brand of machine
    $query1 = "SELECT brand FROM machines WHERE id=?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("i", $id_machine);
    $stmt1->execute();
    $stmt1->bind_result($brand_machine);
    $stmt1->fetch();
    $stmt1->close();

    // Prepare and execute query to insert task into the database
    $query2 = "INSERT INTO tasks (state, priority, id_area, id_machine, id_collaborator, creation_task, date_task, description_task, maintenance_type) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("sssiissss", $state, $priority, $area_request, $id_machine, $id_collaborator, $current_date_time, $maintenance_date, $description_request, $maintenance_type);

    if ($stmt2->execute()) {
        // If task is inserted successfully, get task ID
        $task_id = $stmt2->insert_id;
        
        // Check if images are uploaded and process them
        if (!empty($_FILES["images_task"]["name"][0])) {
            $img_dir = "../img/register_tasks_completed/{$brand_machine}-{$id_machine}-{$task_id}";
            if (!is_dir($img_dir)) {
                mkdir($img_dir, 0777, true); // Create directory if it doesn't exist
            }
            foreach ($_FILES["images_task"]["tmp_name"] as $key => $temp) {
                $file_name = "{$id_machine}-{$key}.jpg";
                move_uploaded_file($temp, "{$img_dir}/{$file_name}");
                $images[] = $file_name;
            }
        }

        // Convert images array to JSON format
        $jsonArray = json_encode($images);

        // Update task record with image file names
        $query3 = "UPDATE tasks SET images_task = ? WHERE id=?";
        $stmt3 = $conn->prepare($query3);
        $stmt3->bind_param("si", $jsonArray, $task_id);
        if($stmt3->execute()){
            $message = "¡Registro insertado correctamente!";
        }else{
            $message = "¡Error!";
        }
        $stmt3->close();
        $stmt2->close();
        
    } else {
        $message = "Error al insertar el registro: " . $stmt->error;
    }
}else{
    $message = "No se insertaron todos los datos";
}
echo "<script>alert('$message'); window.location.href = '../admin/admin_create_task_calendar.php?machine=$id_machine&area=$area_request';</script>";
exit();