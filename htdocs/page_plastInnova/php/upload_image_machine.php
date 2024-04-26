<?php
    include("connect.php");
    include("validation_sesion.php");

    $id_machine = htmlspecialchars($_POST['machine_id']);

    $img_dir_machine = "../img/machines/machineid{$id_machine}";

    if(!empty($_FILES['image_machine']['name'])){
        $temp = $_FILES['image_machine']['tmp_name'];
        $file_name = $_FILES['image_machine']['name'];

        $file_name = 'image_machine'.$id_machine.'.jpg';

        move_uploaded_file($temp, $img_dir_machine."/".$file_name);

        $query1 = "UPDATE machines SET image_path=? WHERE id=?";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bind_param("si", $file_name,$id_machine);
        if ($stmt1->execute()) {
            $message = "¡Imagen actualizada!";
        } else {
            $message= "Error al insertar datos: " . $stmt1->error;
        }
        $stmt1->close();

    }else{
        $message = "Error, suba la imagen";
    }
    echo "<script>alert('$message'); window.location.href = '../admin/admin_description_machine.php?machine=".$id_machine."';</script>";
