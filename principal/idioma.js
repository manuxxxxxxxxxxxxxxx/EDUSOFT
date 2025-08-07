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
    const selectedLang = this.value;
    setLanguage(selectedLang);
    updateLangDropdownUI(selectedLang); // 🔥 Esto actualiza el texto y bandera en el botón
  });
}
// Esto se ejecuta en todas las páginas:
window.addEventListener("DOMContentLoaded", function () {
  const lang = localStorage.getItem("lang") || "es";
  if (selector) selector.value = lang;
  setLanguage(lang);
});
const langDropdownBtn = document.getElementById('langDropdownBtn');
const langDropdownList = document.getElementById('langDropdownList');
const currentLangFlag = document.getElementById('currentLangFlag');
const currentLangText = document.getElementById('currentLangText');

const langNames = {
  es: 'Español',
  en: 'English'
};
const langFlags = {
  es: '../img/mexico.png',
  en: '../img/estados.png'
};

function updateLangDropdownUI(lang) {
  currentLangFlag.src = langFlags[lang];
  currentLangText.textContent = langNames[lang];
  document.querySelectorAll('.lang-option').forEach(btn => {
    btn.classList.toggle('active', btn.getAttribute('data-lang') === lang);
  });
}

// Abrir/cerrar el menú
langDropdownBtn.addEventListener('click', function(e) {
  document.querySelector('.language-dropdown').classList.toggle('open');
});

// Cambiar idioma al hacer clic en opción
document.querySelectorAll('.lang-option').forEach(btn => {
  btn.addEventListener('click', function() {
    const lang = btn.getAttribute('data-lang');
    setLanguage(lang);
    updateLangDropdownUI(lang);
    document.querySelector('.language-dropdown').classList.remove('open');
  });
});

// Cerrar si haces clic fuera
document.addEventListener('click', function(e) {
  if (!document.querySelector('.language-dropdown').contains(e.target)) {
    document.querySelector('.language-dropdown').classList.remove('open');
  }
});

// Inicializar al cargar
window.addEventListener('DOMContentLoaded', function() {
  const lang = localStorage.getItem("lang") || "es";
  updateLangDropdownUI(lang);
});