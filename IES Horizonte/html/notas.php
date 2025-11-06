<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$conexion = new mysqli("localhost", "webuser", "123456Aa@", "ies_horizonte");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_alumno  = $_POST["id_alumno"] ?? '';
    $asignatura = $_POST["asignatura"] ?? '';
    $evaluacion = $_POST["evaluacion"] ?? '';
    $nota       = $_POST["nota"] ?? '';

    if ($id_alumno && $asignatura && $evaluacion && $nota) {
        $stmt = $conexion->prepare("INSERT INTO notas (id_alumno, asignatura, evaluacion, nota) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_alumno, $asignatura, $evaluacion, $nota);
        if ($stmt->execute()) {
            $mensaje = "✅ Nota registrada correctamente.";
        } else {
            $mensaje = "❌ Error al registrar nota: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $mensaje = "⚠️ Todos los campos son obligatorios.";
    }
}

$alumnos = $conexion->query("SELECT id_alumno, nombre, apellido, etapa FROM alumnos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar nota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>body { font-family: Arial, sans-serif; }</style>
  <script>
    function actualizarAsignaturas() {
      const alumnoSelect = document.getElementById("id_alumno");
      const selectedOption = alumnoSelect.selectedOptions[0];
      const etapa = selectedOption?.dataset.etapa;

      if (!etapa) {
        console.warn("No se encontró la etapa del alumno.");
        return;
      }

      fetch("get_asignaturas.php?etapa=" + encodeURIComponent(etapa))
        .then(response => response.json())
        .then(data => {
          const asignaturaSelect = document.getElementById("asignatura");
          asignaturaSelect.innerHTML = "";

          if (data.length === 0) {
            const opt = document.createElement("option");
            opt.textContent = "No hay asignaturas para esta etapa";
            opt.disabled = true;
            asignaturaSelect.appendChild(opt);
          } else {
            data.forEach(asignatura => {
              const opt = document.createElement("option");
              opt.value = asignatura.nombre;
              opt.textContent = asignatura.nombre;
              asignaturaSelect.appendChild(opt);
            });
          }
        })
        .catch(error => {
          console.error("Error al cargar asignaturas:", error);
        });
    }
  </script>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2>📝 Registrar nota</h2>
    <?php if (isset($mensaje)) echo "<div class='alert alert-info'>$mensaje</div>"; ?>
    <form method="post" class="card p-4 shadow">
      <div class="mb-3">
        <label>Alumno *</label>
        <select name="id_alumno" id="id_alumno" class="form-select" onchange="actualizarAsignaturas()" required>
          <option disabled selected>Selecciona un alumno</option>
          <?php while ($a = $alumnos->fetch_assoc()) {
            echo "<option value='{$a["id_alumno"]}' data-etapa='{$a["etapa"]}'>{$a["nombre"]} {$a["apellido"]}</option>";
          } ?>
        </select>
      </div>
      <div class="mb-3">
        <label>Asignatura *</label>
        <select name="asignatura" id="asignatura" class="form-select" required>
          <option>Seleccione un alumno primero</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Evaluación *</label>
        <select name="evaluacion" class="form-select" required>
          <option value="1ª">1ª</option>
          <option value="2ª">2ª</option>
          <option value="3ª">3ª</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Nota *</label>
        <input type="text" name="nota" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">Registrar nota</button>
      <a href="index.php" class="btn btn-warning ms-2">⬅ Volver al panel</a>
    </form>
  </div>
</body>
</html>
