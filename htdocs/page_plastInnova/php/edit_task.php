<?php
    include("connect.php"); // Incluir el archivo de conexión a la base de datos
    include("validation_sesion.php");

    // Verificar si se ha enviado el formulario por el método POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $id_machine=$_POST["id_machine"];
        $state = $_POST["state"];
        $id_collaborator = $_POST["id_collaborator"];
        $creation_task = $_POST["creation_task"];
        $date_task = $_POST["date_task"];
        $finalization_task = $_POST["finalization_task"];
        $description_task = $_POST["description_task"];
        $job_description = $_POST["job_description"];
        $images_indb;
        $img_job_dir;
        $img_task_dir;

        $creation_task_formatted = date('Y-m-d H:i:s', strtotime($creation_task));
        $finalization_task_formatted = date('Y-m-d H:i:s', strtotime($finalization_task));

        $query1_edit = "SELECT model FROM machines WHERE id='$id_machine'";
        if ($result1_edit = $conn -> query($query1_edit)) {
            $row1_edit = $result1_edit -> fetch_assoc();
            $img_job_dir = "../img/register_jobs_completed/{$row1_edit['brand']}-{$id_machine}-{$id}";
            $img_task_dir = "../img/register_tasks_completed/{$row1_edit['brand']}-{$id_machine}-{$id}";
        }

        $query2_edit = "SELECT images_task,images_job FROM tasks WHERE id='$id'";
        if ($result2_edit = $conn -> query($query2_edit)) {
            $row2_edit = $result2_edit -> fetch_assoc();
            $images_job_indb = $row2_edit['images_job'];
            $images_task_indb = $row2_edit['images_task'];
        }
        
        // Verificar si se han subido imágenes
        if ((!$_FILES['images_job']['type'][0]) && (!$_FILES['images_task']['type'][0])) {
            $jsonArray_images_job = $images_job_indb;
            $jsonArray_images_task = $images_task_indb;
        } elseif ((!$_FILES['images_job']['type'][0]) && ($_FILES['images_task']['type'][0])) {
            $jsonArray_images_job = $images_job_indb;

            $archivos = glob($img_task_dir . '/*');

            // Iterar sobre cada archivo y eliminarlo
            foreach($archivos as $archivo) {
                if(is_file($archivo)) {
                    unlink($archivo); // Eliminar el archivo
                }
            }

            $images_task = array(); // Inicializar el array de imágenes

            if (!is_dir($img_task_dir)) {
                mkdir($img_task_dir, 0777, true); // Crear el directorio si no existe
            }
            
            // Iterar sobre cada imagen subida
            $total_files = count($_FILES["images_task"]["name"]);
            for ($i = 0; $i < $total_files; $i++) {
                $temp = $_FILES["images_task"]["tmp_name"][$i];
                $file_name = $_FILES["images_task"]["name"][$i];
                $file_name = $id."-".$i.".jpg";
                move_uploaded_file($temp, $img_task_dir."/".$file_name);
                $images_task[] = $file_name; // Agregar el nombre de la imagen al array
            }

            // Convertir el array de imágenes a formato JSON
            $jsonArray_images_task = json_encode($images_task);

        } elseif (($_FILES['images_job']['type'][0]) && (!$_FILES['images_task']['type'][0])) {
            $jsonArray_images_task = $images_task_indb;

            $archivos = glob($img_job_dir . '/*');

            // Iterar sobre cada archivo y eliminarlo
            foreach($archivos as $archivo) {
                if(is_file($archivo)) {
                    unlink($archivo); // Eliminar el archivo
                }
            }

            $images_job = array(); // Inicializar el array de imágenes

            if (!is_dir($img_job_dir)) {
                mkdir($img_job_dir, 0777, true); // Crear el directorio si no existe
            }
            
            // Iterar sobre cada imagen subida
            $total_files = count($_FILES["images_job"]["name"]);
            for ($i = 0; $i < $total_files; $i++) {
                $temp = $_FILES["images_job"]["tmp_name"][$i];
                $file_name = $_FILES["images_job"]["name"][$i];
                $file_name = $id."-".$i.".jpg";
                move_uploaded_file($temp, $img_job_dir."/".$file_name);
                $images_job[] = $file_name; // Agregar el nombre de la imagen al array
            }

            // Convertir el array de imágenes a formato JSON
            $jsonArray_images_job = json_encode($images_job);

        }
        else {
            $archivos_job = glob($img_job_dir . '/*');

            // Iterar sobre cada archivo y eliminarlo
            foreach($archivos_job as $archivo_job) {
                if(is_file($archivo_job)) {
                    unlink($archivo_job); // Eliminar el archivo
                }
            }

            $archivos_task = glob($img_task_dir . '/*');

            foreach($archivos_task as $archivo_task) {
                if(is_file($archivo_task)) {
                    unlink($archivo_task); // Eliminar el archivo
                }
            }

            $images_job = array(); // Inicializar el array de imágenes
            $images_task = array(); // Inicializar el array de imágenes

            if (!is_dir($img_job_dir)) {
                mkdir($img_job_dir, 0777, true); // Crear el directorio si no existe
            }
            if (!is_dir($img_task_dir)) {
                mkdir($img_task_dir, 0777, true); // Crear el directorio si no existe
            }
            
            // Iterar sobre cada imagen subida
            $total_files_job = count($_FILES["images_job"]["name"]);
            for ($i = 0; $i < $total_files_job; $i++) {
                $temp = $_FILES["images_job"]["tmp_name"][$i];
                $file_name = $_FILES["images_job"]["name"][$i];
                $file_name = $id."-".$i.".jpg";
                move_uploaded_file($temp, $img_job_dir."/".$file_name);
                $images_job[] = $file_name; // Agregar el nombre de la imagen al array
            }

            $total_files_task = count($_FILES["images_task"]["name"]);
            for ($i = 0; $i < $total_files_task; $i++) {
                $temp = $_FILES["images_task"]["tmp_name"][$i];
                $file_name = $_FILES["images_task"]["name"][$i];
                $file_name = $id."-".$i.".jpg";
                move_uploaded_file($temp, $img_task_dir."/".$file_name);
                $images_task[] = $file_name; // Agregar el nombre de la imagen al array
            }

            // Convertir el array de imágenes a formato JSON
            $jsonArray_images_job = json_encode($images_job);
            $jsonArray_images_task = json_encode($images_task); 
        }
        
        // Preparar la consulta SQL para actualizar la fila en la base de datos
        $query = "UPDATE tasks SET state=?, id_collaborator=?, creation_task=?, date_task=?, finalization_task=?, 
        description_task=?, job_description=?, images_job=?, images_task=? WHERE id=?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("sisssssssi", $state, $id_collaborator, $creation_task_formatted, $date_task,
        $finalization_task_formatted, $description_task, $job_description, 
         $jsonArray_images_job, $jsonArray_images_task, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "¡Registro actualizado correctamente!";
            if($assigned == "Yes"){
                header("Location: ../admin/tasks_admin.php");
            }else{
            header("Location: ../admin/tasks_admin_unassigned.php");
            }
            

        } else {
            echo "Error al actualizar el registro: " . $conn->error;
        }

        // Cerrar la conexión y liberar los recursos
        $stmt->close();
        $result1 -> close();
        $result2 -> close();
        
    }else{
        echo "No se tomo post";
    }
?>