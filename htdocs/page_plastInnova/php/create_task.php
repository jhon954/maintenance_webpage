<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_machine = $_POST['id_machine'];
    $area_request = $_POST['area'];
    $maintenance_date = $_POST['maintenance_date'];
    $description_request = $_POST['description'];
    $priority = $_POST['priority'];

    // Obtener fecha y hora actual
    date_default_timezone_set('America/Bogota');
    $current_date_time = date("Y-m-d H:i:s");

    // Definir estado y asignación inicial de la tarea
    $state = "unassigned";
    //$assigned = "No";

    // ID de colaborador temporal (reemplazar con lógica para obtener el ID del colaborador)
    $id_collaborator = 1;

    // Array para almacenar nombres de archivos de imágenes
    $images = array();
    $query1 = "SELECT brand FROM machines WHERE id=?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("i", $id_machine);
    $stmt1->execute();
    $stmt1->bind_result($brand_machine);
    $stmt1->fetch();
    $stmt1->close();
    // Consulta preparada para insertar la tarea en la base de datos
    $query2 = "INSERT INTO tasks (state, priority, id_area, id_machine, id_collaborator, creation_task, date_task,description_task) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("sssiisss", $state, $priority, $area_request, $id_machine, $id_collaborator, $current_date_time, $maintenance_date, $description_request);

    // Ejecutar la consulta
    if ($stmt2->execute()) {
        $task_id = $stmt2->insert_id;
        if (!empty($_FILES["images_task"]["name"][0])) {
            // Directorio para almacenar las imágenes
            $img_dir = "../img/register_tasks_completed/{$brand_machine}-{$id_machine}-{$task_id}";
    
            // Crear directorio si no existe
            if (!is_dir($img_dir)) {
                mkdir($img_dir, 0777, true); // 0777 permite todos los permisos
            }
    
            // Procesar cada imagen
            foreach ($_FILES["images_task"]["tmp_name"] as $key => $temp) {
                $file_name = "{$id_machine}-{$key}.jpg";
                move_uploaded_file($temp, "{$img_dir}/{$file_name}");
                $images[] = $file_name;
            }
        }
        $stmt2->close();
        // Convertir el array de nombres de archivos de imágenes a formato JSON
        $jsonArray = json_encode($images);
        $query3 = "UPDATE tasks set images_task = ? WHERE id=?";
        $stmt3 = $conn->prepare($query3);
        $stmt3->bind_param("si", $jsonArray, $task_id);
        if($stmt3->execute()){
            $message = "¡Registro insertado correctamente!";
        }else{
            $message = "¡Error!";
        }
        $stmt3 -> close();
        
    } else {
        $message = "Error al insertar el registro: " . $stmt->error;
    }

    // Mostrar mensaje de éxito o error
    echo "<script>alert('$message'); window.location.href = '../admin/admin_form_create_task.php?machine=$id_machine&area=$area_request';</script>";

}
?>
