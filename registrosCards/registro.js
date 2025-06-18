// JavaScript optimizado para página de selección de usuario

// Función principal para redirigir al login
function redirectToLogin(userType) {
  const button = event.target.closest(".access-btn")
  const btnText = button.querySelector(".btn-text")
  const btnIcon = button.querySelector(".btn-icon i")

  // Cambiar estado del botón
  btnText.textContent = "Cargando..."
  btnIcon.className = "fas fa-spinner fa-spin"
  button.disabled = true

  // Crear overlay de carga
  const overlay = document.createElement("div")
  overlay.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: ${userType === "professor" ? "#ea580c" : "#2563eb"};
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.4s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    font-weight: 500;
  `

  overlay.innerHTML = `
    <div style="text-align: center;">
      <i class="fas fa-spinner fa-spin" style="font-size: 32px; margin-bottom: 15px;"></i>
      <p>Redirigiendo...</p>
    </div>
  `

  document.body.appendChild(overlay)

  // Mostrar overlay
  setTimeout(() => {
    overlay.style.opacity = "1"
  }, 50)

  // Redirigir según el tipo de usuario
  setTimeout(() => {
    if (userType === "professor") {
      window.location.href = "login-profesor.html"
    } else if (userType === "student") {
      window.location.href = "login-estudiante.html"
    }
  }, 1500)
}

// Inicialización cuando carga la página
document.addEventListener("DOMContentLoaded", () => {
  initializeAnimations()
  initializeCounters()
  initializeInteractions()
})

// Animaciones de entrada sutiles
function initializeAnimations() {
  const elements = document.querySelectorAll(".user-card, .info-card, .stat-item")
  
  elements.forEach((element, index) => {
    element.style.opacity = "0"
    element.style.transform = "translateY(20px)"
    element.style.transition = "all 0.6s ease"
    
    setTimeout(() => {
      element.style.opacity = "1"
      element.style.transform = "translateY(0)"
    }, index * 150 + 300)
  })

  // Animación del título principal
  const title = document.querySelector(".title-container h2")
  if (title) {
    title.style.opacity = "0"
    title.style.transform = "translateY(15px)"
    title.style.transition = "all 0.8s ease"
    
    setTimeout(() => {
      title.style.opacity = "1"
      title.style.transform = "translateY(0)"
    }, 100)
  }
}

// Efectos hover sutiles
function initializeInteractions() {
  // Efectos en las tarjetas principales
  const userCards = document.querySelectorAll(".user-card")
  userCards.forEach((card) => {
    card.addEventListener("mouseenter", () => {
      card.style.transition = "all 0.3s ease"
      card.style.transform = "translateY(-3px)"
      
      // Efecto en la ilustración SVG
      const svg = card.querySelector(".custom-svg")
      if (svg) {
        svg.style.transition = "all 0.3s ease"
        svg.style.transform = "scale(1.02)"
      }
    })
    
    card.addEventListener("mouseleave", () => {
      card.style.transform = "translateY(0)"
      
      const svg = card.querySelector(".custom-svg")
      if (svg) {
        svg.style.transform = "scale(1)"
      }
    })
  })

  // Efectos en botones
  const buttons = document.querySelectorAll(".access-btn")
  buttons.forEach(button => {
    button.addEventListener("mouseenter", () => {
      button.style.transition = "all 0.2s ease"
      button.style.transform = "translateY(-1px)"
    })
    
    button.addEventListener("mouseleave", () => {
      button.style.transform = "translateY(0)"
    })
  })

  // Efectos en estadísticas del header
  const statItems = document.querySelectorAll(".stat-item")
  statItems.forEach(item => {
    item.addEventListener("mouseenter", () => {
      item.style.transition = "all 0.2s ease"
      item.style.transform = "translateY(-2px)"
    })
    
    item.addEventListener("mouseleave", () => {
      item.style.transform = "translateY(0)"
    })
  })
}

// Contadores animados para las estadísticas
function initializeCounters() {
  const counters = document.querySelectorAll(".stat-number")

  const animateCounter = (counter) => {
    const target = parseInt(counter.getAttribute("data-target"))
    const duration = 2000
    const increment = target / (duration / 16)
    let current = 0

    const updateCounter = () => {
      if (current < target) {
        current += increment
        counter.textContent = Math.ceil(current)
        requestAnimationFrame(updateCounter)
      } else {
        counter.textContent = target
      }
    }

    updateCounter()
  }

  // Observer para iniciar animación cuando sea visible
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          animateCounter(entry.target)
        }, 500)
        observer.unobserve(entry.target)
      }
    })
  })

  counters.forEach((counter) => {
    observer.observe(counter)
  })
}

// Efecto ripple sutil en botones
document.addEventListener("click", (e) => {
  if (e.target.closest(".access-btn")) {
    const button = e.target.closest(".access-btn")
    const ripple = document.createElement("span")
    
    const rect = button.getBoundingClientRect()
    const size = Math.max(rect.width, rect.height)
    const x = e.clientX - rect.left - size / 2
    const y = e.clientY - rect.top - size / 2
    
    ripple.style.cssText = `
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      width: ${size}px;
      height: ${size}px;
      left: ${x}px;
      top: ${y}px;
      transform: scale(0);
      animation: ripple 0.6s linear;
      pointer-events: none;
    `
    
    button.style.position = "relative"
    button.style.overflow = "hidden"
    button.appendChild(ripple)
    
    setTimeout(() => {
      if (button.contains(ripple)) {
        button.removeChild(ripple)
      }
    }, 600)
  }
})

// Estilos CSS para la animación ripple
const style = document.createElement("style")
style.textContent = `
  @keyframes ripple {
    to {
      transform: scale(2);
      opacity: 0;
    }
  }
`
document.head.appendChild(style)

// Prevenir arrastrar elementos
document.addEventListener("dragstart", (e) => e.preventDefault())