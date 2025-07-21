// materias/js/scriptGeneral.js

document.addEventListener('DOMContentLoaded', function() {
    const tablonBtn = document.getElementById('tablon-btn');
    const tareasBtn = document.getElementById('tareas-btn');
    const alumnosBtn = document.getElementById('alumnos-btn');
    const avisosBtn = document.getElementById('avisos-btn');

    const tablonSection = document.getElementById('tablon');
    const tareasSection = document.getElementById('tareas');
    const alumnosSection = document.getElementById('alumnos');
    const avisosSection = document.getElementById('avisos');

    // Función para mostrar la sección activa y ocultar las demás
    function showSection(sectionToShow) {
        tablonSection.style.display = 'none';
        tareasSection.style.display = 'none';
        alumnosSection.style.display = 'none';
        avisosSection.style.display = 'none';

        sectionToShow.style.display = 'block'; // O 'flex' si tu diseño lo requiere
    }

    // Función para actualizar el estado activo de los botones del sidebar
    function updateActiveButton(activeButton) {
        tablonBtn.classList.remove('active');
        tareasBtn.classList.remove('active');
        alumnosBtn.classList.remove('active');
        avisosBtn.classList.remove('active');

        activeButton.classList.add('active');
    }

    // Event Listeners para los botones del sidebar
    tablonBtn.addEventListener('click', function() {
        showSection(tablonSection);
        updateActiveButton(tablonBtn);
    });

    tareasBtn.addEventListener('click', function() {
        showSection(tareasSection);
        updateActiveButton(tareasBtn);
    });

    alumnosBtn.addEventListener('click', function() {
        showSection(alumnosSection);
        updateActiveButton(alumnosBtn);
    });

    avisosBtn.addEventListener('click', function() {
        showSection(avisosSection);
        updateActiveButton(avisosBtn);
    });

    // --- Funcionalidad del Modal (Tarea) ---
    const modal = document.getElementById('modalTarea');
    const closeBtn = document.querySelector('.modal .close');
    const modalTitulo = document.getElementById('modalTitulo');
    const modalDescripcion = document.getElementById('modalDescripcion');
    const archivoSubir = document.getElementById('archivoSubir');
    const listaArchivos = document.getElementById('listaArchivos');
    const enlaceInput = document.getElementById('enlaceInput');
    const agregarEnlaceBtn = document.getElementById('agregarEnlace');
    const listaEnlaces = document.getElementById('listaEnlaces');

    // Función para abrir el modal
    function openModal(titulo, descripcion) {
        modalTitulo.textContent = titulo;
        modalDescripcion.textContent = descripcion;
        listaArchivos.innerHTML = ''; // Limpiar lista de archivos
        listaEnlaces.innerHTML = ''; // Limpiar lista de enlaces
        enlaceInput.value = ''; // Limpiar input de enlace
        modal.style.display = 'flex'; // Mostrar el modal
    }

    // Evento para abrir el modal al hacer click en una tarea
    document.querySelectorAll('.tarea').forEach(tarea => {
        tarea.addEventListener('click', function() {
            const titulo = this.dataset.titulo;
            const descripcion = this.dataset.descripcion;
            openModal(titulo, descripcion);
        });
    });

    // Evento para cerrar el modal
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Cerrar el modal si se hace click fuera del contenido
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    // Manejo de archivos subidos
    archivoSubir.addEventListener('change', function() {
        listaArchivos.innerHTML = ''; // Limpiar la lista antes de añadir nuevos
        Array.from(this.files).forEach(file => {
            const li = document.createElement('li');
            li.textContent = file.name;
            listaArchivos.appendChild(li);
        });
    });

    // Manejo de enlaces
    agregarEnlaceBtn.addEventListener('click', function() {
        const url = enlaceInput.value.trim();
        if (url) {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = url;
            a.textContent = url;
            a.target = "_blank"; // Abrir en nueva pestaña
            li.appendChild(a);
            listaEnlaces.appendChild(li);
            enlaceInput.value = ''; // Limpiar input
        }
    });

    // --- Animación de Partículas en el Banner (si la estás usando) ---
    // Si no usas canvas para partículas, puedes eliminar esta sección
    const banner = document.querySelector('.banner');
    if (banner && banner.querySelector('#particles-bg')) {
        const canvas = banner.querySelector('#particles-bg');
        const ctx = canvas.getContext('2d');
        let particles = [];
        const numParticles = 30;

        function resizeCanvas() {
            canvas.width = banner.clientWidth;
            canvas.height = banner.clientHeight;
        }

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 1;
                this.speedX = Math.random() * 0.5 - 0.25;
                this.speedY = Math.random() * 0.5 - 0.25;
                this.opacity = Math.random() * 0.5 + 0.1;
                this.color = `rgba(255,255,255,${this.opacity})`;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.size > 0.2) this.size -= 0.01;
                if (this.x > canvas.width || this.x < 0) this.speedX *= -1;
                if (this.y > canvas.height || this.y < 0) this.speedY *= -1;
            }

            draw() {
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function initParticles() {
            particles = [];
            for (let i = 0; i < numParticles; i++) {
                particles.push(new Particle());
            }
        }

        function animateParticles() {
            requestAnimationFrame(animateParticles);
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            for (let i = 0; i < particles.length; i++) {
                particles[i].update();
                particles[i].draw();

                if (particles[i].size < 0.2) {
                    particles.splice(i, 1);
                    i--;
                    particles.push(new Particle());
                }
            }
        }

        resizeCanvas();
        initParticles();
        animateParticles();
        window.addEventListener('resize', resizeCanvas);
    }
});