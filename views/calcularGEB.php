<?php
session_start();

$geb = null;
$get = null;
$vct = null;
$error = "";

if (!isset($_SESSION['id_cliente'])) {
    header("Location: views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_cliente = $_SESSION['id_cliente'];
    $actividad = $_POST['actividad'];

    // Definir FA según selección
    $factores = [
        'sedentario' => 1.2,
        'ligera' => 1.4,
        'moderada' => 1.65,
        'intensa' => 2
    ];

    $FA = $factores[$actividad] ?? 1.2;

    // Conectar a la BD
    $conn = new mysqli("localhost", "root", "", "prueba_dietaapp");

    if ($conn->connect_error) {
        $error = "Error de conexión: " . $conn->connect_error;
    } else {
        $sql = "SELECT sexo, edad, peso, talla, peso_ideal FROM datos_cliente WHERE id_cliente = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $stmt->bind_result($sexo, $edad, $peso, $talla, $peso_ideal);

        if ($stmt->fetch()) {
            if ($sexo && $edad > 0 && $peso > 0 && $talla > 0 && $peso_ideal > 0) {
                // GEB (Harris-Benedict)
                if ($sexo === 'masculino') {
                    $geb = 66.5 + (13.75 * $peso) + (5 * $talla) - (6.75 * $edad);
                } else {
                    $geb = 655 + (9.563 * $peso) + (1.850 * $talla) - (4.676 * $edad);
                }

                // GET
                $get = $geb * $FA;

                // VCT (usando peso ideal)
                if ($sexo === 'masculino') {
                    $vct = (66.5 + (13.75 * $peso_ideal) + (5 * $talla) - (6.75 * $edad)) * $FA;
                } else {
                    $vct = (655 + (9.563 * $peso_ideal) + (1.850 * $talla) - (4.676 * $edad)) * $FA;
                }
            } else {
                $error = "Faltan datos del cliente. Asegúrate de haber completado el Estudio Antropométrico.";
            }
        } else {
            $error = "No se encontró al cliente.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Cálculo Energético</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container flex-c">
        <?php include "../components/navbar.php"; ?>

        <div class="generarDieta-container flex-c box-s">
            <div class="generar-left">
                <img src="../imgs/imagenLogin.jpg" alt="Imagen" />
            </div>
            <div class="generar-right">
                <h2>Cálculo Energético</h2>
                <form method="POST">
                    <label for="actividad">Nivel de Actividad:</label>
                    <select name="actividad" id="actividad" required>
                        <option value="sedentario">Sedentario</option>
                        <option value="ligera">Actividad ligera</option>
                        <option value="moderada">Actividad moderada</option>
                        <option value="intensa">Actividad intensa</option>
                    </select>
                    <br><br>
                    <button type="submit" class="btn">Calcular</button>
                </form>

                <?php if ($geb && $get && $vct): ?>
                    <div class="resultados">
                        <p><strong>GEB:</strong> <?= number_format($geb, 2) ?> kcal</p>
                        <p><strong>GET:</strong> <?= number_format($get, 2) ?> kcal</p>
                        <p><strong>VCT (con peso ideal):</strong> <?= number_format($vct, 2) ?> kcal</p>
                    </div>
                <?php elseif (!empty($error)): ?>
                    <p style="color:red;"><?= $error ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
