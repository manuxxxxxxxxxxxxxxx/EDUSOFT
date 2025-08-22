<?php 
$ServerName = "localhost";
$UserName = "root";
$PassWord = "";
$DbName = "edusoft";

$conn = new mysqli($ServerName, $UserName, $PassWord, $DbName);

if($conn->connect_error)
{
    echo "<script>alert('Conexión fallida: " . $conn->connect_error . "');</script>";
    exit;
}

// Validación de acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Acceso inválido.'); window.history.back();</script>";
    exit;
}

// Captura y limpieza de variables
$nombre = trim($_POST["Nombre"] ?? '');
$email = trim($_POST["Email"] ?? '');
$pass = $_POST["Pass"] ?? '';
$tel = trim($_POST["Tel"] ?? '');
$dui = trim($_POST["DUI"] ?? '');

// 1. Validación de campos vacíos
if ($nombre === '' || $email === '' || $pass === '' || $tel === '' || $dui === '') {
    echo "<script>alert('Por favor completa todos los campos.'); window.history.back();</script>";
    exit;
}

// 2. Validación de formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('El correo electrónico no es válido.'); window.history.back();</script>";
    exit;
}

// 3. Validación de contraseña fuerte
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

// 4. Validación de teléfono
if (!preg_match("/^[267][0-9]{7}$/", $tel)) {
    echo "<script>alert('Número de teléfono inválido. Debe tener 8 dígitos y comenzar con 2, 6 o 7.'); window.history.back();</script>";
    exit;
}

// 5. Validación de DUI
if (!preg_match("/^\d{8}-\d{1}$/", $dui)) {
    echo "<script>alert('DUI inválido. Debe tener el formato ########-#.'); window.history.back();</script>";
    exit;
}

// 6. Email ya registrado
$sql_check = "SELECT id FROM profesores WHERE Email = ?";
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

// 7. Hash de la contraseña
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

// 8. Registro
$sql ="INSERT INTO profesores(Nombre, Email, Pass, Tel, DUI) VALUES(?,?,?,?,?)";
$stm = $conn->prepare($sql);
$stm->bind_param("sssss", $nombre, $email, $pass_hash, $tel, $dui);

if ($stm->execute()){
    echo "<script>
        alert('¡Registro exitoso! Bienvenido, $nombre');
        window.location.href = '../Registros/inicioProfes.php';
    </script>";
    exit;
} else {
    echo "<script>alert('ERROR: " . $stm->error . "'); window.history.back();</script>";
}

$stm->close();
$conn->close();

?>