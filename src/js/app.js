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

  // 1) Revisamos si hay un tema guardado en localStorage
  const temaGuardado = localStorage.getItem("tema");

  if (temaGuardado) {
    // Si el usuario ya eligió un tema antes, aplicamos ese
    if (temaGuardado === "oscuro") {
      document.body.classList.add("dark-mode");
    } else {
      document.body.classList.remove("dark-mode");
    }
  } else {
    // Si no hay preferencia guardada, seguimos la del sistema
    const modoOscuroQuery = window.matchMedia("(prefers-color-scheme: dark)");
    if (modoOscuroQuery.matches) {
      document.body.classList.add("dark-mode");
    }

    // Escuchamos cambios en el sistema SOLO si el usuario no eligió manualmente
    modoOscuroQuery.addEventListener("change", function (e) {
      if (e.matches) {
        document.body.classList.add("dark-mode");
      } else {
        document.body.classList.remove("dark-mode");
      }
    });
  }

  // 2) Al hacer clic en el botón, alternamos el tema y lo guardamos
  btnDarkMode.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
      localStorage.setItem("tema", "oscuro");
    } else {
      localStorage.setItem("tema", "claro");
    }
  });
}
