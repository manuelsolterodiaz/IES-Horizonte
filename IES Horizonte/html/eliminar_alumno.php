<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

$conexion = new mysqli("localhost", "webuser", "123456Aa@", "ies_horizonte");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_alumno"])) {
    $id = $_POST["id_alumno"];
    $sql = "DELETE FROM alumnos WHERE id_alumno = $id";

    $mensaje = $conexion->query($sql)
        ? "✅ Alumno eliminado correctamente."
        : "❌ Error al eliminar: " . $conexion->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Eliminar alumno</title>
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <style>body { font-family: Arial, sans-serif; }</style>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <?php if (isset($mensaje)) echo "<div class='alert alert-info'>$mensaje</div>"; ?>
    <a href="alumnos.php" class="btn btn-warning">⬅ Volver al listado de alumnos</a>
  </div>
</body>
</html>
