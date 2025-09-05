<?php
session_start();
require_once "../conexiones/conexion.php";

// Verificar si el usuario está logueado como profesor o estudiante
if (!isset($_SESSION['id']) && !isset($_SESSION['id_estudiante'])) {
    die("⚠️ Debes iniciar sesión como profesor o estudiante para acceder a esta materia.");
}

// Verifica que venga el id_clase por GET para ambos roles
if (!isset($_GET['id_clase'])) {
    die("⚠️ Clase no especificada.");
}
$id_clase = intval($_GET['id_clase']);

// Obtener SIEMPRE el nombre del profesor y nombre de la clase
$sql_prof = "SELECT c.nombre_clase, p.nombre AS nombre_profesor 
            FROM clases c 
            JOIN profesores p ON c.profesor_id = p.id 
            WHERE c.id = ?";
$stmt_prof = $conn->prepare($sql_prof);
$stmt_prof->bind_param("i", $id_clase);
$stmt_prof->execute();
$result_prof = $stmt_prof->get_result();
if ($result_prof->num_rows === 0) {
    die("Clase no encontrada.");
}
$clase_info = $result_prof->fetch_assoc();
$nombre_clase = $clase_info['nombre_clase'];
$nombre_profesor = $clase_info['nombre_profesor'];

$imagen_alumno = "";

// Solo si el usuario es alumno
if (isset($_SESSION['id_estudiante'])) {
    $id_alumno = $_SESSION['id_estudiante'];
    $stmt = $conn->prepare("SELECT imagen FROM estudiantes WHERE ID = ?");
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $stmt->bind_result($imagen_alumno);
    $stmt->fetch();
    $stmt->close();
}

// Lógica para estudiantes
if (isset($_SESSION['id_estudiante'])) {
    $id_estudiante = $_SESSION['id_estudiante'];
    $materia = 'lenguaje'; // Cambia aquí el nombre de la materia

    // Obtener tareas que subió este estudiante en esta materia
    $sql = "SELECT nombre_archivo, ruta_archivo, fecha_subida FROM tareas WHERE id_estudiante = ? AND materia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_estudiante, $materia);
    $stmt->execute();
    $resultado_tareas = $stmt->get_result();
}

// Lógica para profesores
$tareas_profesor = [];
$materiales_clase = [];
$avisos = [];

if (isset($_SESSION['id']) && $_SESSION['rol'] === 'profesor') {
    $profesor_id = $_SESSION['id'];

    // Verificar que la clase pertenezca al profesor
    $sql = "SELECT * FROM clases WHERE id = ? AND profesor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_clase, $profesor_id);
    $stmt->execute();
    $result_clase = $stmt->get_result();

    if ($result_clase->num_rows === 0) {
        die("No tienes acceso a esta clase.");
    }

    // Obtener tareas del profesor para esta clase

    $sql_tareas = "SELECT * FROM tareas_profesor WHERE id_clase = ? ORDER BY fecha_creacion DESC";
    $stmt_tareas = $conn->prepare($sql_tareas);
    $stmt_tareas->bind_param("i", $id_clase);
    $stmt_tareas->execute();
    $resultado_tareas_profesor = $stmt_tareas->get_result();
    while ($fila = $resultado_tareas_profesor->fetch_assoc()) {
        $tareas_profesor[] = $fila;
    }

    // Obtener materiales de estudio para esta clase

    $clase = $result_clase->fetch_assoc();
}

// Obtener tareas subidas por el profesor para esta clase
$tareas_profesor = [];
$sql_tareas = "SELECT * FROM tareas_profesor WHERE id_clase = ? ORDER BY fecha_creacion DESC";
$stmt_tareas = $conn->prepare($sql_tareas);
$stmt_tareas->bind_param("i", $id_clase);
$stmt_tareas->execute();
$result_tareas = $stmt_tareas->get_result();
while ($fila = $result_tareas->fetch_assoc()) {
    $tareas_profesor[] = $fila;
}

