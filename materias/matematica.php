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
    $materia = 'matematica'; // Cambia aquí el nombre de la materia si corresponde

    // Obtener tareas que subió este estudiante en esta materia
    $sql = "SELECT nombre_archivo, ruta_archivo, fecha_subida FROM tareas WHERE id_estudiante = ? AND materia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_estudiante, $materia);
    $stmt->execute();
    $resultado_tareas = $stmt->get_result();
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

// Obtener materiales de estudio para esta clase
$materiales_clase = [];
$sql_materiales = "SELECT * FROM materiales_estudio WHERE id_clase = ? ORDER BY fecha_subida DESC";
$stmt_materiales = $conn->prepare($sql_materiales);
$stmt_materiales->bind_param("i", $id_clase);
$stmt_materiales->execute();
$resultado_materiales = $stmt_materiales->get_result();
while ($material = $resultado_materiales->fetch_assoc()) {
    $materiales_clase[] = $material;
}

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
    <style>
        .tablon-secciones {
            display: flex;
            gap: 28px;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .tablon-section {
            flex: 1 1 320px;
            min-width: 320px;
            max-width: 380px;
            background: #f9f9fb;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(44,64,187,.09);
            padding: 14px 18px 6px 18px;
            margin-bottom: 10px;
        }
        .tablon-section h3 {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .tablon-card {
            background: #f5f5f5;
            border-radius: 5px;
            margin: 12px 0;
            padding: 14px 14px 10px 14px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            font-weight: 500;
            color: #333;
            cursor: pointer;
            transition: background 0.18s;
            display: block;
            text-decoration: none;
            border-left: 5px solid #e4eaff;
            min-height: 80px;
        }
        .tablon-card:hover {
            background: #e4eaff;
        }
        .tablon-titulo {
            font-size: 1.07em;
            font-weight: bold;
        }
        .tablon-desc {
            font-size: 0.97em;
            color: #444;
            margin: 4px 0 0 0;
        }
        .tablon-info {
            font-size: 0.93em;
            color: #888;
            margin-top: 5px;
            font-weight: normal;
        }
        .sidebar nav button.active {
            background: #e4eaff;
            color: #2d3483;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(44,64,187,.12);
        }
        @media (max-width: 1100px) {
            .tablon-secciones { flex-direction: column; gap: 10px;}
            .tablon-section { max-width: none; min-width: 0;}
        }
    </style>
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
        </nav>
    </div>
    <div class="main-content">
        <header>
            <a href="../cursos.php" class="logo modern-back">
                <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
                <span class="header-title" data-i18n="segundo">Segundo año B <span class="header-materia" data-i18n="matematicaM">Matemática</span></span>
            </a>
            <div class="icons">
                <span class="settings"><i class="fas fa-cog"></i></span>
                <span class="profile"><i class="fas fa-user-circle"></i></span>
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


    <!-- Formulario para estudiantes subir tarea -->
    <?php if (isset($_SESSION['id_estudiante'])): ?>
        <h2 data-i18n="sube">Sube tu tarea</h2>
        <form id="formSubirTarea" action="subir_tarea_ajax.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="materia" value="matematica">
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
        </main>
    </div>
    <script src="../materias/js/scriptMatematica.js"></script>
</body>
</html>