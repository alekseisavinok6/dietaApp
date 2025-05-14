<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DietaApp-Perfil</title>
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
  $nombre = $_SESSION['nombre'];
  $inicial = strtoupper(substr($nombre,0,1));
  if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../views/login.php");
    exit();
  }
  ?>
  <div class="container flex-c">
      <?php include "../components/navbar.php"?>
      <div class="profile-container flex-c">
        <!-- IZQUIERDA -->
        <div class="profile-left-container ">
          <div class="profile-icon">
            <?= $inicial ?>
          </div>
          <div class="list-dieta-container box-s">
            <h3 class="dieta-title">Dietas</h3>
            <ul class="list-dieta">
              <li class="dieta-item"><a href="#" class="dieta-link" >Dieta 1</a></li>
              <li class="dieta-item"><a href="#" class="dieta-link">Nombre Dieta</a></li>
              <li class="dieta-item"><a href="#" class="dieta-link">Miércoles</a></li>
              <li class="dieta-item"><a href="#" class="dieta-link">Jueves</a></li>
              <li class="dieta-item"><a href="#" class="dieta-link">Viernes</a></li>
              <li class="dieta-item"><a href="#" class="dieta-link">Sábado</a></li>
              <li class="dieta-item"><a href="#" class="dieta-link">Domingo</a></li>
              <li class="dieta-item"><a href="#" class="dieta-link">28-03-2001</a></li>
            </ul>
          </div>
          <a href="../views/generarDieta.php"><button class="btn btn-lg">Generar Dieta</button></a>
        </div>

        <!-- DERECHA -->
        <div class="profile-right-container">
          <h1>Hola <?= $nombre ?>!</h1>
          <div class="data-profile-container">
            
          </div>
        </div>
      </div>
  </div>

  <?php include "../components/footer.html"?>

  <script
    src="https://kit.fontawesome.com/6209fab7df.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>