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
    $materia = 'debate';

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
$sql_tareas = "SELECT * FROM tareas_profesor WHERE id_clase = ? ORDER BY fecha_creacion DESC";
$stmt_tareas = $conn->prepare($sql_tareas);
$stmt_tareas->bind_param("i", $id_clase);
$stmt_tareas->execute();
$resultado_tareas_profesor = $stmt_tareas->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSoft - Debate</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../materias/css/styleQuimica.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-comments"></i>
            <span>EduSoft</span>
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
                <span class="header-title">Club de Debate <span class="header-materia">Debate</span></span>
            </a>
            <div class="icons">
                <span class="settings"><i class="fas fa-cog"></i></span>
                <span class="profile"><i class="fas fa-user-circle"></i></span>
            </div>
        </header>
        <main>
<section id="tablon" class="seccion">
    <div class="banner banner-debate" id="bannerDebate">
        <h1>DEBATE</h1>
        <div class="abstract-shape"></div>
    </div>
    <div class="content">
        <div class="profesor">
            <div class="avatar-modern"></div>
            <p>Profesor<br><strong><?php echo htmlspecialchars($nombre); ?></strong></p>
        </div>
        <div class="tareas-container">
            <?php if (isset($resultado_tareas_profesor) && $resultado_tareas_profesor->num_rows > 0): ?>
                <?php while ($tarea = $resultado_tareas_profesor->fetch_assoc()): ?>
                    <div class="tarea">
                        <h4><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
                        <p><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                        <small>
                            <span>Tema</span>: <?php echo htmlspecialchars($tarea['tema']); ?>
                            | <span>Fecha límite</span>: <?php echo $tarea['fecha_entrega']; ?>
                            | <span>Puntos</span>: <?php echo $tarea['puntos']; ?>
                        </small>
                        <?php if (!empty($tarea['archivo_adjunto'])): ?>
                            <br>
                            <a href="<?php echo htmlspecialchars($tarea['archivo_adjunto']); ?>" target="_blank">📎 Ver archivo adjunto</a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No se han asignado tareas aún.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

            <section id="tareas" class="seccion" style="display: none;">
                <h2>Tareas</h2>
                <ul class="lista-tareas">
                    <li>
                        <i class="fas fa-comments"></i>
                        <span>Ensayo de Argumentación</span>
                        <p>Redacta un ensayo defendiendo tu postura sobre el tema actual.</p>
                        <small>Fecha límite: 10 de abril</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-balance-scale"></i>
                        <span>Debate grupal</span>
                        <p>Participa en el debate grupal sobre el tema propuesto.</p>
                        <small>Fecha límite: 12 de abril</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-microphone"></i>
                        <span>Exposición oral</span>
                        <p>Prepara una exposición oral de 5 minutos sobre un tema libre.</p>
                        <small>Fecha límite: 15 de abril</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                </ul>
            </section>
            <section id="alumnos" class="seccion" style="display: none;">
                <h2>Lista de Alumnos</h2>
                <ul class="lista-alumnos">
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Juan Pérez</span>
                        <p>Equipo: A</p>
                        <small>Correo electrónico: juan.perez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>María López</span>
                        <p>Equipo: B</p>
                        <small>Correo electrónico: maria.lopez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Carlos Gómez</span>
                        <p>Equipo: A</p>
                        <small>Correo electrónico: carlos.gomez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Ana Ramírez</span>
                        <p>Equipo: B</p>
                        <small>Correo electrónico: ana.ramirez@gmail.com</small>
                    </li>
                </ul>
            </section>
            <section id="avisos" class="seccion" style="display: none;">
                <h2>Avisos</h2>
                <ul class="lista-avisos">
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Debate final</span>
                        <p>El debate final se realizará el próximo viernes. Prepara tus argumentos.</p>
                        <small>Fecha: 15 de abril</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Entrega de ensayos</span>
                        <p>Recuerda entregar tu ensayo antes del miércoles.</p>
                        <small>Fecha: 12 de abril</small>
                    </li>
                </ul>
            </section>
        </main>
    </div>
    <!-- Modal HTML -->
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
    <script src="../materias/js/scriptCiencias.js"></script>
</body>
</html>