<?php
session_start();
require_once "../conexiones/conexion.php";

// Verificar sesión activa de profesor
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../conexiones/loginProfes.php");
    exit;
}

$profesor_id = $_SESSION["id"];

// Obtener las clases del profesor
$sql = "SELECT id, nombre_clase, materia FROM clases WHERE profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$res = $stmt->get_result();

$clases = [];
while ($fila = $res->fetch_assoc()) {
    $clases[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Subir Material</title>
  <link rel="stylesheet" href="prueba.css"> <!-- O usa tu propio estilo -->
</head>
<body>
  <div class="task-modal">
    <div class="task-header">
      <span class="task-title">Material de Estudio</span>
      <button class="task-close" onclick="cerrarModal()">✕</button>
    </div>

    <form class="task-form" action="procesar_material.php" method="POST" enctype="multipart/form-data">
      <div class="task-row">
        <label for="id_clase">Selecciona una clase:</label>
        <select name="id_clase" required>
          <option value="">-- Selecciona una clase --</option>
          <?php foreach ($clases as $clase): ?>
            <option value="<?= $clase['id'] ?>">
              <?= htmlspecialchars($clase['nombre_clase']) . " – " . ucfirst($clase['materia']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="task-row">
        <label for="titulo">Título del material:</label>
        <input type="text" name="titulo" required>
      </div>

      <div class="task-row">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" rows="3"></textarea>
      </div>

      <div class="task-row">
        <label for="archivo">Archivo:</label>
        <input type="file" name="archivo" required>
      </div>

      <div class="task-row task-actions">
        <button type="submit" class="btn submit-btn">Subir material</button>
      </div>
    </form>
  </div>

  <script>
    function cerrarModal() {
      document.querySelector('.task-modal').style.display = 'none';
    }
  </script>
</body>
</html>
