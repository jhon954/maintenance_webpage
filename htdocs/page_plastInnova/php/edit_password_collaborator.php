<?php
include("connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
isset($_POST['id_collaborator_password'], $_POST['password'])) {

    $id_colab = htmlspecialchars($_POST['id_collaborator_password']);
    $new_password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

    $query = "UPDATE collaborators SET password=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $new_password, $id_colab);


    if($stmt->execute()){
        $message="Contraseña actualizada";
    }else{
        $message = "Error";
    }
    $stmt->close();
}else{
    $message = "Faltan datos";
}
echo "<script>alert('$message'); window.location.href = '../admin/admin_collaborators.php';</script>";
exit();