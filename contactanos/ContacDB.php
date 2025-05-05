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
$asunto = $_POST["Asunto"];
$msj = $_POST["Msj"];

$sql ="INSERT INTO contacto(Nombre, Email, Asunto, Msj) VALUES(?,?,?,?)";
$stm = $conn->prepare($sql);
$stm->bind_param("ssss", $nombre, $email, $asunto, $msj);



if ($stm->execute()){
    echo"Mensaje enviado con exito";
    header ("Location: ../contactanos/contacExitoso.php");
} else {
    echo"ERROR" . $stm->error;
}

$stm->close();
$conn->close();


?>