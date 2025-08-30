<?php 
require_once "../conexiones/conexion.php"; 

session_start();
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../loginProfes.php");
    exit;
}
$profesor_id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];

// Procesar subida de foto de perfil
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['guardar_foto'])) {
    // Si se sube archivo
    if (!empty($_FILES['foto_file']['name'])) {
        $target_dir = "../uploads/profesores/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true); // crea carpeta si no existe
        $nombre_archivo = "profesor_" . $profesor_id . "_" . time() . "_" . basename($_FILES["foto_file"]["name"]);
        $target_file = $target_dir . $nombre_archivo;
        $tipo = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $esImagen = in_array($tipo, ["jpg", "jpeg", "png", "gif"]);
        if ($esImagen && move_uploaded_file($_FILES["foto_file"]["tmp_name"], $target_file)) {
            $ruta_guardar = "uploads/profesores/" . $nombre_archivo; // ruta relativa para mostrar
            $stmtFoto = $conn->prepare("UPDATE profesores SET foto = ? WHERE id = ?");
            $stmtFoto->bind_param("si", $ruta_guardar, $profesor_id);
            $stmtFoto->execute();
            $stmtFoto->close();
            $_SESSION['foto'] = $ruta_guardar;
            header("Location: index.php");
            exit;
        } else {
            $error = "Solo se permiten imágenes jpg, png, gif";
        }
    }
    // Si se pone URL manual
    elseif (!empty($_POST['foto_url'])) {
        $nueva_foto = trim($_POST['foto_url']);
        $stmtFoto = $conn->prepare("UPDATE profesores SET foto = ? WHERE id = ?");
        $stmtFoto->bind_param("si", $nueva_foto, $profesor_id);
        $stmtFoto->execute();
        $stmtFoto->close();
        $_SESSION['foto'] = $nueva_foto;
        header("Location: index.php");
        exit;
    }
}

$stmtFoto = $conn->prepare("SELECT foto FROM profesores WHERE id = ?");
$stmtFoto->bind_param("i", $profesor_id);
$stmtFoto->execute();
$stmtFoto->bind_result($foto_url);
$stmtFoto->fetch();
$stmtFoto->close();
$_SESSION['foto'] = $foto_url ?: 'https://ui-avatars.com/api/?name=Maestro+Ejemplo';

// Consulta para traer las clases del profesor para los select
$sql = "SELECT id, nombre_clase, materia, codigo_clase FROM clases WHERE profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$resultado = $stmt->get_result();
$clases = $resultado->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Obtener id_clase para filtro
$id_clase = isset($_GET['id_clase']) ? intval($_GET['id_clase']) : null;

$clase_nombre = $clase_materia = "";
if ($id_clase) {
    $stmt_clase = $conn->prepare("SELECT nombre_clase, materia FROM clases WHERE id = ?");
    $stmt_clase->bind_param("i", $id_clase);
    $stmt_clase->execute();
    $res_clase = $stmt_clase->get_result();
    if ($row_clase = $res_clase->fetch_assoc()) {
        $clase_nombre = $row_clase['nombre_clase'];
        $clase_materia = $row_clase['materia'];
    }
    $stmt_clase->close();
}

// RESPUESTAS MULTIHILO EN COMENTARIOS
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_comentario_resp'], $_POST['texto_respuesta'])) {
    $id_comentario_resp = intval($_POST['id_comentario_resp']);
    $texto_respuesta = trim($_POST['texto_respuesta']);
    $tipo_usuario = 'profesor';
    $id_usuario = $profesor_id;
    if ($texto_respuesta && $id_comentario_resp && $id_usuario) {
        $stmt_insert = $conn->prepare("INSERT INTO respuestas_comentario (id_comentario, id_usuario, tipo_usuario, respuesta) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("iiss", $id_comentario_resp, $id_usuario, $tipo_usuario, $texto_respuesta);
        $stmt_insert->execute();
        $stmt_insert->close();
        header("Location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['respuesta_comentario'])) {
    $respuesta = trim($_POST['respuesta_comentario']);
    $comentario_id = intval($_POST['comentario_id']);
    if ($respuesta && $comentario_id) {
        $stmt_resp = $conn->prepare("UPDATE comentarios_clase SET respuesta = ?, id_profesor = ?, fecha_respuesta = NOW(), estado = 'respondido' WHERE id = ?");
        $stmt_resp->bind_param("sii", $respuesta, $profesor_id, $comentario_id);
        $stmt_resp->execute();
        $stmt_resp->close();
        header("Location: index.php?id_clase=$id_clase");
        exit;
    }
}

// Cargar comentarios de alumnos
$comentarios = [];
if ($id_clase) {
    $sql_comentarios = "SELECT c.*, e.nombre AS nombre_alumno FROM comentarios_clase c
        LEFT JOIN estudiantes e ON c.id_estudiante = e.ID
        WHERE c.id_clase = ?
        ORDER BY c.estado DESC, c.fecha DESC";
    $stmt_coment = $conn->prepare($sql_comentarios);
    $stmt_coment->bind_param("i", $id_clase);
    $stmt_coment->execute();
    $res_coment = $stmt_coment->get_result();
    while ($row = $res_coment->fetch_assoc()) {
        $comentarios[] = $row;
    }
    $stmt_coment->close();
} else {
    $sql_comentarios = "SELECT c.*, e.nombre AS nombre_alumno, cl.nombre_clase, cl.materia
        FROM comentarios_clase c
        LEFT JOIN estudiantes e ON c.id_estudiante = e.ID
        INNER JOIN clases cl ON c.id_clase = cl.id
        WHERE cl.profesor_id = ?
        ORDER BY c.estado DESC, c.fecha DESC";
    $stmt_coment = $conn->prepare($sql_comentarios);
    $stmt_coment->bind_param("i", $profesor_id);
    $stmt_coment->execute();
    $res_coment = $stmt_coment->get_result();
    while ($row = $res_coment->fetch_assoc()) {
        $comentarios[] = $row;
    }
    $stmt_coment->close();
}
$pendientes = 0;
foreach ($comentarios as $c) {
    if ($c['estado'] === 'pendiente') $pendientes++;
}
// Conteo único de alumnos
$alumno_ids = [];
foreach ($clases as $clase) {
    $sql = "SELECT e.ID FROM clases_estudiantes ce JOIN estudiantes e ON ce.id_estudiante = e.ID WHERE ce.id_clase = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clase['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $alumno_ids[$row['ID']] = true; // solo un id por alumno
    }
    $stmt->close();
}
$total_alumnos_unicos = count($alumno_ids);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Maestro | Edusoft</title>
    <link rel="stylesheet" href="/frontend_maestros/stylemaestro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="/frontend_maestros/script.js"></script>
    <script>
    function confirmEliminar(tipo) {
        if (tipo === 'tarea') return confirm('¿Estás seguro de que deseas eliminar esta tarea?');
        if (tipo === 'material') return confirm('¿Estás seguro de que deseas eliminar este material?');
        if (tipo === 'aviso') return confirm('¿Estás seguro de que deseas eliminar este aviso?');
        return true;
    }
    document.addEventListener('DOMContentLoaded', function(){
        var buscador = document.getElementById('search-student');
        if(buscador) {
            buscador.addEventListener('input', function() {
                var filtro = this.value.toLowerCase();
                document.querySelectorAll('#student-list li[data-nombre]').forEach(function(li){
                    li.style.display = li.getAttribute('data-nombre').includes(filtro) ? '' : 'none';
                });
            });
        }
    });

    //NUEVO BOTON IMAGEN MODIFICAR PROFE
    document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.form-imagen-materia').forEach(function(form) {
    form.addEventListener('submit', function(e) {
      // Busca los inputs dentro del formulario actual
      const archivo = form.querySelector('.imagen_materia').files[0];
      const enlace = form.querySelector('.enlace_imagen').value.trim();

      if (!archivo && !enlace) {
        alert('Debes subir una imagen o poner el enlace.');
        e.preventDefault();
        return false;
      }

      if (enlace) {
        if (!/^https?:\/\/.+\.(jpg|jpeg|png|webp|gif)$/i.test(enlace)) {
          alert('El enlace debe ser una URL válida de imagen (jpg, png, webp, gif).');
          e.preventDefault();
          return false;
        }
      }

      if (archivo) {
        const permitidas = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!permitidas.includes(archivo.type)) {
          alert('El archivo debe ser una imagen jpg, png, webp o gif.');
          e.preventDefault();
          return false;
        }
      }
    });
  });
});
    </script>
