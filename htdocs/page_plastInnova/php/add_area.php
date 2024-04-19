<?php
// Include the database connection file
include("connect.php");

// Check if the new area name is provided and not empty
if(isset($_POST['newAreaName']) && !empty($_POST['newAreaName'])) {
    // Sanitize the input to prevent SQL injection
    $new_area = htmlspecialchars($_POST['newAreaName']);

    // Prepare the SQL query with parameter binding
    $query = "INSERT INTO areas (id) VALUES (?)";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bind_param("s", $new_area);

    // Execute the statement
    if($stmt->execute()) {
        // If successful, set success message
        $message = "Nueva área creada";
    } else {
        // If execution fails, set error message
        $message = "Error al crear el área";
    }

    // Close the statement
    $stmt->close();
} else {
    // If new area name is not provided, set error message
    $message = "Nombre de área no válido";
}

// Redirect back to admin_areas.php with the message
echo "<script>alert('$message'); window.location.href = '../admin/admin_areas.php';</script>";
?>
