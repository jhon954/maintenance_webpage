<?php
// Include the database connection file
include("connect.php");

// Check if all required fields are set
if(isset($_POST['area_id'], $_POST['state_machine'], $_POST['machine_number'], $_POST['brand'], $_POST['model'], $_POST['serial_number'], $_POST['description'])) {
    // Retrieve and sanitize input data
    $id_area = htmlspecialchars($_POST['area_id']);
    $state_machine = htmlspecialchars($_POST['state_machine']);
    $number_machine = htmlspecialchars($_POST['machine_number']);
    $brand_machine = htmlspecialchars($_POST['brand']);
    $model_machine = htmlspecialchars($_POST['model']);
    $serial_number_machine = htmlspecialchars($_POST['serial_number']);
    $description_machine = htmlspecialchars($_POST['description']);

    // Prepare the SQL query with parameter binding
    $query1 = "INSERT INTO machines (state, brand, serial_number, model, machine_number, description, id_area) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt1 = $conn->prepare($query1);

    // Bind parameters
    $stmt1->bind_param("ssssiss", $state_machine, $brand_machine, $serial_number_machine, $model_machine, $number_machine, $description_machine, $id_area);

    // Execute the statement
    if($stmt1->execute()) {
        // If successful, set success message
        $message = "Nueva máquina creada";
    } else {
        // If execution fails, set error message
        $message = "Error al crear la máquina";
    }

    // Close the statement
    $stmt1->close();
} else {
    // If any required field is missing, set error message
    $message = "Todos los campos son obligatorios";
}

// Redirect back to admin_machines.php with the message
echo "<script>alert('$message'); window.location.href = '../admin/admin_machines.php?area={$id_area}';</script>";
?>
