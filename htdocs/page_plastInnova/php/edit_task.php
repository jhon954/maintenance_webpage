<?php
    include("connect.php"); // Incluir el archivo de conexión a la base de datos

    // Verificar si se ha enviado el formulario por el método POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $id_machine=$_POST["id_machine"];
        $state = $_POST["state"];
        $id_collaborator = $_POST["id_collaborator"];
        $creation_task = $_POST["creation_task"];
        $finalization_task = $_POST["finalization_task"];
        $description_task = $_POST["description_task"];
        $job_description = $_POST["job_description"];
        $assigned = $_POST["assigned"];
        $images_indb;
        $img_dir;

        $creation_task_formatted = date('Y-m-d H:i:s', strtotime($creation_task));
        $finalization_task_formatted = date('Y-m-d H:i:s', strtotime($finalization_task));

        $query1 = "SELECT * FROM machines WHERE id='$id_machine'";
        if ($result1 = $conn -> query($query1)) {
            $row1 = $result1 -> fetch_assoc();
            $img_dir = "../img/register_tasks_completed/".$row1['model']."-". $id_machine;
        }

        $query2 = "SELECT images FROM tasks WHERE id='$id'";
        if ($result2 = $conn -> query($query2)) {
            $row2 = $result2 -> fetch_assoc();
            $images_indb = $row2['images'];
        }

        // Verificar si se han subido imágenes
        if ((!$_FILES['images_job']['type'][0])) {
            $jsonArray_images = $images_indb;
        } else {
            $archivos = glob($img_dir . '/*');

            // Iterar sobre cada archivo y eliminarlo
            foreach($archivos as $archivo) {
                if(is_file($archivo)) {
                    unlink($archivo); // Eliminar el archivo
                }
            }

            $images = array(); // Inicializar el array de imágenes

            if (!is_dir($img_dir)) {
                mkdir($img_dir, 0777, true); // Crear el directorio si no existe
            }
            
            // Iterar sobre cada imagen subida
            $total_files = count($_FILES["images_job"]["name"]);
            for ($i = 0; $i < $total_files; $i++) {
                $temp = $_FILES["images_job"]["tmp_name"][$i];
                $file_name = $_FILES["images_job"]["name"][$i];
                $file_name = $id."-".$i.".jpg";
                move_uploaded_file($temp, $img_dir."/".$file_name);
                $images[] = $file_name; // Agregar el nombre de la imagen al array
            }

            // Convertir el array de imágenes a formato JSON
            $jsonArray_images = json_encode($images);
        }
        
        // Preparar la consulta SQL para actualizar la fila en la base de datos
        $query = "UPDATE tasks SET state=?, id_collaborator=?, creation_task=?, finalization_task=?, 
        description_task=?, job_description=?, assigned=?, images=? WHERE id=?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("sissssssi", $state, $id_collaborator, $creation_task_formatted, $finalization_task_formatted, $description_task, $job_description, $assigned, $jsonArray_images, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "¡Registro actualizado correctamente!";
            header("Location: ../admin/tasks_admin_unassigned.php");
        } else {
            echo "Error al actualizar el registro: " . $conn->error;
        }

        // Cerrar la conexión y liberar los recursos
        $stmt->close();
    }
?>