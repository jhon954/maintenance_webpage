<?php

    include("connect.php");
    include("validation_sesion.php");


    $machine_id = $_POST['machine_id'];
    $machine_number = $_POST['machine_number'];
    $machine_brand = $_POST['brand'];
    $machine_model = $_POST['model'];
    $machine_serial_number = $_POST['serial_number'];
    $machine_state = $_POST['state_machine'];
    $description = $_POST['description'];
    $url_datasheet = $_POST['datasheet_url'];

    echo $url_datasheet;

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
    echo "<script>alert('$message'); window.location.href = '../admin/admin_description_machine.php?machine=".$machine_id."';</script>";
?>