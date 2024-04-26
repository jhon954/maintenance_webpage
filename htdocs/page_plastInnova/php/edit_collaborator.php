<?php
include("connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST['id_collaborator'], $_POST['name'], $_POST['surname'], $_POST['state'], $_POST['job_title'])) {
    
    $id_colab = htmlspecialchars($_POST['id_collaborator']);
    $new_name = htmlspecialchars($_POST['name']);
    $new_surname = htmlspecialchars($_POST['surname']);
    $new_state = htmlspecialchars($_POST['state']);
    $new_job_title = htmlspecialchars($_POST['job_title']);
    $new_nickname = strtolower($new_name.$id_colab.$new_surname);

    $query = "UPDATE collaborators SET nickname=?, name=?, surname=?, state=?,`job-title`=?
            WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $new_nickname, $new_name, $new_surname, $new_state, $new_job_title, 
                        $id_colab);
    if($stmt->execute()){
        $message = "Colaborador editado";
    }else{
        $message = "Error ".$stmt->error;
    }

    $stmt->close();
}
else{
    $message = "Faltan datos";
}
echo "<script>alert('$message'); window.location.href = '../admin/admin_collaborators.php';</script>";
exit();