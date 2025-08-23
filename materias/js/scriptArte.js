// // materias/js/scriptGeneral.js

// document.addEventListener('DOMContentLoaded', function() {
//     const tablonBtn = document.getElementById('tablon-btn');
//     const tareasBtn = document.getElementById('tareas-btn');
//     const alumnosBtn = document.getElementById('alumnos-btn');
//     const avisosBtn = document.getElementById('avisos-btn');

//     const tablonSection = document.getElementById('tablon');
//     const tareasSection = document.getElementById('tareas');
//     const alumnosSection = document.getElementById('alumnos');
//     const avisosSection = document.getElementById('avisos');

//     // Función para mostrar la sección activa y ocultar las demás
//     function showSection(sectionToShow) {
//         tablonSection.style.display = 'none';
//         tareasSection.style.display = 'none';
//         alumnosSection.style.display = 'none';
//         avisosSection.style.display = 'none';

//         sectionToShow.style.display = 'block'; // O 'flex' si tu diseño lo requiere
//     }

//     // Función para actualizar el estado activo de los botones del sidebar
//     function updateActiveButton(activeButton) {
//         tablonBtn.classList.remove('active');
//         tareasBtn.classList.remove('active');
//         alumnosBtn.classList.remove('active');
//         avisosBtn.classList.remove('active');

//         activeButton.classList.add('active');
//     }

//     // Event Listeners para los botones del sidebar
//     tablonBtn.addEventListener('click', function() {
//         showSection(tablonSection);
//         updateActiveButton(tablonBtn);
//     });

//     tareasBtn.addEventListener('click', function() {
//         showSection(tareasSection);
//         updateActiveButton(tareasBtn);
//     });

//     alumnosBtn.addEventListener('click', function() {
//         showSection(alumnosSection);
//         updateActiveButton(alumnosBtn);
//     });

//     avisosBtn.addEventListener('click', function() {
//         showSection(avisosSection);
//         updateActiveButton(avisosBtn);
//     });

//     // --- Funcionalidad del Modal (Tarea) ---
//     const modal = document.getElementById('modalTarea');
//     const closeBtn = document.querySelector('.modal .close');
//     const modalTitulo = document.getElementById('modalTitulo');
//     const modalDescripcion = document.getElementById('modalDescripcion');
//     const archivoSubir = document.getElementById('archivoSubir');
//     const listaArchivos = document.getElementById('listaArchivos');
//     const enlaceInput = document.getElementById('enlaceInput');
//     const agregarEnlaceBtn = document.getElementById('agregarEnlace');
//     const listaEnlaces = document.getElementById('listaEnlaces');

//     // Función para abrir el modal
//     function openModal(titulo, descripcion) {
//         modalTitulo.textContent = titulo;
//         modalDescripcion.textContent = descripcion;
//         listaArchivos.innerHTML = ''; // Limpiar lista de archivos
//         listaEnlaces.innerHTML = ''; // Limpiar lista de enlaces
//         enlaceInput.value = ''; // Limpiar input de enlace
//         modal.style.display = 'flex'; // Mostrar el modal
//     }

//     // Evento para abrir el modal al hacer click en una tarea
//     document.querySelectorAll('.tarea').forEach(tarea => {
//         tarea.addEventListener('click', function() {
//             const titulo = this.dataset.titulo;
//             const descripcion = this.dataset.descripcion;
//             openModal(titulo, descripcion);
//         });
//     });

//     // Evento para cerrar el modal
//     closeBtn.addEventListener('click', function() {
//         modal.style.display = 'none';
//     });

//     // Cerrar el modal si se hace click fuera del contenido
//     window.addEventListener('click', function(event) {
//         if (event.target == modal) {
//             modal.style.display = 'none';
//         }
//     });

//     // Manejo de archivos subidos
//     archivoSubir.addEventListener('change', function() {
//         listaArchivos.innerHTML = ''; // Limpiar la lista antes de añadir nuevos
//         Array.from(this.files).forEach(file => {
//             const li = document.createElement('li');
//             li.textContent = file.name;
//             listaArchivos.appendChild(li);
//         });
//     });

