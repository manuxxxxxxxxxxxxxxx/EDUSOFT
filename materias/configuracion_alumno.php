<?php
session_start();
require_once "../conexiones/conexion.php";

$id_clase = isset($_GET['id_clase']) ? $_GET['id_clase'] : '';
if (isset($_GET['origen'])) {
    $_SESSION['origen_materia'] = $_GET['origen'];
}

// Al guardar la preferencia:
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modo_oscuro'])) {
    $modoOscuro = $_POST['modo_oscuro'] === 'on' ? 1 : 0;
    $stmt = $conn->prepare("UPDATE estudiantes SET modo_oscuro = ? WHERE ID = ?");
    $stmt->bind_param("ii", $modoOscuro, $id_alumno);
    $stmt->execute();
    $stmt->close();
}

// Leer la preferencia actual
$stmt = $conn->prepare("SELECT modo_oscuro FROM estudiantes WHERE ID = ?");
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$stmt->bind_result($modoOscuro);
$stmt->fetch();
$stmt->close();

// Puedes guardar también en sesión si quieres usar en otros archivos
$_SESSION['modo_oscuro'] = $modoOscuro;
// Solo alumnos pueden acceder
if (!isset($_SESSION['id_estudiante'])) {
    http_response_code(403);
    die("Acceso no autorizado.");
}

$id_alumno = $_SESSION['id_estudiante'];
$error = "";

// AJAX: Procesar subida de imagen (archivo o URL)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ruta_guardar = "";

    // Si viene archivo
    if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {
        $target_dir = "../uploads/alumnos/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $nombre_archivo = "alumno_" . $id_alumno . "_" . time() . "_" . basename($_FILES["imagen"]["name"]);
        $target_file = $target_dir . $nombre_archivo;
        $tipo = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $esImagen = in_array($tipo, ["jpg", "jpeg", "png", "gif", "webp"]);
        if ($esImagen && move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $ruta_guardar = "uploads/alumnos/" . $nombre_archivo;
        } else {
            $error = "Solo se permiten imágenes jpg, png, gif, webp";
        }
    }
    // Si viene URL
    elseif (isset($_POST['url_imagen']) && filter_var($_POST['url_imagen'], FILTER_VALIDATE_URL)) {
        $url = trim($_POST['url_imagen']);
        $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        if (in_array($ext, ["jpg", "jpeg", "png", "gif", "webp"])) {
            $ruta_guardar = $url; // Guardamos la URL directamente en BD
        } else {
            $error = "La URL debe terminar en jpg, png, gif o webp";
        }
    } else {
        $error = "No se seleccionó archivo ni se ingresó URL válida";
    }

    if ($ruta_guardar && !$error) {
        $stmt = $conn->prepare("UPDATE estudiantes SET imagen = ? WHERE ID = ?");
        $stmt->bind_param("si", $ruta_guardar, $id_alumno);
        $stmt->execute();
        $stmt->close();
        header("Content-Type: application/json");
        echo json_encode([
            "success" => true,
            "image" => $ruta_guardar
        ]);
        exit;
    } else {
        header("Content-Type: application/json");
        echo json_encode([
            "success" => false,
            "error" => $error
        ]);
        exit;
    }
}

// Obtener datos del alumno
$stmt = $conn->prepare("SELECT nombre, email, imagen FROM estudiantes WHERE ID = ?");
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$stmt->bind_result($nombre, $email, $imagen);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configura tu imagen de perfil</title>
    <link rel="stylesheet" href="css/styleMatematica.css">
    <link rel="stylesheet" href="styleconfiguracion_alumno.css">
</head>
<body class="<?= $modoOscuro ? 'dark-mode' : '' ?>">>
    <div class="header-config">
        <a href="<?= htmlspecialchars(isset($_SESSION['origen_materia']) ? $_SESSION['origen_materia'] : 'matematica.php') ?>?id_clase=<?= $id_clase ?>" class="back-btn" title="Volver">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-profile">
            <img
                src="<?= (filter_var($imagen, FILTER_VALIDATE_URL) ? $imagen : "../" . ($imagen ? htmlspecialchars($imagen) : "https://ui-avatars.com/api/?name=" . urlencode($nombre) . "&background=cccccc&color=555555")) ?>"
                class="header-img"
                id="alumno-img-header"
                alt="Imagen alumno"
            >
        </div>
    </div>
    <h2 style="text-align:center;margin-top:30px;">Configura tu imagen de perfil</h2>
    <div class="alumno-card">
        <img
            src="<?= (filter_var($imagen, FILTER_VALIDATE_URL) ? $imagen : "../" . ($imagen ? htmlspecialchars($imagen) : "https://ui-avatars.com/api/?name=" . urlencode($nombre) . "&background=cccccc&color=555555")) ?>"
            class="alumno-img"
            id="alumno-img"
            alt="Imagen alumno"
        >
        <div class="alumno-info">
            <strong><?= htmlspecialchars($nombre) ?></strong> <br>
            <small><?= htmlspecialchars($email) ?></small>
            <form id="alumno-form" class="alumno-form" enctype="multipart/form-data">
                <label>Subir imagen desde tu PC:</label>
                <input type="file" name="imagen" accept="image/*">
                <label>O ingresa la URL de tu foto:</label>
                <input type="url" name="url_imagen" placeholder="https://ejemplo.com/mi-foto.jpg">
                <button type="submit">Actualizar imagen</button>
            </form>

            <h3>Accesibilidad</h3>
            <form method="POST">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="modoOscuroSwitch" name="modo_oscuro" <?= $modoOscuro ? 'checked' : '' ?>>
                    <label class="form-check-label" for="modoOscuroSwitch">Modo Oscuro</label>
                </div>
                <button type="submit" class="btn btn-primary">Guardar preferencias</button>
            </form>
        </div>
    </div>
    <script>
    document.getElementById('modoOscuroSwitch').addEventListener('change', function() {
        if(this.checked) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });
    
    document.getElementById('alumno-form').addEventListener('submit', function(e){
        e.preventDefault();
        let fileInput = this.querySelector('input[type="file"]');
        let urlInput = this.querySelector('input[name="url_imagen"]');
        let formData = new FormData();
        if (fileInput.files.length) {
            formData.append('imagen', fileInput.files[0]);
        }
        if (urlInput.value.trim()) {
            formData.append('url_imagen', urlInput.value.trim());
        }
        fetch('configuracion_alumno.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                let img = document.getElementById('alumno-img');
                let imgHeader = document.getElementById('alumno-img-header');
                let src = /^(https?:\/\/)/.test(data.image) ? data.image : "../" + data.image;
                img.src = src + "?t=" + Date.now();
                imgHeader.src = src + "?t=" + Date.now();
                img.classList.add('updated');
                imgHeader.classList.add('updated');
                alert('¡Imagen actualizada con éxito!');
                setTimeout(function(){
                    img.classList.remove('updated');
                    imgHeader.classList.remove('updated');
                }, 1800);
            } else {
                alert(data.error || "Error al actualizar la imagen.");
            }
        })
        // -----------------------------------------------------------
        .catch(() => alert("Error al subir imagen."));
    });
</script>
</body>
</html>