<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de administración</title>
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f0f8ff; font-family: Arial, sans-serif; }
    h1 { color: #0d6efd; }
    .card-option { transition: transform 0.2s; }
    .card-option:hover { transform: scale(1.02); }
    .card-option a { text-decoration: none; color: inherit; }
    .card-option a:visited, .card-option a:active { color: inherit; }
    .card-img-top { height: 150px; object-fit: cover; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="mb-4 text-center">🎓 Panel de administración</h1>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="card card-option shadow">
          <img src="/img/alumnos.png" class="icono" alt="Alumnos">
          <div class="card-body text-center">
            <h5 class="card-title">Gestionar alumnos</h5>
            <a href="alumnos.php" class="btn btn-primary mt-2">Ir</a>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card card-option shadow">
          <img src="/img/registrar.png" class="icono" alt="Registrar">
          <div class="card-body text-center">
            <h5 class="card-title">Registrar notas</h5>
            <a href="notas.php" class="btn btn-success mt-2">Ir</a>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card card-option shadow">
          <img src="/img/ver.png" class="icono" alt="Ver">
          <div class="card-body text-center">
            <h5 class="card-title">Ver notas</h5>
            <a href="ver_notas.php" class="btn btn-info mt-2">Ir</a>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card card-option shadow">
          <img src="/img/salir.png" class="icono" alt="Salir">
          <div class="card-body text-center">
            <h5 class="card-title text-danger">Cerrar sesión</h5>
            <a href="logout.php" class="btn btn-danger mt-2">Salir</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
