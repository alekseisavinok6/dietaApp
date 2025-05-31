<?php
session_start();

if (!isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
$geb = $get = $vct = null;
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $factor_actividad = floatval($_POST['factor_actividad']);

    $conn = new mysqli("localhost", "root", "", "prueba_dietaapp");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener datos del cliente
    $sql = "SELECT sexo, edad, peso, talla, peso_ideal FROM datos_cliente WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $sexo = strtolower($row['sexo']);
        $edad = $row['edad'];
        $peso = $row['peso'];
        $talla = $row['talla']; // en metros
        $peso_ideal = $row['peso_ideal'];

        // Calcular GEB
        if ($sexo === 'masculino') {
            $geb = 66.5 + (13.75 * $peso) + (5 * ($talla * 100)) - (6.75 * $edad);
        } elseif ($sexo === 'femenino') {
            $geb = 655 + (9.563 * $peso) + (1.850 * ($talla * 100)) - (4.676 * $edad);
        } else {
            $mensaje = "Sexo no válido registrado.";
        }

        // Calcular GET
        if ($geb !== null) {
            $get = $geb * $factor_actividad;
        }

        // Calcular VCT (usando peso ideal)
        if ($peso_ideal !== null) {
            if ($sexo === 'masculino') {
                $vct = (66.5 + (13.75 * $peso_ideal) + (5 * ($talla * 100)) - (6.75 * $edad)) * $factor_actividad;
            } elseif ($sexo === 'femenino') {
                $vct = (655 + (9.563 * $peso_ideal) + (1.850 * ($talla * 100)) - (4.676 * $edad)) * $factor_actividad;
            }
        }

        // Guardar en sesión
        $_SESSION['calculo_energetico'] = [
            'geb' => $geb,
            'get' => $get,
            'vct' => $vct
        ];

        // Guardar en base de datos
        $update = $conn->prepare("UPDATE datos_cliente SET geb = ?, `get` = ?, vct = ? WHERE id_cliente = ?");
        $update->bind_param("dddi", $geb, $get, $vct, $id_cliente);
        $update->execute();

        // if ($update->execute()) {
        //     $mensaje = "Cálculos realizados y guardados correctamente.";
        // } else {
        //     $mensaje = "Error al guardar los datos: " . $update->error;
        // }

        $update->close();
    } else {
        $mensaje = "No se encontraron datos del cliente.";
    }

    $stmt->close();
    $conn->close();
}

    if ($geb === null && isset($_SESSION['calculo_energetico'])) {
        $geb = $_SESSION['calculo_energetico']['geb'];
        $get = $_SESSION['calculo_energetico']['get'];
        $vct = $_SESSION['calculo_energetico']['vct'];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calcular GEB, GET y VCT</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <?php include "../components/navbar.php"; ?>
        <div class="generarDieta-container flex-c box-s">
        <div class="generar-left">
            <img src="../imgs/img1.jpg" alt="Imagen de fondo" />
        </div>
        <div class="generar-right">
        <a href="<?= BASE_URL ?>index.php" class="logo">
        <img src="<?= BASE_URL ?>imgs/logo2.png" alt="DietaApp Logo" style="height: 60px;"></a>

        <h2>Calcular GEB, GET y VCT</h2>

        <form method="POST">
            <label for="factor_actividad">Nivel de Actividad:</label>
            <select name="factor_actividad" id="factor_actividad" required>
                <option value="1.2">Sedentario</option>
                <option value="1.4">Actividad ligera</option>
                <option value="1.65">Actividad moderada</option>
                <option value="2">Actividad intensa</option>
            </select>
            <br><br>
            <button type="submit" class="btn">Calcular</button>
        </form>

        <?php if ($geb !== null && $get !== null && $vct !== null): ?>
            <div class="resultados">
                <p><strong>GEB:</strong> <?= number_format($geb, 2) ?> kcal</p>
                <p><strong>GET:</strong> <?= number_format($get, 2) ?> kcal</p>
                <p><strong>VCT (con peso ideal):</strong> <?= number_format($vct, 2) ?> kcal</p>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensaje)): ?>
            <p style="color:<?= strpos($mensaje, 'Error') !== false ? 'red' : 'green' ?>;"><?= $mensaje ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
