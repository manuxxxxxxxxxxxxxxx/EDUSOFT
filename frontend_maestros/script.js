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