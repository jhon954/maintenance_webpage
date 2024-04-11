<?php
    include("connect.php");

    $id_task = $_GET['id-task'];
    $img_dir = "../img/register_tasks_completed/".$model_machine."-". $id_machine."-". $id_task;
    $query1 = "DELETE FROM tasks WHERE id='$id_task'";
    
    if ($conn->query($query1) === TRUE) {
        // Redirigir a la página anterior
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error al eliminar la tarea: " . $conn->error;
    }
?>
