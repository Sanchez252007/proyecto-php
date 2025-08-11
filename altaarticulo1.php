<?php
// altaarticulo1.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Alta de artículo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
body { background-color: #f8f9fa; }
.form-container { max-width: 600px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
.form-title { margin-bottom: 30px; color: #343a40; font-weight: 600; text-align: center; }
</style>
</head>
<body>
<div class="container form-container">
<h2 class="form-title">Alta de artículo</h2>

<?php
$mysqli = new mysqli("localhost", "root", "123456", "ejemplo1");
if ($mysqli->connect_error) {
  die('<div class="alert alert-danger">Problemas con la conexión a la base de datos: ' . $mysqli->connect_error . '</div>');
}
$result = $mysqli->query("SELECT codigo, descripcion FROM rubros");
if (!$result) {
  die('<div class="alert alert-danger">Error al obtener los rubros: ' . $mysqli->error . '</div>');
}
?>

<form method="post" action="altaarticulo2.php" novalidate>
  <div class="mb-3">
    <label for="descripcion" class="form-label">Descripción del artículo</label>
    <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" autofocus placeholder="Ingrese descripción del artículo" />
    <div class="invalid-feedback">Por favor, ingrese una descripción válida.</div>
  </div>

  <div class="mb-3">
    <label for="precio" class="form-label">Precio</label>
    <input type="number" class="form-control" id="precio" name="precio" required min="0" step="0.01" placeholder="Ingrese precio" />
    <div class="invalid-feedback">Por favor, ingrese un precio válido (número positivo).</div>
  </div>

  <div class="mb-4">
    <label for="codigorubro" class="form-label">Seleccione rubro</label>
    <select class="form-select" id="codigorubro" name="codigorubro" required>
      <option value="" selected disabled>Seleccione un rubro</option>
      <?php
      while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['codigo']) . '">' . htmlspecialchars($row['descripcion']) . '</option>';
      }
      $result->free();
      $mysqli->close();
      ?>
    </select>
    <div class="invalid-feedback">Por favor, seleccione un rubro.</div>
  </div>

  <button type="submit" class="btn btn-primary w-100">Confirmar</button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(() => {
  'use strict';
  const forms = document.querySelectorAll('form');
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
