<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario Dietista</title>
</head>
<body>
  <h2>Formulario de Información Médica</h2>
  <form action="bdd.php" name="" method="post">
    <label for="Nombre">Nombre:</label><br>
    <input type="text" id="Nombre" name="Nombre" required><br><br>
    
    <label for="Password">Contraseña:</label><br>
    <input type="text" id="Password" name="Password" required><br><br>
    
    <label for="Correo">Correo:</label><br>
    <input type="email" id="Correo" name="Correo" required><br><br>

    <label for="fecha">Edad:</label><br>
    <input type="date" id="fecha" name="fecha" min="0" required><br><br>

    <label for="Sexo">Sexo:</label><br>
    <select id="Sexo" name="Sexo" required>
      <option value="">Seleccione</option>
      <option value="femenino">Femenino</option>
      <option value="masculino">Masculino</option>
      <option value="otro">Otro</option>
    </select><br><br>

<label for="Alergenos">Alérgenos:</label><br>
<select id="Alergenos" name="Alergenos[]" multiple size="4">
    <option value="Gluten">Gluten</option>
    <option value="Lactosa">Lactosa</option>
    <option value="Polen">Polen</option>
    <option value="Frutos secos">Frutos secos</option>
</select><br><br>

<label for="Enfermedades">Enfermedades:</label><br>
<select id="Enfermedades" name="Enfermedades[]" multiple size="4">
    <option value="Diabetes">Diabetes</option>
    <option value="Hipertensión">Hipertensión</option>
    <option value="Asma">Asma</option>
    <option value="Obesidad">Obesidad</option>
</select><br><br> <!-- ← este cierre es clave -->

<input type="submit" value="Enviar">
  </form>
</body>
</html>
