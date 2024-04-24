<?php
include("connect.php");
$id_colab = $_POST['id_collaborator_state'];
$new_state = $_POST['state'];

$query = "UPDATE collaborators SET state=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $new_state, $id_colab);


if($stmt->execute()){
    $message="Estado actualizado";
}else{
    $message = "Error";
}
$stmt->close();
echo "<script>alert('$message'); window.location.href = '../admin/admin_collaborators.php';</script>";