<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSoft - Matemática</title>
    <link rel="stylesheet" href="styles2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header>
        <a href="../cursos.php" class="logo">
            <i class="fas fa-arrow-left"></i> Segundo año B - Matemática
        </a>
        <div class="icons">
            <span class="settings">⚙️</span>
            <span class="profile">👤</span>
        </div>
    </header>
    <nav>
        <button onclick="mostrarSeccion('tablon')">Tablón</button>
        <button onclick="mostrarSeccion('tareas')">Tareas</button>
        <button onclick="mostrarSeccion('alumnos')">Alumnos</button>
        <button onclick="mostrarSeccion('avisos')">Avisos</button>
    </nav>

        <!-- Modal HTML -->
        <div id="modalTarea" class="modal">
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
    <main>
            <section id="tablon" class="seccion">
                <!-- <div class="banner"> -->
                    <div class="banner" id="banner1">
                    <h1>MATEMÁTICA</h1>
                </div>
                <div class="content">
                    <div class="profesor">
                        <!-- <div class="avatar"></div> -->
                        <p>Profesor<br><strong>Cristofer Alfaro</strong></p>
                    </div>
                    <div class="anuncios">
                        <div class="tarea" data-titulo="Tarea de Álgebra" data-descripcion="Resolver los ejercicios del 1 al 10 del capítulo 3 de álgebra. Entregar antes del próximo lunes.">
                            <h4>Tarea de Álgebra</h4>
                            <p>Resolver los ejercicios del 1 al 10 del capítulo 3 de álgebra. Entregar antes del próximo lunes.</p>
                        </div>
                        <div class="tarea" data-titulo="Proyecto de Geometría" data-descripcion="Crear un modelo de un edificio utilizando conceptos de geometría. Entregar en clase el próximo miércoles.">
                            <h4>Proyecto de Geometría</h4>
                            <p>Crear un modelo de un edificio utilizando conceptos de geometría. Entregar en clase el próximo miércoles.</p>
                        </div>
                        <div class="tarea" data-titulo="Examen de Estadística" data-descripcion="Estudiar para el examen de estadística que se realizará el próximo viernes. Revisar los apuntes y resolver los ejercicios del capítulo 2.">
                            <h4>Examen de Estadística</h4>
                            <p>Estudiar para el examen de estadística que se realizará el próximo viernes. Revisar los apuntes y resolver los ejercicios del capítulo 2.</p>
                        </div>
                        <div class="tarea" data-titulo="Tarea de Calculo" data-descripcion="Resolver los problemas del 1 al 5 del capítulo 5 de cálculo. Entregar antes del próximo jueves.">
                            <h4>Tarea de Cálculo</h4>
                            <p>Resolver los problemas del 1 al 5 del capítulo 5 de cálculo. Entregar antes del próximo jueves.</p>
                        </div>
                    </div>
                </div>
        </section>

        <section id="tareas" class="seccion" style="display: none;">
            <h2>Tareas</h2>
            <ul class="lista-tareas">
                <li>
                    <i class="fas fa-book"></i>
                    <span>Tarea de Álgebra</span>
                    <p>Resolver los ejercicios del 1 al 10 del capítulo 3 de álgebra.</p>
                    <small>Fecha límite: 10 de abril</small>
                    <button class="boton-estilo" onclick="abrirModal('Tarea de Álgebra', 'Resolver los ejercicios del 1 al 10 del capítulo 3 de álgebra. Entregar antes del próximo lunes.')">Añadir tarea</button>
                </li>
                <li>
                    <i class="fas fa-building"></i>
                    <span>Proyecto de Geometría</span>
                    <p>Crear un modelo de un edificio utilizando conceptos de geometría.</p>
                    <small>Fecha límite: 12 de abril</small>
                    <button class="boton-estilo" onclick="abrirModal('Proyecto de Geometría', 'Crear un modelo de un edificio utilizando conceptos de geometría. Entregar en clase el próximo miércoles.')">Añadir tarea</button>
                </li>
                <li>
                    <i class="fas fa-chart-line"></i>
                    <span>Examen de Estadística</span>
                    <p>Estudiar para el examen de estadística que se realizará el próximo viernes.</p>
                    <small>Fecha límite: 15 de abril</small>
                    <button class="boton-estilo" onclick="abrirModal('Examen de Estadística', 'Estudiar para el examen de estadística que se realizará el próximo viernes. Revisar los apuntes y resolver los ejercicios del capítulo 2.')">Añadir tarea</button>
                </li>
                <li>
                    <i class="fas fa-calculator"></i>
                    <span>Tarea de Cálculo</span>
                    <p>Resolver los problemas del 1 al 5 del capítulo 5 de cálculo.</p>
                    <small>Fecha límite: 17 de abril</small>
                    <button class="boton-estilo" onclick="abrirModal('Tarea de Cálculo', 'Resolver los problemas del 1 al 5 del capítulo 5 de cálculo. Entregar antes del próximo jueves.')">Añadir tarea</button>
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
            </ul>
        </section>
        
        <section id="avisos" class="seccion" style="display: none;">
            <h2>Avisos</h2>
            <ul class="lista-avisos">
                <li>
                    <i class="fas fa-bell"></i>
                    <span>Examen de Matemáticas</span>
                    <p>El próximo viernes se realizará el examen de matemáticas. Asegúrate de estudiar y prepararte adecuadamente.</p>
                    <small>Fecha: 15 de abril</small>
                </li>
                <li>
                    <i class="fas fa-bell"></i>
                    <span>Entrega de Tareas</span>
                    <p>Recuerda que la tarea de álgebra debe ser entregada el próximo lunes. Asegúrate de tenerla lista y entregada a tiempo.</p>
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
    
    <script>
    function mostrarSeccion(seccion) {
    // Ocultar todas las secciones
    document.querySelectorAll('.seccion').forEach(sec => sec.style.display = 'none');

    // Mostrar la sección seleccionada
    document.getElementById(seccion).style.display = 'block';

    // Quitar la clase 'active' de todos los botones
    document.querySelectorAll('nav button').forEach(btn => btn.classList.remove('active'));

    // Agregar la clase 'active' solo al botón seleccionado
    document.querySelector(`nav button[onclick="mostrarSeccion('${seccion}')"]`).classList.add('active');
}