</head>
<body>
    <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Abrir menú">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar">
        <?php
        $foto = $_SESSION['foto'] ?? 'https://ui-avatars.com/api/?name=Maestro+Ejemplo';
        if (preg_match('/^https?:\/\//', $foto)) {
            $src = $foto;
        } else {
            $src = '/' . $foto;
        }
        ?>
        <img id="profile-img" src="<?= htmlspecialchars($src) ?>" alt="Foto de perfil del Maestro Ejemplo">
        <h2 id="profile-name">Docente <?php echo htmlspecialchars($nombre); ?></h2>
        <nav>
            <a href="#"><i class="fas fa-home"></i>Inicio</a>
            <a href="#"><i class="fas fa-book"></i>Cursos <span class="badge">3</span></a>
            <a href="#"><i class="fas fa-users"></i>Alumnos</a>
            <a href="#"><i class="fas fa-tasks"></i>Tareas <span class="badge">3</span></a>
            <a href="#"><i class="fas fa-folder-open"></i>Materiales</a>
            <a href="#"><i class="fas fa-bullhorn"></i>Avisos</a>
            <a href="#"><i class="fas fa-envelope"></i>Mensajes <span class="badge">2</span></a>
            <a href="#"><i class="fas fa-user"></i>Perfil</a>
            <a href="../loginProfes.php"><i class="fas fa-sign-out-alt"></i>Salir</a>
        </nav>
    </div>
    <div class="main-content">
    <!-- INICIO DINÁMICO -->
        <div id="seccion-inicio" class="seccion-panel">
            <div class="dashboard-cards">
                <div class="card">
                    <i class="fas fa-book fa-2x icon-green"></i>
                    <h3><?= count($clases) ?></h3>
                    <p>Cursos asignados</p>
                    <button class="quick-action" onclick="location.reload()">Ver cursos</button>
                </div>
                <div class="card">
                    <i class="fas fa-users fa-2x icon-blue"></i>
                    <h3>
                        <?php
                        // Total de alumnos únicos en todas las clases
                        $alumno_ids = [];
                        foreach ($clases as $clase) {
                            $sql = "SELECT e.ID FROM clases_estudiantes ce JOIN estudiantes e ON ce.id_estudiante = e.ID WHERE ce.id_clase = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $clase['id']);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            while ($row = $res->fetch_assoc()) {
                                $alumno_ids[$row['ID']] = true; // solo cuenta una vez si está en varias clases
                            }
                            $stmt->close();
                        }
                        echo count($alumno_ids);
                        ?>
                    </h3>
                    <p>Alumnos</p>
                    <button class="quick-action" onclick="location.reload()">Ver alumnos</button>
                </div>
                <div class="card">
                    <i class="fas fa-tasks fa-2x icon-orange"></i>
                    <h3>
                        <?php
                        // Tareas pendientes (por clase)
                        $tareas_pendientes = 0;
                        if ($id_clase) {
                            $sql = "SELECT COUNT(*) AS total FROM tareas_profesor WHERE id_clase = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $id_clase);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            $row = $res->fetch_assoc();
                            $tareas_pendientes = intval($row['total']);
                            $stmt->close();
                        } else {
                            foreach ($clases as $clase) {
                                $sql = "SELECT COUNT(*) AS total FROM tareas_profesor WHERE id_clase = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $clase['id']);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                $row = $res->fetch_assoc();
                                $tareas_pendientes += intval($row['total']);
                                $stmt->close();
                            }
                        }
                        echo $tareas_pendientes;
                        ?>
                    </h3>
                    <p>Tareas registradas</p>
                    <button class="quick-action" onclick="location.reload()">Ver tareas</button>
                </div>
            </div>
            <div class="section">
                <h2>Bienvenido, <span id="welcome-name">Docente <?= htmlspecialchars($nombre ?? '') ?></span></h2>
                <p>Desde este panel puedes gestionar tus cursos, tareas, materiales, avisos y comunicarte con tus alumnos.</p>
            </div>
            <div class="section">
                <h3>Notificaciones recientes</h3>
                <ul class="notificaciones">
                    <?php
                    // Ejemplo de notificaciones dinámicas (últimos 3 comentarios, tareas o avisos)
                    $notificaciones = [];
                    // Últimos comentarios
                    $sql = "SELECT c.comentario, e.nombre AS nombre_alumno, c.fecha FROM comentarios_clase c LEFT JOIN estudiantes e ON c.id_estudiante = e.ID ORDER BY c.fecha DESC LIMIT 1";
                    $res = $conn->query($sql);
                    if ($row = $res->fetch_assoc()) {
                        $notificaciones[] = '<i class="fas fa-envelope icon-blue"></i> <span style="margin-left:14px;">Nuevo comentario de <b>' . htmlspecialchars($row['nombre_alumno'] ?? 'Alumno') . '</b></span>: <span style="margin-left:14px;">"' . htmlspecialchars($row['comentario'] ?? '') . '"</span>';
                    }
                    // Última tarea registrada
                    $sql = "SELECT t.titulo, t.fecha_entrega FROM tareas_profesor t ORDER BY t.fecha_entrega DESC LIMIT 1";
                    $res = $conn->query($sql);
                    if ($row = $res->fetch_assoc()) {
                        $notificaciones[] = '<i class="fas fa-check-circle icon-green"></i> <span style="margin-left:14px;">Última tarea registrada</span>: <span style="margin-left:14px;"><b>' . htmlspecialchars($row['titulo'] ?? '') . '</b></span> <span style="margin-left:14px;">(' . htmlspecialchars($row['fecha_entrega'] ?? '') . ')</span>';
                    }
                    // Último aviso publicado
                    $sql = "SELECT titulo, fecha_subida FROM avisos ORDER BY fecha_subida DESC LIMIT 1";
                    $res = $conn->query($sql);
                    if ($row = $res->fetch_assoc()) {
                        $notificaciones[] = '<i class="fas fa-bullhorn icon-orange"></i> <span style="margin-left:14px;">Último aviso publicado</span>: <span style="margin-left:14px;"><b>' . htmlspecialchars($row['titulo'] ?? '') . '</b></span> <span style="margin-left:14px;">(' . htmlspecialchars($row['fecha_subida'] ?? '') . ')</span>';
                    }
                    if (count($notificaciones) == 0) {
                        echo '<li>No hay notificaciones recientes.</li>';
                    } else {
                        foreach ($notificaciones as $n) echo '<li>' . $n . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- CURSOS -->
        <div id="seccion-cursos" class="seccion-panel">
            <div class="section">
                <h3>Mis cursos</h3>
                <input type="button" value="Crear curso" class="quick-action" onclick="window.location.href='../frontend_maestros/crear_curso.php'">
                <ul class="cursos-lista" id="cursos-lista">
                    <?php if (count($clases) > 0): ?>
                        <?php foreach ($clases as $clase): ?>
                            <li class="curso-item">
                                <div class="curso-info">
                                    <a class="curso-link" href="../materias/<?php echo $clase['materia']; ?>.php?id_clase=<?php echo $clase['id']; ?>">
                                        <?= htmlspecialchars($clase['nombre_clase']); ?>
                                    </a>
                                    <span class="curso-materia"> – <?= ucfirst($clase['materia']); ?></span><br>
                                    <span class="curso-codigo"><strong>Código de clase:</strong> <?= htmlspecialchars($clase['codigo_clase']); ?></span>
                                </div>
                                <div class="curso-imagen-form">
                                    <form class="form-imagen-materia" action="actualizar_imagen_materia.php" method="POST" enctype="multipart/form-data" style="display:inline; max-width:300px;">
                                        <input type="hidden" name="id_clase" value="<?= $clase['id'] ?>">
                                        <label for="imagen_materia">Imagen de la materia:</label>
                                        <input type="file" name="imagen_materia" class="imagen_materia" accept="image/*">
                                        <br>
                                        <label for="enlace_imagen">O enlace de imagen:</label>
                                        <input type="text" name="enlace_imagen" class="enlace_imagen" placeholder="https://ejemplo.com/imagen.jpg">
                                        <br>
                                        <button type="submit" class="btn btn-primary">Actualizar imagen</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No has creado ninguna clase aún.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <!-- ALUMNOS -->
        <div id="seccion-alumnos" class="seccion-panel">
            <div class="section alumnos-section">
                <h3>Alumnos</h3>
                <form method="get" action="index.php">
                    <select id="select-clase" name="id_clase" class="select-clase" onchange="this.form.submit()">
                        <option value="">Selecciona una clase</option>
                        <?php foreach ($clases as $clase): ?>
                            <option value="<?= $clase['id'] ?>" <?= ($id_clase == $clase['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <input type="text" id="search-student" placeholder="Buscar alumno..." class="alumnos-buscar" <?= empty($id_clase) ? 'disabled' : '' ?>>
                <ul id="student-list" class="lista-alumnos">
                <?php
                if ($id_clase) {
                    $sql = "SELECT ce.id AS numero_estudiante, e.nombre, e.email
                            FROM clases_estudiantes ce
                            JOIN estudiantes e ON ce.id_estudiante = e.ID
                            WHERE ce.id_clase = ?
                            ORDER BY ce.id ASC";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id_clase);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while($alumno = $result->fetch_assoc()) {
                            echo "<li data-nombre='".strtolower($alumno['nombre'])." ".strtolower($alumno['email'])."'>
                                <span class='alumno-nombre'>".htmlspecialchars($alumno['nombre'])."</span>
                                <span class='alumno-num'>".htmlspecialchars($alumno['numero_estudiante'])."</span>
                                <span class='alumno-email'>".htmlspecialchars($alumno['email'])."</span>
                            </li>";
                        }
                    } else {
                        echo "<li class='alumnos-vacio'>No hay alumnos inscritos en esta clase.</li>";
                    }
                    $stmt->close();
                } else {
                    echo "<li class='alumnos-vacio'>Selecciona una clase para ver los alumnos.</li>";
                }
                ?>
                </ul>
            </div>
        </div>
<div id="seccion-tareas" class="seccion-panel">
    <div class="section">
        <h3>Tareas</h3>
        <!-- BOTÓN DE CREAR/SUBIR TAREA CON ESTILO CONSISTENTE -->
        <form action="../frontend_maestros/subir_tarea.php" method="get" style="margin-bottom: 14px;">
            <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase ?? '') ?>">
            <button type="submit" class="quick-action" >
                <i class="fas fa-plus"></i> Crear tarea
            </button>
        </form>
        <form method="get" action="index.php">
            <select id="select-tarea-clase" name="id_clase" onchange="this.form.submit()">
                <option value="">Todas las clases</option>
                <?php foreach ($clases as $clase): ?>
                    <option value="<?= $clase['id'] ?>" <?= ($id_clase == $clase['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
        <ul id="tareas-lista">
            <?php
            // Si reviso tareas entregadas, fuerza el filtro solo a la clase de esa tarea
            if (isset($_GET['ver_entregas']) && isset($_GET['id_tarea_profesor'])) {
                $stmtClaseTarea = $conn->prepare("SELECT id_clase FROM tareas_profesor WHERE id = ?");
                $stmtClaseTarea->bind_param("i", $_GET['id_tarea_profesor']);
                $stmtClaseTarea->execute();
                $resClaseTarea = $stmtClaseTarea->get_result();
                if ($rowClaseTarea = $resClaseTarea->fetch_assoc()) {
                    $id_clase = $rowClaseTarea['id_clase'];
                }
                $stmtClaseTarea->close();
            }

            if ($id_clase) {
                // Tareas de la clase seleccionada
                $sqlTareas = "SELECT t.id, t.titulo, t.fecha_entrega, t.descripcion, c.materia 
                            FROM tareas_profesor t
                            INNER JOIN clases c ON t.id_clase = c.id
                            WHERE t.id_clase = ?
                            ORDER BY t.fecha_entrega DESC";
                $stmtTareas = $conn->prepare($sqlTareas);
                $stmtTareas->bind_param("i", $id_clase);
                $stmtTareas->execute();
                $resultadoTareas = $stmtTareas->get_result();
                if ($resultadoTareas->num_rows > 0):
                    while ($tarea = $resultadoTareas->fetch_assoc()): ?>
          <li>
                   <b><?= htmlspecialchars($tarea['titulo']); ?></b> 
                 – <?= ucfirst(htmlspecialchars($tarea['materia'])); ?> 
                – Fecha entrega: <?= htmlspecialchars($tarea['fecha_entrega']); ?>
                 <br><small><?= htmlspecialchars($tarea['descripcion']); ?></small>
        <div class="tarea-botones">
                  <form class="form-eliminar-tarea" action="../frontend_maestros/eliminar_tarea.php" method="POST" style="display:inline;">
                   <input type="hidden" name="accion" value="eliminar_tarea">
                  <input type="hidden" name="id_tarea" value="<?= $tarea['id']; ?>">
                 <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase); ?>">
                    <button type="button" class="btn-eliminar" onclick="abrirModalEliminarTarea('<?= $tarea['id'] ?>','<?= htmlspecialchars($tarea['titulo']) ?>')">Eliminar</button>
             </form>
        <form action="index.php" method="get" style="display:inline;">
            <input type="hidden" name="ver_entregas" value="1">
            <input type="hidden" name="id_tarea_profesor" value="<?= $tarea['id'] ?>">
            <input type="hidden" name="id_clase" value="<?= $id_clase ?>">
            <button type="submit" class="btn-ver-entregas">Tareas entregadas</button>
        </form>
         </div>
           </li>
                    <?php endwhile;
                else: ?>
                    <li>No hay tareas registradas para esta clase.</li>
                <?php endif;
                $stmtTareas->close();
            } else {
                // Mostrar tareas de todas las clases
                $sqlTareas = "SELECT t.id, t.titulo, t.fecha_entrega, t.descripcion, c.materia, c.nombre_clase, t.id_clase
                            FROM tareas_profesor t
                            INNER JOIN clases c ON t.id_clase = c.id
                            WHERE c.profesor_id = ?
                            ORDER BY c.nombre_clase, t.fecha_entrega DESC";
                $stmtTareas = $conn->prepare($sqlTareas);
                $stmtTareas->bind_param("i", $profesor_id);
                $stmtTareas->execute();
                $resultadoTareas = $stmtTareas->get_result();

                $tareasPorClase = [];
                while ($tarea = $resultadoTareas->fetch_assoc()) {
                    $tareasPorClase[$tarea['id_clase']]['nombre_clase'] = $tarea['nombre_clase'];
                    $tareasPorClase[$tarea['id_clase']]['materia'] = $tarea['materia'];
                    $tareasPorClase[$tarea['id_clase']]['tareas'][] = $tarea;
                }

                if (count($tareasPorClase) > 0) {
             foreach ($tareasPorClase as $idClase => $datosClase) {
                echo "<div class='tareas-clase-group'>";
               echo "<div class='tareas-clase-group-title'>" . htmlspecialchars($datosClase['nombre_clase']) . " – " . htmlspecialchars($datosClase['materia']) . "</div>";
                echo "<ul>";
             foreach ($datosClase['tareas'] as $tarea) {
                echo "<li>";
                echo "<b>" . htmlspecialchars($tarea['titulo']) . "</b> – Fecha entrega: " . htmlspecialchars($tarea['fecha_entrega']);
                echo "<br><small>" . htmlspecialchars($tarea['descripcion']) . "</small>";
                echo "<div class='tarea-botones'>";
       
                 echo "<form class='form-eliminar-tarea' action='../frontend_maestros/eliminar_tarea.php' method='POST' style='display:inline;'>";
                echo "<input type='hidden' name='accion' value='eliminar_tarea'>";
                echo "<input type='hidden' name='id_tarea' value='" . $tarea['id'] . "'>";
                echo "<input type='hidden' name='id_clase' value='" . htmlspecialchars($idClase) . "'>";
                echo "<button type='button' class='btn-eliminar' onclick=\"abrirModalEliminarTarea('" . $tarea['id'] . "','" . htmlspecialchars($tarea['titulo']) . "')\">Eliminar</button>";
                echo "</form>";
        
                echo "<form action='index.php' method='get' style='display:inline;'>";
                echo "<input type='hidden' name='ver_entregas' value='1'>";
                echo "<input type='hidden' name='id_tarea_profesor' value='" . $tarea['id'] . "'>";
                echo "<input type='hidden' name='id_clase' value='" . $idClase . "'>";
               echo "<button type='submit' class='btn-ver-entregas'>Tareas entregadas</button>";
               echo "</form>";
               echo "</div>"; // tarea-botones
              echo "</li>";
             }
                echo "</ul>";
                echo "</div>"; // tareas-clase-group
            }
                } else {
                    echo "<li>No hay tareas registradas aún.</li>";
                }
                $stmtTareas->close();
            }
            ?>
        </ul>
        <!-- BLOQUE DE TAREAS ENTREGADAS Y ARCHIVOS DE ALUMNOS -->
        <?php
        if (isset($_GET['ver_entregas']) && isset($_GET['id_tarea_profesor'])): 
            $id_tarea_profesor = intval($_GET['id_tarea_profesor']);
            $sql = "SELECT t.id, t.id_estudiante, t.fecha_subida, t.calificacion, t.retroalimentacion, e.nombre
                    FROM tareas t
                    JOIN estudiantes e ON t.id_estudiante = e.ID
                    WHERE t.id_tarea_profesor = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_tarea_profesor);
            $stmt->execute();
            $res = $stmt->get_result();
            ?>
           <div class="entregas-section">
    <h3>Tareas entregadas por alumnos</h3>
    <?php
    if ($res->num_rows == 0) {
        echo "<p>No hay entregas aún.</p>";
    } else {
        while ($entrega = $res->fetch_assoc()) {
            ?>
            <div class="entrega-card">
                <div class="entrega-header">
                    <b><?= htmlspecialchars($entrega['nombre']) ?></b>
                    <span class="entrega-fecha">Fecha entrega: <?= htmlspecialchars($entrega['fecha_subida']) ?></span>
                </div>
                <?php
                // Mostrar todos los archivos subidos por el alumno para esta entrega
                $sqlArchivos = "SELECT nombre_archivo, ruta_archivo FROM tareas_archivos WHERE id_tarea = ?";
                $stmtArchivos = $conn->prepare($sqlArchivos);
                $stmtArchivos->bind_param("i", $entrega['id']);
                $stmtArchivos->execute();
                $resArchivos = $stmtArchivos->get_result();
                if ($resArchivos->num_rows > 0) {
                    echo "<ul class='entrega-archivos'>";
                    while ($archivo = $resArchivos->fetch_assoc()) {
                        echo '<li><a href="' . htmlspecialchars($archivo['ruta_archivo']) . '" target="_blank">Descargar: ' . htmlspecialchars($archivo['nombre_archivo']) . '</a></li>';
                    }
                    echo "</ul>";
                } else {
                    echo "<span class='entrega-sin-archivos'>No hay archivos subidos.</span>";
                }
                $stmtArchivos->close();
                ?>
                <form class="entrega-calificacion-form" method="POST" action="calificar_tarea.php">
                    <input type="hidden" name="id_tarea" value="<?= $entrega['id'] ?>">
                    <label>Calificación:</label>
                    <select name="calificacion" required>
                        <?php for($i=1;$i<=10;$i++): ?>
                            <option value="<?= $i ?>"<?= ($entrega['calificacion']==$i)?" selected":"" ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <input type="text" name="retroalimentacion" class="retroalimentacion-input" placeholder="Retroalimentación" value="<?= htmlspecialchars($entrega['retroalimentacion'] ?? '') ?>">
                    <button type="submit" class="entrega-btn-calificar">Guardar</button>
                </form>
                <?php if ($entrega['calificacion'] !== null): ?>
                    <div class="entrega-calificacion-actual">
                        <strong>Calificación actual:</strong> <?= $entrega['calificacion'] ?>
                        <?php if ($entrega['retroalimentacion']): ?>
                            <br><small><b>Retroalimentación:</b> <?= htmlspecialchars($entrega['retroalimentacion']) ?></small>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        }
    }
    $stmt->close();
    ?>
