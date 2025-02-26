const resguardo = document.querySelector("#resguardo");
const mant = document.querySelector("#mante");
const repara = document.querySelector('#repara');

const firmaRes = document.querySelector("#firma-res");
const firmaMant = document.querySelector("#firma-mante");

if (resguardo) {
  resguardo.addEventListener("click", () => {
    window.location.assign("registro_resg.php");
  });
}
if (mant) {
  mant.addEventListener("click", () => {
    window.location.assign("registro_mant.php");
  });
}
if (repara) {
  repara.addEventListener('click',()=>{
    window.location.assign('reparacion.php')
  })
}
if (firmaRes) {
  firmaRes.addEventListener("click", () => {
    window.location.assign("#");
  });
}
if (firmaMant) {
  firmaMant.addEventListener("click", () => {
    window.location.assign("#");
  });
}
