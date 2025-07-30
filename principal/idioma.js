function setLanguage(lang) {
  document.querySelectorAll("[data-i18n]").forEach(function(el) {
    const key = el.getAttribute("data-i18n");
    if (translations[lang] && translations[lang][key]) {
      el.innerHTML = translations[lang][key];
    }
  });
  localStorage.setItem("lang", lang);
}

// Si tienes el selector en la principal:
const selector = document.getElementById("langSelector");
if (selector) {
  selector.addEventListener("change", function() {
    setLanguage(this.value);
  });
}

// Esto se ejecuta en todas las páginas:
window.addEventListener("DOMContentLoaded", function() {
  const lang = localStorage.getItem("lang") || "es";
  if (selector) selector.value = lang;
  setLanguage(lang);
});