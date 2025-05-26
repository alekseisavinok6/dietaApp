<?php 
include_once "conexionLocal.php";
session_start();
$id = $_SESSION['id_cliente'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        $cliente = $conexion->prepare("SELECT edad, sexo, altura, peso, peso_deseado, enfermedades, alergias, intolerancias FROM clientes WHERE id_cliente = ?");
        $cliente->bind_param("i", $id);
        $cliente->execute();
        $cliente->bind_result($edad, $sexo, $altura, $peso, $peso_deseado, $enfermedades, $alergias, $intolerancias);
        $cliente->fetch();
        $cliente->close();

        $_SESSION['dieta_generada'] = [
            "descripcion" => "Dieta equilibrada de prueba para mantener el peso con $comidasDias comidas al día.",
            "comidas" => [
                "Desayuno" => [
                    "total_calorias" => 400,
                    "platos" => [[
                        "nombre" => "Avena con frutas",
                        "ingredientes" => [
                            ["nombre" => "Avena", "nutriente" => "Carbohidrato", "alergenos" => "Gluten", "valorCalorico" => 150, "peso" => "40g", "medida" => "media taza"],
                            ["nombre" => "Plátano", "nutriente" => "Carbohidrato", "alergenos" => "Ninguno", "valorCalorico" => 90, "peso" => "100g", "medida" => "1 unidad"],
                            ["nombre" => "Leche", "nutriente" => "Proteína", "alergenos" => "Lácteos", "valorCalorico" => 160, "peso" => "200ml", "medida" => "1 vaso"]
                        ]
                    ]]
                ],
                "Almuerzo" => [
                    "total_calorias" => 600,
                    "platos" => [[
                        "nombre" => "Ensalada de pollo",
                        "ingredientes" => [
                            ["nombre" => "Pechuga de pollo", "nutriente" => "Proteína", "alergenos" => "Ninguno", "valorCalorico" => 200, "peso" => "150g", "medida" => "1 filete"],
                            ["nombre" => "Lechuga", "nutriente" => "Fibra", "alergenos" => "Ninguno", "valorCalorico" => 30, "peso" => "50g", "medida" => "1 taza"],
                            ["nombre" => "Aceite de oliva", "nutriente" => "Grasa saludable", "alergenos" => "Ninguno", "valorCalorico" => 90, "peso" => "10g", "medida" => "1 cucharada"]
                        ]
                    ]]
                ],
                "Cena" => [
                    "total_calorias" => 500,
                    "platos" => [[
                        "nombre" => "Tortilla de verduras",
                        "ingredientes" => [
                            ["nombre" => "Huevos", "nutriente" => "Proteína", "alergenos" => "Huevo", "valorCalorico" => 200, "peso" => "100g", "medida" => "2 unidades"],
                            ["nombre" => "Calabacín", "nutriente" => "Fibra", "alergenos" => "Ninguno", "valorCalorico" => 50, "peso" => "100g", "medida" => "1 taza"],
                            ["nombre" => "Cebolla", "nutriente" => "Fibra", "alergenos" => "Ninguno", "valorCalorico" => 30, "peso" => "50g", "medida" => "media unidad"]
                        ]
                    ]]
                ]
            ]
        ];

        header("Location: ../views/dieta.php");
        exit();
    }
}
$conexion->close();
?>
