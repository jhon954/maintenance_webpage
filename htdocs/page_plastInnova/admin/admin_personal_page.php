<?php
    include("../php/validation_sesion.php");
    include("../php/connect.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colaborador</title>
     <!-- Bootstrap CSS -->
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <link href="../css/styles_nav_bar.css" rel="stylesheet">
     <link href="../css/styles_personal_page.css" rel="stylesheet">
     <!-- Bootstrap JS -->
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
                <section class="logo-container">
                    <img src="../img/images_page/login.png" alt="Logo" class="logo">
                </section>
            <?php 
            include_once 'admin_nav_header.php';
            $activePage = basename($_SERVER['PHP_SELF']);
            renderNavbar($activePage);
            ?>
        </nav>
    </header>
    <section class="container mt-5">
        <section class="row">
            <section class="col-md-3">
                <img src="<?php echo $_SESSION['profilePic'];?>" class="img-fluid profile-image" alt="Foto de perfil">
                <form action="../php/change_profile.php" method="POST" enctype="multipart/form-data">
                    <section class="form-group">
                        <label for="archivo">Seleccionar nueva foto:</label>
                        <input type="file" class="form-control-file" id="archivo" name="archivo" accept=".jpeg, .jpg, .png" required>
                    </section>
                    <button type="submit" class="button">Subir</button>
                </form>
            </section>
            <section class="col-md-9">
                <section class="profile-info">
                    <section class="profile-info-item">
                        <span class="profile-info-label">Título:</span>
                        <span class="profile-info-value"><?php echo $_SESSION['job_title']?></span>
                    </section>
                    <section class="profile-info-item">
                        <span class="profile-info-label">Nombre:</span>
                        <span class="profile-info-value"><?php echo $_SESSION['name']." ". $_SESSION['surname']?></span>
                    </section>
                    <section class="profile-info-item">
                        <span class="profile-info-label">Nickname:</span>
                        <span class="profile-info-value"><?php echo $_SESSION['nickname']?></span>
                    </section>
                </section>
            </section>
    </section>
</body>
</html>