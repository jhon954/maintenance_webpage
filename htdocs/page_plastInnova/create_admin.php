<?php

    include("php/connect.php");

    $name = 'admin';
    $surname = ''; 
    $job_title = 'Ingeniero';
    $type_user = 'admin';
    $state = 'active';
    $password = 'admin123';


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $query = "INSERT INTO collaborators (name, surname, `job-title`, `type-user`, state, password) 
                VALUES (?, ?, ?, ?, ?, ?)";


    // Preparar la consulta SQL
    $stmt = $conn->prepare($query);

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("ssssss", $name, $surname, $job_title, $type_user, $state, $hashed_password);
    $stmt->execute();

    // Verificar si la consulta se ejecutó correctamente
    if ($stmt->affected_rows > 0) {
    echo "Usuario añadido exitosamente.";
    } else {
    echo "Error al añadir usuario: " . $conn->error;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conn->close();
