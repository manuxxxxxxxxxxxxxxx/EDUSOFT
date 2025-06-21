<?php 

require_once "../conexiones/conexion.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
$nombre = $_POST["nombre"];
$materia = $_POST["materia"];
$anio = $_POST["anio"];
$contrasena = bin2hex(random_bytes(4));

$sql = "INSERT INTO profesores (nombre, materia, anio, contrasena) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssis", $nombre, $materia, $anio, $contrasena);
$stmt->execute();
echo "<p>Profesor agregado. Contraseña: <strong>$contrasena</strong></p>";
}

if ($stm->execute()){
    echo"Usuario ingresado";
} else {
    echo"ERROR" . $stm->error;
}

$stm->close();
$conn->close();


?>