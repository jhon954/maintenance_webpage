<?php
include ("connect.php");
$previous_url = $_SERVER['HTTP_REFERER'];
$url_unassign_tasks = 'http://localhost/page_plastInnova/admin/tasks_admin_unassigned.php';
$url_tasks = 'http://localhost/page_plastInnova/admin/tasks_admin.php';
$url_tasks_completed = 'http://localhost/page_plastInnova/admin/tasks_completed_admin.php';

if(isset($_GET['id-task'])) {
    // Obtener el ID del área de la URL
    $task_id = htmlspecialchars($_GET['id-task']);
    $brand_machine = htmlspecialchars($_GET['brand-machine']);
    $id_machine = htmlspecialchars($_GET['id-machine']);
    $img_dir_tasks = "../img/register_tasks_completed/".$brand_machine."-".$id_machine."-".$task_id;
    $img_dir_jobs = "../img/register_jobs_completed/".$brand_machine."-".$id_machine."-".$task_id;

    echo $task_id."<br>";
    echo $brand_machine."<br>";
    echo $id_machine."<br>";
    echo $img_dir_jobs."<br>";
    echo $img_dir_tasks;
    // Preparar la consulta de eliminación
    $query1 = "DELETE FROM tasks WHERE id=?";
    $stmt1 = $conn->prepare($query1);

    // Vincular el parámetro del ID del área a la consulta
    $stmt1->bind_param("i", $task_id); // Suponiendo que el ID del área es numérico

    // Ejecutar la consulta de eliminación
    if($stmt1->execute()){
        if (is_dir($img_dir_tasks)) {
            // Abrir el directorio
            $dir_handle = opendir($img_dir_tasks);
            // Recorrer el directorio y eliminar cada archivo
            while (($file = readdir($dir_handle)) !== false) {
                if ($file != "." && $file != "..") {
                    unlink($img_dir_tasks . "/" . $file); // Eliminar el archivo
                }
            } 
            // Cerrar el directorio
            closedir($dir_handle);
            // Eliminar el directorio vacío
            if (rmdir($img_dir_tasks)) {
                echo "El directorio tarea y su contenido fueron eliminados correctamente.";
            } else {
                echo "Error al intentar eliminar el directorio tarea.";
            }
        } else {
            echo "El directorio tarea no existe.";
        }
        if (is_dir($img_dir_jobs)) {
            // Abrir el directorio
            $dir_handle = opendir($img_dir_jobs);
            // Recorrer el directorio y eliminar cada archivo
            while (($file = readdir($dir_handle)) !== false) {
                if ($file != "." && $file != "..") {
                    unlink($img_dir_jobs . "/" . $file); // Eliminar el archivo
                }
            } 
            // Cerrar el directorio
            closedir($dir_handle);
            // Eliminar el directorio vacío
            if (rmdir($img_dir_jobs)) {
                echo "El directorio trabajo y su contenido fueron eliminados correctamente.";
            } else {
                echo "Error al intentar eliminar el directorio trabajo.";
            }
        } else {
            echo "El directorio trabajo no existe.";
        }
        if($previous_url == $url_unassign_tasks) {
            header("Location: ../admin/tasks_admin_unassigned.php");
        }elseif($previous_url == $url_tasks) {
            header("Location: ../admin/tasks_admin.php");
        }elseif($previous_url == $url_tasks_completed) {
            header("Location: ../admin/tasks_completed_admin.php");
        }
    } else {
        echo "Error al ejecutar ". $stmt1->error;
    }
} else {
    echo "Los datos no fueron proporcionados";
    $stmt1->close();
}
exit();