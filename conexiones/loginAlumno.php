<?php
session_start();
require_once "../conexiones/conexion.php";

// Validaciones mejoradas

// 1. Método POST obligatorio
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Acceso inválido'); window.history.back();</script>";
    exit;
}

// 2. Validar campos vacíos
$nombre = trim($_POST["Nombre"] ?? '');
$pass = $_POST["Pass"] ?? '';

if ($nombre === '' || $pass === '') {
    echo "<script>alert('Por favor, complete todos los campos.'); window.history.back();</script>";
    exit;
}

// 3. Validación de longitud de nombre (mínimo 2 caracteres, solo letras y espacios)
if (strlen($nombre) < 2 || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ ]+$/', $nombre)) {
    echo "<script>alert('El nombre debe tener al menos 2 letras y no contener números o símbolos.'); window.history.back();</script>";
    exit;
}

// 4. Consulta por nombre (protegido contra SQL Injection)
$sql = "SELECT ID, nombre, pass FROM estudiantes WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $db_nombre, $pass_hash);
    $stmt->fetch();

    // 5. Validar contraseña
    if (password_verify($pass, $pass_hash)) {
        $_SESSION["id_estudiante"] = $id;
        $_SESSION["nombre"] = $db_nombre;
        $_SESSION["rol"] = "estudiante"; 
        // Contraseña nunca se almacena en la sesión ni se muestra

        // SOLO redirige a cursos.php con el nombre
        header("Location: ../cursos.php?bienvenido=" . urlencode($db_nombre));
        exit;
    } else {
        echo "<script>alert('❌ Contraseña incorrecta.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('❌ Nombre no registrado.'); window.history.back();</script>";
    exit;
}

$stmt->close();
$conn->close();
?>