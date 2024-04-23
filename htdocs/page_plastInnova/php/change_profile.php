<?php
include("connect.php");
include("validation_sesion.php");

// Ruta donde se guardarán las imágenes
$ub = "../img/profiles/".$_SESSION['id'];

// Verificar si el directorio existe, si no, crearlo
if (!is_dir($ub)) {
    mkdir($ub, 0777, true); // 0777 permite todos los permisos
}

// Ruta completa del archivo de imagen
$file_tmp = $_FILES['archivo']['tmp_name'];
$file_destiny = $ub."/profile.jpg";

// Escalar y guardar la imagen
list($width_orig, $heigth_orig) = getimagesize($file_tmp);
$width_new = 200; // Ancho deseado
$heigth_new = 200; // Alto deseado

$new_image = imagecreatetruecolor($width_new, $heigth_new);
$orig_image = imagecreatefromjpeg($file_tmp);

// Escalar la imagen
imagecopyresampled($new_image, $orig_image, 0, 0, 0, 0, $width_new, $heigth_new, $width_orig, $heigth_orig);

// Guardar la imagen en el destino
imagejpeg($new_image, $file_destiny);

// Liberar memoria
imagedestroy($new_image);
imagedestroy($orig_image);

// Actualizar la ruta de la imagen en la base de datos
$query = "UPDATE collaborators 
          SET `profile-photo` = ? 
          WHERE id = ?";

// Preparar la consulta
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $file_destiny, $_SESSION['id']);

// Ejecutar la consulta
if ($stmt->execute()) {
    $message = "El archivo ha sido subido";
    $_SESSION['profilePic'] = $file_destiny;
} else {
    $message = "Ha ocurrido un error, inténtelo de nuevo";
}

// Cerrar la consulta
$stmt->close();

// Redireccionar según el tipo de usuario
if ($_SESSION['type_user'] == "admin") {
    echo "<script>alert('$message'); window.location.href = '../admin/admin_personal_page.php?reload=true';</script>";
} else {
    echo "<script>alert('$message'); window.location.href = '../colab/colab_personal_page.php?reload=true';</script>";
}
exit;

