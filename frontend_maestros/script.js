// Solo navegación visual, sin funcionalidad extra

function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}

// Navegación entre secciones
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.sidebar nav a');
    links.forEach(function(link, idx) {
        link.onclick = function(e) {
            e.preventDefault();
            links.forEach(a => a.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.seccion-panel').forEach(sec => sec.style.display = 'none');
            switch(idx) {
                case 0: document.getElementById('seccion-inicio').style.display = 'block'; break;
                case 1: document.getElementById('seccion-cursos').style.display = 'block'; break;
                case 2: document.getElementById('seccion-alumnos').style.display = 'block'; break;
                case 3: document.getElementById('seccion-tareas').style.display = 'block'; break;
                case 4: document.getElementById('seccion-materiales').style.display = 'block'; break;
                case 5: document.getElementById('seccion-avisos').style.display = 'block'; break;
                case 6: document.getElementById('seccion-mensajes').style.display = 'block'; break;
                case 7: document.getElementById('seccion-perfil').style.display = 'block'; break;
                case 8: window.location.reload(); break; // "Salir" recarga la página
            }
            if(window.innerWidth <= 800) document.querySelector('.sidebar').classList.remove('active');
        }
    });
});
// Buscador de alumnos
function searchStudent() {
    const input = document.getElementById('search-student').value.toLowerCase();
    const list = document.getElementById('student-list').getElementsByTagName('li');
    for (let i = 0; i < list.length; i++) {
        const name = list[i].textContent.toLowerCase();
        list[i].style.display = name.includes(input) ? '' : 'none';
    }
}
// Mostrar sección según el hash en la URL al cargar y cuando cambie
function mostrarSeccionDesdeHash() {
    document.querySelectorAll('.seccion-panel').forEach(function(sec) {
        sec.style.display = 'none';
    });
    var hash = window.location.hash || '#seccion-inicio';
    var hashSolo = hash.split('&')[0];
    var seccion = document.querySelector(hashSolo);
    if (seccion) {
        seccion.style.display = 'block';
        const links = document.querySelectorAll('.sidebar nav a');
        links.forEach(a => a.classList.remove('active'));
        const hashList = [
            '#seccion-inicio',
            '#seccion-cursos',
            '#seccion-alumnos',
            '#seccion-tareas',
            '#seccion-materiales',
            '#seccion-avisos',
            '#seccion-mensajes',
            '#seccion-perfil'
        ];
        const idx = hashList.indexOf(hashSolo);
        if (idx >= 0 && links[idx]) links[idx].classList.add('active');
    } else {
        document.getElementById('seccion-inicio').style.display = 'block';
        document.querySelector('.sidebar nav a').classList.add('active');
    }
}
document.addEventListener('DOMContentLoaded', mostrarSeccionDesdeHash);
window.addEventListener('hashchange', mostrarSeccionDesdeHash);

// Detecta cambios en todos los selects de clase para redirigir con el hash adecuado
document.addEventListener('DOMContentLoaded', function() {
    // Alumnos
    var selectAlumnos = document.getElementById('select-clase');
    if (selectAlumnos) {
        selectAlumnos.onchange = function() {
            var id_clase = this.value;
            var url = 'index.php';
            if (id_clase) url += '?id_clase=' + encodeURIComponent(id_clase);
            url += '#seccion-alumnos';
            window.location.href = url;
        };
    }
    // Tareas
    var selectTareas = document.getElementById('select-tarea-clase');
    if (selectTareas) {
        selectTareas.onchange = function() {
            var id_clase = this.value;
            var url = 'index.php';
            if (id_clase) url += '?id_clase=' + encodeURIComponent(id_clase);
            url += '#seccion-tareas';
            window.location.href = url;
        };
    }
    // Materiales
    var selectMateriales = document.getElementById('select-material-clase');
    if (selectMateriales) {
        selectMateriales.onchange = function() {
            var id_clase = this.value;
            var url = 'index.php';
            if (id_clase) url += '?id_clase=' + encodeURIComponent(id_clase);
            url += '#seccion-materiales';
            window.location.href = url;
        };
    }
    // Avisos
    var selectAvisos = document.getElementById('select-aviso-clase');
    if (selectAvisos) {
        selectAvisos.onchange = function() {
            var id_clase = this.value;
            var url = 'index.php';
            if (id_clase) url += '?id_clase=' + encodeURIComponent(id_clase);
            url += '#seccion-avisos';
            window.location.href = url;
        };
    }
});