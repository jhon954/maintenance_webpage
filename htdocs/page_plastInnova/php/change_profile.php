<?php
include("connect.php");
include("validation_sesion.php");

$ub = "../img/profiles/".$_SESSION['id'];

if (!is_dir($ub)) {
    mkdir($ub, 0777, true);
}

$file_tmp = $_FILES['archivo']['tmp_name'];
$file_destiny = $ub."/profile.jpg";

list($width_orig, $heigth_orig) = getimagesize($file_tmp);
$width_new = 300;
$heigth_new = 300;

$new_image = imagecreatetruecolor($width_new, $heigth_new);
$orig_image = imagecreatefromjpeg($file_tmp);

imagecopyresampled($new_image, $orig_image, 0, 0, 0, 0, $width_new, $heigth_new, $width_orig, $heigth_orig);

imagejpeg($new_image, $file_destiny);

imagedestroy($new_image);
imagedestroy($orig_image);

$query = "UPDATE collaborators 
          SET `profile-photo` = ?
          WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $file_destiny, $_SESSION["id"]);
if ($stmt->execute()) {
    $message = "El archivo ha sido subido";
    $_SESSION['profilePic'] = $file_destiny;
} else {
    $message = "Ha ocurrido un error, inténtelo de nuevo";
}
$stmt->close();

if ($_SESSION['type_user'] == "admin") {
    echo "<script>alert('$message'); window.location.href = '../admin/admin_personal_page.php?reload=true';</script>";
} else {
    echo "<script>alert('$message'); window.location.href = '../colab/colab_personal_page.php?reload=true';</script>";
}
exit;

