<?php
// bajaarticulo.php
if (!isset($_REQUEST['codigo']) || !filter_var($_REQUEST['codigo'], FILTER_VALIDATE_INT)) {
  die("Código inválido o no especificado.");
}

$codigo = (int)$_REQUEST['codigo'];

$mysqli = new mysqli("localhost", "root", "123456", "ejemplo1");
if ($mysqli->connect_error) {
  die("Problemas con la conexión a la base de datos: " . $mysqli->connect_error);
}

$stmt = $mysqli->prepare("DELETE FROM articulos WHERE codigo = ?");
if ($stmt === false) {
  die("Error en la preparación de la consulta: " . $mysqli->error);
}

$stmt->bind_param("i", $codigo);
if (!$stmt->execute()) {
  die("Error al eliminar el artículo: " . $stmt->error);
}
$stmt->close();
$mysqli->close();

// Redirigir al listado
header('Location: mantenimientoarticulos.php');
exit;