</div>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL DE CONFIRMACIÓN ELIMINAR TAREA -->
<div id="modalEliminarTarea" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:#fff; padding:32px 24px; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.15); max-width:400px; width:100%; text-align:center; margin:100px auto; position:relative;">
        <span id="cerrarModalEliminarTarea" style="position:absolute; right:16px; top:10px; font-size:28px; cursor:pointer;">&times;</span>
        <h2 style="color:#FF9800;">¿Eliminar tarea?</h2>
        <p id="textoModalEliminarTarea">¿Seguro que quieres eliminar esta tarea? Esta acción no se puede deshacer.</p>
        <form id="formEliminarTarea" method="POST" action="../frontend_maestros/eliminar_tarea.php">
            <input type="hidden" name="accion" value="eliminar_tarea">
            <input type="hidden" name="id_tarea" id="inputIdTareaEliminar">
            <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase); ?>">
            <button type="submit" class="quick-action" style="background:#FF9800;color:#fff;">Sí, eliminar</button>
            <button type="button" class="quick-action" style="background:#eee;color:#333;" onclick="cerrarModalEliminarTarea()">Cancelar</button>
        </form>
    </div>
</div>

<script>
function abrirModalEliminarTarea(idTarea, titulo) {
    document.getElementById('modalEliminarTarea').style.display = 'block';
    document.getElementById('inputIdTareaEliminar').value = idTarea;
    document.getElementById('textoModalEliminarTarea').innerHTML = '¿Seguro que quieres eliminar la tarea <b>' + titulo + '</b>? Esta acción no se puede deshacer.';
}
function cerrarModalEliminarTarea() {
    document.getElementById('modalEliminarTarea').style.display = 'none';
}
document.getElementById('cerrarModalEliminarTarea').onclick = cerrarModalEliminarTarea;
</script>
       <!-- MATERIALES -->
