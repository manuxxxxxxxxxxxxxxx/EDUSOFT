<?php
session_start();

if (!isset($_SESSION['id_estudiante'])) {
    echo "⚠️ Debes iniciar sesión como estudiante para acceder a esta materia.";
    exit;
}

include '../conexiones/conexion.php';

$id_estudiante = $_SESSION['id_estudiante'];
$materia = 'biologia';

// Obtener tareas que subió este estudiante en esta materia
$sql = "SELECT nombre_archivo, ruta_archivo, fecha_subida FROM tareas WHERE id_estudiante = ? AND materia = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id_estudiante, $materia);
$stmt->execute();
$resultado = $stmt->get_result();
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
</head>
<body>



    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-dna"></i>
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
    <a href="../cursos.php" class="logo modern-back">
        <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
        <span class="header-title">Segundo año B <span class="header-materia">Biología</span></span>
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
                        <p>Profesor<br><strong>Cristofer Alfaro</strong></p>
                    </div>
                    <div class="tareas-container">
                        <div class="tarea" data-titulo="Tarea de Biología Celular" data-descripcion="Resolver los problemas de biología celular del capítulo 3. Entregar antes del próximo lunes.">
                            <h4>Tarea de Biología Celular</h4>
                            <p>Resolver los problemas de biología celular del capítulo 3. Entregar antes del próximo lunes.</p>
                        </div>
                        <div class="tarea" data-titulo="Proyecto de Biología Molecular" data-descripcion="Crear un proyecto sobre la biología molecular. Entregar en clase el próximo miércoles.">
                            <h4>Proyecto de Biología Molecular</h4>
                            <p>Crear un proyecto sobre la biología molecular. Entregar en clase el próximo miércoles.</p>
                        </div>
                        <div class="tarea" data-titulo="Examen de Biología Evolutiva" data-descripcion="Estudiar para el examen de biología evolutiva que se realizará el próximo viernes. Revisar los apuntes y resolver los ejercicios del capítulo 2.">
                            <h4>Examen de Biología Evolutiva</h4>
                            <p>Estudiar para el examen de biología evolutiva que se realizará el próximo viernes. Revisar los apuntes y resolver los ejercicios del capítulo 2.</p>
                        </div>
                        <div class="tarea" data-titulo="Tarea de Biología Ambiental" data-descripcion="Escribir un ensayo sobre la importancia de la biología ambiental en la conservación del medio ambiente. Entregar antes del próximo jueves.">
                            <h4>Tarea de Biología Ambiental</h4>
                            <p>Escribir un ensayo sobre la importancia de la biología ambiental en la conservación del medio ambiente. Entregar antes del próximo jueves.</p>
                        </div>
                    </div>
                </div>
            </section>
            <section id="tareas" class="seccion" style="display: none;">
                <h2>Tareas</h2>
                <ul class="lista-tareas">
                    <li>
                        <i class="fas fa-atom"></i>
                        <span>Tarea de Biología Celular</span>
                        <p>Resolver los problemas de biología celular del capítulo 3.</p>
                        <small>Fecha límite: 10 de abril</small>
                        <h2>Sube tu tarea de Biología</h2>
<form action="subir_tarea.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="materia" value="biologia">
    <input type="hidden" name="id_estudiante" value="<?php echo $_SESSION['id_estudiante']; ?>"> <!-- o como estés guardando la sesión -->
    
    <label for="archivo">Archivo (PDF, DOCX, JPG...):</label>
    <input type="file" name="archivo" id="archivo" required><br><br>

    <button type="submit">Subir tarea</button>
</form>
                    </li>
                    <li>
                        <i class="fas fa-dna"></i>
                        <span>Proyecto de Biología Molecular</span>
                        <p>Crear un proyecto sobre la biología molecular.</p>
                        <small>Fecha límite: 12 de abril</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-tree"></i>
                        <span>Examen de Biología Evolutiva</span>
                        <p>Estudiar para el examen de biología evolutiva que se realizará el próximo viernes.</p>
                        <small>Fecha límite: 15 de abril</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-pen"></i>
                        <span>Tarea de Biología Ambiental</span>
                        <p>Escribir un ensayo sobre la importancia de la biología ambiental en la conservación del medio ambiente.</p>
                        <small>Fecha límite: 17 de abril</small>
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
                <h2>Avisos</h2>
                <ul class="lista-avisos">
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Examen de Biología Celular</span>
                        <p>El próximo viernes se realizará el examen de biología celular. Asegúrate de estudiar y prepararte adecuadamente.</p>
                        <small>Fecha: 15 de abril</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Entrega de Tareas</span>
                        <p>Recuerda que la tarea de biología molecular debe ser entregada el próximo lunes. Asegúrate de tenerla lista y entregada a tiempo.</p>
                        <small>Fecha: 12 de abril</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Feria de Ciencias</span>
                        <p>La feria de ciencias se realizará el próximo sábado. Asegúrate de asistir y participar en los eventos y actividades programadas.</p>
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
        </main>
    </div>

    <!-- Modal de tareas -->
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

    <script src="../materias/js/scriptBiologia.js"></script>
</body>
</html>