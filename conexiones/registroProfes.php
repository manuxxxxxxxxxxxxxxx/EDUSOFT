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
$tel = $_POST["Tel"];
$dui = $_POST["DUI"];

//numero de telefono
if (!preg_match("/^[267][0-9]{7}$/", $tel)) {
    die("Número de teléfono inválido. Debe tener 8 dígitos y comenzar con 2, 6 o 7.");
}

// DUI
if (!preg_match("/^\d{8}-\d{1}$/", $dui)) {
    die("DUI inválido. Debe tener el formato ########-#.");
}

$sql ="INSERT INTO profesores(Nombre, Email, Pass, Tel, DUI) VALUES(?,?,?,?,?)";
$stm = $conn->prepare($sql);
$stm->bind_param("sssss", $nombre, $email, $pass_hash, $tel, $dui);



if ($stm->execute()){
    echo"Usuario ingresado";
} else {
    echo"ERROR" . $stm->error;
}

$stm->close();
$conn->close();


?>