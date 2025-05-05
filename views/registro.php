<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DietaApp-Registrarse</title>
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
            <img src="../imgs/imagenRegistro.jpg" alt="Imagen de fondo" />
        </div>
        <div class="login-right box-s">
            <a href="../index.php"><h2>LOGO</h2></a>
            <p class="text-lg">Crea tu cuenta para empezar a crear dietas</p>
            <form id="registro-form" class="login-form flex-c" action="" method="POST"> <!-- Cambia la acción al controlador correspondiente -->
                <!-- Quitar required y agregar validación en js -->
                 <div class="form-name">
                    <input type="text" name="nombre" placeholder="Nombre" />
                    <input type="text" name="apellido" placeholder="Apellido" />
                </div>
                <p class="input-nombre-error input-registro-error hidden">El nombre o apellidos no es válido</p>
                <div class="input-div">
                    <input type="email" name="email" placeholder="Correo" />
                    <p class="input-email-error input-error hidden">El correo no es válido</p>
                    </div>
                 <div class="form-fNacimiento">
                    <label for="f_nacimiento">Fecha Nacimiento</label>
                    <input type="date" name="f_nacimiento" id="f_nacimiento" />
                 </div>
                 <p class="input-fNacimiento-error input-registro-error hidden">La fecha introducida no es válida</p>
                 <div class="form-sexo">
                    <label for="Sexo">Sexo Biológico</label>
                    <select name="sexo" id="sexo">
                        <option value="Hombre" selected>Hombre</option>
                        <option value="Mujer">Mujer</option>
                    </select>
                </div>
                 <div class="input-div">
                    <input id="password" type="password" name="password" placeholder="Contraseña" />
                    <p class="input-password-error input-error hidden">La contraseña debe tener por lo menos 12 carácteres</p>
                 </div>
                 <div class="input-div">
                     <input id="password2" type="password" name="password2" placeholder="Confirmar Contraseña" />
                     <p class="input-password2-error input-error hidden">Ambas contraseñas deben ser iguales</p>
                 </div>
                 <p class="form-msg hidden"><i class="fa-solid fa-triangle-exclamation"></i> <strong>Error:</strong> Porfavor, rellena el formulario correctamente.</p>
                 <input type="submit" class="btn" value="Registrarse"/>
            </form>
            <p class="text-md">Ya tienes cuenta? <a href="login.php" class="link">Inicia Sesión</a></p>    
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