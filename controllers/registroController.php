<?php 
include_once "conexionLocal.php";
if (!$conexion || $conexion->connect_error) {
    die("Fallo de conexión: " . $conexion->connect_error);
}

$errores = [];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit();

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $correo = trim($_POST["email"] ?? "");
    $sexo = $_POST["sexo"] ?? "Hombre";
    $f_nacimiento = $_POST["f_nacimiento"];
    $edad = 0;
    
    // Encriptar contraseña
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Se Encripta

    

    $errores = [];

    //Validaciones
    if (empty($nombre) || !preg_match("/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s']{2,40}$/", $nombre)) {
        $errores['nombre'] = "El nombre no es válido.";
    }
    if (empty($apellido) || !preg_match("/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s']{2,40}$/", $apellido)) {
        $errores['apellido'] = "El apellido no es válido.";
    }
    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo no es válido.";
    }
    if (strlen($password) < 12) {
        $errores['password'] = "La contraseña debe tener al menos 12 caracteres.";
    }
    if (!empty($f_nacimiento)) {
        // Calcular edad
        $fecha_nacimiento = new DateTime($f_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fecha_nacimiento)->y;

        if ($edad < 2 || $edad > 100){
            $errores['edad'] = "La edad no es válida.";
        }
    } else {
        $errores['fNacimiento'] = "La fecha de nacimiento es obligatoria.";
    }

    if(!empty($errores)) {
        foreach ($errores as $error) {
            echo "<p>$error</p>";
        }
    }

    // Consultas
    $query = "INSERT INTO clientes (nombre, apellido, correo, password, edad, sexo) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conexion->prepare($query)) {
        // Se vinculan los parámetros
        $stmt->bind_param("ssssis", $nombre, $apellido, $correo, $hashed_password, $edad, $sexo);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro exitoso";
            header("Location: ../views/perfil.php"); // Redirigir al perfil
            exit();
        } else {
            echo "Error al registrar el usuario. " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }
}

$conexion->close();
?>
    