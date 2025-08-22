<?php 
require_once "../conexiones/conexion.php";

// Validación de acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Acceso inválido.'); window.history.back();</script>";
    exit;
}

// Validación de campos
$nombre = trim($_POST["Nombre"] ?? '');
$email = trim($_POST["Email"] ?? '');
$pass = $_POST["Pass"] ?? '';

// 1. Campos vacíos
if ($nombre === '' || $email === '' || $pass === '') {
    echo "<script>alert('Por favor completa todos los campos.'); window.history.back();</script>";
    exit;
}

// 2. Formato email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('El correo electrónico no es válido.'); window.history.back();</script>";
    exit;
}

// 3. Validación de contraseña: mínimo 6 caracteres, 1 mayúscula, 1 número, 1 especial
if (
    strlen($pass) < 6 ||
    !preg_match('/[A-Z]/', $pass) ||        // al menos una mayúscula
    !preg_match('/\d/', $pass) ||           // al menos un número
    !preg_match('/[\W_]/', $pass)           // al menos un caracter especial
) {
    echo "<script>
        alert('La contraseña debe tener al menos 6 caracteres, una letra mayúscula, un número y un carácter especial.');
        window.history.back();
    </script>";
    exit;
}

// 4. Email ya registrado
$sql_check = "SELECT id FROM estudiantes WHERE Email = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$stmt_check->store_result();
if ($stmt_check->num_rows > 0) {
    echo "<script>alert('Ya existe un usuario registrado con ese correo electrónico.'); window.history.back();</script>";
    $stmt_check->close();
    $conn->close();
    exit;
}
$stmt_check->close();

// 5. Registrar alumno
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

$sql ="INSERT INTO estudiantes(Nombre, Email, Pass) VALUES(?,?,?)";
$stm = $conn->prepare($sql);
$stm->bind_param("sss", $nombre, $email, $pass_hash);

if ($stm->execute()) {
    echo "<script>
        alert('¡Registro exitoso! Bienvenido, $nombre');
        window.location.href = '../Registros/Inicio.php';
    </script>";
    exit;
} else {
    echo "<script>alert('ERROR EN EL USUARIO: " . $stm->error . "'); window.history.back();</script>";
}

$stm->close();
$conn->close();
?>