$entregas_alumno = [];
if (isset($_SESSION['id_estudiante'])) {
    $id_estudiante = $_SESSION['id_estudiante'];
    $sql = "SELECT * FROM tareas WHERE id_estudiante = ? AND materia = ? AND id_clase = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $id_estudiante, $materia, $id_clase);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $entregas_alumno[$row['id_tarea_profesor']] = $row; // index by tarea_profesor id
    }
}

    // Obtener materiales de estudio para esta clase
    $sql_materiales = "SELECT titulo, descripcion, archivo, ruta_archivo, fecha_subida 
                    FROM materiales_estudio 
                    WHERE id_clase = ? 
                    ORDER BY fecha_subida DESC";
    $stmt_materiales = $conn->prepare($sql_materiales);
    $stmt_materiales->bind_param("i", $id_clase);
    $stmt_materiales->execute();
    $resultado_materiales = $stmt_materiales->get_result();

// Obtener avisos de la clase (SIEMPRE, para cualquier usuario)
$avisos = [];
$sql_avisos = "SELECT * FROM avisos WHERE id_clase = ? ORDER BY fecha_subida DESC";
$stmt_avisos = $conn->prepare($sql_avisos);
$stmt_avisos->bind_param("i", $id_clase);
$stmt_avisos->execute();
$resultado_avisos = $stmt_avisos->get_result();
while ($aviso = $resultado_avisos->fetch_assoc()) {
    $avisos[] = $aviso;
}


// Obtener materiales subidos por el profesor para esta clase
$materiales_clase = [];
if (isset($id_clase)) 

    $sql_materiales = "SELECT * FROM materiales_estudio WHERE id_clase = ? ORDER BY fecha_subida DESC";
    $stmt_materiales = $conn->prepare($sql_materiales);
    $stmt_materiales->bind_param("i", $id_clase);
    $stmt_materiales->execute();
    $resultado_materiales = $stmt_materiales->get_result();
    while ($material = $resultado_materiales->fetch_assoc()) {
        $materiales_clase[] = $material;
    }



//obtener alumnos
$lista_alumnos = [];
$sql_alumnos = "SELECT ce.id AS numero_estudiante, e.nombre, e.email
                FROM clases_estudiantes ce
                JOIN estudiantes e ON ce.id_estudiante = e.ID
                WHERE ce.id_clase = ?
                ORDER BY ce.id ASC";
$stmt_alumnos = $conn->prepare($sql_alumnos);
$stmt_alumnos->bind_param("i", $id_clase);
$stmt_alumnos->execute();
$resultado_alumnos = $stmt_alumnos->get_result();
while($row = $resultado_alumnos->fetch_assoc()) {
    $lista_alumnos[] = $row;
}

// Obtener avisos de la clase
$avisos = [];
if (isset($_SESSION['id']) && $_SESSION['rol'] === 'profesor' && isset($id_clase)) {

    $sql_avisos = "SELECT * FROM avisos WHERE id_clase = ? ORDER BY fecha_subida DESC";
    $stmt_avisos = $conn->prepare($sql_avisos);
    $stmt_avisos->bind_param("i", $id_clase);
    $stmt_avisos->execute();
    $resultado_avisos = $stmt_avisos->get_result();
    while ($aviso = $resultado_avisos->fetch_assoc()) {
        $avisos[] = $aviso;
    }
}
// RESPUESTAS MÚLTIPLES EN COMENTARIOS (ALUMNO O PROFESOR)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_comentario_resp'], $_POST['texto_respuesta'])) {
    $id_comentario_resp = intval($_POST['id_comentario_resp']);
    $texto_respuesta = trim($_POST['texto_respuesta']);
    $tipo_usuario = (isset($_SESSION['id']) && $_SESSION['rol'] === 'profesor') ? 'profesor' : 'alumno';
    $id_usuario = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_SESSION['id_estudiante']) ? $_SESSION['id_estudiante'] : null);
    if ($texto_respuesta && $id_comentario_resp && $id_usuario) {
        $stmt_insert = $conn->prepare("INSERT INTO respuestas_comentario (id_comentario, id_usuario, tipo_usuario, respuesta) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("iiss", $id_comentario_resp, $id_usuario, $tipo_usuario, $texto_respuesta);
        $stmt_insert->execute();
        $stmt_insert->close();
        header("Location: ".$_SERVER['REQUEST_URI']."#comentario-".$id_comentario_resp);
        exit;
    }
}
$comentarios = [];
$sql_comentarios = "SELECT c.*, e.nombre AS nombre_alumno, p.nombre AS nombre_profesor
    FROM comentarios_clase c
    LEFT JOIN estudiantes e ON c.id_estudiante = e.ID
    LEFT JOIN profesores p ON c.id_profesor = p.id
    WHERE c.id_clase = ?
    ORDER BY c.fecha DESC";
