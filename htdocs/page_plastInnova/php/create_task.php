<?php
    include("connect.php");
    $area_request = $_POST['area'];
    $id_machine = $_POST['machine'];
    $description_request = $_POST['description'];
    $importance = $_POST['importance'];
    date_default_timezone_set('America/Bogota');
    $current_date_time = date("Y-m-d H:i:s");
    $state = "active";
    $assigned = "No";
    $id_collaborator= 1;
    $jsonArray_images_task;

    // Consulta preparada para obtener el modelo de máquina
    $query1 = "SELECT model FROM machines WHERE id=?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("i", $id_machine);
    $stmt1->execute();
    $stmt1->store_result();

    // Verificar si se encontró la máquina
    if ($stmt1->num_rows > 0) {
        $stmt1->bind_result($machine_model);
        $stmt1->fetch();
        
        // Consulta preparada para insertar la tarea
        $query2 = "INSERT INTO tasks (state, id_area, id_machine, id_collaborator,
                    creation_task, description_task, assigned) 
                    VALUES (?, ?, ?,?, ?, ?, ?)";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("sssisss", $state, $area_request, $id_machine, $id_collaborator,
                $current_date_time, $description_request, $assigned);
        
        // Ejecutar la consulta de inserción
        if ($stmt2->execute()) {
            $last_insert_id = $conn->insert_id;
            
            $img_dir = "../img/register_tasks_completed/".$machine_model."-". $id_machine."-". $last_insert_id;
            $images = array();

            if(!$_FILES['images_task']['type'][0]){
                $jsonArray = "";
                
            }else{
                if (!is_dir($img_dir)) {
                    mkdir($img_dir, 0777, true); // 0777 permite todos los permisos
                }
                if (!empty($_FILES["images_task"]["name"])) {
                    $total_files = count($_FILES["images_task"]["name"]);
                    for ($i = 0; $i < $total_files; $i++) {
                        $temp = $_FILES["images_task"]["tmp_name"][$i];
                        $file_name = $_FILES["images_task"]["name"][$i];
                        $file_name = $last_insert_id."-".$i.".jpg";
                        move_uploaded_file($temp, $img_dir."/".$file_name);
                        $images[] = $file_name;
                    }
                }
                $jsonArray = json_encode($images);
            }
            
            $query3 = "UPDATE tasks SET images_task=? WHERE id=?";
            $stmt3 = $conn->prepare($query3);
            $stmt3->bind_param("si", $jsonArray, $last_insert_id);

            if ($stmt3->execute()) {
                $message = "¡Registro insertado correctamente!";
            } else {
                $message= "Error al insertar datos: " . $stmt3->error;
            }
            $stmt3->close();

            
        } else {
            $message = "Error al insertar el registro: " . $stmt2->error;
        }
        
        // Cerrar la consulta
        $stmt2->close();
    } else {
        $message = "No se encontró la máquina con el ID: " . $id_machine;
    }

    // Cerrar la consulta y liberar los recursos
    $stmt1->close();
    $conn->close();

    // Mostrar el mensaje emergente después de completar la operación
    echo "<script>alert('$message'); window.location.href = '../users/form_create_task.php';</script>";


?>