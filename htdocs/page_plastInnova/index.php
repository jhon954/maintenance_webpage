<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS personalizado -->
    <link href="css/styles_login.css" rel="stylesheet">
    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="scripts/validation_error_login.js"></script>
</head>
<body>
    <section class="container">
        <section class="row justify-content-center login-container">
            <section class="col-md-6">
                <section class="card">
                    <section class="card-header">
                        <img src="img/images_page/login.png" class="img-fluid mb-3" alt="Logo">
                        <h3 class="text-center">Iniciar Sesión</h3>
                    </section>
                    <section class="card-body">
                        <form action="php/login.php" method="POST">
                            <section class="form-group">
                                <label for="nickname">Usuario</label>
                                <input type="text" class="form-control" id="nickname" name="nickname" required>
                                <span id="userError" style="display: none;">Usuario no encontrado</span>
                            </section>
                            <section class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <span id="passwordError" style="display: none;">Contraseña incorrecta</span>
                                <span id="inactiveError" style="display: none;">Contraseña Inactivo</span>
                            </section>
                            <section class="form-group">
                                <button type="button" onclick="login()" class="btn btn-block btn-login">Iniciar Sesión</button>
                            </section>
                        </form>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- <p class="leonardo-credit">Imagen proporcionada por <a href="https://leonardo.ai/" target="_blank">Leonardo AI</a></p> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <footer>
        <p>&copy; 2024 <em>JFM</em></p>
    </footer>
</body>
</html>