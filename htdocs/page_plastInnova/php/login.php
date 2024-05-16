<?php
session_start();
include("connect.php");

$response = array("success" => false, "errors" => array("userError" => "", "passwordError" => "", "userNotFoundError"=>""));

$user = htmlspecialchars($_POST["nickname"]);
$password = htmlspecialchars($_POST["password"]);

$consulta = "SELECT * FROM collaborators WHERE nickname=?";
$stmt = $conn->prepare($consulta);
$stmt->bind_param("s", $user);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {
    $usuario = $resultado->fetch_assoc();
    if (password_verify($password, $usuario['password']) && ($usuario['state'] == 'active')) {
        $response["success"] = true;
        $response["redirectUrl"] = $usuario['type-user'] == "admin" ? "admin/admin_personal_page.php" : "colab/colab_personal_page.php";
        $_SESSION['login'] = true;
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nickname'] = $usuario['nickname'];
        $_SESSION['name'] = $usuario['name'];
        $_SESSION['surname'] = $usuario['surname'];
        $_SESSION['job_title'] = $usuario['job-title'];
        $_SESSION['type_user'] = $usuario['type-user'];
        $_SESSION['state'] = $usuario['state'];
        $_SESSION['profilePic'] = $usuario['profile-photo'];
    } else if($usuario['state'] != 'active'){
        $response["errors"]["userNotFoundError"] = "Usuario Inactivo.";
    }
    else {
        $response["errors"]["passwordError"] = "Contraseña incorrecta.";
    }
} else {
    $response["errors"]["userError"] = "Usuario no encontrado.";
}

echo json_encode($response);
$stmt->close();
$conn->close();
