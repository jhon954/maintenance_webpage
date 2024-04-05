<?php
    include("connect.php");
    
    $area_request= $_POST['area'];
    $description_request = $_POST['description'];
    $importance = $_POST['importance'];
    date_default_timezone_set('America/Bogota');
    $current_date_time = date("Y-m-d H:i:s");

    $query = "INSERT INTO tasks (state, area,creation_task, description_task, asigned, id_machine, id_collaborator) 
            VALUES ('active', '$area_request', '$current_date_time', '$description_request', 'No', '2', '2')";

    if($query = mysqli_query($conn, $query)){
        echo "Done";
    }
?>