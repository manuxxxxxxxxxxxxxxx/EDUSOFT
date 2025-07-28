<?php 

require_once "../conexiones/conexion.php";

$nombre = $_POST["Nombre"];
$email = $_POST["Email"];
$pass = $_POST["Pass"];
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

$sql ="INSERT INTO estudiantes(Nombre, Email, Pass) VALUES(?,?,?)";
$stm = $conn->prepare($sql);
$stm->bind_param("sss", $nombre, $email, $pass_hash);



if ($stm->execute()) {
    header("Location: ../Registros/Inicio.php");
    exit;
} else {
    echo " ERROR EN EL USUARIO: " . $stm->error;
}

$stm->close();
$conn->close();
?> 