<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dieta</title>
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
    </div>

    <?php include "../components/footer.html"?>
    <script 
        src="https://kit.fontawesome.com/6209fab7df.js"
        crossorigin="anonymous"
    ></script>
</body>
</html>