<?php 
session_start();

$imc = null;
$pesoIdeal = null;
$clasificacion = "";
$error = "";

if (!isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $peso = floatval($_POST['peso']);
    $talla = floatval($_POST['talla']); // en metros

    if ($peso > 0 && $talla > 0) {
        $imc = $peso / ($talla * $talla);
        $pesoIdeal = $talla * $talla * 22;

        // Clasificación según la OMS
        if ($imc < 18.5) {
            $clasificacion = "Bajo peso";
        } elseif ($imc < 25) {
            $clasificacion = "Normal";
        } elseif ($imc < 30) {
            $clasificacion = "Sobrepeso";
        } elseif ($imc < 35) {
            $clasificacion = "Obesidad I";
        } elseif ($imc < 40) {
            $clasificacion = "Obesidad II";
        } else {
            $clasificacion = "Obesidad mórbida";
        }

        // Guardar en sesión
        $_SESSION['estudio_antropometrico'] = [
            'peso' => $peso,
            'talla' => $talla,
            'imc' => $imc,
            'peso_ideal' => $pesoIdeal,
            'clasificacion' => $clasificacion
        ];

        // Guardar en base de datos
        $id_cliente = $_SESSION['id_cliente'];
        $conn = new mysqli("localhost", "root", "", "prueba_dietaapp");

        if ($conn->connect_error) {
            $error = "Error de conexión: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare("UPDATE datos_cliente SET peso = ?, talla = ?, imc = ?, peso_ideal = ?, clasificacion = ? WHERE id_cliente = ?");
            $stmt->bind_param("ddddsi", $peso, $talla, $imc, $pesoIdeal, $clasificacion, $id_cliente);

            if (!$stmt->execute()) {
                $error = "Error al guardar los datos: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }

    } else {
        $error = "Por favor, introduce valores válidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudio Antropométrico</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <?php include "../components/navbar.php"; ?>

    <div class="generarDieta-container flex-c box-s">
      <div class="generar-left">
        <img src="../imgs/imagenRegistro.jpg" alt="Imagen de fondo" />
      </div>
      <div class="generar-right">
        <a href="<?= BASE_URL ?>index.php" class="logo">
        <img src="<?= BASE_URL ?>imgs/logo2.png" alt="DietaApp Logo" style="height: 60px;"></a>
        <h2>Estudio Antropométrico</h2>
        <form method="POST">
            <label for="peso">Peso (kg):</label>
            <input type="number" step="0.1" name="peso" id="peso" required>
            <br>
            <label for="talla">Talla (m):</label>
            <input type="number" step="0.01" name="talla" id="talla" required>
            <br>
            <button type="submit" class="btn">Calcular</button>
        </form>

        <?php if (isset($_SESSION['estudio_antropometrico'])): ?>
            <div class="resultados">
                <p><strong>IMC:</strong> <?= number_format($_SESSION['estudio_antropometrico']['imc'], 2) ?></p>
                <p><strong>Peso Ideal:</strong> <?= number_format($_SESSION['estudio_antropometrico']['peso_ideal'], 2) ?> kg</p>
                <p><strong>Clasificación:</strong> <?= $_SESSION['estudio_antropometrico']['clasificacion'] ?></p>
                <!-- <p style="color:green;">Datos guardados correctamente.</p> -->
            </div>
        <?php elseif (!empty($error)): ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
