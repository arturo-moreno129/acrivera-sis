<script>
  var eventoSeleccionadoId = null;
  document.addEventListener("DOMContentLoaded", function() {

    var calendarEl = document.getElementById("calendar");

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: "dayGridMonth",
      locale: "es",
      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay",
      },
      //initialDate: '2021-01-01',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      select: function(arg) {
        //console.log(arg.start.toISOString().split('.')[0]);
        const fecha = arg.start.toLocaleDateString('en-CA'); // Formato 'YYYY-MM-DD'
        console.log(fecha);

        //var startTime = arg.start.toISOString().split('.')[0];
        //var claveUser = "1299790";
        //var comparation = prompt("Ingrese la contraseña");
        //if (claveUser == comparation) {

        Swal.fire({
          title: 'Detalles de la Reunion',
          html: `
            <label for="html">Titulo</label>
            <input id="swal-input-title" class="swal2-input" placeholder="Reunion con invitados" onkeyup="this.value = this.value.toUpperCase();"><br><br>
            <label for="html">Fecha</label>
            <input type="date" class="swal2-input"><br>
            <label for="html">Hora inicio</label>
            <input type="time" id="swal-input-start" class="swal2-input">
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
            const fecha = document.querySelector('input[type="date"]').value;
            const horaInicio = document.getElementById('swal-input-start').value;
            const horaFin = document.getElementById('swal-input-end').value;
            const dispo = document.getElementById('swal-input-dispo').value;
            //const mail = document.getElementById('swal-input-mail').value;
            /*const opciones = document.getElementsByName('option');
            var seleccion = '';
            for (const opcion of opciones) {
              if (opcion.checked) {
                seleccion = opcion.value;
                break;
              }
            }
            option = seleccion;*/
            if (!title) {
              Swal.showValidationMessage('Por favor, ingrese el usuario');
            }
            if (!dispo) {
              Swal.showValidationMessage('Por favor, ingrese el dispositivo');
            }
            if (!fecha) {
              Swal.showValidationMessage('Por favor, ingrese la fecha');
            }
            if (!horaInicio) {
              Swal.showValidationMessage('Por favor, ingrese la hora de inicio');
            }
            if (!horaFin) {
              Swal.showValidationMessage('Por favor, ingrese la hora de fin');
            }
            return {
              title,
              dispo,
              fecha,
              horaInicio,
              horaFin
              //mail
            };
          }
        }).then((result) => {
          if (result.isConfirmed) {
            const {
              title,
              dispo,
              fecha,
              horaInicio,
              horaFin
              //mail
            } = result.value;
            /**PRUEBA ENVIO DE DATOS A PHP */

            // Variables en JavaScript
            /*const phptitle = title
            const phpdescription = description;
            const phptime = description;
            const phpuser = $_SESSION['ususario'];*/
            // Crear formulario
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "uploadDate.php";

            // Crear campos ocultos
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
            inputDate.value = fecha;

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

            /*const inputRadio = document.createElement("input");
            inputRadio.type = "hidden";
            inputRadio.name = "phpRadio";
            inputRadio.value = option;

            const inputdispo = document.createElement("input");
            inputdispo.type = "hidden";
            inputdispo.name = "phpdispo";
            inputdispo.value = dispo;*/



            /*const inputMail = document.createElement("input");
            inputMail.type = "hidden";
            inputMail.name = "phpmail";
            inputMail.value = mail;*/

            // Agregar campos y enviar formulario
            form.appendChild(inputTitle);
            form.appendChild(inputDispo);
            form.appendChild(inputDate);
            form.appendChild(inputUser);
            //form.appendChild(inputRadio);
            form.appendChild(inputHoraInicio);
            form.appendChild(inputHoraFin);

            //form.appendChild(inputMail);
            document.body.appendChild(form);
            form.submit();
            /********************************* */
            calendar.addEvent({
              title: title,
              start: horaInicio,
              end: horaFin,
              description: description, // Puedes agregar más campos si es necesario
              location: location,
            });
          }
        });

        /*var title = prompt("Titulo del evento:");
        if (title) {
          calendar.addEvent({
            title: title,
            start: arg.start,
            end: arg.end,
            //allDay: arg.allDay,
          });
        }*/
        //}
        calendar.unselect();
      },
      eventClick: function(arg) {

        eventoSeleccionadoId = arg.event.id;
        if (arg.event.groupId == 0) {
          Swal.fire({
            title: "Acceso denegado",
            text: "No tienes permiso para editar o eliminar elementos de otros usuarios o aquellos que ya están finalizados.",
            icon: "error"
          });
        } else {
          Swal.fire({
            title: "¿Qué quiere realizar?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Eliminar",
            denyButtonText: "Finalizar tarea",
            cancelButtonText: 'Cancelar',
            html: `
           <button id="otro-boton" class="swal2-styled">Compartir con usuario</button>
            `

          }).then((result) => {
            if (result.isConfirmed) {
              // Enviar solicitud AJAX para eliminar el evento
              fetch('crud-calendar.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                  },
                  //body: `id=${arg.event.id}`
                  body: `action=eliminar&id=${arg.event.id}`
                })
                .then(response => response.json())
                .then(data => {
                  if (data.status === "success") {
                    Swal.fire(data.message, "", "success");
                    arg.event.remove(); // Remueve el evento del calendario si se eliminó correctamente
                  } else {
                    Swal.fire("Error", data.message, "error");
                  }
                })
                .catch(error => Swal.fire("Error", "No se pudo conectar con el servidor.", "error"));
            } else if (result.isDenied) {
              fetch('crud-calendar.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                  },
                  body: `action=finalizarTarea&id=${arg.event.id}`
                })
                .then(response => response.json())
                .then(data => {
                  if (data.status === "success") {
                    Swal.fire({
                      title: data.message,
                      icon: "success",
                      confirmButtonText: "OK"
                    }).then((result) => {
                      if (result.isConfirmed) {
                        location.reload(); // Recarga la página cuando el usuario presiona "OK"
                      }
                    });

                  } else {
                    Swal.fire("Error", data.message, "error");
                  }
                })
              //Swal.fire("¡Tarea finalizada correctamente!", "", "info");
            }
          });
        }
      },

      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: [
        <?php
        include('conexion.php');
        $SqlEventos   =
          (
            "SELECT m.*
              FROM mantenimientos m
              WHERE m.id_usuario = {$_SESSION['id_usuario']} and m.estatus != 2
              UNION
              SELECT m.*
              FROM mantenimientos m
              JOIN compartidos c ON m.id_mantenimiento = c.id_cita
              WHERE c.id_usuario_compartido = {$_SESSION['id_usuario']} and m.estatus != 2"
          );
        $resulEventos = mysqli_query($con, $SqlEventos);
        while ($dataEvento = mysqli_fetch_array($resulEventos)) { ?> {
            id: '<?php echo $dataEvento['id_mantenimiento']; ?>',
            title: '<?php echo $dataEvento['usuario_final']; ?>',
            start: '<?php echo $dataEvento['fecha'].'T'.$dataEvento['horaInicio']; ?>',
            end: '<?php echo $dataEvento['fecha'].'T'.$dataEvento['horaFin']; ?>',
            color: '<?php echo ($dataEvento['estatus'] == 1) ? "#60c4f3" : "red" ?>',
            editable: '<?= ($dataEvento['estatus'] == 1 && $dataEvento['id_usuario'] == $_SESSION['id_usuario']) ?>',
            groupId: '<?php echo ($dataEvento['estatus'] == 1 && $dataEvento['id_usuario'] == $_SESSION['id_usuario']) ? 1 : 0 ?>',
            extendedProps: {
              //location: "Sala A",
              description: '<?php echo $dataEvento['usuario_final']; ?>',
              //organizer: "María",
              //perro: 1
            }
          },
        <?php } ?>
        /*{
          id: "1",
          groupId: "recurring-event",
          title: "Reunión semanal",
          start: "2024-11-06T10:00:00",
          end: "2024-11-06T12:00:00",
          allDay: false,
          daysOfWeek: [1], // Recurrente cada lunes
          startRecur: "2024-11-01",
          endRecur: "2024-12-01",
          startTime: "10:00:00",
          endTime: "12:00:00",
          //url: "https://ejemplo.com",
          classNames: ["highlight"],
          editable: true,
          startEditable: true,
          durationEditable: true,
          resourceEditable: true,
          overlap: true,
          display: "block",
          backgroundColor: "#3788d8",
          color: "#fffff"
          borderColor: "#ff0000",
          textColor: "#333333",
          extendedProps: {
            location: "Sala A",
            description: "Reunión de equipo semanal",
            organizer: "María",
            perro: 1
          }
        {
          title: "prueba",
          start: '2024-11-04T05:00:00',
          end: '2024-11-04T06:30:00',
          color: '#FF0000',
          groupId: 1,
          editable: false,
        }/*,
        {
          title: "Conference",
          start: "2024-11-05",
          end: "2024-11-05",
          color: '#FF0000',
        },
        {
          title: "Lunch",
          start: "2024-11-06T12:00:00",
        },
        /*
                      {
                        title: "Meeting",
                        start: "2024-01-12T14:30:00",
                      },
                      {
                        title: "Happy Hour",
                        start: "2024-01-12T17:30:00",
                      },
                      {
                        title: "Dinner",
                        start: "2024-01-12T20:00:00",
                      },
                      {
                        title: "Birthday Party",
                        start: "2024-01-13T07:00:00",
                      },
                      {
                        title: "Click for Google",
                        url: "http://google.com/",
                        start: "2024-01-28",
                      },
                      
        
              {
                title: 'Meeting',
                start: '2024-09-13T11:00:00',
                //constraint: 'availableForMeeting', // defined below
                color: '#FF0000'
              },
              {
                groupId: 999,
                title: "Evento Repetido 2",
                start: "2024-01-01T16:00:00",
              },
              {
                groupId: 999,
                title: "Evento repetido 1",
                start: "2024-01-03T16:00:00",
              },
              {
                        title: "Meeting",
                        start: "2024-01-12T10:30:00",
                        end: "2024-01-12T12:30:00",
                      },*/

      ],
      eventDidMount: function(info) {
        // Para mostrar la descripción como tooltip cuando se poneel mouse por ensima
        if (info.event.extendedProps.description) {
          info.el.setAttribute('title', info.event.extendedProps.description);
        }
      },
      eventDragStart: function(info) {
        // Mostrar un mensaje al iniciar el arrastre
        console.log('Iniciaste el arrastre de: ' + info.event.title);

        // También puedes hacer otras cosas, como cambiar el estilo del evento
        info.el.style.opacity = '0.5'; // Ejemplo de cambiar opacidad
      },
      eventDrop: function(info) {
        // Aquí puedes manejar el evento después de que se suelta
        console.log('El evento ' + info.event.title + ' fue movido a: ' + info.event.start);
        // Restablecer el estilo del evento
        info.el.style.opacity = ''; // Restablecer opacidad
      }
    });

    calendar.render();
  });

  // Evento para el botón extra
  document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'otro-boton') {
      fetch('crud-calendar.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `action=obtenerUsuarios`

        })
        .then(response => response.json())
        .then(data => {
          if (data.status === "success") {
            console.log(data.message);
            Swal.fire({
                title: "Usuarios",
                //showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Actualizar",
                //denyButtonText: "Baja",
                html: `
                                    <select id="usuarios" class="form-control">
                                        <option value=></option>
                                    </select>
                                `,
                didOpen: () => {
                  const select = document.getElementById("usuarios");

                  // Limpiar el select y agregar una opción por defecto
                  select.innerHTML = '<option value="">Seleccione un usuario</option>';

                  // Recorrer arreglo de usuarios
                  data.message.forEach(usuario => {
                    const option = document.createElement("option");
                    option.value = usuario.id_usuario; // o usuario.usuario si prefieres
                    option.textContent = `${usuario.nombre} ${usuario.apellidoP} ${usuario.apellidoM}`;
                    select.appendChild(option);
                  });
                },
                preConfirm: () => {
                  return {
                    slect2: document.getElementById('usuarios').value
                  };
                }
              })
              .then((result) => {
                if (result.isConfirmed) {
                  console.log("resultado:", result.value)
                  const selectedUser = result.value.slect2;
                  if (selectedUser) {
                    // Aquí puedes hacer algo con el usuario seleccionado
                    console.log("Usuario seleccionado:", selectedUser);
                    fetch('crud-calendar.php', {
                        method: 'POST',
                        headers: {
                          'Content-Type': 'application/x-www-form-urlencoded'
                        },
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
                      .catch(error => Swal.fire("Error", "No se pudo conectar con el servidor.", "error"));
                  }
                }
              })
          }
        })
    }
  });
</script>