<?php
    include("php/conexion.php");
    include("php/validarSesion.php");
    $nicknameA = $_GET['nickname'];
    include("php/datosAmigo.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Red Social</title>
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
        <img src="<?php echo $fotoPerfilA; ?>" alt="Foto de Perfil">
        <h1><?php echo $nombreA.$apellidosA; ?></h1>
        <p><?php echo $descripcionA; ?></p>
    </section>

    <section id="recuadros">
        <h2>Mis amigos</h2>
        <?php
        $consulta = "SELECT * 
                        FROM persona P
                        WHERE P.Nickname in (SELECT A.Nickname2
                                            FROM amistad A
                                            WHERE A.Nickname1 ='$nicknameA')
                        LIMIT 3";
        $datos = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_array($datos)){

        ?>

        <section class="recuadro">
            <img src="<?php echo $fila['FotoPerfil'];?>" alt="imagen" height="150">
            <h2><?php echo $fila['Nombre'] . " " .$fila['Apellidos'];?></h2>
            <p class="parrafo"> <?php echo $fila['Descripcion'];?></p>
            <p>
                <a href="<?php echo "perfil.php?nickname=".$fila['Nickname']; ?>" class="boton">Ver perfil</a><br><br>
            </p>
        </section>
        <?php 
        }
        ?>
    </section>

    <section id="recuadros">
        <h2>Mis fotos</h2>

        <?php
        $consulta = "SELECT * 
                        FROM fotos F
                        WHERE F.Nickname='$nicknameA'
                        LIMIT 3";
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