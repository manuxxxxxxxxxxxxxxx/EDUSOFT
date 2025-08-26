<?php
session_start();
require_once '../conexiones/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_clase = $_POST['id_clase'];
    $ruta_imagen = null;

    // Si subió un archivo
    if (isset($_FILES['imagen_materia']) && $_FILES['imagen_materia']['error'] === UPLOAD_ERR_OK) {
        $archivo = $_FILES['imagen_materia'];
        $directorio = "../img/materias/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }
        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nombre_archivo = "materia_" . $id_clase . "_" . time() . "." . $extension;
        $ruta = $directorio . $nombre_archivo;
        if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
            $ruta_imagen = $ruta;
        }
    }

    // Si puso un enlace y no subió archivo, usa el enlace
    if (empty($ruta_imagen) && !empty($_POST['enlace_imagen'])) {
        $enlace = trim($_POST['enlace_imagen']);
        // Opcional: validar que es URL y termina en imagen
        if (filter_var($enlace, FILTER_VALIDATE_URL)) {
            $ruta_imagen = $enlace;
        }
    }

    // Si se tiene ruta (archivo subido o enlace), actualiza
    if (!empty($ruta_imagen)) {
        $stmt = $conn->prepare("UPDATE clases SET imagen_materia = ? WHERE id = ?");
        $stmt->bind_param("si", $ruta_imagen, $id_clase);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?exito=1");
        exit;
    } else {
        echo "Debes subir un archivo o poner un enlace válido.";
    }
}
?>