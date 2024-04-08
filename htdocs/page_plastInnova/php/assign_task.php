<?php
    include("connect.php");
    include("validation_sesion.php");
    

    $id_task = $_GET['id-task'];
    $id_colab = $_GET['id-colab'];

    $query = "UPDATE tasks
            SET id_collaborator='$id_colab', assigned='Yes' 
            WHERE id = '$id_task'";

    if($query = mysqli_query($conn, $query)){
        echo "Done";
        header("Location: ../admin/tasks_admin_unassigned.php");
    }else{
        echo "Ocurrio un error";
        echo "<div> <a href = '../php/collaborators_assign_task.php'> Intentalo de nuevo. </a> </div>";
    }
?>