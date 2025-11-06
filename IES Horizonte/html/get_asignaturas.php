<?php
$conexion = new mysqli("localhost", "webuser", "123456Aa@", "ies_horizonte");

$etapa = $_GET["etapa"] ?? '';
$etapa = $conexion->real_escape_string($etapa);

$resultado = $conexion->query("SELECT nombre FROM asignaturas WHERE etapa = '$etapa'");
$asignaturas = [];

while ($fila = $resultado->fetch_assoc()) {
  $asignaturas[] = $fila;
}

header("Content-Type: application/json");
echo json_encode($asignaturas);
