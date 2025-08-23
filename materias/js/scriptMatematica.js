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

    // Partículas animadas en el banner (solo rojas pastel y menos cantidad)
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
            // Solo tonos rojos pastel
            const colors = [
                '#ffb6b9',
                '#fa7e7e',
                '#ff8787',
                '#ffb6b9cc',
                '#fa7e7ecc'
            ];
            return colors[Math.floor(Math.random() * colors.length)];
        }

        function createParticles() {
            particles = [];
            for (let i = 0; i < 8; i++) { // menos partículas
                particles.push({
                    x: Math.random() * w,
                    y: Math.random() * h,
                    r: 8 + Math.random() * 10,
                    dx: (Math.random() - 0.5) * 0.5,
                    dy: (Math.random() - 0.5) * 0.5,
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
