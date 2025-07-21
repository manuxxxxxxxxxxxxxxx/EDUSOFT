<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Calendario de Citas</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
  <style>
    #calendar {
      max-width: 900px;
      margin: 40px auto;
      padding: 20px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <div id="calendar"></div>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
 <script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    selectable: true,
    editable: true, // Permite mover eventos
    eventClick: function(info) {
      // Botón para eliminar
      if (confirm("¿Quieres eliminar esta cita?")) {
        fetch('eliminar.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: 'id=' + encodeURIComponent(info.event.id)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            info.event.remove();
            alert('¡Cita eliminada!');
          } else {
            alert('Error al eliminar la cita');
          }
        });
      }
    },
    eventDrop: function(info) {
      // Mover evento de día/hora
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
          alert('Error al mover la cita');
          info.revert();
        }
      });
    },
    select: function(info) {
      var title = prompt('Título de la cita:');
      if (title) {
        fetch('guardar_citas.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({
            title: title,
            start: info.startStr,
            end: info.endStr
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            calendar.refetchEvents();
            alert('¡Cita guardada!');
          } else {
            alert('Error al guardar la cita');
          }
        })
        .catch(error => alert('Error de conexión'));
      }
    },
    events: 'citas.php'
  });
  calendar.render();
});
</script>
</body>
</html>