<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ingreso</title>
</head>
<body>
  <?php
  $conexion = mysqli_connect("localhost", "root", "123456", "ejemplo1");

  if (!$conexion) 
    die("❌ Problemas con la conexión: " . mysqli_connect_error());

  $nombre = $_REQUEST['nombre'];
  $mail = $_REQUEST['mail'];
  $codigocurso = $_REQUEST['codigocurso'];

  $query = "INSERT INTO alumnos(nombre, mail, codigocurso) 
            VALUES ('$nombre', '$mail', $codigocurso)";

  if (mysqli_query($conexion, $query)) {
    echo "✅ El alumno fue registrado correctamente.";
  } else {
    echo "❌ Error al registrar: " . mysqli_error($conexion);
  }

  mysqli_close($conexion);
  ?>
  <br><br>
  <a href="index.html">Volver al formulario</a>
</body>
</html>