<div id="seccion-materiales" class="seccion-panel">
    <div class="section">
        <h3>Materiales</h3>
        <!-- BOTÓN DE SUBIR MATERIAL CON MISMO ESTILO -->
        <form action="../frontend_maestros/subir_material.php" method="get" style="margin-bottom: 14px;">
            <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase ?? '') ?>">
            <button type="submit" class="quick-action" >
                <i class="fas fa-plus"></i> Subir material
            </button>
        </form>
        <form method="get" action="index.php">
            <select id="select-material-clase" name="id_clase" onchange="this.form.submit()">
                <option value="">Todas las clases</option>
                <?php foreach ($clases as $clase): ?>
                    <option value="<?= $clase['id'] ?>" <?= ($id_clase == $clase['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
        <ul id="lista-materiales">
            <?php
            if ($id_clase) {
                $sql = "SELECT id, titulo, descripcion, archivo, ruta_archivo, fecha_subida FROM materiales_estudio WHERE id_clase = ? ORDER BY fecha_subida DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_clase);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    while ($material = $resultado->fetch_assoc()) {
                        $material_id = $material["id"];
                        $titulo = htmlspecialchars($material["titulo"] ?? '');
                        $descripcion = htmlspecialchars($material["descripcion"] ?? '');
                        $archivo = htmlspecialchars($material["archivo"] ?? '');
                        $ruta = htmlspecialchars($material["ruta_archivo"] ?? '#');
                        $fecha = date("d/m/Y", strtotime($material["fecha_subida"] ?? ''));

                        echo "<li>";
                        echo "<strong>$titulo</strong>";
                        if ($descripcion) {
                            echo "<br><small>$descripcion</small>";
                        }
                        echo " — <a href='$ruta' target='_blank'>$archivo</a> (Subido el $fecha) ";
                        echo "<form class='form-eliminar-material' action='../frontend_maestros/eliminar_tarea.php' method='POST' style='display:inline-block; margin-left:10px;'>";
                        echo "<input type='hidden' name='accion' value='eliminar_material'>";
                        echo "<input type='hidden' name='id_material' value='$material_id'>";
                        echo "<input type='hidden' name='id_clase' value='" . htmlspecialchars($id_clase) . "'>";
                        echo "<button type='button' class='btn-eliminar' onclick=\"abrirModalEliminarMaterial('$material_id','$titulo')\">Eliminar</button>";
                        echo "</form>";
                        echo "</li>";
                    }
                } else {
                    echo "<li>No hay archivos registrados para esta clase.</li>";
                }
                $stmt->close();
            } else {
                $sql = "SELECT m.id, m.titulo, m.descripcion, m.archivo, m.ruta_archivo, m.fecha_subida, c.nombre_clase, c.materia, m.id_clase AS id_clase
                        FROM materiales_estudio m
                        INNER JOIN clases c ON m.id_clase = c.id
                        WHERE c.profesor_id = ?
                        ORDER BY c.nombre_clase, m.fecha_subida DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $profesor_id);
                $stmt->execute();
                $resultado = $stmt->get_result();

                $materialesPorClase = [];
                while ($material = $resultado->fetch_assoc()) {
                    $materialesPorClase[$material['id_clase']]['nombre_clase'] = $material['nombre_clase'];
                    $materialesPorClase[$material['id_clase']]['materia'] = $material['materia'];
                    $materialesPorClase[$material['id_clase']]['materiales'][] = $material;
                }

                if (count($materialesPorClase) > 0) {
                    foreach ($materialesPorClase as $idClase => $datosClase) {
                        echo "<li style='margin-top:10px;'><strong>" . htmlspecialchars($datosClase['nombre_clase']) . " – " . htmlspecialchars($datosClase['materia']) . "</strong><ul>";
                        foreach ($datosClase['materiales'] as $material) {
                            $material_id = $material["id"];
                            $titulo = htmlspecialchars($material["titulo"] ?? '');
                            $descripcion = htmlspecialchars($material["descripcion"] ?? '');
                            $archivo = htmlspecialchars($material["archivo"] ?? '');
                            $ruta = htmlspecialchars($material["ruta_archivo"] ?? '#');
                            $fecha = date("d/m/Y", strtotime($material["fecha_subida"] ?? ''));
                            echo "<li>";
                            echo "<strong>$titulo</strong>";
                            if ($descripcion) {
                                echo "<br><small>$descripcion</small>";
                            }
                            echo " — <a href='$ruta' target='_blank'>$archivo</a> (Subido el $fecha) ";
                            echo "<form class='form-eliminar-material' action='../frontend_maestros/eliminar_tarea.php' method='POST' style='display:inline-block; margin-left:10px;'>";
                            echo "<input type='hidden' name='accion' value='eliminar_material'>";
                            echo "<input type='hidden' name='id_material' value='$material_id'>";
                            echo "<input type='hidden' name='id_clase' value='" . htmlspecialchars($idClase) . "'>";
                            echo "<button type='button' class='btn-eliminar' onclick=\"abrirModalEliminarMaterial('$material_id','$titulo')\">Eliminar</button>";
                            echo "</form>";
                            echo "</li>";
                        }
                        echo "</ul></li>";
                    }
                } else {
                    echo "<li>No hay archivos registrados en tus clases.</li>";
                }
                $stmt->close();
            }
            ?>
        </ul>
    </div>
