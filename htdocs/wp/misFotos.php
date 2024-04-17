<?php
    include("php/conexion.php");
    include("php/validarSesion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Mis Fotos</title>
</head>
<body>
    <header>
        <div id="logo">
            <img src="images/logo.jpeg" alt="logo">
        </div>
        
        <nav class="menu">
            <ul>
                <li><a href="miPerfil.php">Mi perfil</a></li>
                <li><a href="misAmigos.php">Mis amigos</a></li>
                <li><a href="misFotos.php">Mis fotos</a></li>
                <li><a href="buscarAmigos.php">Buscar amigos</a></li>
                <li><a href="php/cerrarSesion.php">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </header>

    <section id="perfil">
        <img src="<?php echo $_SESSION['fotoPerfil']; ?>" alt="Foto de Perfil">
        <h1><?php echo $_SESSION['nombre'].$_SESSION['apellidos']; ?></h1>

        <form action="php/cambiarFoto.php" method="POST" enctype="multipart/form-data">Cambiar foto de perfil:
            <input type="file" name="archivo" id="archivo" accept=".jpeg, .jpg, .png" required>
            <input type="submit" name="subir" value="Subir">
        </form>
    </section>

    <section id="recuadros">
        
        <h2>Mis fotos</h2>

        <h3>
            <form action="php/subirFoto.php" method="POST", enctype="multipart/form-data"> Añadir imagen:
                <input type="file" name="archivo" id="archivo" accept=".jpeg, .jpg, .png" required>
                <input type="submit" name="subir" value="Subir">
            </form>
        </h3>

        <?php
        $consulta = "SELECT * 
                        FROM fotos F
                        WHERE F.Nickname='$nickname'";
        $datos = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_array($datos)){

        ?>

        <section class="recuadro">
            <img src="<?php echo $fila['NombreFoto']?>" alt="imagen" height="200" width="280">
        </section>
        <?php 
        }
        ?>

    </section>

    <footer>
        <p>Copyrigth</p>
    </footer>
</body>
</html>