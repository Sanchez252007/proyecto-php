<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Eliminar Correo de Alumno</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">Listado de Alumnos (Eliminar Solo el Correo)</h2>

  <?php
  // Conexión a la base de datos
  $conexion = new mysqli("localhost", "root", "123456", "ejemplo1");
  if ($conexion->connect_error) {
      die("<div class='alert alert-danger'>Error de conexión: " . $conexion->connect_error . "</div>");
  }

  // Eliminar solo el correo electrónico si se envió el formulario
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
      $id = intval($_POST["id"]);
      $stmt = $conexion->prepare("UPDATE alumnos SET mail = '' WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {
          echo "<div class='alert alert-success'>Correo electrónico eliminado correctamente.</div>";
      } else {
          echo "<div class='alert alert-warning'>No se pudo eliminar el correo o ya estaba vacío.</div>";
      }

      $stmt->close();
  }

  // Obtener datos de alumnos con nombre de curso
  $query = "
    SELECT a.id, a.nombre, a.mail, c.nombrecurso 
    FROM alumnos a
    LEFT JOIN cursos c ON a.codigocurso = c.codigo
  ";
  $resultado = $conexion->query($query);

  if ($resultado->num_rows > 0) {
      echo "<table class='table table-bordered table-hover'>
              <thead class='table-light'>
                <tr>
                  <th>Nombre</th>
                  <th>Correo Electrónico</th>
                  <th>Curso</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody>";
      while ($fila = $resultado->fetch_assoc()) {
          echo "<tr>
                  <td>" . htmlspecialchars($fila['nombre']) . "</td>
                  <td>" . htmlspecialchars($fila['mail']) . "</td>
                  <td>" . htmlspecialchars($fila['nombrecurso'] ?? 'Desconocido') . "</td>
                  <td>
                    <form method='post' style='display:inline;'>
                      <input type='hidden' name='id' value='" . $fila['id'] . "'>
                      <button type='submit' class='btn btn-danger btn-sm'>Eliminar Correo</button>
                    </form>
                  </td>
                </tr>";
      }
      echo "</tbody></table>";
  } else {
      echo "<div class='alert alert-info'>No hay alumnos registrados.</div>";
  }

  $conexion->close();
  ?>

  <div class="mt-4">
    <a href="index.html" class="btn btn-secondary">Volver al Formulario Principal</a>
  </div>
</div>

</body>
</html>
