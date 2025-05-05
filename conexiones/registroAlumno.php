<?php 
$ServerName = "localhost";
$UserName = "root";
$PassWord = "";
$DbName = "edusoft";

$conn = new mysqli($ServerName, $UserName, $PassWord, $DbName);

if($conn->connect_error)
{
    die("Conexion fallida" . $conn->connect_error);
}


$nombre = $_POST["Nombre"];
$email = $_POST["Email"];
$pass = $_POST["Pass"];
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

$sql ="INSERT INTO estudiantes(Nombre, Email, Pass) VALUES(?,?,?)";
$stm = $conn->prepare($sql);
$stm->bind_param("sss", $nombre, $email, $pass_hash);



if ($stm->execute()){
    echo"Usuario ingresado";
    header ("Location: ../Registros/Inicio.php");
} else {
    echo"ERROR" . $stm->error;
}

$stm->close();
$conn->close();


?>