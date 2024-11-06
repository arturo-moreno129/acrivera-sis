<script>
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
          title: 'Detalles del mantenimiento',
          html: `
            <input id="swal-input-title" class="swal2-input" placeholder="Nombre del usuario" onkeyup="this.value = this.value.toUpperCase();"><br><br>
            <input id="swal-input-dispo" class="swal2-input" placeholder="Nombre del dispositivo" onkeyup="this.value = this.value.toUpperCase();"><br><br>
            <table>
              <thead>
                <tr>
                    <th>Tipo de mantenimiento</th>
                    <th>No.</th>
                </tr>
                <tr>
                    <td><label for="html">Programado</label><br></td>
                    <td><input type="radio" id="swal-input-programado" name="option" value="1" checked></td>
                </tr>
                 <tr>
                    <td><label for="css">Solicitado</label><br></td>
                    <td><input type="radio" id="swal-input-solicitado" name="option" value="2"></td>
                </tr>
              </thead>
            </table> 
        `,
          focusConfirm: false,
          showCancelButton: true,
          confirmButtonText: 'Guardar',
          cancelButtonText: 'Cancelar',
          preConfirm: () => {
            const title = document.getElementById('swal-input-title').value;
            const dispo = document.getElementById('swal-input-dispo').value;
            const opciones = document.getElementsByName('option');
            var seleccion = '';
            for (const opcion of opciones) {
              if (opcion.checked) {
                seleccion = opcion.value;
                break;
              }
            }
            option = seleccion;
            if (!title) {
              Swal.showValidationMessage('Por favor, ingrese el usuario');
            }
            return {
              title,
              dispo,
            };
          }
        }).then((result) => {
          if (result.isConfirmed) {
            const {
              title,
              dispo
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

            const inputDate = document.createElement("input");
            inputDate.type = "hidden";
            inputDate.name = "phpdate";
            inputDate.value = fecha;

            const inputUser = document.createElement("input");
            inputUser.type = "hidden";
            inputUser.name = "phpuser";
            inputUser.value = "<?php echo $_SESSION['id_usuario']; ?>";

            const inputRadio = document.createElement("input");
            inputRadio.type = "hidden";
            inputRadio.name = "phpRadio";
            inputRadio.value = option;

            const inputdispo = document.createElement("input");
            inputRadio.type = "hidden";
            inputRadio.name = "phpdispo";
            inputRadio.value = dispo;

            // Agregar campos y enviar formulario
            form.appendChild(inputTitle);
            form.appendChild(inputDate);
            form.appendChild(inputdispo);
            form.appendChild(inputUser);
            form.appendChild(inputRadio);
            document.body.appendChild(form);
            form.submit();
            /********************************* */
            calendar.addEvent({
              title: title,
              start: fecha,
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
        if (arg.event.groupId == 0) {
          //alert("No tienes permiso para editar o eliminar elementos de otros usuarios.");
          Swal.fire({
            title: "Acceso denegado",
            text: "No tienes permiso para editar o eliminar elementos de otros usuarios o aquellos que ya están finalizados.",
            icon: "error"
          });
        } else {
          Swal.fire({
            title: "¿Estas seguro de que quierres eliminar este elemento?",
            showDenyButton: true,
            //showCancelButton: true,
            confirmButtonText: "Eliminar",
            denyButtonText: `Cancelar`
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              Swal.fire("Se elimino correctamente el elemento!", "", "success");
              arg.event.remove();
            } else if (result.isDenied) {
              Swal.fire("Los cambios no fueron realizados", "", "info");
            }
          });

        }
      },
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: [
        <?php
        include('conexion.php');
        $SqlEventos   = ("SELECT * FROM mantenimietos");
        $resulEventos = mysqli_query($con, $SqlEventos);
        while ($dataEvento = mysqli_fetch_array($resulEventos)) { ?> {
            _id: '<?php echo $dataEvento['id_mantenimiento']; ?>',
            title: '<?php echo $dataEvento['usuario']; ?>',
            start: '<?php echo $dataEvento['fecha']; ?>',
            color: '<?php echo ($dataEvento['estatus'] == 1) ? "#60c4f3" : "red" ?>',
            editable: '<?= ($dataEvento['estatus'] == 1 && $dataEvento['id_usuario'] == $_SESSION['id_usuario']) ?>',
            groupId: '<?php echo ($dataEvento['estatus'] == 1 && $dataEvento['id_usuario'] == $_SESSION['id_usuario']) ? 1 : 0 ?>',
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
        },
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
</script>