<?php
session_start();
require_once "../conexiones/conexion.php";

// Valor por defecto para evitar error si no se define $nombre
$nombre = "Nombre no disponible";

// Verificar si el usuario está logueado como profesor o como estudiante
if (!isset($_SESSION['id']) && !isset($_SESSION['id_estudiante'])) {
    die("⚠️ Debes iniciar sesión como profesor o estudiante para acceder a esta materia.");
}

// Lógica para estudiantes
if (isset($_SESSION['id_estudiante'])) {
    $id_estudiante = $_SESSION['id_estudiante'];
    $materia = 'biologia'; // Puedes cambiar esto dinámicamente si lo deseas

    // Obtener tareas que subió este estudiante en esta materia
    $sql = "SELECT id, nombre_archivo, ruta_archivo, fecha_subida FROM tareas WHERE id_estudiante = ? AND materia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_estudiante, $materia);
    $stmt->execute();
    $resultado_tareas = $stmt->get_result();
}

// Lógica para profesores
if (isset($_SESSION['id']) && $_SESSION['rol'] === 'profesor') {
    $profesor_id = $_SESSION['id'];

    if (!isset($_GET['id_clase'])) {
        die("Clase no especificada.");
    }

    $id_clase = intval($_GET['id_clase']);

    // Obtener nombre si está definido en sesión
    if (isset($_SESSION['nombre'])) {
        $nombre = $_SESSION['nombre'];
    }

    // Verificar que la clase pertenezca al profesor
    $sql = "SELECT * FROM clases WHERE id = ? AND profesor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_clase, $profesor_id);
    $stmt->execute();
    $result_clase = $stmt->get_result();

    if ($result_clase->num_rows === 0) {
        die("No tienes acceso a esta clase.");
    }

    $clase = $result_clase->fetch_assoc();
}