</div>

<!-- MODAL DE CONFIRMACIÓN ELIMINAR MATERIAL -->
<div id="modalEliminarMaterial" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:#fff; padding:32px 24px; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.15); max-width:400px; width:100%; text-align:center; margin:100px auto; position:relative;">
        <span id="cerrarModalEliminarMaterial" style="position:absolute; right:16px; top:10px; font-size:28px; cursor:pointer;">&times;</span>
        <h2 style="color:orange;">¿Eliminar material?</h2>
        <p id="textoModalEliminarMaterial">¿Seguro que quieres eliminar este material? Esta acción no se puede deshacer.</p>
        <form id="formEliminarMaterial" method="POST" action="../frontend_maestros/eliminar_tarea.php">
            <input type="hidden" name="accion" value="eliminar_material">
            <input type="hidden" name="id_material" id="inputIdMaterialEliminar">
            <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase); ?>">
            <button type="submit" class="quick-action" style="background:orange;color:#fff;">Sí, eliminar</button>
            <button type="button" class="quick-action" style="background:#eee;color:#333;" onclick="cerrarModalEliminarMaterial()">Cancelar</button>
        </form>
    </div>
</div>

<script>
function abrirModalEliminarMaterial(idMaterial, titulo) {
    document.getElementById('modalEliminarMaterial').style.display = 'block';
    document.getElementById('inputIdMaterialEliminar').value = idMaterial;
    document.getElementById('textoModalEliminarMaterial').innerHTML = '¿Seguro que quieres eliminar el material <b>' + titulo + '</b>? Esta acción no se puede deshacer.';
}
function cerrarModalEliminarMaterial() {
    document.getElementById('modalEliminarMaterial').style.display = 'none';
}
document.getElementById('cerrarModalEliminarMaterial').onclick = cerrarModalEliminarMaterial;
</script>
       <!-- AVISOS -->
