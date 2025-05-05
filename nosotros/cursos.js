document.addEventListener("DOMContentLoaded", () => {
    // Toggle submenu
    const menuItems = document.querySelectorAll(".has-submenu")
    const sidebar = document.querySelector(".sidebar")
    const mainContent = document.querySelector(".main-content")
    const collapseToggle = document.getElementById("collapse-toggle")
    const sidebarToggle = document.getElementById("sidebar-toggle")
  
    // Iniciar con el sidebar colapsado
    mainContent.classList.add("expanded")
  
    // Función para manejar clics en elementos con submenú
    menuItems.forEach((item) => {
      item.addEventListener("click", function (e) {
        // Si el sidebar está colapsado, no abrir submenús al hacer clic
        if (sidebar.classList.contains("collapsed") && !e.target.closest(".submenu")) {
          return
        }
  
        if (e.target.closest(".submenu")) return
  
        e.preventDefault()
        this.classList.toggle("open")
  
        // Cerrar otros submenús abiertos
        menuItems.forEach((otherItem) => {
          if (otherItem !== item && otherItem.classList.contains("open")) {
            otherItem.classList.remove("open")
          }
        })
      })
    })
  
    // Toggle para colapsar/expandir el sidebar
    collapseToggle.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed")
      mainContent.classList.toggle("expanded")
  
      // Cerrar todos los submenús al colapsar
      if (sidebar.classList.contains("collapsed")) {
        menuItems.forEach((item) => {
          item.classList.remove("open")
        })
      }
    })
  
    // Toggle sidebar en móvil
    sidebarToggle.addEventListener("click", () => {
      sidebar.classList.toggle("active")
    })
  
    // Cerrar sidebar al hacer clic fuera en móvil
    document.addEventListener("click", (e) => {
      if (window.innerWidth <= 992) {
        if (!e.target.closest(".sidebar") && !e.target.closest("#sidebar-toggle")) {
          if (sidebar.classList.contains("active")) {
            sidebar.classList.remove("active")
          }
        }
      }
    })
  
    // Manejar cambio de tamaño de ventana
    window.addEventListener("resize", () => {
      if (window.innerWidth > 992) {
        sidebar.classList.remove("active")
      }
    })
  
    // Mostrar submenús al pasar el mouse en modo colapsado
    if (window.innerWidth > 992) {
      menuItems.forEach((item) => {
        item.addEventListener("mouseenter", function () {
          if (sidebar.classList.contains("collapsed")) {
            this.querySelector(".submenu").style.display = "block"
          }
        })
  
        item.addEventListener("mouseleave", function () {
          if (sidebar.classList.contains("collapsed")) {
            this.querySelector(".submenu").style.display = ""
          }
        })
      })
    }
  })
  