$stmt_coment = $conn->prepare($sql_comentarios);
$stmt_coment->bind_param("i", $id_clase);
$stmt_coment->execute();
$res_coment = $stmt_coment->get_result();
while ($row = $res_coment->fetch_assoc()) {
    $comentarios[] = $row;
}
$stmt_coment->close();

// Procesar comentario nuevo del alumno
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nuevo_comentario']) && isset($_SESSION['id_estudiante'])) {
    $comentario = trim($_POST['nuevo_comentario']);
    $id_estudiante = $_SESSION['id_estudiante'];
    if ($comentario) {
        $stmt_add = $conn->prepare("INSERT INTO comentarios_clase (id_clase, id_estudiante, comentario) VALUES (?, ?, ?)");
        $stmt_add->bind_param("iis", $id_clase, $id_estudiante, $comentario);
        $stmt_add->execute();
        $stmt_add->close();
        header("Location: matematica.php?id_clase=$id_clase#comentarios");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSoft - Matemática</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../materias/css/styleMatematica.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script>
    // Cambia de sección y navbar activo
    function showSection(id) {
        document.querySelectorAll("main > section").forEach(function(section) {
            section.style.display = "none";
        });
        var el = document.getElementById(id);
        if (el) el.style.display = "block";

        document.querySelectorAll(".sidebar nav button").forEach(function(btn) {
            btn.classList.remove("active");
        });
        let btnTarget = document.getElementById(id + "-btn");
        if (btnTarget) btnTarget.classList.add("active");
    }
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("tablon-btn").onclick = function() { showSection("tablon"); };
        document.getElementById("tareas-btn").onclick = function() { showSection("tareas"); };
        document.getElementById("material-btn").onclick = function() { showSection("material"); };
        document.getElementById("alumnos-btn").onclick = function() { showSection("alumnos"); };
        document.getElementById("avisos-btn").onclick = function() { showSection("avisos"); };
        document.getElementById("ia-btn").onclick = function() { showSection("ia"); };

        // Tablón: click en cada card para ir a su sección y cambiar navbar
        document.querySelectorAll(".tablon-card[data-section]").forEach(function(el) {
            el.onclick = function() {
                showSection(el.getAttribute("data-section"));
            };
        });

        // Inicial: mostrar tablon
        showSection("tablon");
    });
    </script>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-square-root-alt"></i>
            <span>EduSoft</span>
        </div>
        <nav>
            <button data-i18n="tablon" id="tablon-btn" class="active"><i class="fas fa-th-large"></i>Tablón</button>
            <button data-i18n="tareas"    id="tareas-btn"><i class="fas fa-tasks"></i>Tareas</button>
            <button data-i18n="material"  id="material-btn"><i class="fas fa-folder-open"></i>Material</button> 
            <button  data-i18n="alumnos"  id="alumnos-btn"><i class="fas fa-users"></i>Alumnos</button>
            <button data-i18n="avisos" id="avisos-btn"><i class="fas fa-bell"></i>Avisos</button>
            <button data-i18n="comentarios" id="comentarios-btn"><i class="fas fa-comments"></i>Comentarios</button>
            <button data-i18n="ia" id="ia-btn"><i class="fas fa-robot"></i>IA</button>
        </nav>
    </div>
    <div class="main-content">
        <header>
            <a href="../cursos.php" class="logo modern-back">
                <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
                <span class="header-title" data-i18n="segundo">Segundo año B <span class="header-materia" data-i18n="matematicaM">Matemática</span></span>
            </a>
            <div class="icons">
                <span class="profile">
                <a href="configuracion_alumno.php?id_clase=<?= $id_clase ?>&origen=<?= urlencode(basename($_SERVER['PHP_SELF'])) ?>" title="Ajustes">
                    <i class="fas fa-cog"></i>
                </a>
                <?php if (!empty($imagen_alumno)): ?>
                    <img src="<?= (filter_var($imagen_alumno, FILTER_VALIDATE_URL) ? $imagen_alumno : "../" . htmlspecialchars($imagen_alumno)) ?>"
                        alt="Foto de perfil"
                        style="width:54px;height:54px;border-radius:50%;object-fit:cover;">
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?name=Alumno&background=cccccc&color=555555"
                        alt="Avatar alumno" style="width:34px;height:34px;border-radius:50%;object-fit:cover;">
                <?php endif; ?>
                </a>
                </span>
            </div>
        </header>
        <main>
            <section id="tablon" class="seccion">
                <div class="banner" id="banner1">
                    <canvas id="particles-bg"></canvas>
                    <div class="abstract-shape"></div>
                    <h1 data-i18n="matematicaM">MATEMÁTICA</h1>
                </div>
                <div class="content">
                    <div class="profesor">
                        <div class="avatar-modern"></div>
                        <p data-i18n="profesor">Profesor<br><strong><?php echo htmlspecialchars($nombre_profesor); ?></strong></p>
                    </div>
                    <div class="tablon-secciones">
                        <!-- Tareas -->
                        <div class="tablon-section">
                            <h3 style="color:#3f51b5;"><i class="fas fa-tasks"></i> Tareas</h3>
                            <?php if (!empty($tareas_profesor)): ?>
                                <?php foreach ($tareas_profesor as $tarea): ?>
                                    <div class="tablon-card" data-section="tareas">
                                        <span class="tablon-titulo"><?php echo htmlspecialchars($tarea['titulo']); ?></span>
                                        <span class="tablon-desc"><?php echo htmlspecialchars($tarea['descripcion']); ?></span>
                                        <div class="tablon-info">
                                            Fecha límite: <?php echo htmlspecialchars($tarea['fecha_entrega']); ?> | Puntos: <?php echo $tarea['puntos']; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="tablon-card" data-section="tareas">
                                    No se han asignado tareas aún.
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Materiales -->
                        <div class="tablon-section">
                            <h3 style="color:#388e3c;"><i class="fas fa-folder-open"></i> Materiales</h3>
                            <?php if (!empty($materiales_clase)): ?>
                                <?php foreach ($materiales_clase as $material): ?>
                                    <div class="tablon-card" data-section="material">
                                        <span class="tablon-titulo"><?php echo htmlspecialchars($material['titulo']); ?></span>
                                        <span class="tablon-desc"><?php echo htmlspecialchars($material['descripcion']); ?></span>
                                        <div class="tablon-info">
                                            <?php
                                            $archivo = htmlspecialchars($material["archivo"]);
                                            $ruta = htmlspecialchars($material["ruta_archivo"]);
                                            $fecha = date("d/m/Y", strtotime($material["fecha_subida"]));
                                            echo "Archivo: $archivo | ";
                                            echo "<a href='$ruta' target='_blank'>📎 Descargar</a> | Subido el $fecha";
                                            ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="tablon-card" data-section="material">
                                    No hay materiales disponibles para esta clase.
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Avisos -->
                        <div class="tablon-section">
                            <h3 style="color:#e65100;"><i class="fas fa-bell"></i> Avisos</h3>
                            <?php if (!empty($avisos)): ?>
                                <?php foreach ($avisos as $aviso): ?>
                                    <div class="tablon-card" data-section="avisos">
                                        <span class="tablon-titulo"><?php echo htmlspecialchars($aviso['titulo']); ?></span>
                                        <span class="tablon-desc"><?php echo htmlspecialchars($aviso['descripcion']); ?></span>
                                        <div class="tablon-info">
                                            Fecha: <?php echo htmlspecialchars($aviso['fecha_subida']); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="tablon-card" data-section="avisos">
                                    No hay avisos registrados para esta clase.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
