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
<div class="container">
    <div class="inner-container flex-c box-s">
        <div class="login-left">
            <img src="../imgs/imagenRegistro.jpg" alt="Imagen de fondo" />
        </div>
        <div class="login-right flex-c">
            <div class="login-right-top">
                <a href="../index.php"><h2>LOGO</h2></a>
                <p class="text-lg">Crea tu cuenta para empezar a crear dietas</p>
            </div>
            <form id="registro-form" class="login-form flex-c" action="../controllers/registroController.php" method="POST">
                <div class="form-name">
                    <input type="text" name="nombre" placeholder="Nombre" />
                    <input type="text" name="apellido" placeholder="Apellido" />
                </div>
                <p class="input-nombre-error input-registro-error no-display">El nombre o apellido no es válido</p>
                <div class="input-div">
                    <input type="email" name="email" placeholder="Correo" />
                    <p class="input-email-error input-registro-error no-display">El correo no es válido</p>
                    <?php 
                    if (isset($_GET['error']) && $_GET['error'] === 'correo_duplicado') {
                        echo '<p class="input-email-error input-error">El correo ya está registrado.</p>';
                    }
                    ?>
                </div>
                <div class="form-nacimiento-sexo">
                    <div class="form-fNacimiento">
                        <label for="f_nacimiento">Fecha Nacimiento</label>
                        <input type="date" name="f_nacimiento" id="f_nacimiento" />
                        <p class="input-fNacimiento-error input-registro-error no-display">La fecha introducida no es válida</p>
                    </div>
                    <div class="form-sexo">
                        <label for="Sexo">Sexo Biológico</label>
                        <select name="sexo" id="sexo">
                            <option value="Hombre" selected>Hombre</option>
                            <option value="Mujer">Mujer</option>
                        </select>
                        <p class="input-fNacimiento-error input-registro-error no-display">El sexo seleccionado no es válido</p>
                    </div>
                </div>
                <div class="peso-altura">
                    <div class="peso">
                        <input type="number" name="peso" id="peso" placeholder="Peso" />
                        <p class="input-peso-error input-registro-error no-display">El peso introducido no es válido</p>
                    </div>
                    <div class="altura">
                        <input type="number" name="altura" id="altura" placeholder="Altura" />
                        <p class="input-altura-error input-registro-error no-display">La altura introducida no es válida</p>
                    </div>
                </div>
                <div>
                    <label for="alergenos">Alergenos</label>
                    <div>
                        <label><input type="checkbox" name="alergenos[]" value="huevo"> Huevo</label>
                        <label><input type="checkbox" name="alergenos[]" value="frutosSecos"> Frutos Secos</label>
                        <label><input type="checkbox" name="alergenos[]" value="lactosa"> Lactosa</label>
                    </div>
                </div>
                <div>
                    <label for="intolerancias">Intolerancias</label>
                    <div>
                        <label><input type="checkbox" name="intolerancias[]" value="lactosa"> Lactosa</label>
                        <label><input type="checkbox" name="intolerancias[]" value="gluten"> Gluten</label>
                        <label><input type="checkbox" name="intolerancias[]" value="NULL"> Ninguna</label>
                    </div>
                </div>
                <div>
                    <label for="enfermedades">Enfermedades</label>
                    <div>
                        <label><input type="checkbox" name="enfermedades[]" value="diabetes"> Diabetes</label>
                        <label><input type="checkbox" name="enfermedades[]" value="hipertension"> Hipertensión</label>
                        <label><input type="checkbox" name="enfermedades[]" value="NULL"> Ninguna</label>
                    </div>
                </div>
                <div class="input-div">
                    <input id="password" type="password" name="password" placeholder="Contraseña" />
                    <p class="input-password-error input-registro-error  no-display">La contraseña debe tener por lo menos 12 carácteres</p>
                    
                </div>
                <div class="input-div">
                    <input id="password2" type="password" name="password2" placeholder="Confirmar Contraseña" />
                    <p class="input-password2-error input-registro-error  no-display">Las contraseñas no coinciden</p>
                </div>
                <p class="form-msg hidden"><i class="fa-solid fa-triangle-exclamation"></i> <strong>Error:</strong> Porfavor, rellena el formulario correctamente.</p>
                <input type="submit" name="registrar" class="btn" value="Registrarse"/>
            </form>
            <p class="text-md">Ya tienes cuenta? <a href="login.php" class="link">Inicia Sesión</a></p>    
        </div>
    </div>
</div>
    <!-- <?php include "../components/footer.html"?> -->
    <script src="../js/loginScript.js"></script>
    <script
      src="https://kit.fontawesome.com/6209fab7df.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>