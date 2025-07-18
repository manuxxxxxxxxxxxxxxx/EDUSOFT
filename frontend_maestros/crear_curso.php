<?php
session_start();
require_once "../conexiones/conexion.php";

// Validar sesión de profesor
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'profesor') {
    header("Location: ../conexiones/loginProfes.php");
    exit;
}

$profesor_id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];
$mensaje = "";

// Si se envió el formulario (POST), procesar:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que vengan los campos
    if (!isset($_POST['nombre_clase'], $_POST['materia']) || empty($_POST['nombre_clase']) || empty($_POST['materia'])) {
        $mensaje = "Faltan campos obligatorios.";
    } else {
        $nombre_clase = $_POST['nombre_clase'];
        $materia = $_POST['materia'];
        $descripcion = $_POST['descripcion'] ?? '';

        // Insertar en base de datos
        $sql = "INSERT INTO clases (nombre_clase, materia, descripcion, profesor_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre_clase, $materia, $descripcion, $profesor_id);

        if ($stmt->execute()) {
            $mensaje = "Clase creada con éxito.";
        } else {
            $mensaje = "Error al crear clase: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Clase</title>
</head>
<body>

    <h2>Bienvenido, Profesor <?php echo htmlspecialchars($nombre); ?></h2>
    <h3>Crear una nueva clase</h3>

    <?php if ($mensaje): ?>
        <p><strong><?php echo $mensaje; ?></strong></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nombre de la clase:</label><br>
        <input type="text" name="nombre_clase" required><br><br>

        <label>Materia:</label><br>
        <select name="materia" required>
            <option value="">-- Selecciona una materia --</option>
            <option value="matematica">Matemática</option>
            <option value="biologia">Biología</option>
            <option value="sociales">Sociales</option>
            <option value="lenguaje">Lenguaje</option>
        </select><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"></textarea><br><br>

        <button type="submit">Crear clase</button>
    </form>

</body>
</html>