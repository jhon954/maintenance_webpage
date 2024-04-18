<?php

include("connect.php");

$old_id_area = $_GET['area'];


$query1 = "UPDATE areas SET id=? WHERE id=?";
$stmt1 = $conn->prepare($query1);

$stmt1->bind_param("ss", $new_area);

if($stmt1->execute()){
    $message = "Nueva área creada";
    $stmt1->close();
}else{
    $message = "Error";
}
echo "<script>alert('$message'); window.location.href = '../admin/admin_areas.php';</script>";

?>