<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "webuser", "123456Aa@", "ies_horizonte");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = trim($_POST["nombre"] ?? '');
    $apellido = trim($_POST["apellido"] ?? '');
    $etapa    = $_POST["etapa"] ?? '';
    $curso    = $_POST["curso"] ?? '';
    $grupo    = $_POST["grupo"] ?? '';
    $fecha    = $_POST["fecha"] ?? null;

    if ($nombre && $apellido && $etapa && $curso) {
        $stmt = $conexion->prepare("INSERT INTO alumnos (nombre, apellido, etapa, curso, grupo, fecha_nacimiento) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombre, $apellido, $etapa, $curso, $grupo, $fecha);
        if ($stmt->execute()) {
            $mensaje = "✅ Alumno insertado correctamente.";
        } else {
            $mensaje = "❌ Error al insertar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $mensaje = "⚠️ Por favor, rellena todos los campos obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear alumno</title>
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <style>body { font-family: Arial, sans-serif; }</style>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2>➕ Crear nuevo alumno</h2>
    <?php if (isset($mensaje)) echo "<div class='alert alert-info'>$mensaje</div>"; ?>
    <form method="post" class="card p-4 shadow">
      <div class="mb-3">
        <label>Nombre *</label>
        <input type="text" name="nombre" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Apellido *</label>
        <input type="text" name="apellido" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Etapa *</label>
        <select name="etapa" class="form-select" required>
          <option value="">Selecciona etapa</option>
          <option value="Primaria">Primaria</option>
          <option value="ESO">ESO</option>
          <option value="Bachillerato">Bachillerato</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Curso *</label>
        <input type="text" name="curso" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Grupo</label>
        <input type="text" name="grupo" class="form-control">
      </div>
      <div class="mb-3">
        <label>Fecha de nacimiento</label>
        <input type="date" name="fecha" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Crear alumno</button>
      <a href="index.php" class="btn btn-warning ms-2">⬅ Volver al panel</a>
    </form>
  </div>
</body>
</html>
