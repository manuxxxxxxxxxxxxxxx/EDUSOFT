function mostrarFormulario() {
  const form = document.getElementById("formTarea");
  form.style.display = form.style.display === "none" || form.style.display === "" ? "block" : "none";
}