<?php
include("connect.php");
$old_id_area = htmlspecialchars($_POST['old_area_id']);
$new_id_area = htmlspecialchars($_POST['new_area_id']);

$query1 = "UPDATE areas SET area_name=? WHERE id=?";
$stmt1 = $conn->prepare($query1);

$stmt1->bind_param("ss", $new_id_area, $old_id_area);

if($stmt1->execute()){
    $message = "Nueva área creada";
    $stmt1->close();
}else{
    $message = "Error";
}
echo "<script>alert('$message'); window.location.href = '../admin/admin_areas.php';</script>";
exit();