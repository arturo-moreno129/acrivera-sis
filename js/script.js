const cloud = document.getElementById("cloud");
const barraLateral = document.querySelector(".barra-lateral");
const spans = document.querySelectorAll("span");
const palanca = document.querySelector(".switch"); //--------
const circulo = document.querySelector(".circulo"); //--------
const menu = document.querySelector(".menu");
const main = document.querySelector("main");

const btn = document.querySelector(".push");

const modoOscuroGuardado = localStorage.getItem("modoprueba");
const cuerpo = document.body;

if (modoOscuroGuardado === "activado") {
  cuerpo.classList.add("dark-mode");
  circulo.classList.toggle("prendido");
}

menu.addEventListener("click", () => {
  barraLateral.classList.toggle("max-barra-lateral");
  if (barraLateral.classList.contains("max-barra-lateral")) {
    menu.children[0].style.display = "none";
    menu.children[1].style.display = "block";
  } else {
    menu.children[0].style.display = "block";
    menu.children[1].style.display = "none";
  }
  if (window.innerWidth <= 320) {
    barraLateral.classList.add("mini-barra-lateral");
    main.classList.add("min-main");
    spans.forEach((span) => {
      span.classList.add("oculto");
    });
  }
});

palanca.addEventListener("click", () => {
  let body = document.body;
  body.classList.toggle("dark-mode");
  circulo.classList.toggle("prendido");
  if (cuerpo.classList.contains("dark-mode")) {
    localStorage.setItem("modoprueba", "activado");
  } else {
    localStorage.setItem("modoprueba", "desactivado");
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
    select.style.display = "none";
    select.required = false;
    text.style.display = "none";
    inputs.forEach(function (input) {
      input.style.display = ""; // Mostrar el campo
      input.required = true; // Quitar el atributo `required`
    });
  } else {
    select.style.display = "";
    select.required = true;
    text.style.display = "";
    inputs.forEach(function (input) {
      input.style.display = "none"; // Ocultar el campo
      input.required = false; // Asegurar que no sea obligatorio
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

/********************************NUEVO EVENTO PARA LAS CARDS**************** */
const cards = document.querySelectorAll(".card"); //--------

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
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success",
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

// Get the element with id="defaultOpen" and click on it
const defaultOpen = document.getElementById("defaultOpen");
if (defaultOpen) {
  defaultOpen.click();
}

//para verificar si essta seleccionado el raqdio button.
document.querySelectorAll('input[name="option_1"]').forEach((radio) => {
  radio.addEventListener("change", function () {
    if (this.value == 2) {
      //si selecciona no asociar
      const radiobuttons = document.querySelectorAll(".asociar");
      radiobuttons.forEach(function (radiobuttons) {
        radiobuttons.style.display = "none"; // Mostrar el campo
        radiobuttons.required = false; // Quitar el atributo `required`
      });
      const noasociar = document.querySelectorAll(".no-asociar");
      noasociar.forEach(function (noasociar) {
        noasociar.style.display = "block";
      });
    } else {
      //si selecciona asiciar
      const radiobuttons = document.querySelectorAll(".asociar");
      radiobuttons.forEach(function (radiobuttons) {
        radiobuttons.style.display = "block"; // Mostrar el campo
        radiobuttons.required = true; // Quitar el atributo `required`
      });
      const noasociar = document.querySelectorAll(".no-asociar");
      noasociar.forEach(function (noasociar) {
        noasociar.style.display = "none";
      });
    }
  });
});

/// agregar valores a tabla
var datosTabla = [];
function agregarFila() {
  var CANTIDAD = document.getElementById("CANTIDAD").value;
  var DESCRIPCION = document.getElementById("DESCRIPCION").value;
  var MARCA = document.getElementById("MARCA").value;
  var MODELO = document.getElementById("MODELO").value;
  var SERIE = document.getElementById("SERIE").value;
  var FISICO = document.getElementById("FISICO").value;

  if (
    CANTIDAD === "" ||
    DESCRIPCION === "" ||
    MARCA === "" ||
    MODELO === "" ||
    SERIE === "" ||
    FISICO === ""
  ) {
    //alert("Por favor, ingresa todos los datos.");
    Swal.fire({
      title: "Valores vacios",
      text: "Falta texto por capturar..!",
      icon: "error",
    });
    return;
  }

  var tabla = document.getElementById("tabla").getElementsByTagName("tbody")[0];
  var nuevaFila = tabla.insertRow();

  var celdaCantidad = nuevaFila.insertCell(0);
  var celdaDescripcion = nuevaFila.insertCell(1);
  var celdaMarca = nuevaFila.insertCell(2);
  var celdaModelo = nuevaFila.insertCell(3);
  var celdaSerie = nuevaFila.insertCell(4);
  var celdaFisico = nuevaFila.insertCell(5);
  //var celdaAccion = nuevaFila.insertCell(6);

  celdaCantidad.innerHTML = CANTIDAD;
  celdaDescripcion.innerHTML = DESCRIPCION;
  celdaMarca.innerHTML = MARCA;
  celdaModelo.innerHTML = MODELO;
  celdaSerie.innerHTML = SERIE;
  celdaFisico.innerHTML = FISICO;

  datosTabla.push({
    cantidad: CANTIDAD,
    descripcion: DESCRIPCION,
    marca: MARCA,
    modelo: MODELO,
    serie: SERIE,
    fisico: FISICO,
  });
  //celdaAccion.innerHTML ='<button type="button" onclick="eliminarFila(this)">Eliminar</button>';

  document.getElementById("CANTIDAD").value = null;
  document.getElementById("DESCRIPCION").value = " ";
  document.getElementById("MARCA").value = " ";
  document.getElementById("MODELO").value = " ";
  document.getElementById("SERIE").value = " ";
  document.getElementById("FISICO").value = " ";
}

function eliminarFila(btn) {
  var fila = btn.parentNode.parentNode;
  fila.parentNode.removeChild(fila);
}

/*function validarFormulario(event) {
  var filas = document.getElementById("tabla").getElementsByTagName("tbody")[0]
    .rows.length;

  if (filas === 0) {
    alert("Debes agregar al menos una fila antes de enviar.");
    return false; // Evita que el formulario se envíe
  }
  return true; // Permite el envío si hay datos en la tabla
}*/

document.getElementById("btnenviar").addEventListener("click", (event) => {
  event.preventDefault(); // Evita el envío por defecto del formulario

  var tabla = document.getElementById("tabla");
  var filas = tabla.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
  var nombreselect = document.querySelector("#select-user").value;
  var dispo = document.querySelector('[name="dispositivo"]').value;
  var fecha = document.querySelector('[name="fecha-registro"]').value; //seleccionado por nombre
  var equipo = document.querySelector('input[name="option1"]:checked').value; //obtiene el valor seleccionado
  var puesto = document.querySelector('[name="puesto"]').value;
  ///************nuevo nombre ***************/
  var nom = document.querySelector("#fname1").value;
  var apeM = document.querySelector("#lname1").value;
  var apeP = document.querySelector("#Sname1").value;
  var nombreUsu = "";
  if (nombreselect != "") {
    nombreUsu = nombreselect;
  } else {
    nom = nom.trim();
    apeM = apeM.trim();
    apeP = apeP.trim();
    nombreUsu = nom.concat(" ", apeM, " ", apeP);
  }

  var datosTabla = [];

  for (var i = 0; i < filas.length; i++) {
    var celdas = filas[i].getElementsByTagName("td");

    datosTabla.push({
      cantidad: celdas[0].innerText.trim(),
      descripcion: celdas[1].innerText.trim(),
      marca: celdas[2].innerText.trim(),
      modelo: celdas[3].innerText.trim(),
      serie: celdas[4].innerText.trim(),
      fisico: celdas[5].innerText.trim(),
    });
  }
  var datosfinale = {
    nombre: nombreUsu,
    datos: datosTabla,
    dispositivo: dispo,
    fecha: fecha,
    equipo: equipo,
    puesto: puesto,
  };

  console.log("Datos que se enviarán:", datosfinale); // Verificar datos antes de enviarlos
  if (
    datosfinale.nombre == "" ||
    datosfinale.dispositivo == "" ||
    datosfinale.fecha == "" ||
    datosfinale.equipo == "" ||
    datosfinale.puesto == ""
  ) {
    console.log("faltan datos");
    return;
  }
  if (datosTabla.length <= 0) {
    alert("Debes agregar al menos una fila antes de enviar.");
    return;
  }
  fetch("create_registro.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ datosfinale }), // Enviar en formato JSON
  })
    .then((response) => response.text()) // Leer la respuesta como texto para depuración
    .then((data) => {
      Swal.fire({
        title: "LISTO",
        text: "Se creo exitosamente el registro...!",
        icon: "success",
      }).then(() => {
        window.location.assign("card_registro.php");
      });
      console.log("Respuesta del servidor:", data);
    })
    .catch((error) => {
      Swal.fire("Error de transmisión, contactar al área de soporte");
      console.error("Error de transmisión:", error);
    });
});
