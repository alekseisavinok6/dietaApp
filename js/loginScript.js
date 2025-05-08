// FORMULARIO DE LOGIN Y REGISTRO
const loginForm = document.getElementById("login-form");
const registroForm = document.getElementById("registro-form");
//INPUTS DE LOS FORMULARIOS
const inputsLogin = document.querySelectorAll("#login-form input");
const inputsRegistro = document.querySelectorAll("#registro-form input");

// EXPRESIONES REGULARES
const expresiones = {
  email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9]+\.[a-zA-Z0-9-.]+$/, // Correo con @, con punto y caracter después del punto
  password: /^.{12,}$/, // 8 caracteres o más
  nombre: /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s']{2,40}$/, // Nombre de por lo menos 2 caracteres, sin signos especiales (a excepción algunos)
};

const campos = {
  nombre: false,
  email: false,
  fNacimiento: false,
  sexo: false,
  password: false,
  password2: false,
};

// VALIDACIONES
const validarFormulario = (e) => {
  switch (e.target.name) {
    // VALIDACION DE CORREO
    case "email":
      validarCampo(expresiones.email, e.target, "email");
      break;
    case "password":
      validarCampo(expresiones.password, e.target, "password");
      break;
    case "password2":
      validarPassword2();
      break;
    case "nombre":
      validarCampo(expresiones.nombre, e.target, "nombre");
      break;
    case "apellido":
      validarCampo(expresiones.nombre, e.target, "nombre");
      break;
    case "f_nacimiento":
      validarCampo(expresiones.fNacimiento, e.target, "fNacimiento");
      break;
    case "sexo":
      campos["sexo"] = true;
      break;
    default:
      break;
  }
};

const validarCampo = (expresion, input, campo) => {
  const inputError = document.querySelector(`.input-${campo}-error`);
  // VALIDAR FECHA
  if (input.name === "f_nacimiento") {
    if (input.value >= "1925-01-01" && input.value <= "2023-12-31") {
      input.classList.remove("invalid");
      if (inputError) {
        inputError.classList.add("no-display");
      }
      campos[campo] = true;
    } else {
      input.classList.add("invalid");
      if (inputError) {
        inputError.classList.remove("no-display");
      }
      campos[campo] = false;
    }
    //VALIDAR (NOMBRE, APELLIDO, EMAIL, PASSWORD)
  } else {
    // EJEMPLO: validarCampo = (expresiones.email, e.target, email)...
    if (expresion.test(input.value)) {
      input.classList.remove("invalid");
      if (inputError) {
        inputError.classList.add("no-display");
      }
      campos[campo] = true;
    } else if (input.value.length < 1) {
      input.classList.remove("invalid");
      if (inputError) {
        inputError.classList.add("no-display");
      }
      campos[campo] = false;
    } else {
      input.classList.add("invalid");
      if (inputError) {
        inputError.classList.remove("no-display");
      }
      campos[campo] = false;
    }
  }
};

// VALIDAR PASSWORD2
const validarPassword2 = () => {
  const inputPassword1 = document.getElementById("password");
  const inputPassword2 = document.getElementById("password2");
  if (inputPassword1.value === inputPassword2.value) {
    inputPassword2.classList.remove("invalid");
    document
      .querySelector(".input-password2-error")
      .classList.add("no-display");
    campos["password2"] = true;
  } else if (inputPassword2.value.length < 1) {
    inputPassword2.classList.remove("invalid");
    document
      .querySelector(".input-password2-error")
      .classList.add("no-display");
    campos["password2"] = false;
  } else {
    inputPassword2.classList.add("invalid");
    document
      .querySelector(".input-password2-error")
      .classList.remove("no-display");
    campos["password2"] = false;
  }
};

// INPUTS DEL LOGIN
inputsLogin.forEach((input) => {
  input.addEventListener("keyup", validarFormulario);
  input.addEventListener("blur", validarFormulario);
});

// INPUTS DEL REGISTRO
inputsRegistro.forEach((input) => {
  input.addEventListener("keyup", validarFormulario);
  input.addEventListener("blur", validarFormulario);
});
// SELECT (sexo)
const inputSexo = document.getElementById("sexo");
if (inputSexo) {
  inputSexo.addEventListener("change", validarFormulario);
  inputSexo.addEventListener("blur", validarFormulario);
  // Se válida al cargar la página (HOMBRE por defecto)
  window.addEventListener("DOMContentLoaded", () => {
    if (inputSexo.value) {
      campos["sexo"] = true;
    }
  });
}

// FORMULARIO LOGIN
if (loginForm) {
  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();
    if (campos["email"] && campos["password"]) {
      window.location.href = "perfil.php";
    } else {
      document.querySelector(".form-msg").classList.remove("no-display");
    }
  });
}

// FORMULARIO REGISTRO
if (registroForm) {
  registroForm.addEventListener("submit", (e) => {
    e.preventDefault();
    if (
      campos["nombre"] &&
      campos["email"] &&
      campos["fNacimiento"] &&
      campos["sexo"] &&
      campos["password"] &&
      campos["password2"]
    ) {
      document.querySelector(".form-msg").classList.add("hidden");
      registroForm.submit();
      registroForm.reset();
    } else {
      document.querySelector(".form-msg").classList.remove("hidden");
    }
  });
}
