<?php
include("connect.php");

$id_area = $_POST['area_id'];
$state_machine = $_POST['state_machine'];
$number_machine = $_POST['machine_number'];
$brand_machine = $_POST['brand'];
$model_machine = $_POST['model'];
$serial_number_machine = $_POST['serial_number'];
$description_machine = $_POST['description'];

echo $id_area;

$query1= "INSERT INTO machines (state, brand, serial_number, model,machine_number, 
        description, id_area) VALUES (?,?,?,?,?,?,?)";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("ssssiss", $state_machine, $brand_machine, $serial_number_machine, $model_machine,
                    $number_machine, $description_machine, $id_area);

if($stmt1->execute()){
    $message = "Nueva máquina creada";
    $stmt1->close();
}else{
    $message = "Error";
}
echo "<script>alert('$message'); window.location.href = '../admin/admin_machines.php?area={$id_area}';</script>";


?>