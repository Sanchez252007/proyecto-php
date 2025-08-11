<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado de la Búsqueda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 50px;
    }
    .container {
      max-width: 800px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card shadow">
      <div class="card-header bg-info text-white">
        <h5 class="mb-0">Resultado de la Búsqueda</h5>
      </div>
      <div class="card-body">
        <?php
        $conexion = mysqli_connect("localhost", "root", "123456", "ejemplo1")
          or die("<div class='alert alert-danger'>❌ Problemas con la conexión.</div>");

        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);

        $registros = mysqli_query($conexion,
          "SELECT codigo, nombre, mail, codigocurso FROM alumnos WHERE nombre LIKE '%$nombre%'")
          or die("<div class='alert alert-danger'>❌ Problemas en el SELECT: " . mysqli_error($conexion) . "</div>");

        if (mysqli_num_rows($registros) > 0) {
          echo '<div class="table-responsive">';
          echo '<table class="table table-bordered table-striped">';
          echo '<thead class="table-dark">';
          echo '<tr><th>Código</th><th>Nombre</th><th>Correo</th><th>Curso</th></tr>';
          echo '</thead><tbody>';

          while ($reg = mysqli_fetch_array($registros)) {
            echo '<tr>';
            echo '<td>' . $reg['codigo'] . '</td>';
            echo '<td>' . htmlspecialchars($reg['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($reg['mail']) . '</td>';
            echo '<td>';
            switch ($reg['codigocurso']) {
              case 1: echo "PHP"; break;
              case 2: echo "ASP"; break;
              case 3: echo "JSP"; break;
              default: echo "Curso desconocido"; break;
            }
            echo '</td>';
            echo '</tr>';
          }

          echo '</tbody></table></div>';
        } else {
          echo "<div class='alert alert-warning'>No se encontraron alumnos con ese nombre.</div>";
        }

        mysqli_close($conexion);
        ?>
        <a href="buscar_nombre.html" class="btn btn-secondary mt-3">Volver</a>
      </div>
    </div>
  </div>
</body>
</html>
