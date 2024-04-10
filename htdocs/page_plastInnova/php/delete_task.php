<?php
    include("connect.php");


    $id_task = $_GET['id-task'];
    
    $query1 = "DELETE FROM tasks WHERE id='$id_task'";
    
    if ($conn->query($query1) === TRUE) {
        header("Location: ../admin/tasks_admin.php");
        exit();
    } else {
        echo "Error al eliminar la tarea: " . $conn->error;
    }

    
?>