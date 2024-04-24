<?php
include("connect.php");

$id_colab = $_POST['id_collaborator'];
$new_name = $_POST['name'];
$new_surname = $_POST['surname'];
$new_state = $_POST['state'];
$new_job_title = $_POST['job_title'];
$new_nickname = strtolower($new_name.$id_colab.$new_surname);

$query = "UPDATE collaborators SET nickname=?, name=?, surname=?, state=?,`job-title`=?
        WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssi", $new_nickname, $new_name, $new_surname, $new_state, $new_job_title, 
                    $id_colab);
if($stmt->execute()){
    $message = "Colaborador editado";
}else{
    $message = "Error";
}

$stmt->close();
echo "<script>alert('$message'); window.location.href = '../admin/admin_collaborators.php';</script>";