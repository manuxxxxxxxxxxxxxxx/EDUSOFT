

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Calendario de Citas</title>
  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(120deg, #e6f0fa 0%, #c2e9fb 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
    }
    .calendar-container {
      max-width: 950px;
      margin: 50px auto;
      padding: 30px;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 8px 32px rgba(60,72,88,0.12);
      border: 2px solid #90caf9;
    }
    .fc-toolbar-title,
    .navbar-brand,
    .text-pastel {
      color: #1976d2 !important;
    }
    .fc-event {
      background-color: #90caf9 !important; /* Azul pastel */
      color: #1976d2 !important;
      border: none !important;
      border-radius: 8px !important;
      font-size: 1rem;
      box-shadow: 0 2px 6px rgba(144,202,249,0.12);
      padding: 4px 8px;
      font-weight: 500;
    }
    .fc-daygrid-day:hover {
      background-color: #e3f2fd;
      cursor: pointer;
      transition: background 0.2s;
    }
    .custom-btn {
      background: #90caf9;
      color: #1976d2;
      border: none;
      border-radius: 8px;
      padding: 8px 18px;
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: 18px;
      transition: background 0.2s;
      box-shadow: 0 2px 8px rgba(144,202,249,0.08);
    }
    .custom-btn:hover {
      background: #64b5f6;
      color: #fff;
    }
    .navbar-brand {
      font-size: 1.4rem;
      font-weight: 700;
      letter-spacing: 1px;
      color: #1976d2;
    }
    .modal-header {
      background: #90caf9;
      color: #1976d2;
    }
    .modal-title {
      font-weight: 700;
      font-size: 1.2rem;
    }
    .form-label {
      font-weight: 500;
      color: #1976d2;
    }
    .btn-pastel {
      background: #90caf9;
      color: #1976d2;
      border: none;
      font-weight: 500;
    }
    .btn-pastel:hover {
      background: #1976d2;
      color: #fff;
    }
    .btn-outline-pastel {
      border-color: #90caf9;
      color: #1976d2;
    }
    .btn-outline-pastel:hover {
      background: #90caf9;
      color: #1976d2;
    }
    .alert-pastel {
      background: #e3f2fd;
      color: #1976d2;
      border: 1px solid #90caf9;
      box-shadow: 0 2px 8px rgba(144,202,249,0.08);
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="../img/ELEFANTE.png" alt="Logo" style="width: 60px; height: 60px;"> EduSoft Calendario</a>
    </div>
  </nav>
  <div class="calendar-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0 text-pastel"><i class="bi bi-calendar3"></i> Calendario de Citas</h2>
      <button class="custom-btn" onclick="window.location.reload()">
        <i class="bi bi-arrow-clockwise"></i> Actualizar
      </button>
    </div>
    <div id="calendar"></div>
  </div>

  <!-- Modal: Crear cita -->
  <div class="modal fade" id="modalCita" tabindex="-1" aria-labelledby="modalCitaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formCita" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCitaLabel"><i class="bi bi-calendar-plus"></i> Nueva Cita</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="citaTitulo" class="form-label">Título de la cita</label>
            <input type="text" class="form-control" id="citaTitulo" required autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="citaFechaInicio" class="form-label">Fecha inicio</label>
            <input type="datetime-local" class="form-control" id="citaFechaInicio" required>
          </div>
          <div class="mb-3">
            <label for="citaFechaFin" class="form-label">Fecha fin (opcional)</label>
            <input type="datetime-local" class="form-control" id="citaFechaFin">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-pastel" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-pastel"><i class="bi bi-save2"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal: Editar cita -->
  <div class="modal fade" id="modalEditarCita" tabindex="-1" aria-labelledby="modalEditarCitaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formEditarCita" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarCitaLabel"><i class="bi bi-pencil-square"></i> Editar Cita</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editarId">
          <div class="mb-3">
            <label for="editarTitulo" class="form-label">Título de la cita</label>
            <input type="text" class="form-control" id="editarTitulo" required autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="editarInicio" class="form-label">Fecha inicio</label>
            <input type="datetime-local" class="form-control" id="editarInicio" required>
          </div>
          <div class="mb-3">
            <label for="editarFin" class="form-label">Fecha fin (opcional)</label>
            <input type="datetime-local" class="form-control" id="editarFin">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-pastel" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-pastel"><i class="bi bi-save2"></i> Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal: Eliminar cita -->
  <div class="modal fade" id="modalEliminarCita" tabindex="-1" aria-labelledby="modalEliminarCitaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formEliminarCita" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEliminarCitaLabel"><i class="bi bi-trash3"></i> Eliminar Cita</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="eliminarId">
          <p>¿Estás seguro que deseas eliminar esta cita?</p>
          <p class="fw-bold text-pastel" id="eliminarTitulo"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-pastel" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS (modals) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
  <script>
    let calendar, selectedInfo, selectedEvent;

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        selectable: true,
        editable: true,
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventClick: function(info) {
          selectedEvent = info.event;
          // Mostrar modal de opciones: Editar o Eliminar
          abrirEditarModal(selectedEvent);
        },
        eventDrop: function(info) {
          fetch('actualizar_cita.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
              id: info.event.id,
              start: info.event.startStr,
              end: info.event.endStr
            })
          })
          .then(response => response.json())
          .then(data => {
            if (!data.success) {
              showMsg('Error al mover la cita', 'danger');
              info.revert();
            } else {
              showMsg('¡Cita movida!', 'info');
            }
          });
        },
        select: function(info) {
          selectedInfo = info;
          // Modal para crear cita
          document.getElementById('citaTitulo').value = '';
          document.getElementById('citaFechaInicio').value = info.startStr.replace('T', ' ').substring(0,16).replace(' ', 'T');
          document.getElementById('citaFechaFin').value = info.endStr ? info.endStr.replace('T', ' ').substring(0,16).replace(' ', 'T') : '';
          var modal = new bootstrap.Modal(document.getElementById('modalCita'));
          modal.show();
        },
        events: 'citas.php'
      });
      calendar.render();
    });

    // Guardar cita (crear)
    document.getElementById('formCita').addEventListener('submit', function(e) {
      e.preventDefault();
      const title = document.getElementById('citaTitulo').value;
      const start = document.getElementById('citaFechaInicio').value;
      const end = document.getElementById('citaFechaFin').value;
      fetch('guardar_citas.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
          title: title,
          start: start,
          end: end || null
        })
      })
      .then(response => response.json())
      .then(data => {
        var modal = bootstrap.Modal.getInstance(document.getElementById('modalCita'));
        modal.hide();
        if (data.success) {
          calendar.refetchEvents();
          showMsg('¡Cita guardada!', 'success');
        } else {
          showMsg('Error al guardar la cita', 'danger');
        }
      })
      .catch(error => showMsg('Error de conexión', 'danger'));
    });

    // Editar cita
    function abrirEditarModal(event) {
      document.getElementById('editarId').value = event.id;
      document.getElementById('editarTitulo').value = event.title;
      document.getElementById('editarInicio').value = formatDateTime(event.start);
      document.getElementById('editarFin').value = event.end ? formatDateTime(event.end) : '';
      var modal = new bootstrap.Modal(document.getElementById('modalEditarCita'));
      modal.show();

      // Botón para eliminar en esta modal abre el modal de eliminar
      document.getElementById('modalEditarCita').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formEditarCita').reset();
      });
    }

    document.getElementById('formEditarCita').addEventListener('submit', function(e) {
      e.preventDefault();
      const id = document.getElementById('editarId').value;
      const title = document.getElementById('editarTitulo').value;
      const start = document.getElementById('editarInicio').value;
      const end = document.getElementById('editarFin').value;
      fetch('actualizar_cita.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
          id: id,
          title: title,
          start: start,
          end: end || null
        })
      })
      .then(response => response.json())
      .then(data => {
        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarCita'));
        modal.hide();
        if (data.success) {
          calendar.refetchEvents();
          showMsg('¡Cita actualizada!', 'success');
        } else {
          showMsg('Error al editar la cita', 'danger');
        }
      })
      .catch(error => showMsg('Error de conexión', 'danger'));
    });

    // Modal eliminar cita
    function abrirEliminarModal(event) {
      document.getElementById('eliminarId').value = event.id;
      document.getElementById('eliminarTitulo').innerText = event.title;
      var modal = new bootstrap.Modal(document.getElementById('modalEliminarCita'));
      modal.show();
    }

    // Eliminar cita
    document.getElementById('formEliminarCita').addEventListener('submit', function(e) {
      e.preventDefault();
      const id = document.getElementById('eliminarId').value;
      fetch('eliminar.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
      })
      .then(response => response.json())
      .then(data => {
        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminarCita'));
        modal.hide();
        if (data.success) {
          calendar.refetchEvents();
          showMsg('¡Cita eliminada!', 'success');
        } else {
          showMsg('Error al eliminar la cita', 'danger');
        }
      })
      .catch(error => showMsg('Error de conexión', 'danger'));
    });

    // Al hacer doble clic en evento, mostrar modal eliminar
    document.getElementById('modalEditarCita').addEventListener('dblclick', function() {
      abrirEliminarModal(selectedEvent);
    });

    // Mensaje flotante Bootstrap
    function showMsg(msg, type='info') {
      let alert = document.createElement('div');
      alert.className = `alert alert-pastel alert-${type} fade show position-fixed top-0 end-0 m-3 shadow`;
      alert.style.zIndex = 9999;
      alert.role = 'alert';
      alert.innerText = msg;
      document.body.appendChild(alert);
      setTimeout(() => {
        alert.classList.remove('show');
        setTimeout(()=>document.body.removeChild(alert), 500);
      }, 2000);
    }

    // Formatea Date a YYYY-MM-DDTHH:mm para el input
    function formatDateTime(date) {
      if (!date) return '';
      const d = new Date(date);
      d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
      return d.toISOString().slice(0,16);
    }

    // Al hacer clic en el botón eliminar dentro de la modal editar, abre el modal de eliminar
    document.getElementById('formEditarCita').insertAdjacentHTML('beforeend', `
      <button type="button" class="btn btn-danger mt-3" id="btnEliminarCita">
        <i class="bi bi-trash"></i> Eliminar esta cita
      </button>
    `);
    document.getElementById('btnEliminarCita').addEventListener('click', function() {
      abrirEliminarModal(selectedEvent);
      var modalEditar = bootstrap.Modal.getInstance(document.getElementById('modalEditarCita'));
      modalEditar.hide();
    });
  </script>
</body>
</html>