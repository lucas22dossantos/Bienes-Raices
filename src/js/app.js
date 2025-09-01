document.addEventListener("DOMContentLoaded", function () {
  desplegarMenu();
  darkMode();
});

function desplegarMenu() {
  const mobileMenu = document.querySelector(".mobile-menu");

  mobileMenu.addEventListener("click", navResponsive);
}

function navResponsive() {
  const navegacion = document.querySelector(".navegacion");

  navegacion.classList.toggle("mostrar");
}

function darkMode() {
  const btnDarkMode = document.querySelector(".dark-mode-boton");

  btnDarkMode.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");
  });
}