<div id="seccion-avisos" class="seccion-panel">
    <div class="section">
        <h3>Avisos</h3>
        <!-- BOTÓN DE CREAR AVISO CON ESTILO CONSISTENTE -->
        <form action="../frontend_maestros/crear_aviso.php" method="get" style="margin-bottom: 14px;">
            <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase ?? '') ?>">
            <button type="submit" class="quick-action" >
                <i class="fas fa-plus"></i> Crear aviso
            </button>
        </form>
        <form method="get" action="index.php">
            <select id="select-aviso-clase" name="id_clase" onchange="this.form.submit()">
                <option value="">Todas las clases</option>
                <?php foreach ($clases as $clase): ?>
                    <option value="<?= $clase['id'] ?>" <?= ($id_clase == $clase['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
        <ul id="avisos-lista">
        <?php
        if ($id_clase) {
            $sqlAvisos = "SELECT a.id, a.titulo, a.descripcion, a.fecha_subida, c.materia 
                        FROM avisos a
                        INNER JOIN clases c ON a.id_clase = c.id
                        WHERE a.id_clase = ?
                        ORDER BY a.fecha_subida DESC";
            $stmtAvisos = $conn->prepare($sqlAvisos);
            $stmtAvisos->bind_param("i", $id_clase);
            $stmtAvisos->execute();
            $resultadoAvisos = $stmtAvisos->get_result();

            if ($resultadoAvisos->num_rows > 0):
                while ($aviso = $resultadoAvisos->fetch_assoc()): ?>
                    <li>
                        <b><?= htmlspecialchars($aviso['titulo']); ?></b>
                        – <?= ucfirst(htmlspecialchars($aviso['materia'])); ?> 
                        – <span>Fecha: <?= htmlspecialchars($aviso['fecha_subida']); ?></span><br>
                        <small><?= htmlspecialchars($aviso['descripcion']); ?></small>
                        <form class="form-eliminar-aviso" action="../frontend_maestros/eliminar_tarea.php" method="POST" style="display:inline;">
                            <input type="hidden" name="accion" value="eliminar_aviso">
                            <input type="hidden" name="id_aviso" value="<?= $aviso['id']; ?>">
                            <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase); ?>">
                            <button type="button" class="btn-eliminar" onclick="abrirModalEliminarAviso('<?= $aviso['id'] ?>','<?= htmlspecialchars($aviso['titulo']) ?>')">Eliminar</button>
                        </form>
                    </li>
                <?php endwhile;
            else: ?>
                <li>No hay avisos registrados para esta clase.</li>
            <?php endif;
            $stmtAvisos->close();
        } else {
            $sqlAvisos = "SELECT a.id, a.titulo, a.descripcion, a.fecha_subida, c.materia, c.nombre_clase, a.id_clase
                        FROM avisos a
                        INNER JOIN clases c ON a.id_clase = c.id
                        WHERE c.profesor_id = ?
                        ORDER BY c.nombre_clase, a.fecha_subida DESC";
            $stmtAvisos = $conn->prepare($sqlAvisos);
            $stmtAvisos->bind_param("i", $profesor_id);
            $stmtAvisos->execute();
            $resultadoAvisos = $stmtAvisos->get_result();

            $avisosPorClase = [];
            while ($aviso = $resultadoAvisos->fetch_assoc()) {
                $avisosPorClase[$aviso['id_clase']]['nombre_clase'] = $aviso['nombre_clase'];
                $avisosPorClase[$aviso['id_clase']]['materia'] = $aviso['materia'];
                $avisosPorClase[$aviso['id_clase']]['avisos'][] = $aviso;
            }

            if (count($avisosPorClase) > 0) {
                foreach ($avisosPorClase as $idClase => $datosClase) {
                    echo "<li style='margin-top:10px;'><strong>" . htmlspecialchars($datosClase['nombre_clase']) . " – " . htmlspecialchars($datosClase['materia']) . "</strong><ul>";
                    foreach ($datosClase['avisos'] as $aviso) {
                        echo "<li>";
                        echo "<b>" . htmlspecialchars($aviso['titulo']) . "</b> – Fecha: " . htmlspecialchars($aviso['fecha_subida']);
                        echo "<br><small>" . htmlspecialchars($aviso['descripcion']) . "</small>";
                        echo "<form class='form-eliminar-aviso' action='../frontend_maestros/eliminar_tarea.php' method='POST' style='display:inline;'>";
                        echo "<input type='hidden' name='accion' value='eliminar_aviso'>";
                        echo "<input type='hidden' name='id_aviso' value='" . $aviso['id'] . "'>";
                        echo "<input type='hidden' name='id_clase' value='" . htmlspecialchars($idClase) . "'>";
                        echo "<button type='button' class='btn-eliminar' onclick=\"abrirModalEliminarAviso('".$aviso['id']."','".htmlspecialchars($aviso['titulo'])."')\">Eliminar</button>";
                        echo "</form>";
                        echo "</li>";
                    }
                    echo "</ul></li>";
                }
            } else {
                echo "<li>No hay avisos registrados aún.</li>";
            }
            $stmtAvisos->close();
        }
        ?>
        </ul>
    </div>
</div>

<!-- MODAL DE CONFIRMACIÓN ELIMINAR AVISO -->
<div id="modalEliminarAviso" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:#fff; padding:32px 24px; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.15); max-width:400px; width:100%; text-align:center; margin:100px auto; position:relative;">
        <span id="cerrarModalEliminarAviso" style="position:absolute; right:16px; top:10px; font-size:28px; cursor:pointer;">&times;</span>
        <h2 style="color:#ff8c1a;">¿Eliminar aviso?</h2>
        <p id="textoModalEliminarAviso">¿Seguro que quieres eliminar este aviso? Esta acción no se puede deshacer.</p>
        <form id="formEliminarAviso" method="POST" action="../frontend_maestros/eliminar_tarea.php">
            <input type="hidden" name="accion" value="eliminar_aviso">
            <input type="hidden" name="id_aviso" id="inputIdAvisoEliminar">
            <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase); ?>">
            <button type="submit" class="quick-action" style="background:#ff8c1a;color:#fff;">Sí, eliminar</button>
            <button type="button" class="quick-action" style="background:#eee;color:#333;" onclick="cerrarModalEliminarAviso()">Cancelar</button>
        </form>
    </div>
