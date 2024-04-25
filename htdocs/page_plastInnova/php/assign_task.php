<?php
    include("connect.php");

    $id_task = htmlspecialchars($_GET['id-task']);
    $id_colab = htmlspecialchars($_GET['id-colab']);

    
    $query = "UPDATE tasks
            SET id_collaborator='$id_colab', state='active' 
            WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt ->bind_param("s", $id_task);
    if($stmt->execute()){
        $message = "Tarea asignada";
        ##Add a redirect to tasks admin or unassigned tasks
    }else{
        $message = "Ocurrió un error";
    }
echo "<script>alert('$message'); window.location.href = '../admin/tasks_admin.php?area={$id_area}';</script>";
exit();