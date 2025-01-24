const cloud = document.getElementById("cloud");
const barraLateral = document.querySelector(".barra-lateral");
const spans = document.querySelectorAll("span");
const palanca = document.querySelector(".switch");//--------
const circulo = document.querySelector(".circulo");//--------
const menu = document.querySelector(".menu");
const main = document.querySelector("main");

const btn = document.querySelector(".push");

const modoOscuroGuardado = localStorage.getItem('modoprueba');
const cuerpo = document.body;

if (modoOscuroGuardado === 'activado') {
  cuerpo.classList.add('dark-mode');
  circulo.classList.toggle("prendido");
}

menu.addEventListener("click", () => {
  barraLateral.classList.toggle("max-barra-lateral");
  if (barraLateral.classList.contains("max-barra-lateral")) {
    menu.children[0].style.display = "none";
    menu.children[1].style.display = "block";
  }
  else {
    menu.children[0].style.display = "block";
    menu.children[1].style.display = "none";
  }
  if (window.innerWidth <= 320) {
    barraLateral.classList.add("mini-barra-lateral");
    main.classList.add("min-main");
    spans.forEach((span) => {
      span.classList.add("oculto");
    })
  }
});

palanca.addEventListener("click", () => {
  let body = document.body;
  body.classList.toggle("dark-mode");
  circulo.classList.toggle("prendido");
  if (cuerpo.classList.contains('dark-mode')) {
    localStorage.setItem('modoprueba', 'activado');
  } else {
    localStorage.setItem('modoprueba', 'desactivado');
  }
});



/******** */
/*cloud.addEventListener("click", () => {
    barraLateral.classList.toggle("mini-barra-lateral");
    main.classList.toggle("min-main");
    spans.forEach((span) => {
        span.classList.toggle("oculto");
    });
});*/
///**para ocultar y mostrar si se quiere subir archivo */
function myFunction(number, numer2, file) {
  var checkBox = document.getElementById(numer2);
  var text = document.getElementById(number);

  var inputElement = document.getElementById(file);

  if (checkBox.checked == true) {
    text.style.display = "block";
    inputElement.required = true;
  } else {
    text.style.display = "none";
    inputElement.required = false;
  }
}
function functionPass() {
  var x = document.getElementById("myPass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}


function myFunction1() {
  var input, filter, table, tr, td, i, txtValue, y;
  y = document.getElementById("mySelect").value;
  input = document.getElementById("input-search");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[y];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

//***************FUNCION PARA APARECER TEXTOS */
function newUser() {
  var inputs = document.querySelectorAll(".display-info");
  var check = document.getElementById("check-newUser");
  var select = document.getElementById("select-user");
  var text = document.getElementById("display-text-name");

  if (check.checked === true) {
    select.value = "";
    select.style.display = "none"
    select.required = false
    text.style.display = "none"
    inputs.forEach(function (input) {
      input.style.display = ""; // Mostrar el campo
      input.required = true;   // Quitar el atributo `required`
    });
  } else {
    select.style.display = ""
    select.required = true
    text.style.display = ""
    inputs.forEach(function (input) {
      input.style.display = "none"; // Ocultar el campo
      input.required = false;       // Asegurar que no sea obligatorio
      input.value = null;
    });
  }
}




/*para from multiple steps*/
/*var currentTab = 1; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}*/

/*****************para notificaciones push*************/
// 1. Solicitar permiso para notificaciones
/*function pedirPermisoNotificaciones() {
  if (Notification.permission !== "granted") {
      Notification.requestPermission().then((permiso) => {
          if (permiso === "granted") {
              console.log("Permiso para notificaciones otorgado.");
          } else {
              console.log("Permiso para notificaciones denegado.");
          }
      });
  }
}

// 2. Función para mostrar la notificación
function mostrarNotificacion(title) {
  if (Notification.permission === "granted") {
      var img = "/";
      var text = '¡OYE! Tu tarea "' + title + '" ahora está vencida.';
      var notification = new Notification("Lista de tareas", {
          body: text,
          icon: img
      });

      // Opcional: acción al hacer clic en la notificación
      notification.onclick = () => {
          window.focus(); // Enfoca la ventana
          notification.close(); // Cierra la notificación
      };
  } else {
      console.log("El permiso de notificación no ha sido otorgado.");
  }
}

// Llama a esta función cuando cargue la página para pedir permiso al usuario
pedirPermisoNotificaciones();
mostrarNotificacion()*/

// Ejemplo de uso: Llamar a mostrarNotificacion cuando sea necesario
// mostrarNotificacion("Nombre de la tarea");

/**************************para tabs******************* */
function openPage(pageName, elmnt, color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

/********************************NUEVO EVENTO PARA LAS CARDS**************** */
const cards = document.querySelectorAll(".card");//--------

// Itera sobre todas las tarjetas y les agrega el evento de clic
/*document.querySelector(".card") esta función selecciona únicamente el primer elemento con la clase .card en 
el DOM, por lo que el evento se aplica solo a la primera tarjeta.
Para solucionar este problema, debes usar document.querySelectorAll(".card") 
para seleccionar todas las tarjetas, y luego agregar el evento de clic a cada una de ellas mediante un bucle.*/
cards.forEach((card) => {
  card.addEventListener("click", () => {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success"
        });
      }
    });
  });
});


//****************funcion estado del internet *********/
window.addEventListener("load", () => {
  const statusWifi = document.querySelector(".wifi");

  if (statusWifi) {
    const handleNetworkChange = () => {
      if (navigator.onLine) {
        statusWifi.classList.remove("offline");
        statusWifi.classList.add("online");
      } else {
        statusWifi.classList.add("offline");
        statusWifi.classList.remove("online");
        Swal.fire("Se perdió la conexión");
      }
    };

    window.addEventListener("online", handleNetworkChange);
    window.addEventListener("offline", handleNetworkChange);

    // Llama al manejador inmediatamente para establecer el estado inicial.
    handleNetworkChange();
  }
});
