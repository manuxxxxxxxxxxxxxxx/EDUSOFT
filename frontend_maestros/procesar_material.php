<?php
session_start();
require_once "../conexiones/conexion.php";

// Verifica si se envió el formulario correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar que vienen los campos necesarios
    if (!isset($_POST["id_clase"]) || !isset($_POST["titulo"]) || !isset($_POST["descripcion"])) {
        die("Faltan datos requeridos.");
    }

    $id_clase = $_POST["id_clase"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];

    // Verificar si se subió un archivo
    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
        $archivo = $_FILES["archivo"];
        $nombreArchivo = basename($archivo["name"]);
        $rutaDestino = "../materiales_subidos/" . $nombreArchivo;

        // Crear carpeta si no existe
        if (!file_exists("../materiales_subidos")) {
            mkdir("../materiales_subidos", 0777, true);
        }

        // Mover archivo al directorio de materiales
        if (move_uploaded_file($archivo["tmp_name"], $rutaDestino)) {
            // Guardar información en la base de datos
            $query = "INSERT INTO materiales_estudio (id_clase, titulo, descripcion, archivo, ruta_archivo, fecha_subida)
                      VALUES (?, ?, ?, ?, ?, NOW())";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("issss", $id_clase, $titulo, $descripcion, $nombreArchivo, $rutaDestino);

            if ($stmt->execute()) {
                echo "✅ Material subido correctamente.";
            } else {
                echo "❌ Error al guardar en la base de datos.";
            }

            $stmt->close();
        } else {
            echo "❌ Error al mover el archivo.";
        }
    } else {
        echo "❌ No se ha subido ningún archivo o hubo un error.";
    }

    $conn->close();
} else {
    echo "⚠️ Acceso no autorizado.";
}
?>