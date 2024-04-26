<?php
    include("connect.php");
    include("validation_sesion.php");

    date_default_timezone_set('America/Bogota');
    $current_date_time = date("Y-m-d H:i:s");
    $description_job = htmlspecialchars($_POST["description_job"]);
    $result_task = htmlspecialchars($_POST["result_task"]);
    $id_task = htmlspecialchars($_GET['id-task']);
    $id_machine = htmlspecialchars($_GET['id-machine']);
    $brand_machine = htmlspecialchars($_GET['brand-machine']);
    $state = "completed";


    $img_dir = "../img/register_jobs_completed/{$brand_machine}-{$id_machine}-{$id_task}";
    
    
    $images = array();

    if (!is_dir($img_dir)) {
        mkdir($img_dir, 0777, true); // 0777 permite todos los permisos
    }
    if (!empty($_FILES["images_job"]["name"])) {
        $total_files = count($_FILES["images_job"]["name"]);
        for ($i = 0; $i < $total_files; $i++) {
            $temp = $_FILES["images_job"]["tmp_name"][$i];
            $file_name = $_FILES["images_job"]["name"][$i];
            $file_name = $id_task."-".$i.".jpg";
            move_uploaded_file($temp, $img_dir."/".$file_name);
            $images[] = $file_name;
        }
    }
    $jsonArray = json_encode($images);
    
    $query = "UPDATE tasks 
                    SET finalization_task = ?, result_task = ? ,job_description = ?, images_job= ?, state = ?
                    WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_Param("sssssi", $current_date_time, $result_task, $description_job, $jsonArray, $state, $id_task);
    if( $stmt->execute() ){
        echo "Completed!";
        $stmt -> close();
        header('Location: ../admin/tasks_admin.php');
        
    }else{
        echo "No se pudo completar la tarea, vuelve a intentarlo.";
        header('Location: ../form_task_complete.php');
    }    
exit();