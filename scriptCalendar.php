<script>
  var eventoSeleccionadoId = null;

  document.addEventListener("DOMContentLoaded", function() {

    var calendarEl = document.getElementById("calendar");

    // 🗓️ Leer la fecha pasada por la URL (si existe)
    const params = new URLSearchParams(window.location.search);
    const fechaURL = params.get('fecha');
    const fechaInicial = fechaURL ? fechaURL : new Date();

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: "dayGridMonth",
      initialDate: fechaInicial,
      locale: "es",

      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay",
      },

      navLinks: true,

      // ✅ Opciones recomendadas para TOUCH
      selectable: true,
      longPressDelay: 50,
      selectLongPressDelay: 50,

      // ✅ Cargar eventos desde PHP (Multi-dispositivo)
      events: function(fetchInfo, successCallback, failureCallback) {
        fetch('getEvents.php')
          .then(response => response.json())
          .then(data => successCallback(data))
          .catch(error => failureCallback(error));
      },

      // ✅ TOUCH / CLICK sobre un día
      dateClick: function(info) {
        const fechaCita = info.dateStr; // YYYY-MM-DD
        console.log("TOUCH Fecha:", fechaCita);

        Swal.fire({
          title: 'Detalles de la Reunion',
          html: `
            <label for="html">Titulo</label>
            <input id="swal-input-title" class="swal2-input" placeholder="Recepción Vanes" onkeyup="this.value = this.value.toUpperCase();"><br><br>

            <label for="html">Hora inicio</label>
            <input type="time" id="swal-input-start" class="swal2-input"><br>

            <label for="html">Hora fin</label>
            <input type="time" id="swal-input-end" class="swal2-input"><br><br>

            <label for="html">Detalles</label><br>
            <textarea id="swal-input-dispo" class="swal2-textarea" placeholder="Detalles de la reunion"></textarea><br>
          `,
          width: 500,
          focusConfirm: false,
          showCancelButton: true,
          confirmButtonText: 'Guardar',
          cancelButtonText: 'Cancelar',

          preConfirm: () => {
            const title = document.getElementById('swal-input-title').value;
            const horaInicio = document.getElementById('swal-input-start').value;
            const horaFin = document.getElementById('swal-input-end').value;
            const dispo = document.getElementById('swal-input-dispo').value;

            if (!title) { Swal.showValidationMessage('Por favor, ingrese el usuario'); return false; }
            if (!dispo) { Swal.showValidationMessage('Por favor, ingrese el dispositivo'); return false; }
            if (!horaInicio) { Swal.showValidationMessage('Por favor, ingrese la hora de inicio'); return false; }
            if (!horaFin) { Swal.showValidationMessage('Por favor, ingrese la hora de fin'); return false; }

            return { title, dispo, horaInicio, horaFin };
          }
        }).then((result) => {
          if (result.isConfirmed) {

            const { title, dispo, horaInicio, horaFin } = result.value;

            // ✅ Crear formulario para mandar datos a PHP
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "uploadDate.php";

            const inputTitle = document.createElement("input");
            inputTitle.type = "hidden";
            inputTitle.name = "phptitle";
            inputTitle.value = title;

            const inputDispo = document.createElement("input");
            inputDispo.type = "hidden";
            inputDispo.name = "phpdispo";
            inputDispo.value = dispo;

            const inputDate = document.createElement("input");
            inputDate.type = "hidden";
            inputDate.name = "phpdate";
            inputDate.value = fechaCita;

            const inputHoraInicio = document.createElement("input");
            inputHoraInicio.type = "hidden";
            inputHoraInicio.name = "phpHoraInicio";
            inputHoraInicio.value = horaInicio;

            const inputHoraFin = document.createElement("input");
            inputHoraFin.type = "hidden";
            inputHoraFin.name = "phpHoraFin";
            inputHoraFin.value = horaFin;

            const inputUser = document.createElement("input");
            inputUser.type = "hidden";
            inputUser.name = "phpuser";
            inputUser.value = "<?php echo $_SESSION['id_usuario']; ?>";

            form.appendChild(inputTitle);
            form.appendChild(inputDispo);
            form.appendChild(inputDate);
            form.appendChild(inputUser);
            form.appendChild(inputHoraInicio);
            form.appendChild(inputHoraFin);

            document.body.appendChild(form);
            form.submit();

            // ✅ si NO recargas página, esto refresca
            setTimeout(() => {
              calendar.refetchEvents();
            }, 1000);
          }
        });
      },

      // ✅ Tap/click sobre evento
      eventClick: function(arg) {

        eventoSeleccionadoId = arg.event.id;

        if (arg.event.groupId == 0) {
          Swal.fire({
            title: "Acceso denegado",
            text: "No tienes permiso para editar o eliminar elementos de otros usuarios o aquellos que ya están finalizados.",
            icon: "error"
          });
          return;
        }

        Swal.fire({
          title: "¿Qué quiere realizar?",
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: "Eliminar",
          denyButtonText: "Finalizar tarea",
          cancelButtonText: 'Cancelar',
          html: `<button id="otro-boton" class="swal2-styled">Compartir con usuario</button>`
        }).then((result) => {

          // ✅ ELIMINAR
          if (result.isConfirmed) {

            fetch('crud-calendar.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: `action=eliminar&id=${arg.event.id}`
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === "success") {
                Swal.fire(data.message, "", "success");
                arg.event.remove();
              } else {
                Swal.fire("Error", data.message, "error");
              }
            })
            .catch(() => Swal.fire("Error", "No se pudo conectar con el servidor.", "error"));
          }

          // ✅ FINALIZAR
          else if (result.isDenied) {

            fetch('crud-calendar.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: `action=finalizarTarea&id=${arg.event.id}`
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === "success") {
                Swal.fire({
                  title: data.message,
                  icon: "success",
                  confirmButtonText: "OK"
                }).then(() => location.reload());
              } else {
                Swal.fire("Error", data.message, "error");
              }
            })
            .catch(() => Swal.fire("Error", "No se pudo conectar con el servidor.", "error"));
          }
        });
      },

      dayMaxEvents: true,
      editable: true,

      eventDidMount: function(info) {
        if (info.event.extendedProps.description) {
          info.el.setAttribute('title', info.event.extendedProps.description);
        }
      },

      eventDragStart: function(info) {
        info.el.style.opacity = '0.5';
      },

      // ✅ Mover evento (drag and drop)
      eventDrop: function(info) {

        info.el.style.opacity = '';
        const id_evento = info.event.id;
        const nuevaFecha = info.event.start.toISOString().slice(0, 10);

        fetch('crud-calendar.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `action=actualizarFecha&id=${id_evento}&fecha=${nuevaFecha}`
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === "success") {
            Swal.fire(data.message, "", "success");
            calendar.refetchEvents();
          } else {
            Swal.fire("Error", data.message, "error");
          }
        })
        .catch(() => Swal.fire("Error", "No se pudo conectar con el servidor.", "error"));
      }

    });

    calendar.render();

    // ✅ AUTO ACTUALIZACIÓN MULTI-DISPOSITIVO
    setInterval(() => {
      calendar.refetchEvents();
    }, 5000); // cada 5 segundos

  });

  // ✅ Evento para botón "Compartir con usuario"
  document.addEventListener('click', function(e) {

    if (e.target && e.target.id === 'otro-boton') {

      fetch('crud-calendar.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=obtenerUsuarios`
      })
      .then(response => response.json())
      .then(data => {

        if (data.status === "success") {

          Swal.fire({
            title: "Usuarios",
            showCancelButton: true,
            confirmButtonText: "Actualizar",
            html: `
              <select id="usuarios" class="form-control">
                <option value=""></option>
              </select>
            `,
            didOpen: () => {
              const select = document.getElementById("usuarios");
              select.innerHTML = '<option value="">Seleccione un usuario</option>';

              data.message.forEach(usuario => {
                const option = document.createElement("option");
                option.value = usuario.id_usuario;
                option.textContent = `${usuario.nombre.toUpperCase()} ${usuario.apellidoP.toUpperCase()} ${usuario.apellidoM.toUpperCase()}`;
                select.appendChild(option);
              });
            },
            preConfirm: () => {
              return {
                slect2: document.getElementById('usuarios').value
              };
            }
          }).then((result) => {

            if (result.isConfirmed) {

              const selectedUser = result.value.slect2;

              if (selectedUser) {

                fetch('crud-calendar.php', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                  body: `action=compartir&id=${eventoSeleccionadoId}&usuario=${selectedUser}`
                })
                .then(response => response.json())
                .then(data => {
                  if (data.status === "success") {
                    Swal.fire(data.message, "", "success");
                  } else {
                    Swal.fire("Error", data.message, "error");
                  }
                })
                .catch(() => Swal.fire("Error", "No se pudo conectar con el servidor.", "error"));
              }
            }

          });
        }

      })
      .catch(() => Swal.fire("Error", "No se pudo conectar con el servidor.", "error"));

    }
  });

</script>
