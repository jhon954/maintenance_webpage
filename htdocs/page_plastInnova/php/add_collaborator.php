<?php
include("connect.php");

// Verificar si todos los campos del formulario están configurados
if(isset($_POST["name_add"], $_POST['surname_add'], $_POST['job_title_add'], $_POST['state_add'], $_POST['password_add'])) {
    // Asignar y sanitizar los valores de los campos del formulario
    $name = htmlspecialchars($_POST["name_add"]);
    $surname = htmlspecialchars($_POST['surname_add']);
    $job_title = htmlspecialchars($_POST['job_title_add']);
    $type_user = 'colab';
    $state = htmlspecialchars($_POST['state_add']);
    $password_hashed = password_hash(htmlspecialchars($_POST['password_add']), PASSWORD_DEFAULT);
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
} else {
    // Si no se completaron todos los campos del formulario, mostrar un mensaje de error
    $message = "Por favor, complete todos los campos del formulario.";
}

// Redirigir de vuelta a la página de administración de colaboradores con el mensaje
echo "<script>alert('$message'); window.location.href = '../admin/admin_collaborators.php';</script>";
exit();