// ✅ Asegurar que al cargar la página, "Tablón" esté activo
document.addEventListener("DOMContentLoaded", function() {
    mostrarSeccion('tablon'); // Esto activa la sección "Tablón" al entrar
});

    var modal = document.getElementById("modalTarea");
    var span = document.getElementsByClassName("close")[0];
    var listaArchivos = document.getElementById("listaArchivos");
    var archivoInput = document.getElementById("archivoSubir");
    var enlaceInput = document.getElementById("enlaceInput");
    var listaEnlaces = document.getElementById("listaEnlaces");
    var agregarEnlaceBtn = document.getElementById("agregarEnlace");

    function abrirModal(titulo, descripcion) {
      document.getElementById("modalTitulo").innerText = titulo;
      document.getElementById("modalDescripcion").innerText = descripcion;
      listaArchivos.innerHTML = "";
      listaEnlaces.innerHTML = "";
      modal.style.display = "block";
    }

    // Detectar click en cualquier tarea automáticamente
    document.querySelectorAll('.tarea').forEach(function(tarea) {
      tarea.addEventListener('click', function() {
        var titulo = this.getAttribute('data-titulo');
        var descripcion = this.getAttribute('data-descripcion');
        abrirModal(titulo, descripcion);
      });
    });

    span.onclick = function() {
      modal.style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    archivoInput.addEventListener('change', function() {
      listaArchivos.innerHTML = "";
      Array.from(archivoInput.files).forEach(function(file) {
        var li = document.createElement("li");
        li.textContent = file.name;
        listaArchivos.appendChild(li);
      });
    });

    agregarEnlaceBtn.addEventListener('click', function() {
      var url = enlaceInput.value;
      if (url.trim() !== "") {
        var li = document.createElement("li");
        var a = document.createElement("a");
        a.href = url;
        a.target = "_blank";
        a.textContent = url;
        li.appendChild(a);
        listaEnlaces.appendChild(li);
        enlaceInput.value = "";
      }
    });
    </script>
</body>
</html>