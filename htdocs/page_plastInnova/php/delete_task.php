<?php
include ("connect.php");
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
        $message = "Se ha eliminado la tarea correctamente";
        $stmt1->close();
    } else {
        $message = "Error al eliminar tarea";
    }
} else {
    $message = "ID de área no proporcionado";
    $stmt1->close();
}

// Redirigir de vuelta a la página de administración de áreas
echo "<script>alert('$message'); window.location.href = '../admin/admin_areas.php';</script>";
exit();
