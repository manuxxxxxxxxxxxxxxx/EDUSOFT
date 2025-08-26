<?php
session_start();
require_once "../conexiones/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["id_clase"], $_POST["titulo"], $_POST["descripcion"])) {
        die("Faltan datos requeridos.");
    }

    $id_clase = $_POST["id_clase"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];

    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
        $archivo = $_FILES["archivo"];
        $nombreArchivo = basename($archivo["name"]);
        $rutaDestino = "../materiales_subidos/" . $nombreArchivo;

        if (!file_exists("../materiales_subidos")) {
            mkdir("../materiales_subidos", 0777, true);
        }

        if (move_uploaded_file($archivo["tmp_name"], $rutaDestino)) {
            $query = "INSERT INTO materiales_estudio (id_clase, titulo, descripcion, archivo, ruta_archivo, fecha_subida)
                    VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("issss", $id_clase, $titulo, $descripcion, $nombreArchivo, $rutaDestino);

            if ($stmt->execute()) {
                // Redireccionamos al panel de profesor con id_clase para ver el material subido
                header("Location: ../frontend_maestros/subir_material.php?id_clase=" . $id_clase . "&exito=1");
                exit;
            } else {
                die("Error al guardar en la base de datos: " . $stmt->error);
            }
        } else {
            die("Error al mover el archivo.");
        }
    } else {
        die("No se ha subido ningún archivo o hubo un error.");
    }
} else {
    die("Acceso no autorizado.");
}
