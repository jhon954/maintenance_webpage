<?php
include ("connect.php");

// Verificar si el parámetro del área está presente en la URL
if(isset($_GET['area'])) {
    // Obtener el ID del área de la URL
    $area_id = $_GET['area'];

    // Preparar la consulta de eliminación
    $query1 = "DELETE FROM areas WHERE id=?";
    $stmt1 = $conn->prepare($query1);

    // Vincular el parámetro del ID del área a la consulta
    $stmt1->bind_param("i", $area_id); // Suponiendo que el ID del área es numérico

    // Ejecutar la consulta de eliminación
    if($stmt1->execute()){
        $message = "Área {$area_id} eliminada correctamente";
        $stmt1->close();
    } else {
        $message = "Error al eliminar el área";
    }
} else {
    $message = "ID de área no proporcionado";
}

// Redirigir de vuelta a la página de administración de áreas
echo "<script>alert('$message'); window.location.href = '../admin/admin_areas.php';</script>";
?>
