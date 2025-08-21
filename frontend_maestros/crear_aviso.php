<?php
require_once "../conexiones/conexion.php";
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    die("Acceso denegado.");
}
$profesor_id = $_SESSION["id"];

// Traer clases del profesor para el select
$sql = "SELECT id, nombre_clase, materia FROM clases WHERE profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$res = $stmt->get_result();
$clases = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Procesar el formulario
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_clase = intval($_POST["id_clase"] ?? 0);
    $titulo = trim($_POST["titulo"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $fecha_subida = trim($_POST["fecha_subida"] ?? date("Y-m-d"));

    if (!$id_clase || !$titulo || !$descripcion || !$fecha_subida) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO avisos (id_clase, titulo, descripcion, fecha_subida) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_clase, $titulo, $descripcion, $fecha_subida);
        if ($stmt->execute()) {
            $success = "Aviso creado correctamente.";
        } else {
            $error = "Hubo un error al guardar el aviso.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear aviso | Edusoft</title>
</head>
<body>
    <h2>Crear aviso</h2>
    <?php if ($success): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="id_clase"><b>Clase/Materia:</b></label>
        <select name="id_clase" id="id_clase" required>
            <option value="">Seleccione una clase</option>
            <?php foreach ($clases as $clase): ?>
                <option value="<?= $clase['id'] ?>">
                    <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="titulo"><b>Nombre del aviso:</b></label>
        <input type="text" name="titulo" id="titulo" required><br><br>

        <label for="descripcion"><b>Descripción:</b></label>
        <textarea name="descripcion" id="descripcion" cols="40" rows="4" required></textarea><br><br>

        <label for="fecha_subida"><b>Fecha de subida:</b></label>
        <input type="date" name="fecha_subida" id="fecha_subida" value="<?= date('Y-m-d') ?>" required><br><br>

        <button type="submit">Crear aviso</button>
        <a href="javascript:history.back()">Volver</a>
    </form>
</body>
</html>