//     // Manejo de enlaces
//     agregarEnlaceBtn.addEventListener('click', function() {
//         const url = enlaceInput.value.trim();
//         if (url) {
//             const li = document.createElement('li');
//             const a = document.createElement('a');
//             a.href = url;
//             a.textContent = url;
//             a.target = "_blank"; // Abrir en nueva pestaña
//             li.appendChild(a);
//             listaEnlaces.appendChild(li);
//             enlaceInput.value = ''; // Limpiar input
//         }
//     });

//     // --- Animación de Partículas en el Banner (si la estás usando) ---
//     // Si no usas canvas para partículas, puedes eliminar esta sección
//     const banner = document.querySelector('.banner');
//     if (banner && banner.querySelector('#particles-bg')) {
//         const canvas = banner.querySelector('#particles-bg');
//         const ctx = canvas.getContext('2d');
//         let particles = [];
//         const numParticles = 30;

//         function resizeCanvas() {
//             canvas.width = banner.clientWidth;
//             canvas.height = banner.clientHeight;
//         }

//         class Particle {
//             constructor() {
//                 this.x = Math.random() * canvas.width;
//                 this.y = Math.random() * canvas.height;
//                 this.size = Math.random() * 2 + 1;
//                 this.speedX = Math.random() * 0.5 - 0.25;
//                 this.speedY = Math.random() * 0.5 - 0.25;
//                 this.opacity = Math.random() * 0.5 + 0.1;
//                 this.color = `rgba(255,255,255,${this.opacity})`;
//             }

//             update() {
//                 this.x += this.speedX;
//                 this.y += this.speedY;

//                 if (this.size > 0.2) this.size -= 0.01;
//                 if (this.x > canvas.width || this.x < 0) this.speedX *= -1;
//                 if (this.y > canvas.height || this.y < 0) this.speedY *= -1;
//             }

//             draw() {
//                 ctx.fillStyle = this.color;
//                 ctx.beginPath();
//                 ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
//                 ctx.fill();
//             }
//         }

//         function initParticles() {
//             particles = [];
//             for (let i = 0; i < numParticles; i++) {
//                 particles.push(new Particle());
//             }
//         }

//         function animateParticles() {
//             requestAnimationFrame(animateParticles);
//             ctx.clearRect(0, 0, canvas.width, canvas.height);

//             for (let i = 0; i < particles.length; i++) {
//                 particles[i].update();
//                 particles[i].draw();

//                 if (particles[i].size < 0.2) {
//                     particles.splice(i, 1);
//                     i--;
//                     particles.push(new Particle());
//                 }
//             }
//         }

//         resizeCanvas();
//         initParticles();
//         animateParticles();
//         window.addEventListener('resize', resizeCanvas);
//     }
// });

