<?php
    include("connect.php");
    include("validation_sesion.php");
    

    $id_task = $_GET['id-task'];
    $id_colab = $_GET['id-colab'];

    
    $query = "UPDATE tasks
            SET id_collaborator='$id_colab', assigned='Yes' 
            WHERE id = '$id_task'";

    if($query = mysqli_query($conn, $query)){
        if(isset($_SERVER['HTTP_REFERER'])) {
            // Define la URL base que quieres comparar
            $url_base = "http://localhost/page_plastInnova/admin/collaborators_assign_task.php";
    
            // Obtiene la URL de la página anterior
            $url_anterior = $_SERVER['HTTP_REFERER'];
    
            // Verifica si la URL de la página anterior contiene la URL base
            if(strpos($url_anterior, $url_base) !== false) {
                // Si la URL de la página anterior coincide con la URL base, haz algo
                echo "Estás viniendo de la página deseada.";
                header("Location: ../admin/tasks_admin.php");
            } else {
                // Si la URL de la página anterior no coincide con la URL base, haz algo diferente
                echo "No estás viniendo de la página deseada.";
                header("Location: ../admin/tasks_admin_unassigned.php");
            }
        } else {
            // Si la variable $_SERVER['HTTP_REFERER'] no está definida, haz algo diferente
            echo "No se detectó la URL de la página anterior.";
        }  
    }else{
        echo "Ocurrio un error";
        echo "<div> <a href = '../admin/collaborators_assign_task.php'> Intentalo de nuevo. </a> </div>";
    }
?>