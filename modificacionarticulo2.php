<?php
// modificacionarticulo2.php

if (
  !isset($_POST['codigo'], $_POST['descripcion'], $_POST['precio'], $_POST['codigorubro']) ||
  !filter_var($_POST['codigo'], FILTER_VALIDATE_INT) ||
  !is_numeric($_POST['precio']) ||
  !filter_var($_POST['codigorubro'], FILTER_VALIDATE_INT) ||
  trim($_POST['descripcion']) === ''
) {
  die("Datos inválidos o incompletos.");
}

$codigo = (int)$_POST['codigo'];
$descripcion = trim($_POST['descripcion']);
$precio = (float)$_POST['precio'];
$codigorubro = (int)$_POST['codigorubro'];

$mysqli = new mysqli("localhost", "root", "123456", "ejemplo1");
if ($mysqli->connect_error) {
  die("Problemas con la conexión a la base de datos: " . $mysqli->connect_error);
}

$stmt = $mysqli->prepare("UPDATE articulos SET descripcion = ?, precio = ?, codigorubro = ? WHERE codigo = ?");
if (!$stmt) {
  die("Error en la preparación de la consulta: " . $mysqli->error);
}
$stmt->bind_param("sdii", $descripcion, $precio, $codigorubro, $codigo);
if (!$stmt->execute()) {
  die("Error al actualizar el artículo: " . $stmt->error);
}
$stmt->close();
$mysqli->close();

header("Location: mantenimientoarticulos.php");
exit;
