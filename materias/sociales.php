<?php
session_start();
require_once "../conexiones/conexion.php";

// Verificar si el usuario está logueado como profesor o como estudiante
if (!isset($_SESSION['id']) && !isset($_SESSION['id_estudiante'])) {
    die("⚠️ Debes iniciar sesión como profesor o estudiante para acceder a esta materia.");
}

// Lógica para estudiantes
if (isset($_SESSION['id_estudiante'])) {
    $id_estudiante = $_SESSION['id_estudiante'];
    $materia = 'sociales';

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

    $nombre = $_SESSION['nombre'];

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

    // Obtener tareas para esta clase y guardarlas en array $tareas_profesor
    $sql_tareas = "SELECT * FROM tareas_profesor WHERE id_clase = ? ORDER BY fecha_creacion DESC";
    $stmt_tareas = $conn->prepare($sql_tareas);
    $stmt_tareas->bind_param("i", $id_clase);
    $stmt_tareas->execute();
    $result_tareas = $stmt_tareas->get_result();

    $tareas_profesor = [];
    while ($fila = $result_tareas->fetch_assoc()) {
        $tareas_profesor[] = $fila;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EduSoft - Sociales</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../materias/css/styleSociales.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-globe"></i>
            <span>EduSoft</span>
        </div>
        <nav>
            <button id="tablon-btn" class="active"><i class="fas fa-th-large"></i> Tablón</button>
            <button id="tareas-btn"><i class="fas fa-tasks"></i> Tareas</button>
            <button id="alumnos-btn"><i class="fas fa-users"></i> Alumnos</button>
            <button id="avisos-btn"><i class="fas fa-bell"></i> Avisos</button>
            <button id="material-btn"><i class="fas fa-folder-open"></i> Material</button>
        </nav>
    </div>
    <div class="main-content">
        <header>
            <a href="../cursos.php" class="logo modern-back">
                <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
                <span class="header-title">Segundo año B <span class="header-materia">Sociales</span></span>
            </a>
            <div class="icons">
                <span class="settings"><i class="fas fa-cog"></i></span>
                <span class="profile"><i class="fas fa-user-circle"></i></span>
            </div>
        </header>
        <main>
            <section id="tablon" class="seccion">
                <div class="banner" id="banner-sociales">
                    <canvas id="particles-bg"></canvas>
                    <div class="abstract-shape"></div>
                    <h1>SOCIALES</h1>
                </div>
                <div class="content">
                    <div class="profesor">
                        <div class="avatar-modern"></div>
                        <p>Profesor<br><strong><?php echo htmlspecialchars($nombre ?? ''); ?></strong></p>
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
                <h2>Tareas</h2>
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
            </section>

            <section id="alumnos" class="seccion" style="display: none;">
                <h2>Lista de Alumnos</h2>
                <ul class="lista-alumnos">
                    <!-- Aquí tu lista o código dinámico para alumnos -->
                </ul>
            </section>

            <section id="avisos" class="seccion" style="display: none;">
                <h2>Avisos</h2>
                <ul class="lista-avisos">
                    <!-- Aquí tu lista o código dinámico para avisos -->
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

    <script src="../materias/js/scriptSociales.js"></script>
    <script>
    // Script simple para mostrar/ocultar secciones con los botones sidebar
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
