<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado del borrado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card p-4">
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreCurso = trim($_POST['nombrecurso']);

    if (empty($nombreCurso)) {
        echo "<div class='alert alert-warning'>Debe ingresar un nombre de curso válido.</div>";
        exit;
    }

    // Conexión
    $conexion = new mysqli("localhost", "root", "123456", "ejemplo1");
    if ($conexion->connect_error) {
        die("<div class='alert alert-danger'>Error de conexión: " . $conexion->connect_error . "</div>");
    }

    // Verificar si existe el curso
    $stmt = $conexion->prepare("SELECT codigo FROM cursos WHERE nombrecurso = ?");
    $stmt->bind_param("s", $nombreCurso);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Existe, borrar
        $delete = $conexion->prepare("DELETE FROM cursos WHERE nombrecurso = ?");
        $delete->bind_param("s", $nombreCurso);
        $delete->execute();

        echo "<div class='alert alert-success'>✅ Curso <strong>" . htmlspecialchars($nombreCurso) . "</strong> eliminado correctamente.</div>";
        $delete->close();
    } else {
        echo "<div class='alert alert-warning'>❌ No se encontró ningún curso con ese nombre.</div>";
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "<div class='alert alert-danger'>Acceso no permitido.</div>";
}
?>
      <div class="text-center mt-3">
        <a href="index.html" class="btn btn-secondary">Volver al Formulario Principal</a>
      </div>
    </div>
  </div>
</body>
</html>