// Obtener tareas subidas por el profesor para esta clase
$tareas_profesor = [];
if (isset($_SESSION['id']) && $_SESSION['rol'] === 'profesor' && isset($id_clase)) {
    $sql_tareas = "SELECT * FROM tareas_profesor WHERE id_clase = ? ORDER BY fecha_creacion DESC";
    $stmt_tareas = $conn->prepare($sql_tareas);
    $stmt_tareas->bind_param("i", $id_clase);
    $stmt_tareas->execute();
    $resultado_tareas_profesor = $stmt_tareas->get_result();

    while ($fila = $resultado_tareas_profesor->fetch_assoc()) {
        $tareas_profesor[] = $fila;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EduSoft - Biología</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../materias/css/styleArte copy.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="../materias/js/subir_tarea.js" defer></script>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-logo">
        <i class="fas fa-dna"></i>
        <span>EduSoft</span>
    </div>
    <nav>
        <button data-i18n="tablon" id="tablon-btn" class="active"><i class="fas fa-th-large"></i> Plank</button>
        <button data-i18n="tareas" id="tareas-btn"><i class="fas fa-tasks"></i> Homeworks</button>
        <button id="material-btn"><i class="fas fa-folder-open"></i>Material</button>
        <button data-i18n="alumnos" id="alumnos-btn"><i class="fas fa-users"></i>Alumnos</button>
        <button data-i18n="avisos" id="avisos-btn"><i class="fas fa-bell"></i> notices</button>
    </nav>
</div>

<div class="main-content">
    <header>
        <a href="../extracurriculares.php" class="logo modern-back">
            <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
            <span data-i18n="segundo" class="header-title">Segundo año B <span class="header-materia" data-i18n="debate">Debate</span></span>
        </a>
        <div class="icons">
            <span class="settings"><i class="fas fa-cog"></i></span>
            <span class="profile"><i class="fas fa-user-circle"></i></span>
        </div>
    </header>

    <main>
        <section id="tablon" class="seccion">
            <div class="banner" id="banner6">
                <canvas id="particles-bg"></canvas>
                <div class="abstract-shape"></div>
                <h1 data-i18n="debate">DEBATE</h1>
            </div>
            <div class="content">
                <div class="profesor">
                    <div class="avatar-modern"></div>
                    <p>
                        <span data-i18n="profesor">Profesor</span><br />
                        <strong><?php echo htmlspecialchars($nombre); ?></strong>
                    </p>
                </div>

                <div class="tareas-container">
                    <?php if (!empty($tareas_profesor)): ?>
                        <?php foreach ($tareas_profesor as $tarea): ?>
                            <div class="tarea">
                                <h4 data-i18n="titulo"><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
                                <p data-i18n="descripcion"><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                                <small>
                                    <span data-i18n="fechal">Fecha límite</span>: <?php echo htmlspecialchars($tarea['fecha_entrega']); ?>
                                    | <span data-i18n="puntos">Puntos</span>: <?php echo $tarea['puntos']; ?>
                                </small>
                                <?php if (!empty($tarea['ruta_archivo'])): ?>
                                    <br /><a href="<?php echo htmlspecialchars($tarea['ruta_archivo']); ?>" target="_blank" data-i18n="archivo">📎 Ver archivo adjunto</a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p data-i18n="notareas">No se han asignado tareas aún.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section id="tareas" class="seccion" style="display: none;">
    <h2 data-i18n="tareas">Tareas</h2>

    <!-- Mostrar tareas del profesor -->
    <div class="tareas-container">
        <?php if (isset($resultado_tareas_profesor) && $resultado_tareas_profesor->num_rows > 0): ?>
            <?php while ($tarea = $resultado_tareas_profesor->fetch_assoc()): ?>
                <div class="tarea">
                    <i class="fas fa-book"></i>
                    <h4><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
                    <p><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                    <small>Fecha límite: <?php echo htmlspecialchars($tarea['fecha_entrega']); ?> | Puntos: <?php echo $tarea['puntos']; ?></small>
                    <?php if (!empty($tarea['ruta_archivo'])): ?>
                        <br><a href="<?php echo htmlspecialchars($tarea['ruta_archivo']); ?>" target="_blank">📎 Ver archivo adjunto</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p data-i18n="notareas">No se han asignado tareas aún.</p>
        <?php endif; ?>
    </div>

    <!-- Formulario para estudiantes subir tarea -->
    <?php if (isset($_SESSION['id_estudiante'])): ?>
        <h2 data-i18n="sube">Sube tu tarea de Debate</h2>
        <form id="formSubirTarea" action="subir_tarea_ajax.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="materia" value="biologia">
            <input type="hidden" name="id_estudiante" value="<?php echo $_SESSION['id_estudiante']; ?>">
            <label for="archivo" data-i18n="archivo2">Archivo (PDF, DOCX, JPG...):</label>
            <input type="file" name="archivo" id="archivo" required><br><br>
            <button type="submit" data-i18n="subir">Subir tarea</button>
        </form>

        <div id="mensajeSubida"></div>

        <h3 data-i18n="subidas">Tareas subidas</h3>
        <ul id="listaTareas" style="list-style-type: none; padding-left: 0;">
            <?php if (isset($resultado_tareas) && $resultado_tareas->num_rows > 0): ?>
                <?php while ($fila = $resultado_tareas->fetch_assoc()): ?>
                    <li id="tarea_<?php echo $fila['id']; ?>">
                        <a href="<?php echo htmlspecialchars($fila['ruta_archivo']); ?>" target="_blank">
                            <?php echo htmlspecialchars($fila['nombre_archivo']); ?>
                        </a>
                        <small>(<?php echo htmlspecialchars($fila['fecha_subida']); ?>)</small>
                        <button onclick="eliminarTarea(<?php echo $fila['id']; ?>)">❌ Eliminar</button>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No has subido tareas aún.</li>
            <?php endif; ?>
        </ul>
    <?php else: ?>
        <p>No tienes permisos para subir tareas.</p>
    <?php endif; ?>
</section>


        <section id="alumnos" class="seccion" style="display: none;">
            <h2 data-i18n="lista">Lista de Alumnos</h2>
            <ul class="lista-alumnos">
                <!-- Lista estática o dinámica según lo que necesites -->
            </ul>
        </section>

        <section id="avisos" class="seccion" style="display: none;">
            <h2 data-i18n="avisos">Avisos</h2>
            <ul class="lista-avisos">
                <!-- Lista estática o dinámica de avisos -->
            </ul>
        </section>

        <section id="material" class="seccion" style="display: none;">
            <h2><i class="fas fa-folder-open"></i> Material de la materia</h2>
            <ul class="lista-material">
                <?php
                if (!isset($id_clase)) {
                    echo "<li>⚠️ Clase no especificada.</li>";
                } else {
                    $sql = "SELECT titulo, descripcion, archivo, ruta_archivo, fecha_subida 
                            FROM materiales_estudio 
                            WHERE id_clase = ? 
                            ORDER BY fecha_subida DESC";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id_clase);
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    if ($resultado->num_rows > 0) {
                        while ($material = $resultado->fetch_assoc()) {
                            $titulo = htmlspecialchars($material['titulo']);
                            $descripcion = htmlspecialchars($material['descripcion']);
                            $archivo = htmlspecialchars($material['archivo']);
                            $ruta = htmlspecialchars($material['ruta_archivo']);
                            $fecha = date("d/m/Y", strtotime($material['fecha_subida']));

                            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                            switch (strtolower($extension)) {
                                case 'pdf': $icono = 'fa-file-pdf'; break;
                                case 'doc':
                                case 'docx': $icono = 'fa-file-word'; break;
                                case 'ppt':
                                case 'pptx': $icono = 'fa-file-powerpoint'; break;
                                case 'xls':
                                case 'xlsx': $icono = 'fa-file-excel'; break;
                                case 'mp4':
                                case 'avi':
                                case 'mov': $icono = 'fa-file-video'; break;
                                default: $icono = 'fa-file'; break;
                            }

                            echo "<li>";
                            echo "<i class='fas $icono'></i> <strong>$titulo</strong><br>";
                            if ($descripcion) {
                                echo "<p>$descripcion</p>";
                            }
                            echo "<a href='$ruta' target='_blank'>📎 Descargar archivo: $archivo</a><br>";
                            echo "<small>Subido el $fecha</small>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li>📭 No hay materiales disponibles para esta clase.</li>";
                    }
                }
                ?>
            </ul>
        </section>
    </main>
</div>

<div id="modalTarea" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalTitulo" data-i18n="titulo">Título de la tarea</h2>
        <p id="modalDescripcion" data-i18n="descripcionB">Descripción de la tarea</p>
        <div class="modal-section">
            <label for="archivoSubir" data-i18n="archivos">Subir archivos:</label>
            <input type="file" id="archivoSubir" multiple />
            <ul id="listaArchivos"></ul>
        </div>
        <div class="modal-section">
            <label for="enlaceInput" data-i18n="enlace">Añadir enlace:</label>
            <input type="url" id="enlaceInput" placeholder="https://" />
            <button id="agregarEnlace" data-i18n="agregarE">Agregar enlace</button>
            <ul id="listaEnlaces"></ul>
        </div>
    </div>
</div>

<script src="../materias/js/scriptBiologia.js"></script>
<script src="../principal/lang.js"></script>
<script src="../principal/idioma.js"></script>

<script>
function eliminarTarea(id) {
    if (!confirm("¿Estás seguro de que quieres eliminar esta tarea?")) return;

    fetch("eliminar_tarea.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}`
    })
    .then(response => response.text())
    .then(res => {
        if (res === "OK") {
            const tareaLi = document.getElementById(`tarea_${id}`);
            if (tareaLi) tareaLi.remove();
        } else {
            alert("No se pudo eliminar la tarea");
        }
    })
    .catch(err => {
        console.error("Error eliminando tarea:", err);
    });
}
</script>
</body>
</html>
