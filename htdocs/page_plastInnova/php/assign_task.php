<?php
    include("connect.php");
    $id_task = htmlspecialchars($_GET['id-task']);
    $id_colab = htmlspecialchars($_GET['id-colab']);
    $previous_url = htmlspecialchars($_GET['url-b']);
    $url_unassign_tasks = 'http://localhost/page_plastInnova/admin/tasks_admin_unassigned.php';
    if (!isset($id_task, $id_colab, $previous_url)) {
        echo "Parámetros inválidos.";
        exit();
    }
    $query = "UPDATE tasks
            SET id_collaborator=?, state='active' 
            WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt ->bind_param("ii", $id_colab, $id_task);
    if($stmt->execute()){
        if($previous_url == $url_unassign_tasks ){
            header('Location: ../admin/tasks_admin_unassigned.php');
        }else{
            header('Location: ../admin/tasks_admin.php');
        }
        exit();
    }else{
        echo "Error al ejecutar la consulta: " . $stmt->error;
        exit();
    }
