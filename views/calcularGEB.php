<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Calcular GEB</title>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
    rel="stylesheet"
  />
</head>
<body>
  <div class="container">
    <?php include "../components/navbar.php"; ?>

    <div class="generarDieta-container flex-c box-s">
      <div class="generar-left">
        <img src="../imgs/imagenLogin.jpg" alt="Imagen de fondo" />
      </div>
      <div class="generar-right">
        <a href="<?= BASE_URL ?>index.php" class="logo">
        <img src="<?= BASE_URL ?>imgs/logo2.png" alt="DietaApp Logo" style="height: 60px;"></a>
        
        <p class="text-lg">Introduce tus datos para calcular tu Gasto Energético Basal (GEB)</p>

        <form method="POST" class="generar-form">
          <input type="number" name="peso" placeholder="Peso (kg)" required step="0.1">
          <input type="number" name="talla" placeholder="Talla (cm)" required>
          <input type="number" name="edad" placeholder="Edad (años)" required>
          <input type="submit" name="calcular" value="Calcular GEB" class="btn">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["calcular"])) {
            $peso = floatval($_POST["peso"]);
            $talla = floatval($_POST["talla"]);
            $edad = intval($_POST["edad"]);

            // Fórmula de Harris-Benedict para hombres (ajustar si tienes el sexo disponible)
            $geb = 66.5 + (13.75 * $peso) + (5 * $talla) - (6.75 * $edad);
            $_SESSION['geb'] = round($geb, 2);
            $id_cliente = $_SESSION['id_cliente'];

            // Conexión a la base de datos
            $conn = new mysqli("localhost", "root", "", "prueba_dietaapp");

            if ($conn->connect_error) {
              echo "<p style='color: red;'>Error de conexión: " . $conn->connect_error . "</p>";
            } else {
              // Eliminar datos previos del mismo cliente si ya existen
              $conn->query("DELETE FROM datos_cliente WHERE id_cliente = $id_cliente");

              // Insertar nuevos datos
              $stmt = $conn->prepare("INSERT INTO datos_cliente (id_cliente, peso, talla, edad, geb) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("iddid", $id_cliente, $peso, $talla, $edad, $geb);

              if ($stmt->execute()) {
                  echo "<p class='text-lg' style='margin-top: 1rem; color: green;'>
                          <strong>Tu GEB es:</strong> {$_SESSION['geb']} kcal/día
                        </p>";
              } else {
                  echo "<p style='color: red;'>Error al guardar en base de datos: " . $stmt->error . "</p>";
              }

              $stmt->close();
              $conn->close();
            }
        }
        ?>
      </div>
    </div>
  </div>

  <?php include "../components/footer.html"; ?>
</body>
</html>
