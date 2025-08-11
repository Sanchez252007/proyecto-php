<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Alumnos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 40px;
    }
    .container {
      max-width: 900px;
    }
    .table th, .table td {
      vertical-align: middle;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="mb-4 text-center">Listado de Alumnos</h2>

    <?php
      $conexion = mysqli_connect("localhost", "root", "123456", "ejemplo1");

      if (!$conexion) 
        die("❌ Problemas con la conexión: " . mysqli_connect_error());

      $registros = mysqli_query($conexion, "SELECT codigo, nombre, mail, codigocurso FROM alumnos") 
        or die("<div class='alert alert-danger'>❌ Problemas en el select: " . mysqli_error($conexion) . "</div>");

      echo '<div class="table-responsive">';
      echo '<table class="table table-bordered table-hover table-striped">';
      echo '<thead class="table-dark">';
      echo '<tr><th>Código</th><th>Nombre</th><th>Email</th><th>Curso</th></tr>';
      echo '</thead><tbody>';

      while ($reg = mysqli_fetch_array($registros)) {
        echo '<tr>';
        echo '<td>' . $reg['codigo'] . '</td>';
        echo '<td>' . $reg['nombre'] . '</td>';
        echo '<td>' . $reg['mail'] . '</td>';
        echo '<td>';
        switch ($reg['codigocurso']) {
          case 1: echo "PHP"; break;
          case 2: echo "ASP"; break;
          case 3: echo "JSP"; break;
          default: echo "Desconocido"; break;
        }
        echo '</td>';
        echo '</tr>';
      }

      echo '</tbody></table></div>';

      mysqli_close($conexion);
    ?>

    <!-- Botón para volver al formulario -->
    <div class="text-center mt-4">
      <a href="index.html" class="btn btn-primary">Volver al Formulario</a>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
