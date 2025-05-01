// FORMuLARIO DE LOGIN
const loginForm = document.getElementById("login-form");

if (loginForm) {
  loginForm.addEventListener("submit", function (event) {
    event.preventDefault();
    // HACER VALIDACIONES DE FORM AQUI
    window.location.href = "perfil.php";
  });
}

const registroForm = document.getElementById("registro-form");
if (registroForm) {
  registroForm.addEventListener("submit", function (event) {
    event.preventDefault();
    // HACER VALIDACIONES DE FORM AQUI
    window.location.href = "generarDieta.php";
  });
}
