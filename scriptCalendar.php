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
        console.log(arg.start.toISOString().split('.')[0]);

        var claveUser = "1299790";
        var comparation = prompt("Ingrese la contraseña");
        if (claveUser == comparation) {
          var title = prompt("Titulo del evento:");
          if (title) {
            calendar.addEvent({
              title: title,
              start: arg.start,
              end: arg.end,
              allDay: arg.allDay,
            });
          }
        }
        calendar.unselect();
      },
      eventClick: function(arg) {
        if (arg.event.groupId == 1) {
          alert("No puedes eliminar este elemento");
        } else {
          arg.event.remove()
        }
      },
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: [{
          title: "prueba",
          start: '2024-09-25T06:00:00',
          end: '2024-09-25T06:30:00',
          color: '#FF0000'
        },
        /*
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
                title: "Conference",
                start: "2024-01-11",
                end: "2024-01-14",
              },
              {
                title: "Meeting",
                start: "2024-01-12T10:30:00",
                end: "2024-01-12T12:30:00",
              },
              {
                title: "Lunch",
                start: "2024-01-12T12:00:00",
              },
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
              },*/
      ],
    });

    calendar.render();
  });
</script>