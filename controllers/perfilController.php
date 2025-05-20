<?php
    include_once "conexionLocal.php";
    session_start();
    $id = $_SESSION['id_cliente'];

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $altura = (int)$_POST["altura"];
        $peso = (int)$_POST["peso"];
        $pesoDeseado = (int)$_POST["pesoDeseado"];
        
        $errores = [];

        if(!empty($altura)){
            $stmt = $conexion->prepare("UPDATE clientes SET altura = ? WHERE id_cliente = ?");
            $stmt->bind_param("ii", $altura, $id);
            $stmt->execute();
        }
        if(!empty($peso)){
            $stmt = $conexion->prepare("UPDATE clientes SET peso = ? WHERE id_cliente = ?");
            $stmt->bind_param("ii", $peso, $id);
            $stmt->execute();
        }
        if(!empty($pesoDeseado)){
            $stmt = $conexion->prepare("UPDATE clientes SET peso_deseado = ? WHERE id_cliente = ?");
            $stmt->bind_param("ii", $pesoDeseado, $id);
            $stmt->execute();
        }
        

        header("Location: ../views/perfil.php");
        exit;
    }
?>