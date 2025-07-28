document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formSubirTarea");

    if (!form) {
        console.error("❌ No se encontró el formulario con ID 'formSubirTarea'");
        return;
    }

    console.log("✅ Script de subir_tarea.js cargado correctamente");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

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

                // Agregar la tarea a la lista (si tienes una lista UL o DIV con ID listaTareas)
                if (data.archivo) {
                    const nuevaTarea = document.createElement("li");
                    nuevaTarea.innerHTML = `<a href="${data.archivo.ruta}" target="_blank">${data.archivo.nombre}</a> <small>(${data.archivo.fecha})</small>`;
                    const lista = document.getElementById("listaTareas");
                    if (lista) lista.appendChild(nuevaTarea);
                }

                // Limpiar el input
                document.getElementById("archivo").value = "";
            } else {
                mensajeDiv.innerHTML = `<p style="color: red;">${data.mensaje}</p>`;
            }
        })
        .catch(error => {
            console.error("Error en fetch:", error);
            document.getElementById("mensajeSubida").innerHTML = `<p style="color: red;">❌ Error al enviar la tarea.</p>`;
        });
    });
});

function eliminarTarea(id_tarea) {
    if (!confirm("¿Estás seguro de eliminar esta tarea?")) return;

    const formData = new FormData();
    formData.append("id_tarea", id_tarea);

    fetch("eliminar_tarea.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const li = document.getElementById("tarea_" + id_tarea);
            if (li) li.remove();
        } else {
            alert("❌ No se pudo eliminar: " + data.mensaje);
        }
    })
    .catch(error => {
        alert("❌ Error al eliminar tarea.");
        console.error(error);
    });
}

