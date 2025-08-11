<?php
// modificacionarticulo1.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Modificación de artículo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container my-5">
<h2 class="mb-4 text-center">Modificación de artículo</h2>

<?php
if (!isset($_REQUEST['codigo']) || !filter_var($_REQUEST['codigo'], FILTER_VALIDATE_INT)) {
  echo '<div class="alert alert-danger text-center">Código inválido o no especificado.</div>';
  exit;
}
$codigo = (int)$_REQUEST['codigo'];

$mysqli = new mysqli("localhost", "root", "123456", "ejemplo1");
if ($mysqli->connect_error) {
  echo '<div class="alert alert-danger text-center">Problemas con la conexión a la base de datos: ' . htmlspecialchars($mysqli->connect_error) . '</div>';
  exit;
}

$stmt = $mysqli->prepare("SELECT descripcion, precio, codigorubro FROM articulos WHERE codigo = ?");
$stmt->bind_param("i", $codigo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($reg = $resultado->fetch_assoc()):
?>

<form method="post" action="modificacionarticulo2.php" class="needs-validation" novalidate>
  <div class="mb-3">
    <label for="descripcion" class="form-label">Descripción del artículo</label>
    <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100"
           value="<?php echo htmlspecialchars($reg['descripcion']); ?>">
    <div class="invalid-feedback">Por favor, ingrese una descripción válida.</div>
  </div>

  <div class="mb-3">
    <label for="precio" class="form-label">Precio</label>
    <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" required
           value="<?php echo htmlspecialchars($reg['precio']); ?>">
    <div class="invalid-feedback">Por favor, ingrese un precio válido (número positivo).</div>
  </div>

  <div class="mb-4">
    <label for="codigorubro" class="form-label">Rubro</label>
    <select class="form-select" id="codigorubro" name="codigorubro" required>
      <option value="" disabled>Seleccione un rubro</option>
      <?php
      $registros2 = $mysqli->query("SELECT codigo, descripcion FROM rubros");
      while ($reg2 = $registros2->fetch_assoc()):
        $selected = ($reg2['codigo'] == $reg['codigorubro']) ? "selected" : "";
      ?>
        <option value="<?php echo htmlspecialchars($reg2['codigo']); ?>" <?php echo $selected; ?>>
          <?php echo htmlspecialchars($reg2['descripcion']); ?>
        </option>
      <?php endwhile; ?>
    </select>
    <div class="invalid-feedback">Por favor, seleccione un rubro.</div>
  </div>

  <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">
  <button type="submit" class="btn btn-primary w-100">Confirmar</button>
</form>

<?php
else:
  echo '<div class="alert alert-warning text-center">No existe un artículo con dicho código.</div>';
endif;
$stmt->close();
$mysqli->close();
?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>
</body>
</html>
