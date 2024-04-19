<?php
include("connect.php");


$name = $_POST["name"];
$surname = $_POST['surname'];
$job_title = $_POST['job_title'];
$type_user = 'colab';
$state = $_POST['state'];
$password_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
$nickname ="";


$query1 = "INSERT INTO collaborators (name, surname, `job-title`, `type-user`, state, password) 
                VALUES ( ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("ssssss", $name, $surname, $job_title, $type_user, $state, $password_hashed);
$stmt1->execute();

// Verificar si la consulta se ejecutó correctamente
if ($stmt1->affected_rows > 0) {
    $last_id_inserted = $stmt1->insert_id;
    $nickname = strtolower($name.$last_id_inserted.$surname);
    $query2 = "UPDATE collaborators SET nickname=? WHERE id=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("si", $nickname, $last_id_inserted);
    if($stmt2->execute()) {
        $message="Usuario añadido exitosamente.";
    }else{
        $message= "Error al insertar nickname";
    }
} else {
    $message="Error al añadir usuario: " . $conn->error;
}

// Cerrar la conexión y liberar recursos
$stmt1->close();
$stmt2->close();
echo "<script>alert('$message'); window.location.href = '../admin/admin_collaborators.php';</script>";

?>