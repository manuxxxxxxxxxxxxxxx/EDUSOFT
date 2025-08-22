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

// Lógica para estudiantes
if (isset($_SESSION['id_estudiante'])) {
    $id_estudiante = $_SESSION['id_estudiante'];
    $materia = 'lenguaje'; // Ajusta si es necesario

    // Obtener tareas que subió este estudiante en esta materia
    $sql = "SELECT nombre_archivo, ruta_archivo, fecha_subida FROM tareas WHERE id_estudiante = ? AND materia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_estudiante, $materia);
    $stmt->execute();
    $resultado_tareas = $stmt->get_result();
}

// Lógica para profesores
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
    $tareas_profesor = [];
    $result_tareas = $stmt_tareas->get_result();
    while ($fila = $result_tareas->fetch_assoc()) {
        $tareas_profesor[] = $fila;
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

    // Obtener avisos para esta clase
    $sql_avisos = "SELECT titulo, descripcion, fecha_subida 
                FROM avisos 
                WHERE id_clase = ? 
                ORDER BY fecha_subida DESC";
    $stmt_avisos = $conn->prepare($sql_avisos);
    $stmt_avisos->bind_param("i", $id_clase);
    $stmt_avisos->execute();
    $resultado_avisos = $stmt_avisos->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EduSoft - Lenguaje y Literatura</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../materias/css/styleLenguaje.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron:wght@700&display=swap" rel="stylesheet" />
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-book"></i>
            <span>EduSoft</span>
        </div>
        <nav>
            <button data-i18n="tablon" id="tablon-btn" class="active"><i class="fas fa-th-large"></i>Tablón</button>
            <button data-i18n="tareas" id="tareas-btn"><i class="fas fa-tasks"></i>Tareas</button>
            <button id="material-btn"><i class="fas fa-folder-open"></i>Material</button>
            <button data-i18n="alumnos" id="alumnos-btn"><i class="fas fa-users"></i>Alumnos</button>
            <button data-i18n="avisos" id="avisos-btn"><i class="fas fa-bell"></i>Avisos</button>
        </nav>
    </div>
    <div class="main-content">
        <header>
            <a href="../cursos.php" class="logo modern-back">
                <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
                <span class="header-title" data-i18n="segundo">Segundo año B <span class="header-materia" data-i18n="lenguajeM">Lenguaje y Literatura</span></span>
            </a>
            <div class="icons">
                <span class="settings"><i class="fas fa-cog"></i></span>
                <span class="profile"><i class="fas fa-user-circle"></i></span>
            </div>
        </header>
        <main>
            <section id="tablon" class="seccion">
                <div class="banner banner-lenguaje" id="banner2">
                    <canvas id="particles-bg"></canvas>
                    <div class="abstract-shape"></div>
                    <h1 data-i18n="lenguajeM">LENGUAJE Y LITERATURA</h1>
                </div>
                <div class="content">
                    <div class="profesor">
                        <div class="avatar-modern"></div>
                        <p data-i18n="profesor">Profesor<br><strong><?php echo htmlspecialchars($nombre_profesor); ?></strong></p>
                    </div>
                    <div class="tareas-container">
                        <?php if (!empty($tareas_profesor)): ?>
                            <?php foreach ($tareas_profesor as $tarea): ?>
                                <div class="tarea">
                                    <h4 data-i18n="titulo"><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
                                    <p data-i18n="descripcion"><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                                    <small>
                                        <span data-i18n="fechal">Fecha límite</span>: <?php echo htmlspecialchars($tarea['fecha_entrega']); ?> |
                                        <span data-i18n="puntos">Puntos</span>: <?php echo htmlspecialchars($tarea['puntos']); ?>
                                    </small>
                                    <?php if (!empty($tarea['ruta_archivo'])): ?>
                                        <br>
                                        <a href="<?php echo htmlspecialchars($tarea['ruta_archivo']); ?>" target="_blank" data-i18n="archivo">📎 Ver archivo adjunto</a>
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
                <div class="tareas-container">
                    <?php if (!empty($tareas_profesor)): ?>
                        <?php foreach ($tareas_profesor as $tarea): ?>
                            <div class="tarea">
                                <i class="fas fa-book"></i>
                                <h4><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
                                <p><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                                <small>Fecha límite: <?php echo htmlspecialchars($tarea['fecha_entrega']); ?> | Puntos: <?php echo htmlspecialchars($tarea['puntos']); ?></small>
                                <?php if (!empty($tarea['ruta_archivo'])): ?>
                                    <br><a href="<?php echo htmlspecialchars($tarea['ruta_archivo']); ?>" target="_blank">📎 Ver archivo adjunto</a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No se han asignado tareas aún.</p>
                    <?php endif; ?>
                </div>
            </section>

            <section id="alumnos" class="seccion" style="display: none;">
                <h2 data-i18n="lista">Lista de Alumnos</h2>
                <ul class="lista-alumnos">
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Juan Pérez</span>
                        <p>Número de estudiante: 001</p>
                        <small>Correo electrónico: juan.perez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>María López</span>
                        <p>Número de estudiante: 002</p>
                        <small>Correo electrónico: maria.lopez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Carlos Gómez</span>
                        <p>Número de estudiante: 003</p>
                        <small>Correo electrónico: carlos.gomez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Ana Ramírez</span>
                        <p>Número de estudiante: 004</p>
                        <small>Correo electrónico: ana.ramirez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Luis Hernández</span>
                        <p>Número de estudiante: 005</p>
                        <small>Correo electrónico: luis.hernandez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Sofía García</span>
                        <p>Número de estudiante: 006</p>
                        <small>Correo electrónico: sofia.garcia@gmail.com</small>
                    </li>
                </ul>
            </section>

            <section id="avisos" class="seccion" style="display: none;">
                <h2 data-i18n="avisos">Avisos</h2>
                <ul class="lista-avisos">
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Examen de Literatura</span>
                        <p>El próximo viernes se realizará el examen de literatura. Asegúrate de estudiar y prepararte adecuadamente.</p>
                        <small>Fecha: 15 de abril</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Entrega de Tareas</span>
                        <p>Recuerda que la tarea de análisis de texto debe ser entregada el próximo lunes. Asegúrate de tenerla lista y entregada a tiempo.</p>
                        <small>Fecha: 12 de abril</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Feria de Libros</span>
                        <p>La feria de libros se realizará el próximo sábado. Asegúrate de asistir y participar en los eventos y actividades programadas.</p>
                        <small>Fecha: 17 de abril</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Información Importante</span>
                        <p>Recuerda que la escuela estará cerrada el próximo martes por motivo de una reunión de padres y maestros. Asegúrate de planificar tus actividades adecuadamente.</p>
                        <small>Fecha: 13 de abril</small>
                    </li>
                </ul>
            </section>

            <section id="material" class="seccion" style="display: none;">
                <h2><i class="fas fa-folder-open"></i> Material de la materia</h2>
                <ul class="lista-material">
                <?php
                if (!isset($id_clase)) {
                    echo "<li>⚠️ Clase no especificada.</li>";
                } else {
                    $sql_materiales = "SELECT titulo, descripcion, archivo, ruta_archivo, fecha_subida 
                                       FROM materiales_estudio 
                                       WHERE id_clase = ? 
                                       ORDER BY fecha_subida DESC";
                    $stmt_materiales = $conn->prepare($sql_materiales);
                    $stmt_materiales->bind_param("i", $id_clase);
                    $stmt_materiales->execute();
                    $resultado_materiales = $stmt_materiales->get_result();

                    if ($resultado_materiales->num_rows > 0) {
                        while ($material = $resultado_materiales->fetch_assoc()) {
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

    <!-- Modal HTML -->
    <div id="modalTarea" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitulo" data-i18n="titulo">Título de la tarea</h2>
            <p id="modalDescripcion" data-i18n="descripcion">Descripción de la tarea</p>
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

    <script src="../materias/js/scriptLenguaje.js"></script>
    <script src="../principal/lang.js"></script>
    <script src="../principal/idioma.js"></script>

    <script>
        // Cambiar secciones con botones sidebar
        document.querySelectorAll('.sidebar nav button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('main .seccion').forEach(seccion => seccion.style.display = 'none');
                const id = button.id.replace('-btn','');
                const seccionMostrar = document.getElementById(id);
                if (seccionMostrar) seccionMostrar.style.display = 'block';

                document.querySelectorAll('.sidebar nav button').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });
    </script>
</body>
</html>
