<?php
session_start();
require_once "conexiones/conexion.php";

// Verificar que el usuario sea estudiante
if (!isset($_SESSION['id_estudiante']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: ../conexiones/loginAlumno.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo_clase'] ?? '';
    $estudiante_id = $_SESSION['id_estudiante'];

    if (empty($codigo)) {
        echo "<script>alert('Por favor, ingresa un código de clase.'); window.location.href='cursos.php';</script>";
        exit;
    }

    if (!isset($_POST['codigo_clase']) || empty($_POST['codigo_clase'])) {
        die("Error: código de clase no enviado.");
    }
    // Verificar si existe una clase con ese código
    $stmt = $conn->prepare("SELECT id FROM clases WHERE codigo_clase = ?");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        echo "<script>alert('Código de clase no válido.'); window.location.href='cursos.php';</script>";
        exit;
    }

    $clase = $resultado->fetch_assoc();
    $clase_id = $clase['id'];

    // Verificar si el estudiante ya está inscrito
    $stmt_check = $conn->prepare("SELECT * FROM clases_estudiantes WHERE id_clase = ? AND id_estudiante = ?");
    $stmt_check->bind_param("ii", $clase_id, $estudiante_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Ya estás inscrito en esta clase.'); window.location.href='cursos.php';</script>";
        exit;
    }

    // Insertar en tabla intermedia
    $stmt_insert = $conn->prepare("INSERT INTO clases_estudiantes (id_clase, id_estudiante) VALUES (?, ?)");
    $stmt_insert->bind_param("ii", $clase_id, $estudiante_id);

    if ($stmt_insert->execute()) {
        echo "<script>alert('Te has unido a la clase exitosamente.'); window.location.href='cursos.php';</script>";
    } else {
        echo "<script>alert('Ocurrió un error al intentar unirse a la clase.'); window.location.href='cursos.php';</script>";
    }

    $stmt->close();
    $stmt_check->close();
    $stmt_insert->close();
    $conn->close();
}
?>
