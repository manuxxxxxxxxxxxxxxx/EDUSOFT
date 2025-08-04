function setLanguage(lang) {
  document.querySelectorAll("[data-i18n]").forEach(function(el) {
    const key = el.getAttribute("data-i18n");

    if (translations[lang] && translations[lang][key]) {
      const translation = translations[lang][key];

      // Detectar si es un input o textarea
      if (el.tagName === "INPUT" || el.tagName === "TEXTAREA") {
        // Si tiene placeholder, se traduce
        if (el.hasAttribute("placeholder")) {
          el.setAttribute("placeholder", translation);
        }
        // Si es botón de tipo submit o button, se traduce el value
        if (el.type === "submit" || el.type === "button") {
          el.value = translation;
        }
      } else {
        // Si es cualquier otro elemento (p, h2, div, etc.), se traduce solo el nodo de texto
        let textNodeFound = false;

        el.childNodes.forEach(function(node) {
          if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== "") {
            node.textContent = translation;
            textNodeFound = true;
          }
        });

        // Si no hay nodo de texto (por ejemplo, solo hay íconos), se añade uno
        if (!textNodeFound) {
          el.appendChild(document.createTextNode(" " + translation));
        }
      }
    }
  });

  localStorage.setItem("lang", lang);
}

// Si tienes el selector en la principal:
const selector = document.getElementById("langSelector");
if (selector) {
  selector.addEventListener("change", function () {
    setLanguage(this.value);
  });
}

// Esto se ejecuta en todas las páginas:
window.addEventListener("DOMContentLoaded", function () {
  const lang = localStorage.getItem("lang") || "es";
  if (selector) selector.value = lang;
  setLanguage(lang);
});
