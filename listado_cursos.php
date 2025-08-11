<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Cursos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
      padding-top: 40px;
    }
    .container {
      max-width: 800px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="mb-4 text-center">Listado de Cursos</h2>

    <?php
    $conexion = mysqli_connect("localhost", "root", "123456", "ejemplo1")
      or die("<div class='alert alert-danger'>❌ Error de conexión</div>");

    $cursos = mysqli_query($conexion, "SELECT codigo, nombrecurso FROM cursos")
      or die("<div class='alert alert-danger'>❌ Problemas al obtener los cursos: " . mysqli_error($conexion) . "</div>");

    echo '<div class="table-responsive">';
    echo '<table class="table table-bordered table-hover">';
    echo '<thead class="table-dark"><tr><th>Código</th><th>Nombre del Curso</th></tr></thead>';
    echo '<tbody>';

    while ($curso = mysqli_fetch_array($cursos)) {
      echo "<tr>";
      echo "<td>" . $curso['codigo'] . "</td>";
      echo "<td>" . $curso['nombrecurso'] . "</td>";
      echo "</tr>";
    }

    echo '</tbody></table></div>';

    mysqli_close($conexion);
    ?>
  </div>
</body>
</html>
