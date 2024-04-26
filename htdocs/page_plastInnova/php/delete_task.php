<?php
include ("connect.php");
$previous_url = $_SERVER['HTTP_REFERER'];
$url_unassign_tasks = 'http://localhost/page_plastInnova/admin/tasks_admin_unassigned.php';
$url_tasks = 'http://localhost/page_plastInnova/admin/tasks_admin.php';
$url_tasks_completed = 'http://localhost/page_plastInnova/admin/tasks_completed_admin.php';

// Verificar si el parámetro del área está presente en la URL
if(isset($_GET['id-task'])) {
    // Obtener el ID del área de la URL
    $task_id = htmlspecialchars($_GET['id-task']);

    // Preparar la consulta de eliminación
    $query1 = "DELETE FROM tasks WHERE id=?";
    $stmt1 = $conn->prepare($query1);

    // Vincular el parámetro del ID del área a la consulta
    $stmt1->bind_param("i", $task_id); // Suponiendo que el ID del área es numérico

    // Ejecutar la consulta de eliminación
    if($stmt1->execute()){
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