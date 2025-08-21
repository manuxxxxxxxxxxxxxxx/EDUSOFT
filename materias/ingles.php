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
    $sql = "SELECT nombre_archivo, ruta_archivo, fecha_subida FROM tareas WHERE id_estudiante = ? AND materia = ?";
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
$tareas_profesor = []; // para almacenar las tareas del profesor

if (isset($_SESSION['id']) && $_SESSION['rol'] === 'profesor' && isset($id_clase)) {
    // Ya validaste arriba que la clase pertenece al profesor

    $sql_tareas = "SELECT * FROM tareas_profesor WHERE id_clase = ? ORDER BY fecha_creacion DESC";
    $stmt_tareas = $conn->prepare($sql_tareas);
    $stmt_tareas->bind_param("i", $id_clase);
    $stmt_tareas->execute();
    $resultado_tareas_profesor = $stmt_tareas->get_result();

    while ($fila = $resultado_tareas_profesor->fetch_assoc()) {
        $tareas_profesor[] = $fila;
    }
}

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSoft - Inglés</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../materias/css/styleIngles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-language" style="color: #00bcd4;"></i> <span>EduSoft</span>
        </div>
        <nav>
            <button id="tablon-btn" class="active"><i class="fas fa-th-large"></i>Tablón</button>
            <button id="tareas-btn"><i class="fas fa-tasks"></i>Tareas</button>
            <button id="alumnos-btn"><i class="fas fa-users"></i>Alumnos</button>
            <button id="avisos-btn"><i class="fas fa-bell"></i>Avisos</button>
        </nav>
    </div>
    <div class="main-content">
        <header>
            <a href="../extracurriculares.php" class="logo modern-back">
                <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
                <span class="header-title">Segundo año B <span class="header-materia">Inglés</span></span> 
            </a>
            <div class="icons">
                <span class="settings"><i class="fas fa-cog"></i></span>
                <span class="profile"><i class="fas fa-user-circle"></i></span>
            </div>
        </header>
        <main>
            <section id="tablon" class="seccion">
                <div class="banner banner-ingles" id="banner-ingles"> 
                    <canvas id="particles-bg"></canvas>
                    <div class="abstract-shape"></div>
                    <h1>ENGLISH</h1> 
                </div>
                <div class="content">
                    <div class="profesor">
                        <div class="avatar-modern" style="background-image: url('https://ui-avatars.com/api/?name=Laura+Smith&background=80deea&color=006064');"></div>
                        <p>Profesor<br><strong><?php echo htmlspecialchars($nombre); ?></strong></p>
                    </div>
                        <div class="tareas-container">
                            <?php if (!empty($tareas_profesor)): ?>
                                <?php foreach ($tareas_profesor as $tarea): ?>
                            <div class="tarea">
                                <h4><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
                                <p><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                                <small>Fecha límite: <?php echo htmlspecialchars($tarea['fecha_entrega']); ?> | Puntos: <?php echo $tarea['puntos']; ?></small>
                                <?php if (!empty($tarea['ruta_archivo'])): ?>
                                    <br><a href="<?php echo htmlspecialchars($tarea['ruta_archivo']); ?>" target="_blank">📎 Ver archivo adjunto</a>
                                <?php endif; ?>
                            </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p>No se han asignado tareas aún.</p>
                                <?php endif; ?>
                        </div>
                    </div>
            </section>
        <section id="tareas" class="seccion" style="display: none;">
            <h2 data-i18n="tareas">Tareas</h2>
            <!-- Mostrar tareas del profesor -->
                <div class="tareas-container">
                    <?php if (!empty($tareas_profesor)): ?>
                        <?php foreach ($tareas_profesor as $tarea): ?>
                            <div class="tarea">
                                <i class="fas fa-book"></i>
                                <h4><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
                                <p><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                                <small>Fecha límite: <?php echo htmlspecialchars($tarea['fecha_entrega']); ?> | Puntos: <?php echo $tarea['puntos']; ?></small>
                                <?php if (!empty($tarea['ruta_archivo'])): ?>
                                    <br><a href="<?php echo htmlspecialchars($tarea['ruta_archivo']); ?>" target="_blank">📎 Ver archivo adjunto</a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No se han asignado tareas aún.</p>
                    <?php endif; ?>
                </div>

    <!-- Formulario para estudiantes subir tarea -->
    <?php if (isset($_SESSION['id_estudiante'])): ?>
        <h2 data-i18n="sube">Sube tu tarea de Arte</h2>
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
                <h2>Lista de Alumnos</h2>
                <ul class="lista-alumnos">
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Diego Torres</span>
                        <p>Número de estudiante: 009</p>
                        <small>Correo electrónico: diego.torres@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Valeria Castro</span>
                        <p>Número de estudiante: 010</p>
                        <small>Correo electrónico: valeria.castro@gmail.com</small>
                    </li>
                </ul>
            </section>
<section id="avisos" class="seccion" style="display: none;">
    <h2 data-i18n="avisos">Avisos</h2>
    <ul class="lista-avisos">
        <?php
        // Mostrar los avisos de la clase actual
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
        </main>
    </div>
    
    <div id="modalTarea" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitulo">Título de la tarea</h2>
            <p id="modalDescripcion">Descripción de la tarea</p>
            <div class="modal-section">
                <label for="archivoSubir">Subir archivos:</label>
                <input type="file" id="archivoSubir" multiple>
                <ul id="listaArchivos"></ul>
            </div>
            <div class="modal-section">
                <label for="enlaceInput">Añadir enlace:</label>
                <input type="url" id="enlaceInput" placeholder="https://">
                <button id="agregarEnlace">Agregar enlace</button>
                <ul id="listaEnlaces"></ul>
            </div>
        </div>
    </div>
    
    <script src="../materias/js/scriptIngles.js"></script>
</body>
</html>