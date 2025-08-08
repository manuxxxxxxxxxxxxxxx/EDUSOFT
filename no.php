<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSoft - Matemática</title>
    <link rel="stylesheet" href="styles22.css">
</head>
<body>
    <header>
        <div class="logo">🎓 Segundo año B - Matemática</div>
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
    
    <main>
            <section id="tablon" class="seccion">
                <div class="banner">
                    <h1>MATEMÁTICA</h1>
                </div>
                <div class="content">
                    <div class="profesor">
                        <div class="avatar"></div>
                        <p>Profesor<br><strong>Cristofer Alfaro</strong></p>
                    </div>
                    <div class="anuncios">
                        <div class="anuncio"></div>
                        <div class="anuncio"></div>
                        <div class="anuncio"></div>
                    </div>
                </div>
        </section>

        <section id="tareas" class="seccion" style="display: none;">
            <h2>Tareas</h2>
            <ul class="lista-tareas">
                <li>📌 Ejercicio de álgebra - Fecha límite: 10 de abril</li>
                <li>📌 Problemas de trigonometría - Fecha límite: 12 de abril</li>
                <li>📌 Proyecto de geometría - Fecha límite: 15 de abril</li>
            </ul>
        </section>
        
        <section id="alumnos" class="seccion" style="display: none;">
            <h2>Lista de Alumnos</h2>
            <ul class="lista-alumnos">
                <li>👤 Juan Pérez</li>
                <li>👤 María López</li>
                <li>👤 Carlos Gómez</li>
                <li>👤 Ana Ramírez</li>
            </ul>
        </section>
        
        <section id="avisos" class="seccion" style="display: none;">
            <h2>Avisos</h2>
            <div class="aviso">📢 Examen de matemáticas el 20 de abril</div>
            <div class="aviso">📢 Revisión de notas el 22 de abril</div>
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
    </script>
</body>
</html>
