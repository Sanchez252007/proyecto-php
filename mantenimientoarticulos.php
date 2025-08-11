<?php
// mantenimientoarticulos.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de Artículos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.table thead th { background-color: #ffd040; }
.table tbody td { background-color: #ffdd73; }
</style>
</head>
<body>
<div class="container mt-4">
<h1 class="mb-4 text-center"><i class="bi bi-box-seam"></i> Listado de Artículos</h1>

<?php
$mysqli = new mysqli("localhost", "root", "123456", "ejemplo1");
if ($mysqli->connect_errno) {
  die('<div class="alert alert-danger">Error de conexión a la base de datos: ' . htmlspecialchars($mysqli->connect_error) . '</div>');
}

$sql = "
SELECT
  ar.codigo AS codigoart,
  ar.descripcion AS descripcionart,
  ar.precio,
  ru.descripcion AS descripcionrub
FROM articulos AS ar
INNER JOIN rubros AS ru
  ON ru.codigo = ar.codigorubro
ORDER BY ar.codigo
";

if ($resultado = $mysqli->query($sql)) {
  if ($resultado->num_rows > 0) {
    echo '<div class="table-responsive">';
    echo '<table class="table table-bordered table-hover align-middle">';
    echo '<thead class="text-center">
            <tr>
              <th>Código</th>
              <th>Descripción</th>
              <th>Precio</th>
              <th>Rubro</th>
              <th>Borrar</th>
              <th>Modificar</th>
            </tr>
          </thead><tbody>';
    while ($fila = $resultado->fetch_assoc()) {
      echo '<tr>';
      echo '<td class="text-center">' . htmlspecialchars($fila['codigoart']) . '</td>';
      echo '<td>' . htmlspecialchars($fila['descripcionart']) . '</td>';
      echo '<td class="text-end">$' . htmlspecialchars(number_format($fila['precio'], 2)) . '</td>';
      echo '<td>' . htmlspecialchars($fila['descripcionrub']) . '</td>';
      echo '<td class="text-center">
              <a href="bajaarticulo.php?codigo=' . urlencode($fila['codigoart']) . '"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm(\'¿Está seguro de borrar este artículo?\')">
                <i class="bi bi-trash"></i> Borrar
              </a>
            </td>';
      echo '<td class="text-center">
              <a href="modificacionarticulo1.php?codigo=' . urlencode($fila['codigoart']) . '"
                 class="btn btn-sm btn-warning">
                <i class="bi bi-pencil-square"></i> Modificar
              </a>
            </td>';
      echo '</tr>';
    }
    echo '<tr>
            <td colspan="6" class="text-center">
              <a href="altaarticulo1.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Agregar un nuevo artículo
              </a>
            </td>
          </tr>';
    echo '</tbody></table></div>';
  } else {
    echo '<div class="alert alert-info text-center"><i class="bi bi-info-circle"></i> No hay artículos registrados.</div>';
  }
  $resultado->free();
} else {
  echo '<div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> Error en la consulta: ' . htmlspecialchars($mysqli->error) . '</div>';
}
$mysqli->close();
?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
