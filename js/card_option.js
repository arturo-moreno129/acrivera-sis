const resguardo = document.querySelector("#resguardo");
const mant = document.querySelector("#mante");

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
