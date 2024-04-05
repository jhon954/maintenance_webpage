<?php
    include("connect.php");
    include("validation_sesion.php");

    date_default_timezone_set('America/Bogota');
    $current_date_time = date("Y-m-d H:i:s");
    $description_job = $_POST["description_job"];
    $id_task = $_GET['id-task'];
    $id_machine = $_GET['id-machine'];
    $name_machine = $_GET['name-machine'];
    $img_dir = "../img/".$name_machine."-". $id_machine;
    
    
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
    #$miArrayRecuperado = json_decode($jsonArray, true);
    
    $consulta = "UPDATE tasks 
                    SET finalization_task = '$current_date_time', 
                    job_description = '$description_job',
                    image='$jsonArray',
                    state = 'completed'
                    WHERE id = '$id_task'";
    
    if($consulta = mysqli_query($conn, $consulta)){
        echo "Completed!";
        header('Location: ../tasks.php');
    }else{
        echo "No se pudo completar la tarea, vuelve a intentarlo.";
        header('Location: ../form_task_complete.php');
    }    
?>