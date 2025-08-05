document.getElementById("formSubirTarea").addEventListener("submit", function (e) {
    e.preventDefault();

    const form = document.getElementById("formSubirTarea");
    const formData = new FormData(form);

    fetch("subir_tarea_ajax.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const mensajeDiv = document.getElementById("mensajeSubida");

        if (data.success) {
            mensajeDiv.innerHTML = `<p style="color: green;">${data.mensaje}</p>`;

            // Crear el nuevo elemento <li> con botón de eliminar
            const nuevaTarea = document.createElement("li");
            nuevaTarea.id = `tarea_${data.archivo.id}`;
            nuevaTarea.innerHTML = `
                <a href="${data.archivo.ruta}" target="_blank">${data.archivo.nombre}</a>
                <small>(${data.archivo.fecha})</small>
                <button onclick="eliminarTarea(${data.archivo.id})"> ❌ Eliminar </button>
            `;

            const lista = document.getElementById("listaTareas");
            if (lista) lista.appendChild(nuevaTarea);

            form.reset(); // Limpiar el formulario
        } else {
            mensajeDiv.innerHTML = `<p style="color: red;">${data.mensaje}</p>`;
        }
    })
    .catch(error => {
        console.error("Error al subir tarea:", error);
        document.getElementById("mensajeSubida").innerHTML = `<p style="color: red;">❌ Error al subir la tarea.</p>`;
    });
});