document.addEventListener("DOMContentLoaded", function() {
    // Mostrar tablón por defecto
    document.querySelectorAll('.seccion').forEach(sec => sec.style.display = 'none');
    document.getElementById('tablon').style.display = 'block';

    // Sidebar buttons
    document.querySelectorAll('.sidebar nav button').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.sidebar nav button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.seccion').forEach(sec => sec.style.display = 'none');
            document.getElementById(this.id.replace('-btn','')).style.display = 'block';
        });
    });

    // Modal funcionalidad
    var modal = document.getElementById("modalTarea");
    var span = document.getElementsByClassName("close")[0];
    var listaArchivos = document.getElementById("listaArchivos");
    var archivoInput = document.getElementById("archivoSubir");
    var enlaceInput = document.getElementById("enlaceInput");
    var listaEnlaces = document.getElementById("listaEnlaces");
    var agregarEnlaceBtn = document.getElementById("agregarEnlace");

    // Función global para abrir modal desde botones
    window.abrirModal = function(titulo, descripcion) {
        document.getElementById("modalTitulo").innerText = titulo;
        document.getElementById("modalDescripcion").innerText = descripcion;
        listaArchivos.innerHTML = "";
        listaEnlaces.innerHTML = "";
        archivoInput.value = "";
        modal.style.display = "flex";
    };

    // Detectar click en cualquier tarea del tablón
    document.querySelectorAll('.tarea').forEach(function(tarea) {
        tarea.addEventListener('click', function() {
            var titulo = this.getAttribute('data-titulo') || (this.querySelector('h4') ? this.querySelector('h4').innerText : '');
            var descripcion = this.getAttribute('data-descripcion') || (this.querySelector('p') ? this.querySelector('p').innerText : '');
            window.abrirModal(titulo, descripcion);
        });
    });

    // Botones "Añadir tarea" en la sección tareas
    document.querySelectorAll('.boton-estilo').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var li = btn.closest('li');
            var titulo = li.querySelector('span') ? li.querySelector('span').innerText : '';
            var descripcion = li.querySelector('p') ? li.querySelector('p').innerText : '';
            window.abrirModal(titulo, descripcion);
        });
    });

    // Cerrar modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Subir archivos
    archivoInput.addEventListener('change', function() {
        listaArchivos.innerHTML = "";
        Array.from(archivoInput.files).forEach(function(file) {
            var li = document.createElement("li");
            li.textContent = file.name;
            listaArchivos.appendChild(li);
        });
    });

    // Agregar enlaces
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

    // Partículas animadas en el banner
    const canvas = document.getElementById('particles-bg');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let particles = [];
        let w, h;

        function resize() {
            w = canvas.offsetWidth;
            h = canvas.offsetHeight;
            canvas.width = w;
            canvas.height = h;
        }
        resize();
        window.addEventListener('resize', resize);

        function randomColor() {
            const colors = [
                '#fff',
                '#e3d6ff', // lila pastel
                '#ffe6fa', // rosa pastel claro
                '#d6c6ff', // lila claro
                '#fff9',
                '#fff7'
            ];
            return colors[Math.floor(Math.random() * colors.length)];
        }

        function createParticles() {
            particles = [];
            for (let i = 0; i < 22; i++) {
                particles.push({
                    x: Math.random() * w,
                    y: Math.random() * h,
                    r: 6 + Math.random() * 10,
                    dx: (Math.random() - 0.5) * 0.6,
                    dy: (Math.random() - 0.5) * 0.6,
                    color: randomColor(),
                    alpha: 0.3 + Math.random() * 0.5
                });
            }
        }
        createParticles();

        function animate() {
            ctx.clearRect(0, 0, w, h);
            for (let p of particles) {
                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = p.color;
                ctx.shadowColor = p.color;
                ctx.shadowBlur = 12;
                ctx.fill();
                ctx.restore();

                p.x += p.dx;
                p.y += p.dy;
                if (p.x < -20 || p.x > w + 20) p.dx *= -1;
                if (p.y < -20 || p.y > h + 20) p.dy *= -1;
            }
            requestAnimationFrame(animate);
        }
        animate();

        // Re-crear partículas en resize
        window.addEventListener('resize', function() {
            resize();
            createParticles();
        });
    }
});

/*document.getElementById("formSubirTarea").addEventListener("submit", function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const mensaje = document.getElementById("mensajeSubida");

    fetch('subir_tarea_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        mensaje.innerHTML = data.mensaje;

    })
    .catch(err => {
        mensaje.innerHTML = "❌ Error en la conexión.";
    });
});*/

function eliminarArchivo(idArchivo) {
    if (confirm("¿Seguro que deseas eliminar este archivo?")) {
        fetch("eliminar_archivo_ajax.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "id_archivo=" + idArchivo
        })
        .then(resp => resp.text())
        .then(msg => {
            alert(msg);
            location.reload();
        });
    }
}

function eliminarEntrega(idEntrega) {
    if (confirm("¿Seguro que deseas eliminar toda la entrega?")) {
        fetch("eliminar_entrega_ajax.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "id_entrega=" + idEntrega
        })
        .then(resp => resp.text())
        .then(msg => {
            alert(msg);
            location.reload();
        });
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // ... (todo tu código sidebar, modal, partículas, etc) ...

    // SUBIR TAREA CON ALERT DE MENSAJE
    document.querySelectorAll('.formSubirTarea').forEach(form => {
        form.onsubmit = function(e) {
            e.preventDefault();
            let formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(resp => resp.json())
            .then(data => {
                alert(data.mensaje); // <-- Sale el alert aquí
                location.reload();   // Opcional: recarga la página para mostrar los nuevos archivos
            })
            .catch(err => {
                alert("❌ Error en la conexión.");
            });
        };
    });

    // ... (el resto de tu código, funciones de eliminar, etc) ...
});
