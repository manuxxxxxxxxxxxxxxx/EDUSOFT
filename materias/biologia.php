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
    <title>EduSoft - Biología</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../materias/css/styleBiologia.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="../js/subir_tarea.js"></script>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-logo">
        <i class="fas fa-dna"></i>
        <span>EduSoft</span>
    </div>
    <nav>
        <button data-i18n="tablon" id="tablon-btn" class="active"><i class="fas fa-th-large"></i> Tablón</button>
        <button data-i18n="tareas" id="tareas-btn"><i class="fas fa-tasks"></i> Tareas</button>
        <button data-i18n="alumnos" id="alumnos-btn"><i class="fas fa-users"></i> Alumnos</button>
        <button data-i18n="avisos" id="avisos-btn"><i class="fas fa-bell"></i> Avisos</button>
    </nav>
</div>

<div class="main-content">
    <header>
        <a href="../cursos.php" class="logo modern-back">
            <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
            <span data-i18n="segundo" class="header-title">Segundo año B <span class="header-materia" data-i18n="biologiaM">Biología</span></span>
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
                <h1>BIOLOGÍA</h1>
            </div>
            <div class="content">
                <div class="profesor">
                    <div class="avatar-modern"></div>
                    <p data-i18n="profesor">Profesor<br><strong><?php echo htmlspecialchars($nombre); ?></strong></p>
                </div>
                <div class="tareas-container">
                    <?php if (isset($resultado_tareas_profesor) && $resultado_tareas_profesor->num_rows > 0): ?>
                        <?php while ($tarea = $resultado_tareas_profesor->fetch_assoc()): ?>
                            <div class="tarea">
                                <h4 data-i18n="titulo"><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
                                <p data-i18n="descripcion"><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                                <small data-i18n="fechal">Fecha límite: <?php echo $tarea['fecha_entrega']; ?> | Puntos: <?php echo $tarea['puntos']; ?></small>
                                <?php if (!empty($tarea['ruta_archivo'])): ?>
                                    <br><a href="<?php echo htmlspecialchars($tarea['ruta_archivo']); ?>" target="_blank" data-i18n="archivo">📎 Ver archivo adjunto</a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p data-i18n="notareas">No se han asignado tareas aún.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section id="tareas" class="seccion" style="display: none;">
            <h2 data-i18n="tareas">Tareas</h2>
            <ul class="lista-tareas">
                <li>
                    <i class="fas fa-atom"></i>
                    <span data-i18n="tarea">Tarea de Biología Celular</span>
                    <p data-i18n="resolver">Resolver los problemas de biología celular del capítulo 3.</p>
                    <small data-i18n="fecha">Fecha límite: 10 de abril</small>

                    <h2 data-i18n="sube">Sube tu tarea de Biología</h2>
                    <form id="formSubirTarea" action="subir_tarea_ajax.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="materia" value="biologia">
                        <input type="hidden" name="id_estudiante" value="<?php echo $_SESSION['id_estudiante']; ?>">
                        <label for="archivo">Archivo (PDF, DOCX, JPG...):</label>
                        <input type="file" name="archivo" id="archivo" required><br><br>
                        <button type="submit" data-i18n="subir">Subir tarea</button>
                    </form>

                    <div id="mensajeSubida"></div>

                    <h3 data-i18n="subidas">Tareas subidas</h3>
                    <ul id="listaTareas" style="list-style-type: none; padding-left: 0;">
                        <?php if (isset($resultado_tareas)) {
                            while ($fila = $resultado_tareas->fetch_assoc()) {
                                $id = $fila['id'] ?? null;
                                $nombre_archivo = htmlspecialchars($fila['nombre_archivo']);
                                $ruta = htmlspecialchars($fila['ruta_archivo']);
                                $fecha = htmlspecialchars($fila['fecha_subida']);

                                echo "<li id='tarea_$id'>
                                        <a href='$ruta' target='_blank'>$nombre_archivo</a> <small>($fecha)</small>
                                        <button onclick='eliminarTarea($id)'>❌ Eliminar</button>
                                      </li>";
                            }
                        } ?>
                    </ul>
                </li>

                <!-- Otras tareas ficticias -->
                <li>
                    <i class="fas fa-dna"></i>
                    <span data-i18n="proyecto">Proyecto de Biología Molecular</span>
                    <p data-i18n="crearM">Crear un proyecto sobre la biología molecular.</p>
                    <small data-i18n="limete">Fecha límite: 12 de abril</small>
                    <button data-i18n="añadir" class="boton-estilo">Añadir tarea</button>
                </li>
                <li>
                    <i class="fas fa-tree"></i>
                    <span data-i18n="examen">Examen de Biología Evolutiva</span>
                    <p data-i18n="estudiar">Estudiar para el examen de biología evolutiva que se realizará el próximo viernes.</p>
                    <small data-i18n="limete">Fecha límite: 15 de abril</small>
                    <button data-i18n="añadir" class="boton-estilo">Añadir tarea</button>
                </li>
                <li>
                    <i class="fas fa-pen"></i>
                    <span data-i18n="tarea">Tarea de Biología Ambiental</span>
                    <p data-i18n="escribir">Escribir un ensayo sobre la importancia de la biología ambiental en la conservación del medio ambiente.</p>
                    <small data-i18n="limete">Fecha límite: 17 de abril</small>
                    <button data-i18n="añadir" class="boton-estilo">Añadir tarea</button>
                </li>
            </ul>
        </section>

        <section id="alumnos" class="seccion" style="display: none;">
            <h2 data-i18n="lista">Lista de Alumnos</h2>
            <ul class="lista-alumnos">
                <!-- Lista estática de alumnos -->
                <!-- Puedes convertir esto en dinámica luego -->
            </ul>
        </section>

        <section id="avisos" class="seccion" style="display: none;">
            <h2 data-i18n="avisos">Avisos</h2>
            <ul class="lista-avisos">
                <!-- Lista estática de avisos -->
            </ul>
        </section>
    </main>
</div>

<div id="modalTarea" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalTitulo" data-i18n="titulo">Título de la tarea</h2>
        <p id="modalDescripcion" data-i18n="descripcion">Descripción de la tarea</p>
        <div class="modal-section">
            <label for="archivoSubir" data-i18n="archivos">Subir archivos:</label>
            <input type="file" id="archivoSubir" multiple>
            <ul id="listaArchivos"></ul>
        </div>
        <div class="modal-section">
            <label for="enlaceInput" data-i18n="enlace">Añadir enlace:</label>
            <input type="url" id="enlaceInput" placeholder="https://">
            <button id="agregarEnlace" data-i18n="agregarE">Agregar enlace</button>
            <ul id="listaEnlaces"></ul>
        </div>
    </div>
</div>

<script src="../materias/js/scriptBiologia.js"></script>
</body>
</html>