</div>

<script>
function abrirModalEliminarAviso(idAviso, titulo) {
    document.getElementById('modalEliminarAviso').style.display = 'block';
    document.getElementById('inputIdAvisoEliminar').value = idAviso;
    document.getElementById('textoModalEliminarAviso').innerHTML = '¿Seguro que quieres eliminar el aviso <b>' + titulo + '</b>? Esta acción no se puede deshacer.';
}
function cerrarModalEliminarAviso() {
    document.getElementById('modalEliminarAviso').style.display = 'none';
}
document.getElementById('cerrarModalEliminarAviso').onclick = cerrarModalEliminarAviso;
</script>
        <!-- MENSAJES / COMENTARIOS MULTIHILO -->
        <div id="seccion-mensajes" class="seccion-panel">
            <div class="section">
                <h3>Comentarios/dudas de alumnos 
                    <?php if ($pendientes > 0): ?>
                        <span class="badge" style="background:#e65100;color:white;padding:2px 9px;border-radius:11px;">
                            <?= $pendientes ?> pendientes
                        </span>
                    <?php endif; ?>
                </h3>
                <ul style="list-style:none;padding-left:0;">
                    <?php foreach ($comentarios as $c): ?>
                        <li id="comentario-<?= $c['id'] ?>" style="margin-bottom:15px;border-bottom:1px solid #93a3ddff;padding-bottom:8px;">
                            <b>
                                <?= htmlspecialchars(($c['nombre_alumno'] ?? '') ?: '') ?>
                                <?php if (!$id_clase): ?>
                                    <span style="color:#888;">(<?= htmlspecialchars(($c['nombre_clase'] ?? '') ?: '') ?> - <?= htmlspecialchars(($c['materia'] ?? '') ?: '') ?>)</span>
                                <?php endif; ?>
                            </b>
                            <br>
                            <?= htmlspecialchars(($c['comentario'] ?? '') ?: '') ?>
                            <small style="color:#888;">(<?= isset($c['fecha']) ? date("d/m/Y H:i", strtotime($c['fecha'])) : '' ?>)</small>
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
                                <div class="respuesta-hilo <?= ($r['tipo_usuario'] ?? '') == 'profesor' ? 'resp-prof' : 'resp-alum' ?>">
                                    <b><?= (($r['tipo_usuario'] ?? '') == 'profesor') ? 'Profesor' : 'Alumno' ?>:</b>
                                    <?= htmlspecialchars(($r['respuesta'] ?? '') ?: '') ?>
                                    <small style="color:#888;"><?= isset($r['fecha']) ? date("d/m/Y H:i", strtotime($r['fecha'])) : '' ?></small>
                                </div>
                            <?php endforeach; ?>
                            <form method="POST" class="form-resp-comentario" action="index.php?id_clase=<?= htmlspecialchars($id_clase ?? '') ?>">
                                <input type="hidden" name="id_comentario_resp" value="<?= $c['id'] ?>">
                                <textarea name="texto_respuesta" rows="2" class="textarea-respuesta" placeholder="Responder al comentario..." required></textarea>
                                <button type="submit" class="btn-respuesta">Responder</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($comentarios)): ?>
                        <li>No hay comentarios/dudas aún.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <!-- PERFIL -->
        <div id="seccion-perfil" class="seccion-panel">
            <div class="section">
                <h3>Perfil</h3>
                <form id="foto-perfil-form" method="POST" action="index.php" enctype="multipart/form-data">
                    <!--  <label for="edit-name">Nombre</label>
                    <input type="text" id="edit-name" value="<?= htmlspecialchars($nombre) ?>" disabled><br><br>-->
                    
                    <label for="edit-img"><h3>Subir foto de perfil</h3></label>
                    <input type="file" name="foto_file" id="edit-img" accept="image/*">

                    <label for="foto_url">o URL de foto</label>
                    <input type="text" name="foto_url" id="foto_url" placeholder="URL de foto" value="<?= htmlspecialchars($_SESSION['foto']) ?>">
                    
                    <button type="submit" name="guardar_foto">Editar foto de perfil</button>
                    <?php if (!empty($error)): ?>
                        <div style="color:red"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                </form>
                <script>

                // Alerta cuando selecciona archivo
                document.getElementById('edit-img').addEventListener('change', function() {
                    if (this.files.length > 0) {
                        alert('Has seleccionado una nueva foto de perfil desde tu computadora.');
                    }
                });

                // Alerta cuando escribe una URL
                document.getElementById('foto_url').addEventListener('input', function() {
                    if (this.value.length > 5) {
                        alert('Has ingresado una URL para la foto de perfil.');
                    }
                });

                // Alerta antes de guardar cambios
                document.addEventListener('DOMContentLoaded', function() {
                    var fotoForm = document.getElementById('foto-perfil-form');
                    var fileInput = document.getElementById('edit-img');
                    var urlInput = document.getElementById('foto_url');

                    fotoForm.addEventListener('submit', function(e) {
                        var cambioArchivo = fileInput.files.length > 0;
                        var cambioURL = urlInput.value.length > 5;

                        if (cambioArchivo || cambioURL) {
                            var confirmar = confirm('¿Seguro que quieres editar tu foto de perfil?');
                            if (!confirmar) {
                                e.preventDefault();
                            }
                        }
                    });
                });
                </script>
            </div>
        </div>

    </div>
    <script src="../nosotros/cursos.js"></script>
    <script src="../principal/lang.js"></script>
    <script src="../principal/idioma.js"></script>
</body>
</html>