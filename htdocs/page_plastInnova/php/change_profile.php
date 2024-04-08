<?php
    include("connect.php");
    include("validation_sesion.php");

    $ub = "../img/profiles/".$_SESSION['id'];

    if (!is_dir($ub)) {
        mkdir($ub, 0777, true); // 0777 permite todos los permisos
    }

    $archivo = $_FILES['archivo']['tmp_name'];

    $ub = "../img/profiles/".$_SESSION['id']."/profile.jpg";

    $query1 = "UPDATE collaborators 
                SET `profile-photo` = '$ub' 
                WHERE id = " . $_SESSION['id'];

    if(move_uploaded_file($archivo, $ub) && mysqli_query($conn, $query1)){
        if($_SESSION['type_user'] == "admin"){
            echo "El archivo ha sido subido";
            header('Location: ../admin/personal_page_admin.php');
        }else{
            echo "El archivo ha sido subido";
            header('Location: ../colab/personal_page.php');
        }
    }else{
        if($_SESSION['type_user'] == "admin"){
            echo "Ha ocurrido un error, trate de nuevo";
            header('Location: ../admin/personal_page_admin.php');
        }else{
            echo "Ha ocurrido un error, trate de nuevo";
            #header('Location: ../colab/personal_page.php');
        }
    }

?>