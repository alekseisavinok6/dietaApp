<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Generardor de Dieta</title>
    <link rel="stylesheet" href="css/styles.css?v=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <?php 
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    ?>
    <div class="container flex-c">
        <?php include "components/navbar.php"?>

        <header class="banner flex-c">
            <h1>Dieta Inteligente</h1>
            <p>
              Obtén tu dieta saludable <br />
              basada en tus necesidades y objetivos
            </p>
            <div class="two-buttons">
                <a href="#"><button class="btn">Generar Dieta</button></a>
                <a href="#"><button class="btn">Iniciar Sesión</button></a>
            </div>
        </header>

        <div class="home-cards flex-c">
            <div class="card">
                <i class="fa-solid fa-utensils"></i>
                <h3>Personalizada</h3>
                <p>
                    Recibe un plan de alimentación único, creado especificamente para ti
                </p>
            </div>
            <div class="card">
                <i class="fa-solid fa-leaf"></i>
                <h3>Nutritiva</h3>
                <p>
                    Proporcionamos los nutrientes escenciales que tu cuerpo necesita
                </p>
            </div>
            <div class="card">
                <i class="fa-solid fa-microchip"></i>
                <h3>Inteligente</h3>
                <p>Nuestra IA analiza tus datos, necesidades y preferencias</p>
            </div>
        </div>
    </div>
    <?php include "components/footer.html"?>
    <script
      src="https://kit.fontawesome.com/6209fab7df.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>