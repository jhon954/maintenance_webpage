<?php
include("connect.php");

$name = 'Boss';
$surname = 'Bosy';
$job_title = 'Jefaso';
$type_user = 'admin';
$state = 'active';
$password_hashed = password_hash('admin123', PASSWORD_DEFAULT);
$nickname ="";

// Preparar y ejecutar la primera consulta para insertar el nuevo colaborador
$query1 = "INSERT INTO collaborators (name, surname, `job-title`, `type-user`, state, password) 
                VALUES (?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("ssssss", $name, $surname, $job_title, $type_user, $state, $password_hashed);
$stmt1->execute();

// Verificar si se insertó correctamente el nuevo colaborador
if ($stmt1->affected_rows > 0) {
    // Obtener el ID del colaborador insertado
    $last_id_inserted = $stmt1->insert_id;
    // Generar el nickname del colaborador
    $nickname = strtolower($name.$last_id_inserted.$surname);
    // Preparar y ejecutar la segunda consulta para actualizar el nickname del colaborador
    $query2 = "UPDATE collaborators SET nickname=? WHERE id=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("si", $nickname, $last_id_inserted);
    if($stmt2->execute()) {
        $message="Usuario añadido exitosamente.";
    } else {
        $message= "Error al insertar nickname";
    }
} else {
    $message="Error al añadir usuario: " . $conn->error;
}

// Cerrar las declaraciones preparadas
$stmt1->close();
$stmt2->close();