<section id="tareas" class="seccion" style="display: none;">
                <div class="section-card">
                    <h2 data-i18n="tareas">Tareas</h2>
                    <div class="tareas-container">
                        <?php if (!empty($tareas_profesor)): ?>
                            <?php foreach ($tareas_profesor as $tarea): ?>
                                <div class="tarea">
                                    <i class="fas fa-book"></i>
                                    <h4><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
                                    <p><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                                    <small>
                                        Fecha límite: <?php echo htmlspecialchars($tarea['fecha_entrega']); ?> | 
                                        Puntos: <?php echo $tarea['puntos']; ?>
                                    </small>
                                    <?php if (!empty($tarea['archivo_adjunto'])): ?>
                                        <br><a href="<?php echo htmlspecialchars($tarea['archivo_adjunto']); ?>" target="_blank">📎 Ver archivo adjunto del profesor</a>
                                    <?php endif; ?>
                                    <?php if (isset($_SESSION['id_estudiante'])): ?>
                                        <div class="entrega-alumno">
                                            <?php
                                            $entrega = $entregas_alumno[$tarea['id']] ?? null;
                                            $archivos = [];
                                            if ($entrega) {
                                                $sql_archivos = "SELECT * FROM tareas_archivos WHERE id_tarea = ?";
                                                $stmt_archivos = $conn->prepare($sql_archivos);
                                                $stmt_archivos->bind_param("i", $entrega['id']);
                                                $stmt_archivos->execute();
                                                $result_archivos = $stmt_archivos->get_result();
                                                while ($fila = $result_archivos->fetch_assoc()) {
                                                    $archivos[] = $fila;
                                                }
                                            }
                                            ?>
                                            <?php if ($entrega && count($archivos) > 0): ?>
                                                <div>
                                                    <h5>Archivos subidos:</h5>
                                                    <?php foreach ($archivos as $file): ?>
                                                        <a href="<?php echo htmlspecialchars($file['ruta_archivo']); ?>" target="_blank">
                                                            <?php echo htmlspecialchars($file['nombre_archivo']); ?>
                                                        </a>
                                                        <small>(<?php echo htmlspecialchars($file['fecha_subida']); ?>)</small>
                                                        <button onclick="eliminarArchivo(<?php echo $file['id']; ?>)">❌ Eliminar archivo</button>
                                                        <br>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                            <!-- MOSTRAR NOTA Y RETROALIMENTACIÓN DEL PROFESOR -->
                                            <?php if ($entrega && isset($entrega['calificacion'])): ?>
                                                <div class="nota-alumno">
                                                    <strong>Nota del profesor:</strong> 
                                                    <?php echo ($entrega['calificacion'] !== null) ? htmlspecialchars($entrega['calificacion']) : 'Sin calificar aún'; ?>
                                                    <?php if (!empty($entrega['retroalimentacion'])): ?>
                                                        <br><small><b>Retroalimentación:</b> <?php echo htmlspecialchars($entrega['retroalimentacion']); ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <form class="formSubirTarea" action="subir_tarea_ajax.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id_tarea_profesor" value="<?php echo $tarea['id']; ?>">
                                                <input type="hidden" name="materia" value="lenguaje">
                                                <input type="hidden" name="id_clase" value="<?php echo $id_clase; ?>">
                                                <input type="hidden" name="id_estudiante" value="<?php echo $_SESSION['id_estudiante']; ?>">
                                                <?php if ($entrega): ?>
                                                    <input type="hidden" name="id_entrega" value="<?php echo $entrega['id']; ?>">
                                                <?php endif; ?>
                                                <label for="archivo_<?php echo $tarea['id']; ?>" data-i18n="archivo2">Archivo(s):</label>
                                                <input type="file" name="archivo[]" id="archivo_<?php echo $tarea['id']; ?>" multiple required><br>
                                                <button type="submit" data-i18n="subir">Subir archivo(s)</button>
                                            </form>
                                            <div id="mensajeSubida_<?php echo $tarea['id']; ?>"></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No se han asignado tareas aún.</p>
                        <?php endif; ?>
                    </div>
                </div>
        </section>
