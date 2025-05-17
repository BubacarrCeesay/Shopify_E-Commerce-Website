const cnts = document.querySelector(".contents");
const tognav = document.getElementById("tognav");
const sidenav = document.querySelector(".sidenav");

tognav.addEventListener("click", function () {
  sidenav.classList.toggle("hidenav");
  cnts.classList.toggle("resizeconts");
});
