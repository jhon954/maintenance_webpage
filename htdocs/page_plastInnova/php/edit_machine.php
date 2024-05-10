<?php
    include("connect.php");
    include("validation_sesion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" &&
        isset($_POST['machine_id']) || isset($_POST['machine_number']) || isset($_POST['brand']) || 
        isset($_POST['model']) || isset($_POST['serial_number']) || isset($_POST['state_machine']) || 
        isset($_POST['description']) || isset($_POST['datasheet_url'])) {

    $machine_id = htmlspecialchars($_POST['machine_id']);
    $machine_number = htmlspecialchars($_POST['machine_number']);
    $machine_brand = htmlspecialchars($_POST['brand']);
    $machine_model = htmlspecialchars($_POST['model']);
    $machine_serial_number = htmlspecialchars($_POST['serial_number']);
    $machine_state = htmlspecialchars($_POST['state_machine']);
    $description = htmlspecialchars($_POST['description']);
    $url_datasheet = htmlspecialchars($_POST['datasheet_url']);

    $query1 = "UPDATE machines SET state=?, brand=?, model=?, serial_number=?, 
                machine_number=?, description=?, datasheet_url=? WHERE id=?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("sssssssi", $machine_state, $machine_brand, $machine_model, 
                $machine_serial_number, $machine_number, $description, $url_datasheet, $machine_id);
                if ($stmt1->execute()) {
        $message = "¡Máquina actualizada!";
    } else {
        $message= "Error al insertar datos: " . $stmt1->error;
    }
    $stmt1->close();
}else{
    $message = "Faltan datos";
}
echo "<script>alert('$message'); window.location.href = '../admin/admin_description_machine.php?machine=".$machine_id."';</script>";
exit();