<section id="comentarios" class="seccion">
    <h2>Comentarios y dudas 
        <?php
        $pendientes = 0;
        foreach ($comentarios as $c) {
            if ($c['estado'] == 'pendiente') $pendientes++;
        }
        if ($pendientes > 0) echo "<span class='badge' style='background:#e65100;color:white;padding:2px 9px;border-radius:11px;'>$pendientes pendientes</span>";
        ?>
    </h2>
    <?php if (isset($_SESSION['id_estudiante']) || (isset($_SESSION['id']) && $_SESSION['rol'] === 'profesor')): ?>
    <form method="POST" class="form-nuevo-comentario">
    <label for="nuevo_comentario">Enviar nuevo comentario:</label>
    <textarea name="nuevo_comentario" id="nuevo_comentario" class="textarea-nuevo-comentario" rows="3" placeholder="Escribe tu duda o comentario..." required></textarea>
    <button type="submit" class="btn-nuevo-comentario">Enviar comentario</button>
</form>
    <?php endif; ?>
    <ul style="list-style:none;padding-left:0;">
        <?php foreach ($comentarios as $c): ?>
            <li id="comentario-<?= $c['id'] ?>" style="margin-bottom:15px;border-bottom:1px solid #93a3ddff;padding-bottom:8px;">
                <b><?= htmlspecialchars($c['nombre_alumno'] ?? $c['nombre_profesor'] ?? 'Usuario') ?>:</b>
                <?= htmlspecialchars($c['comentario']) ?>
                <small style="color:#888;">(<?= date("d/m/Y H:i", strtotime($c['fecha'])) ?>)</small>
                <!-- RESPUESTAS MULTIHILO -->
                <?php
                $respuestas = [];
                $stmt_resp = $conn->prepare("SELECT * FROM respuestas_comentario WHERE id_comentario = ? ORDER BY fecha ASC");
                $stmt_resp->bind_param("i", $c['id']);
                $stmt_resp->execute();
                $result_resp = $stmt_resp->get_result();
                while ($row_resp = $result_resp->fetch_assoc()) {
                    $respuestas[] = $row_resp;
                }
                $stmt_resp->close();
                ?>
                <?php foreach ($respuestas as $r): ?>
                    <div class="respuesta-hilo <?= $r['tipo_usuario'] == 'profesor' ? 'resp-prof' : 'resp-alum' ?>">
                        <b><?= $r['tipo_usuario'] == 'profesor' ? 'Profesor' : 'Alumno' ?>:</b>
                        <?= htmlspecialchars($r['respuesta']) ?>
                        <small style="color:#888;"><?= date("d/m/Y H:i", strtotime($r['fecha'])) ?></small>
                    </div>
                <?php endforeach; ?>
                <!-- FORMULARIO DE RESPUESTA MULTIHILO -->
                <?php if (isset($_SESSION['id_estudiante']) || (isset($_SESSION['id']) && $_SESSION['rol'] === 'profesor')): ?>
                <form method="POST" class="form-resp-comentario">
                    <input type="hidden" name="id_comentario_resp" value="<?= $c['id'] ?>">
                    <textarea name="texto_respuesta" rows="2" class="textarea-respuesta" placeholder="Responder al comentario..." required></textarea>
                    <button type="submit" class="btn-respuesta">Responder</button>
                </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        <?php if (empty($comentarios)): ?>
            <li>No hay comentarios aún.</li>
        <?php endif; ?>
    </ul>
