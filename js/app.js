// Proyecto: Generador de Dietas
// Año: 2025
// Licencia: Uso académico solamente - Prohibida su redistribución, modificación o comercialización sin autorización.

// ANIMACIÓN PALABRA PÁGINA PRINCIPAL
const palabras = [
  "Inteligente",
  "Nutritiva",
  "Saludable",
  "Equilibrada",
  "Personalizada",
];
let index = 0;

const wordElement = document.getElementById("changing-word");

setInterval(() => {
  // Animación de salida
  wordElement.style.animation = "slide-out 0.5s ease forwards";

  setTimeout(() => {
    // Cambiar palabra
    index = (index + 1) % palabras.length;
    wordElement.textContent = palabras[index];

    // Reiniciar animación entrada
    wordElement.style.animation = "slide-in 0.5s ease forwards";
  }, 500);
}, 3000);
