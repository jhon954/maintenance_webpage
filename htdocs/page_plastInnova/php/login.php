<?php
// include("connect.php");
// session_start();

// $_SESSION['login'] = false;

// $user = htmlspecialchars($_POST["nickname"]);
// $password = htmlspecialchars($_POST["password"]);

// // Consulta SQL para obtener el usuario por nombre de usuario
// $consulta = "SELECT * FROM collaborators WHERE nickname=?";
// $stmt = $conn->prepare($consulta);
// $stmt->bind_param("s", $user);
// $stmt->execute();
// $resultado = $stmt->get_result();

// // Verificar si se encontró un usuario con ese nombre de usuario
// if ($resultado->num_rows == 1) {
//     $usuario = $resultado->fetch_assoc();

//     // Verificar la contraseña utilizando password_verify()
//     if (password_verify($password, $usuario['password']) && ($usuario['state'] == 'active')) {
//         $_SESSION['login'] = true;
//         $_SESSION['id'] = $usuario['id'];
//         $_SESSION['nickname'] = $usuario['nickname'];
//         $_SESSION['name'] = $usuario['name'];
//         $_SESSION['surname'] = $usuario['surname'];
//         $_SESSION['job_title'] = $usuario['job-title'];
//         $_SESSION['type_user'] = $usuario['type-user'];
//         $_SESSION['state'] = $usuario['state'];
//         $_SESSION['profilePic'] = $usuario['profile-photo'];

//         // Redirigir según el tipo de usuario
//         if ($usuario['type-user'] == "admin") {
//             header('Location: ../admin/admin_personal_page.php');
//         } else {
//             header('Location: ../colab/colab_personal_page.php');
//         }
//         exit; // Importante: terminar la ejecución del script después de redirigir
//     } 
//     elseif ($usuario['state'] != 'active') {
//         // echo "Contraseña Inactivo.";
//         // echo "<section><a href='../index.html'>Volver a intentarlo</a></section>";
//         $_SESSION['error'] = "inactive";
//         header('Location: ../index.php');
//         exit;
//     }
//     else {
//         // echo "Contraseña incorrecta.";
//         // echo "<section><a href='../index.html'>Volver a intentarlo</a></section>";
//         $_SESSION['error'] = "password";
//         header('Location: ../index.php');
//         exit;
//     }
// } else {
//     // echo "Usuario no encontrado.";
//     // echo "<section><a href='../index.html'>Volver a intentarlo</a></section>";
//     $_SESSION['error'] = "user";
//     header('Location: ../index.php');
// }

// $stmt->close();
// $conn->close();
// exit();
session_start();
include("connect.php");

$response = array("success" => false, "errors" => array("userError" => "", "passwordError" => ""));

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
    } else {
        $response["errors"]["passwordError"] = "Contraseña incorrecta.";
    }
} else {
    $response["errors"]["userError"] = "Usuario no encontrado.";
}

echo json_encode($response);
$stmt->close();
$conn->close();