</section>
            <section id="material" class="seccion" style="display: none;">
                <h2><i class="fas fa-folder-open"></i> Material de la materia</h2>
                <?php
                if (!$id_clase) {
                    echo "<p>⚠️ Clase no especificada.</p>";
                } else {
                    if (count($materiales_clase) > 0) {
                        echo '<div class="materiales-container">';
                        foreach ($materiales_clase as $material) {
                            $titulo = htmlspecialchars($material["titulo"]);
                            $descripcion = htmlspecialchars($material["descripcion"]);
                            $archivo = htmlspecialchars($material["archivo"]);
                            $ruta = htmlspecialchars($material["ruta_archivo"]);
                            $fecha = date("d/m/Y", strtotime($material["fecha_subida"]));
                            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                            switch (strtolower($extension)) {
                                case "pdf": $icono = "fa-file-pdf"; break;
                                case "doc": case "docx": $icono = "fa-file-word"; break;
                                case "ppt": case "pptx": $icono = "fa-file-powerpoint"; break;
                                case "xls": case "xlsx": $icono = "fa-file-excel"; break;
                                case "mp4": case "avi": case "mov": $icono = "fa-file-video"; break;
                                default: $icono = "fa-file"; break;
                            }
                            echo "<div class='material-item'>";
                            echo "<i class='fas $icono'></i> <strong>$titulo</strong><br>";
                            if ($descripcion) {
                                echo "<p>$descripcion</p>";
                            }
                            echo "<a href='$ruta' target='_blank'>📎 Descargar archivo: $archivo</a><br>";
                            echo "<small>Subido el $fecha</small>";
                            echo "</div>";
                        }
                        echo '</div>';
                    } else {
                        echo "<p>📭 No hay materiales disponibles para esta clase.</p>";
                    }
                }
                ?>
            </section>
            <section id="avisos" class="seccion" style="display: none;">
                <h2 data-i18n="avisos">Avisos</h2>
                <ul class="lista-avisos">
                    <?php
                    if (!empty($avisos)) {
                        foreach ($avisos as $aviso) {
                            echo "<li>";
                            echo "<span>" . htmlspecialchars($aviso['titulo']) . "</span>";
                            echo "<p>" . htmlspecialchars($aviso['descripcion']) . "</p>";
                            echo "<small>Fecha: " . htmlspecialchars($aviso['fecha_subida']) . "</small>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li>No hay avisos registrados para esta clase.</li>";
                    }
                    ?>
                </ul>
            </section>


 
             <section id="comentarios" class="seccion" style="display: none;">
                <h2><i class="fas fa-comments"></i> Comentarios</h2>
                <ul class="lista-comentarios">
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Juan Pérez</span>
                        <p>¿El informe debe incluir imágenes?</p>
                        <small>22/08/2025 - 14:10</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>María Gómez</span>
                        <p>¡Muy útil el material, gracias profe!</p>
                        <small>22/08/2025 - 19:45</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Cristofer Alfaro</span>
                        <p>¡Recuerden que el informe debe entregarse en PDF!</p>
                        <small>23/08/2025 - 09:02</small>
                    </li>
                </ul>
            </section>


            <section id="alumnos" class="seccion" style="display: none;">
            <h2 data-i18n="lista">Lista de Alumnos</h2>
            <ul class="lista-alumnos">
                <?php if (!empty($lista_alumnos)): ?>
                    <?php foreach ($lista_alumnos as $alumno): ?>
                        <li>
                            <i class="fas fa-user"></i>
                            <span><?php echo htmlspecialchars($alumno['nombre']); ?></span>
                            <p>Número de estudiante: <?php echo htmlspecialchars($alumno['numero_estudiante']); ?></p>
                            <small>Correo electrónico: <?php echo htmlspecialchars($alumno['email']); ?></small>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No hay alumnos inscritos en esta clase.</li>
                <?php endif; ?>
            </ul>
        </section>


         <section id="ia" class="seccion" style="display: none;">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 24px;">
                <h2 style="font-size:2em;color:#4285f4;"><i class="fas fa-robot"></i> Chatea con Atenea</h2>
                <p style="font-size:1.15em;color:#234567;margin-bottom:12px;">¿Tienes dudas o quieres explorar algo con inteligencia artificial? Usa nuestro chat educativo.</p>
                <a href="http://127.0.0.1:5000/" class="boton-estilo" style="text-decoration:none;">
                    <i class="fas fa-comments"></i>
                    Ir al chat con Atenea
                </a>
            </div>
        </section>

        </main>
    </div>
    <script src="../materias/js/scriptMatematica.js"></script>
</body>
</html>