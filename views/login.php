<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DietaApp-Login</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
      rel="stylesheet"
    />
</head>
<body>
    <div class="container-r flex-c">
        <div class="login-left box-s">
            <img src="../imgs/imagenLogin.jpg" alt="Imagen de fondo" />
        </div>
        <div class="login-right box-s">
            <a href="../index.php"><h2>LOGO</h2></a>
            <h3>Bienvenido!</h3>
            <p class="text-lg">Inicia sesión para acceder a tus dietas <br> personalizadas</p>
            <form id="login-form" class="login-form flex-c" action="../controllers/loginController.php" method="POST"> <!-- Cambia la acción al controlador correspondiente -->
                <div class="input-div">
                    <input type="email" name="email" placeholder="Correo"  />
                    <p class="input-email-error input-error hidden">El correo no es válido</p>
                </div>
                <div class="input-div">
                    <input type="password" name="password" placeholder="Contraseña"  />
                    <p class="input-password-error input-error hidden">La contraseña debe tener por lo menos 12 carácteres</p>
                </div>
                <p class="input-login-error input-error hidden">El email o la contraseña no es correcta</p>
                <p class="form-msg hidden"><i class="fa-solid fa-triangle-exclamation"></i> <strong>Error:</strong> Porfavor, rellena el formulario correctamente.</p>
                <input type="submit" class="btn" value="Iniciar Sesión"/>
            </form>
            <?php
            include("../controllers/loginRegistro.php");
            ?>
            </p>
            <p class="text-md">No tienes cuenta? <a href="registro.php" class="link">Registrate</a></p>
            <p class="text-md"><a href="#" class="link">¿Has olvidado la contraseña?</a></p>    
        </div>
    </div>
    <?php include "../components/footer.html"?>
    <script src="../js/loginScript.js"></script>
    <script
      src="https://kit.fontawesome.com/6209fab7df.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>