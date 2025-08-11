<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Alumnos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card p-4">
      <h2 class="text-center mb-4">Lista de Alumnos Registrados</h2>

<?php
$conexion = new mysqli("localhost", "root", "123456", "ejemplo1");

if ($conexion->connect_error) {
    die("<div class='alert alert-danger'>Error de conexión: " . $conexion->connect_error . "</div>");
}

// Eliminar alumno si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar']) && isset($_POST['codigo'])) {
    $codigo = intval($_POST['codigo']);
    $borrar = $conexion->prepare("DELETE FROM alumnos WHERE codigo = ?");
    $borrar->bind_param("i", $codigo);
    if ($borrar->execute()) {
        echo "<div class='alert alert-success'>Alumno eliminado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al eliminar alumno.</div>";
    }
    $borrar->close();
}

// Filtro por correo (si lo ingresaron)
$filtroCorreo = '';
if (isset($_GET['correo'])) {
    $filtroCorreo = trim($_GET['correo']);
}

// Mostrar formulario de búsqueda
?>

<form method="get" class="mb-4">
  <div class="input-group">
    <input type="email" name="correo" class="form-control" placeholder="Buscar por correo electrónico" value="<?php echo htmlspecialchars($filtroCorreo); ?>">
    <button class="btn btn-primary" type="submit">Buscar</button>
    <a href="EliminarAlumno.php" class="btn btn-secondary">Mostrar Todos</a>
  </div>
</form>

<?php
// Consulta alumnos
$sql = "SELECT alumnos.codigo, alumnos.nombre, alumnos.mail, cursos.nombrecurso
        FROM alumnos
        LEFT JOIN cursos ON alumnos.codigocurso = cursos.codigo";

if (!empty($filtroCorreo)) {
    $sql .= " WHERE alumnos.mail = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $filtroCorreo);
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    $resultado = $conexion->query($sql);
}

// Mostrar resultados
if ($resultado && $resultado->num_rows > 0) {
    echo "<table class='table table-bordered'>
            <thead class='table-secondary'>
              <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Curso</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>";

    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['nombre']) . "</td>
                <td>" . htmlspecialchars($row['mail']) . "</td>
                <td>" . htmlspecialchars($row['nombrecurso'] ?? 'Sin curso') . "</td>
                <td>
                  <form method='post' onsubmit='return confirm(\"¿Estás seguro de eliminar este alumno?\")'>
                    <input type='hidden' name='codigo' value='" . $row['codigo'] . "'>
                    <button type='submit' name='eliminar' class='btn btn-danger btn-sm'>Eliminar</button>
                  </form>
                </td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<div class='alert alert-warning'>No se encontraron alumnos.</div>";
}

$conexion->close();
?>

      <div class="text-center mt-3">
        <a href="index.html" class="btn btn-secondary">Volver al Formulario Principal</a>
      </div>
    </div>
  </div>
</body>
</html>
