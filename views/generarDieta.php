<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Generar Dieta</title>
  <link rel="stylesheet" href="../css/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
      rel="stylesheet"
    />
</head>
<body>
  <?php
    session_start();
    if (!isset($_SESSION['id_cliente'])) {
      header("Location: ../views/login.php");
      exit();
    }
  ?>
  <div class="container">
    <?php include "../components/navbar.php"?>
    <div class="generarDieta-container flex-c box-s">
      <div class="generar-left">
        <img src="../imgs/imagenLogin.jpg" alt="Imagen de fondo" />
      </div>
      <div class="generar-right">
        <a class="login-top" href="../index.php"><h2>LOGO</h2></a>
        <p class="text-lg">Envia el formulario con tus preferencias para generar una dieta.</p>
        <form class="generar-form" id="generar-form" action="../controllers/generarDietaController.php" method="POST">
        
          <div class="actividad">
            <label for="nivelActividad">Nivel de Actividad Física:</label>
            <select name="nivelActividad" id="nivelActividad">
              <option value="1.2">Inactiva</option>
              <option value="1.4">Ligera</option>
              <option value="1.65" selected>Moderada</option>
              <option value="2">Intensa</option>
            </select>
          </div>
          <div class="objetivo">
            <label for="objetivo">Objetivo:</label>
            <select name="objetivo" id="objetivo">
              <option value="subirPeso">Subir Peso</option>
              <option value="mantenerPeso" selected>Mantener Peso</option>
              <option value="bajarPeso">Bajar Peso</option>
            </select>
          </div>
          <div class="comidasDia">
            <label for="">Número de comidas al día:</label>
            <select name="comidasDias" id="comidasDias">
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
          <div class="preferencias">
            <label for="preferencias">Preferencias (opcional):</label>
            <select name="preferencias" id="preferencias">
              <option value=""></option>
              <option value="vegetariana">Vegetariana</option>
              <option value="vegana">Vegana</option>
              <option value="cetogenica">Cetogénica</option>
              <option value="sinGluten">Sin glúten</option>
            </select>
          </div>
          <div class="comentario">
            <label for="comentario">Comentario (opcional):</label>
            <textarea name="comentario" id="comentario" placeholder="Ejemplo: No me gusta el atún"></textarea>
          </div>
          <p class="form-msg hidden"><i class="fa-solid fa-triangle-exclamation"></i> <strong>Error:</strong> Porfavor, rellena el formulario correctamente.</p>
          <input type="submit" value="Generar" name="generarDieta" class="btn">
        </form>
      </div>
    </div>
    
  </div>

  <?php include "../components/footer.html"?>
  <script src="../js/generarDietaScript.js"></script>
  <script
    src="https://kit.fontawesome.com/6209fab7df.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>
