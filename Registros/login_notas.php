<?php
session_start();
require_once "../conexiones/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $pass = trim($_POST['contraseña']);

    // Buscar en profesores
    $sql_prof = "SELECT id, nombre, pass FROM profesores WHERE nombre = ?";
    $stmt_prof = $conn->prepare($sql_prof);
    $stmt_prof->bind_param("s", $nombre);
    $stmt_prof->execute();
    $res_prof = $stmt_prof->get_result();

    if ($row = $res_prof->fetch_assoc()) {
        if (password_verify($pass, $row['pass'])) {
            $_SESSION["id"] = $row['id'];
            $_SESSION["nombre"] = $row['nombre'];
            $_SESSION["rol"] = "profesor";
            header("Location: ../principal/sistema_notas_profes.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        // Buscar en estudiantes
        $sql_al = "SELECT ID, nombre, pass FROM estudiantes WHERE nombre = ?";
        $stmt_al = $conn->prepare($sql_al);
        $stmt_al->bind_param("s", $nombre);
        $stmt_al->execute();
        $res_al = $stmt_al->get_result();

        if ($row = $res_al->fetch_assoc()) {
            if (password_verify($pass, $row['pass'])) {
                $_SESSION["id_estudiante"] = $row['ID'];
                $_SESSION["nombre"] = $row['nombre'];
                $_SESSION["rol"] = "alumno";
                header("Location: ../principal/sistema_notas_alumno.php");
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Notas</title>
    <style>
        body {font-family: Arial, sans-serif;}
        .login-box {margin:120px auto;max-width:350px;padding:30px;border-radius:8px;box-shadow:0 2px 16px #aaa;}
        input {margin-bottom:12px;width:100%;padding:8px;}
        button {width:100%;padding:10px;background:#0a59a8;color:white;border:none;}
    </style>
</head>
<body>
<div class="login-box">
    <h2>Iniciar Sesión</h2>
    <?php if(isset($error)): ?>
        <div style="color:red;margin-bottom:10px;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="nombre" placeholder="Usuario" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</div>
</body>
</html>