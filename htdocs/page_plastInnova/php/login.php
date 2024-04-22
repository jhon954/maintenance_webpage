<?php
include("connect.php");
session_start();

$_SESSION['login'] = false;

$user = $_POST["nickname"];
$password = $_POST["password"];

// Consulta SQL para obtener el usuario por nombre de usuario
$consulta = "SELECT * FROM collaborators WHERE nickname=?";
$stmt = $conn->prepare($consulta);
$stmt->bind_param("s", $user);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si se encontró un usuario con ese nombre de usuario
if ($resultado->num_rows == 1) {
    $usuario = $resultado->fetch_assoc();

    // Verificar la contraseña utilizando password_verify()
    if (password_verify($password, $usuario['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nickname'] = $usuario['nickname'];
        $_SESSION['name'] = $usuario['name'];
        $_SESSION['surname'] = $usuario['surname'];
        $_SESSION['job_title'] = $usuario['job-title'];
        $_SESSION['type_user'] = $usuario['type-user'];
        $_SESSION['state'] = $usuario['state'];
        $_SESSION['profilePic'] = $usuario['profile-photo'];

        // Redirigir según el tipo de usuario
        if ($usuario['type-user'] == "admin") {
            header('Location: ../admin/personal_page_admin.php');
        } else {
            header('Location: ../colab/colab_personal_page.php');
        }
        exit; // Importante: terminar la ejecución del script después de redirigir
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}
$stmt->close();
$conn->close();
?>
