<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$conexion = new mysqli("localhost", "webuser", "123456Aa@", "ies_horizonte");

// Eliminar nota si se envía por POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_nota"])) {
    $id_nota = $_POST["id_nota"];
    $sql = "DELETE FROM notas WHERE id_nota = $id_nota";
    $mensaje = $conexion->query($sql)
        ? "✅ Nota eliminada correctamente."
        : "❌ Error al eliminar nota: " . $conexion->error;
}

// Obtener todas las notas
$notas = $conexion->query("SELECT n.id_nota, n.asignatura, n.evaluacion, n.nota, a.nombre, a.apellido
                           FROM notas n
                           JOIN alumnos a ON n.id_alumno = a.id_alumno");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Notas de alumnos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>body { font-family: Arial, sans-serif; }</style>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2>📚 Notas registradas</h2>
    <?php if (isset($mensaje)) echo "<div class='alert alert-info'>$mensaje</div>"; ?>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Alumno</th><th>Asignatura</th><th>Evaluación</th><th>Nota</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($fila = $notas->fetch_assoc()) { ?>
          <tr>
            <td><?= $fila["nombre"] . " " . $fila["apellido"] ?></td>
            <td><?= $fila["asignatura"] ?></td>
            <td><?= $fila["evaluacion"] ?></td>
            <td><?= $fila["nota"] ?></td>
            <td>
              <form method="post" class="d-inline">
                <input type="hidden" name="id_nota" value="<?= $fila["id_nota"] ?>">
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta nota?')">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <a href="index.php" class="btn btn-warning mt-3">⬅ Volver al panel</a>
  </div>
</body>
</html>
