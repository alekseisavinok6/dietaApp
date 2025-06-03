<?php 
include_once "conexionLocal.php";
session_start();
$id = $_SESSION['id_cliente'];

// Datos previos del cliente
$VCT = $_SESSION['VCT'] ?? 2000; // Valor calórico total
$pesoIdeal = $_SESSION['peso_ideal'] ?? 70;
$clasificacion = $_SESSION['clasificacion'] ?? '';
$IMC = $_SESSION['IMC'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nivelActividad = (float)($_POST["nivelActividad"] ?? 1.65);
    $objetivo = $_POST["objetivo"] ?? "mantenerPeso";
    $comidasDias = (int)($_POST["comidasDias"] ?? 3);
    $preferencias = $_POST["preferencias"] ?? "";
    $comentario = trim($_POST["comentario"] ?? "");

    $errores = [];

    if (!in_array($nivelActividad, [1.2, 1.4, 1.65, 2])) {
        $errores["nivelActividad"] = "El nivel de actividad no es válido.";
    }
    if (!in_array($objetivo, ["mantenerPeso", "subirPeso", "bajarPeso"])) {
        $errores['objetivo'] = "El objetivo no es válido.";
    }
    if (!in_array($comidasDias, [3, 4, 5])) {
        $errores['comidasDias'] = "El número de comidas al día no es válido.";
    }

    if (empty($errores)) {
        // Calorías objetivo ajustadas por el objetivo del cliente
        switch ($objetivo) {
            case 'subirPeso':    $caloriasObjetivo = $VCT + 300; break;
            case 'bajarPeso':    $caloriasObjetivo = $VCT - 500; break;
            default:             $caloriasObjetivo = $VCT; break;
        }

        $caloriasPorComida = round($caloriasObjetivo / $comidasDias);

        $platosDisponibles = [];

$sqlPlatos = "SELECT * FROM platos WHERE objetivo = ?";
$stmtPlatos = $conexion->prepare($sqlPlatos);
$stmtPlatos->bind_param("s", $objetivo);
$stmtPlatos->execute();
$resultPlatos = $stmtPlatos->get_result();

while ($plato = $resultPlatos->fetch_assoc()) {
    $idPlato = $plato['id_plato'];
    $platoNombre = $plato['nombre'];
    $platoCalorias = $plato['calorias_totales'];

    // Obtener ingredientes para este plato
    $sqlIngredientes = "
        SELECT i.nombre, i.nutriente_principal, i.alergenos, 
               i.calorias_por_porcion, i.peso_por_porcion, 
               i.medida_porcion, pi.cantidad_porcion
        FROM ingredientes i
        INNER JOIN plato_ingredientes pi ON i.id_ingrediente = pi.id_ingrediente
        WHERE pi.id_plato = ?
    ";
    $stmtIng = $conexion->prepare($sqlIngredientes);
    $stmtIng->bind_param("i", $idPlato);
    $stmtIng->execute();
    $resultIng = $stmtIng->get_result();

    $ingredientes = [];
    while ($ing = $resultIng->fetch_assoc()) {
        $ingredientes[] = [
            "nombre" => $ing['nombre'],
            "nutriente" => $ing['nutriente_principal'],
            "alergenos" => $ing['alergenos'],
            "valorCalorico" => $ing['calorias_por_porcion'],
            "peso" => $ing['peso_por_porcion'],
            "medida" => $ing['cantidad_porcion'] ?? $ing['medida_porcion']
        ];
    }

    $platosDisponibles[] = [
        "nombre" => $platoNombre,
        "calorias" => $platoCalorias,
        "ingredientes" => $ingredientes
    ];
}

if (empty($platosDisponibles)) {
    $_SESSION['error'] = "No se encontraron platos disponibles para el objetivo seleccionado.";
    header("Location: ../views/generarDieta.php");
    exit();
}

        // Distribuir platos a comidas
        $nombresComidas = ["Desayuno", "Almuerzo", "Cena", "Merienda", "Snack"];
        $dieta = [];
        for ($i = 0; $i < $comidasDias; $i++) {
            $plato = $platosDisponibles[$i % count($platosDisponibles)];
            $dieta[$nombresComidas[$i]] = [
                "total_calorias" => $plato['calorias'],
                "platos" => [ [ "nombre" => $plato['nombre'], "ingredientes" => $plato['ingredientes'] ] ]
            ];
        }

        $_SESSION['dieta_generada'] = [
            "descripcion" => "Dieta personalizada basada en tus datos: IMC $IMC ($clasificacion), peso ideal $pesoIdeal kg y VCT ajustado de $caloriasObjetivo kcal para $comidasDias comidas.",
            "comidas" => $dieta
        ];

        header("Location: ../views/dieta.php");
        exit();
    }
}
$conexion->close();
