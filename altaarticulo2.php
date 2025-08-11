<?php
// altaarticulo2.php

if (
  !isset($_REQUEST['descripcion'], $_REQUEST['precio'], $_REQUEST['codigorubro']) ||
  !is_string($_REQUEST['descripcion']) ||
  !is_numeric($_REQUEST['precio']) ||
  !filter_var($_REQUEST['codigorubro'], FILTER_VALIDATE_INT)
) {
  die("Datos inválidos o incompletos.");
}

$descripcion = trim($_REQUEST['descripcion']);
$precio = (float)$_REQUEST['precio'];
$codigorubro = (int)$_REQUEST['codigorubro'];

$mysqli = new mysqli("localhost", "root", "123456", "ejemplo1");
if ($mysqli->connect_error) {
  die("Problemas con la conexión a la base de datos: " . $mysqli->connect_error);
}

$stmt = $mysqli->prepare("INSERT INTO articulos (descripcion, precio, codigorubro) VALUES (?, ?, ?)");
if (!$stmt) {
  die("Error en la preparación de la consulta: " . $mysqli->error);
}
$stmt->bind_param("sdi", $descripcion, $precio, $codigorubro);

if (!$stmt->execute()) {
  die("Error al insertar el artículo: " . $stmt->error);
}
$stmt->close();
$mysqli->close();

header("Location: mantenimientoarticulos.php");
exit;
