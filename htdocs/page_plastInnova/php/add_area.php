<?php

include ("connect.php");
$new_area = $_POST['newAreaName'];


$query1 = "INSERT INTO areas (id) VALUES (?)";
$stmt1 = $conn->prepare($query1);

$stmt1->bind_param("s", $new_area);

if($stmt1->execute()){
    $message = "Nueva área creada";
    $stmt1->close();
}else{
    $message = "Error";
}
echo "<script>alert('$message'); window.location.href = '../admin/admin_areas.php';</script>";

?>