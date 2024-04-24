<?php
include("connect.php");
$id_colab = $_POST['id_collaborator_password'];
$new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "UPDATE collaborators SET password=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $new_password, $id_colab);


if($stmt->execute()){
    $message="Contraseña actualizada";
}else{
    $message = "Error";
}
$stmt->close();
echo "<script>alert('$message'); window.location.href = '../admin/admin_collaborators.php';</script>";