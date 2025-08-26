<?php
session_start();
require_once "../conexiones/conexion.php";

$id_clase = isset($_GET['id_clase']) ? $_GET['id_clase'] : '';
if (isset($_GET['origen'])) {
    $_SESSION['origen_materia'] = $_GET['origen'];
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Perfil - EDUSOFT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styleconfiguracion_alumno.css">
</head>
<body>
    <!-- Background Elements -->
    <div class="background-elements">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
        <div class="floating-shape shape-4"></div>
    </div>

    <!-- Header OUTSIDE of grid -->
    <header class="profile-header">
        <div class="header-container">
            <a href="<?= htmlspecialchars(isset($_SESSION['origen_materia']) ? $_SESSION['origen_materia'] : 'matematica.php') ?>?id_clase=<?= $id_clase ?>" class="back-button" title="Volver">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
            <div class="header-title">
                <h1><i class="fas fa-user-cog"></i> Configurar Perfil</h1>
                <p>Personaliza tu imagen de perfil</p>
            </div>
            <div class="header-profile-mini">
                <img
                    src="<?= (filter_var($imagen, FILTER_VALIDATE_URL) ? $imagen : "../" . ($imagen ? htmlspecialchars($imagen) : "https://ui-avatars.com/api/?name=" . urlencode($nombre) . "&background=667eea&color=ffffff&size=40")) ?>"
                    class="mini-avatar"
                    id="alumno-img-header"
                    alt="Avatar"
                >
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="profile-container">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-avatar-section">
                    <div class="avatar-container">
                        <img
                            src="<?= (filter_var($imagen, FILTER_VALIDATE_URL) ? $imagen : "../" . ($imagen ? htmlspecialchars($imagen) : "https://ui-avatars.com/api/?name=" . urlencode($nombre) . "&background=667eea&color=ffffff&size=150")) ?>"
                            class="profile-avatar"
                            id="alumno-img"
                            alt="Imagen de perfil"
                        >
                        <div class="avatar-overlay"><i class="fas fa-camera"></i></div>
                    </div>
                    <div class="profile-info">
                        <h2 class="student-name"><?= htmlspecialchars($nombre) ?></h2>
                        <p class="student-email">
                            <i class="fas fa-envelope"></i>
                            <?= htmlspecialchars($email) ?>
                        </p>
                        <div class="profile-badge">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Estudiante EDUSOFT</span>
                        </div>
                    </div>
                </div>

                <!-- Upload Form -->
                <div class="upload-section">
                    <h3><i class="fas fa-upload"></i> Actualizar Imagen de Perfil</h3>
                    <form id="alumno-form" class="upload-form" enctype="multipart/form-data">
                        <!-- File Upload -->
                        <div class="upload-option">
                            <div class="option-header">
                                <i class="fas fa-file-image"></i>
                                <span>Subir desde tu dispositivo</span>
                            </div>
                            <div class="file-input-container">
                                <input type="file" name="imagen" id="file-input" accept="image/*" hidden>
                                <label for="file-input" class="file-input-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span class="file-text">Seleccionar archivo</span>
                                    <span class="file-info">JPG, PNG, GIF, WEBP (máx. 5MB)</span>
                                </label>
                            </div>
                        </div>

                        <!-- URL Input -->
                        <div class="upload-option">
                            <div class="option-header">
                                <i class="fas fa-link"></i>
                                <span>Usar imagen desde URL</span>
                            </div>
                            <div class="url-input-container">
                                <input type="url" name="url_imagen" placeholder="https://ejemplo.com/mi-foto.jpg" class="url-input">
                                <i class="fas fa-globe input-icon"></i>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="submit-button">
                            <i class="fas fa-save"></i>
                            <span>Actualizar Imagen</span>
                            <div class="button-loader"></div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="tips-card">
                <h3><i class="fas fa-lightbulb"></i> Consejos para tu foto de perfil</h3>
                <ul class="tips-list">
                    <li><i class="fas fa-check"></i> Usa una imagen clara y bien iluminada</li>
                    <li><i class="fas fa-check"></i> Asegúrate de que tu rostro sea visible</li>
                    <li><i class="fas fa-check"></i> Evita imágenes borrosas o pixeladas</li>
                    <li><i class="fas fa-check"></i> Mantén un aspecto profesional</li>
                </ul>
            </div>
        </div>
    </main>

    <!-- Success/Error Notifications -->
    <div id="notification" class="notification">
        <div class="notification-content">
            <i class="notification-icon"></i>
            <span class="notification-text"></span>
        </div>
    </div>

    <script>
    // File input handling
    document.getElementById('file-input').addEventListener('change', function(e) {
        const fileLabel = document.querySelector('.file-text');
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            fileLabel.textContent = fileName;
            fileLabel.parentElement.classList.add('file-selected');
        } else {
            fileLabel.textContent = 'Seleccionar archivo';
            fileLabel.parentElement.classList.remove('file-selected');
        }
    });

    // Form submission
    document.getElementById('alumno-form').addEventListener('submit', function(e){
        e.preventDefault();
        
        const submitButton = this.querySelector('.submit-button');
        const buttonText = submitButton.querySelector('span');
        const loader = submitButton.querySelector('.button-loader');
        
        // Show loading state
        submitButton.classList.add('loading');
        buttonText.textContent = 'Actualizando...';
        
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
            submitButton.classList.remove('loading');
            buttonText.textContent = 'Actualizar Imagen';
            
            if (data.success) {
                let img = document.getElementById('alumno-img');
                let imgHeader = document.getElementById('alumno-img-header');
                let src = /^(https?:\/\/)/.test(data.image) ? data.image : "../" + data.image;
                
                img.src = src + "?t=" + Date.now();
                imgHeader.src = src + "?t=" + Date.now();
                
                // Success animation
                img.classList.add('updated');
                imgHeader.classList.add('updated');
                
                showNotification('¡Imagen actualizada con éxito!', 'success');
                
                // Reset form
                fileInput.value = '';
                urlInput.value = '';
                document.querySelector('.file-text').textContent = 'Seleccionar archivo';
                document.querySelector('.file-input-label').classList.remove('file-selected');
                
                setTimeout(function(){
                    img.classList.remove('updated');
                    imgHeader.classList.remove('updated');
                }, 1800);
            } else {
                showNotification(data.error || "Error al actualizar la imagen.", 'error');
            }
        })
        .catch(() => {
            submitButton.classList.remove('loading');
            buttonText.textContent = 'Actualizar Imagen';
            showNotification("Error al subir imagen. Inténtalo de nuevo.", 'error');
        });
    });

    // Notification system
    function showNotification(message, type) {
        const notification = document.getElementById('notification');
        const icon = notification.querySelector('.notification-icon');
        const text = notification.querySelector('.notification-text');
        
        text.textContent = message;
        notification.className = `notification ${type} show`;
        
        if (type === 'success') {
            icon.className = 'notification-icon fas fa-check-circle';
        } else {
            icon.className = 'notification-icon fas fa-exclamation-circle';
        }
        
        setTimeout(() => {
            notification.classList.remove('show');
        }, 4000);
    }

    // Drag and drop functionality
    const fileInputContainer = document.querySelector('.file-input-container');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileInputContainer.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        fileInputContainer.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        fileInputContainer.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        fileInputContainer.classList.add('drag-over');
    }
    
    function unhighlight(e) {
        fileInputContainer.classList.remove('drag-over');
    }
    
    fileInputContainer.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            document.getElementById('file-input').files = files;
            document.getElementById('file-input').dispatchEvent(new Event('change'));
        }
    }
    </script>
</body>
</html>
