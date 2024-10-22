const cloud = document.getElementById("cloud");
const barraLateral = document.querySelector(".barra-lateral");
const spans = document.querySelectorAll("span");
const palanca = document.querySelector(".switch");//--------
const circulo = document.querySelector(".circulo");//--------
const menu = document.querySelector(".menu");
const main = document.querySelector("main");

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