<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_machine = $_POST['id_machine'];
    $area_request = $_POST['area'];
    $maintenance_date = $_POST['maintenance_date'];
    $description_request = $_POST['description'];
    $priority = $_POST['priority'];
    echo $id_machine;

    // Obtener fecha y hora actual
    date_default_timezone_set('America/Bogota');
    $current_date_time = date("Y-m-d H:i:s");

    // Definir estado y asignación inicial de la tarea
    $state = "active";
    $assigned = "No";

    // ID de colaborador temporal (reemplazar con lógica para obtener el ID del colaborador)
    $id_collaborator = 1;

    // Array para almacenar nombres de archivos de imágenes
    $images = array();

    // Verificar si se recibieron archivos de imágenes
    if (!empty($_FILES["images_task"]["name"][0])) {
        // Directorio para almacenar las imágenes
        $img_dir = "../img/register_tasks_completed/{$id_machine}-{$current_date_time}";

        // Crear directorio si no existe
        if (!is_dir($img_dir)) {
            mkdir($img_dir, 0777, true); // 0777 permite todos los permisos
        }

        // Procesar cada imagen
        foreach ($_FILES["images_task"]["tmp_name"] as $key => $temp) {
            $file_name = "{$id_machine}-{$current_date_time}-{$key}.jpg";
            move_uploaded_file($temp, "{$img_dir}/{$file_name}");
            $images[] = $file_name;
        }
    }

    // Convertir el array de nombres de archivos de imágenes a formato JSON
    $jsonArray = json_encode($images);

    // Consulta preparada para insertar la tarea en la base de datos
    $query = "INSERT INTO tasks (state, priority, id_area, id_machine, id_collaborator, creation_task, date_task,description_task, assigned, images_task) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssisssss", $state, $priority, $area_request, $id_machine, $id_collaborator, $current_date_time, $maintenance_date, $description_request, $assigned, $jsonArray);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $message = "¡Registro insertado correctamente!";
    } else {
        $message = "Error al insertar el registro: " . $stmt->error;
    }

    // Cerrar la consulta
    $stmt->close();
    $conn->close();

    // Mostrar mensaje de éxito o error
    echo "<script>alert('$message'); window.location.href = '../admin/admin_form_create_task.php';</script>";
}
?>
