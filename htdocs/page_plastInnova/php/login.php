<?php
include("connect.php");
session_start();

$_SESSION['login'] = false;

$user = htmlspecialchars($_POST["nickname"]);
$password = htmlspecialchars($_POST["password"]);

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
    if (password_verify($password, $usuario['password']) && ($usuario['state'] == 'active')) {
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
            header('Location: ../admin/admin_personal_page.php');
        } else {
            header('Location: ../colab/colab_personal_page.php');
        }
        exit; // Importante: terminar la ejecución del script después de redirigir
    } 
    elseif ($usuario['state'] != 'active') {
        echo "Contraseña Inactivo.";
        echo "<section><a href='../index.html'>Volver a intentarlo</a></section>";
    }
    else {
        echo "Contraseña incorrecta.";
        echo "<section><a href='../index.html'>Volver a intentarlo</a></section>";
    }
} else {
    echo "Usuario no encontrado.";
    echo "<section><a href='../index.html'>Volver a intentarlo</a></section>";
}
$stmt->close();
$conn->close();
exit();
