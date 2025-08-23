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
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title data-i18n="titulo_deportes">EduSoft - Deportes</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../materias/css/styleDeportes copy.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="../materias/js/subir_tarea.js" defer></script>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-logo">
        <i class="fas fa-running" style="color: #66bb6a;"></i> <span data-i18n="logo_edusoft">EduSoft</span>
    </div>
    <nav>
        <button data-i18n="tablon" id="tablon-btn" class="active"><i class="fas fa-th-large"></i> <span data-i18n="tablon_texto">Tablón</span></button>
        <button data-i18n="tareas" id="tareas-btn"><i class="fas fa-tasks"></i> <span data-i18n="tareas_texto">Tareas</span></button>
        <button id="material-btn"><i class="fas fa-folder-open"></i> <span data-i18n="material_texto">Material</span></button>
        <button data-i18n="alumnos" id="alumnos-btn"><i class="fas fa-users"></i> <span data-i18n="alumnos_texto">Alumnos</span></button>
        <button data-i18n="avisos" id="avisos-btn"><i class="fas fa-bell"></i> <span data-i18n="avisos_texto">Avisos</span></button>
    </nav>
</div>

<div class="main-content">
    <header>
        <a href="../extracurriculares.php" class="logo modern-back">
            <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
            <span data-i18n="segundo" class="header-title"><span data-i18n="segundo_texto">Segundo año B</span> <span class="header-materia" data-i18n="deportesN">Deportes</span></span>
        </a>
        <div class="icons">
            <span class="settings" data-i18n="settings"><i class="fas fa-cog"></i></span>
            <span class="profile" data-i18n="profile"><i class="fas fa-user-circle"></i></span>
        </div>
    </header>

    <main>
        <section id="tablon" class="seccion">
            <div class="banner" id="banner6">
                <canvas id="particles-bg"></canvas>
                <div class="abstract-shape"></div>
                <h1 data-i18n="deportes">DEPORTES</h1>
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
                                    <br /><a href="<?php echo htmlspecialchars($tarea['ruta_archivo']); ?>" target="_blank" data-i18n="archivo">📎 <span data-i18n="archivo_adj">Ver archivo adjunto</span></a>
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
            </section><section id="tareas" class="seccion" style="display: none;">
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
            <h2><i class="fas fa-folder-open"></i> <span data-i18n="material_materia">Material de la materia</span></h2>
            <ul class="lista-material">
                <?php
                if (!isset($id_clase)) {
                    echo "<li data-i18n='no_clase'>⚠️ Clase no especificada.</li>";
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
                            echo "<i class='fas $icono'></i> <strong data-i18n='material_titulo'>$titulo</strong><br>";
                            if ($descripcion) {
                                echo "<p data-i18n='material_desc'>$descripcion</p>";
                            }
                            echo "<a href='$ruta' target='_blank' data-i18n='material_descargar'>📎 <span data-i18n='descargar_archivo'>Descargar archivo</span>: $archivo</a><br>";
                            echo "<small data-i18n='material_fecha'>Subido el $fecha</small>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li data-i18n='no_materiales'>📭 No hay materiales disponibles para esta clase.</li>";
                    }
                }
                ?>
            </ul>
        </section>
    </main>
</div>


<script src="../materias/js/scriptArte.js"></script>
<script src="../principal/lang.js"></script>
<script src="../principal/idioma.js"></script>
</body>
</html>