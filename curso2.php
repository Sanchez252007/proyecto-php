<!DOCTYPE html>
<html>
<head>
  <title>Registro</title>
</head>
<body>
  <?php
  $conexion = mysqli_connect("localhost", "root", "123456", "ejemplo1")
    or die("❌ Problemas con la conexión");

  mysqli_query($conexion, "INSERT INTO cursos(nombrecurso) VALUES ('$_REQUEST[nombrecurso]')")
    or die("❌ Problemas al insertar: " . mysqli_error($conexion));

  mysqli_close($conexion);

  echo "✅ El curso fue registrado correctamente.";
  ?>
  <br><br>
  <a href="curso1.html">Volver</a>
</body>
</html>
