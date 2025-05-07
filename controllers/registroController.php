<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include "conexionLocal.php";

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = trim($_POST["nombre"] ?? "");
        $apellido = trim($_POST["apellido"] ?? "");
        $correo = trim($_POST["email"] ?? "");
        $sexo = $_POST["sexo"] ?? "Hombre";
        $f_nacimiento = $_POST["f_nacimiento"];
        $edad = 0;
        $password = trim($_POST["password"]);
        $password2 = trim($_POST["password2"]);
        
        // VERIFICAR QUE EL CORREO NO ESTÉ REGISTRADO
        // SI ESTÁ REGISTRADO, NO MANDA NADA A LA BBDD PERO TE REDIRIGE A UNA PAGINA DE ERROR 
        // (INVESTIGAR FETCH PARA PODER MOSTRAR MENSAJES DE ERROR EN EL FORMULARIO)
        $consultaCorreo = $conexion->prepare("SELECT id_cliente FROM clientes WHERE correo = ?");
        $consultaCorreo->bind_param("s",$correo);
        $consultaCorreo->execute();
        $consultaCorreo->store_result();
        if($consultaCorreo->num_rows > 0) {
            header("Location: ../views/registro.php?error=correo_duplicado");
           $errores['correo'] = "El correo ya está registrado.";
           exit();
        }
        $consultaCorreo->close();

        $errores = [];
        //VALIDACIONES
        if (empty($nombre) || !preg_match("/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s']{2,40}$/", $nombre)) {
            $errores['nombre'] = "El nombre o apellido no es válido.";
        }
        if( empty($apellido) || !preg_match("/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s']{2,40}$/", $apellido)) {
            $errores['apellido'] = "El nombre o apellido no es válido.";
        }
        if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores['correo'] = "El correo no es válido.";
        }
        if ($sexo !== "Hombre" && $sexo !== "Mujer") {
            $errores['sexo'] = "El sexo no es válido.";
        }
        if (empty($f_nacimiento)) {
            $errores['fNacimiento'] = "La fecha de nacimiento es obligatoria.";
        } else {
            // CALCULAR EDAD
            $fecha_nacimiento = new DateTime($f_nacimiento);
            $hoy = new DateTime();
            $edad = $hoy->diff($fecha_nacimiento)->y;

            if ($edad < 2 || $edad > 100) {
                $errores['edad'] = "La edad no es válida.";
            }
        }
        // VALIDACION Y ENCRIPTACIÓN DE CONTRASEÑA
        // AGREGAR MÁS SEGURIDAD (MAYUSCULAS, NÚMEROS, CARACTERES ESPECIALES)
        if (strlen($password) < 12) {
            $errores['password'] = "La contraseña debe tener al menos 12 caracteres.";
        }
        if ($password !== $password2) {
            $errores['password2'] = "Las contraseñas no coinciden.";
        } 
        if (!isset($errores['password']) && !isset($errores['password2'])) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        if(empty($errores)) {
            $stmt = $conexion->prepare("INSERT INTO clientes(nombre, apellido, correo, password, edad, sexo) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssis", $nombre, $apellido, $correo, $password, $edad, $sexo);
            $resultado = $stmt->execute();
            if ($resultado) {
                echo "<p>Registro exitoso</p>";
                header("Location: ../views/perfil.php");
                exit();
            } else {
                echo "<p>Error al registrar el usuario: " . $conexion->error . "</p>";
            }
        } else {
            foreach ($errores as $error) {
                echo "<p>$error</p>";
            }
        }
        // $consulta = "INSERT INTO clientes(nombre, apellido, correo, password, edad, sexo) VALUES ('$nombre', '$apellido', '$correo', '$password', '$edad', '$sexo')";
        // $resultado = $conexion->query($consulta);
        // NO HACERLO ASÍ POR QUE ES VULNERABLE A INYECCIÓN SQL
    }
$conexion->close();
?>