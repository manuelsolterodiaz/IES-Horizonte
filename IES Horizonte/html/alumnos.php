<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

$conexion = new mysqli("localhost", "webuser", "123456Aa@", "ies_horizonte");
$resultado = $conexion->query("SELECT * FROM alumnos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de alumnos</title>
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <style>body { font-family: Arial, sans-serif; }</style>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2>👨‍🎓 Listado de alumnos</h2>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th><th>Nombre</th><th>Apellido</th><th>Etapa</th><th>Curso</th><th>Grupo</th><th>Fecha</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
          <tr>
            <td><?= $fila["id_alumno"] ?></td>
            <td><?= $fila["nombre"] ?></td>
            <td><?= $fila["apellido"] ?></td>
            <td><?= $fila["etapa"] ?></td>
            <td><?= $fila["curso"] ?></td>
            <td><?= $fila["grupo"] ?></td>
            <td><?= $fila["fecha_nacimiento"] ?></td>
            <td>
              <form action="eliminar_alumno.php" method="post" class="d-inline">
                <input type="hidden" name="id_alumno" value="<?= $fila["id_alumno"] ?>">
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <a href="crear_alumno.php" class="btn btn-success">➕ Añadir alumno</a>
    <a href="index.php" class="btn btn-warning ms-2">⬅ Volver al panel</a>
  </div>
</body>
</html>
