<?php
// Conexión a la base de datos
include_once "../controllers/conexionLocal.php";

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los campos están definidos y no están vacíos
    if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
    } else {
        $errores['nombre'] = 'El nombre es obligatorio';
    }

    if (isset($_POST['apellido']) && !empty($_POST['apellido'])) {
        $apellido = $_POST['apellido'];
    } else {
        $errores['apellido'] = 'El apellido es obligatorio';
    }

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];
        // Validación de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'El correo no es válido';
        }
    } else {
        $errores['email'] = 'El correo es obligatorio';
    }

    if (isset($_POST['f_nacimiento']) && !empty($_POST['f_nacimiento'])) {
        $f_nacimiento = $_POST['f_nacimiento'];
    } else {
        $errores['fNacimiento'] = 'La fecha de nacimiento es obligatoria';
    }

    if (isset($_POST['sexo']) && !empty($_POST['sexo'])) {
        $sexo = $_POST['sexo'];
    } else {
        $errores['sexo'] = 'El sexo es obligatorio';
    }

    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
        // Encriptar contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $errores['password'] = 'La contraseña es obligatoria';
    }

    if (isset($_POST['password2']) && !empty($_POST['password2'])) {
        $password2 = $_POST['password2'];
        // Verificar que las contraseñas coincidan
        if ($password !== $password2) {
            $errores['password2'] = 'Las contraseñas no coinciden';
        }
    } else {
        $errores['password2'] = 'La confirmación de contraseña es obligatoria';
    }

    // Si no hay errores, guardar en la base de datos
    if (count($errores) === 0) {
        // Calcular la edad a partir de la fecha de nacimiento
        $fechaNacimiento = new DateTime($f_nacimiento);
        $hoy = new DateTime();
        $edad = $fechaNacimiento->diff($hoy)->y;

        // Preparar la consulta para insertar los datos
        $stmt = $conexion->prepare("INSERT INTO clientes (nombre, apellido, correo, contraseña, edad, sexo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssds", $nombre, $apellido, $email, $passwordHash, $edad, $sexo);

        if ($stmt->execute()) {
            // Redirigir si todo está correcto
            header("Location: ../views/login.php");
            exit();
        } else {
            $errores['general'] = 'Hubo un problema al registrar el usuario';
        }
    }
}

// Si hay errores, volver al formulario
include '../views/registro.php';
?>