// Funcionalidad del navbar y página de misión
document.addEventListener("DOMContentLoaded", () => {
  const navToggle = document.getElementById("navToggle")
  const navLinks = document.getElementById("navLinks")
  const navbar = document.querySelector(".navbar")

  // Toggle del menú móvil
  if (navToggle && navLinks) {
    navToggle.addEventListener("click", () => {
      navToggle.classList.toggle("active")
      navLinks.classList.toggle("active")
      document.body.classList.toggle("nav-open")
    })
  }

  // Cerrar menú al hacer click en un enlace
  const navLinksItems = document.querySelectorAll(".nav-link")
  navLinksItems.forEach((link) => {
    link.addEventListener("click", () => {
      if (navToggle && navLinks) {
        navToggle.classList.remove("active")
        navLinks.classList.remove("active")
        document.body.classList.remove("nav-open")
      }
    })
  })

  // Efecto de scroll en el navbar
  window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
      navbar.classList.add("scrolled")
    } else {
      navbar.classList.remove("scrolled")
    }
  })

  // Cerrar menú móvil al redimensionar ventana
  window.addEventListener("resize", () => {
    if (window.innerWidth > 992) {
      if (navToggle && navLinks) {
        navToggle.classList.remove("active")
        navLinks.classList.remove("active")
        document.body.classList.remove("nav-open")
      }
    }
  })

  // Smooth scroll para enlaces internos
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()
      const target = document.querySelector(this.getAttribute("href"))
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        })
      }
    })
  })

  // Animación de números en las estadísticas
  const observerOptions = {
    threshold: 0.5,
    rootMargin: "0px 0px -100px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const numberElement = entry.target.querySelector(".stat-number")
        if (numberElement && !numberElement.classList.contains("animated")) {
          animateNumber(numberElement)
          numberElement.classList.add("animated")
        }
      }
    })
  }, observerOptions)

  // Observar todas las tarjetas de estadísticas
  document.querySelectorAll(".stat-card").forEach((card) => {
    observer.observe(card)
  })

  // Función para animar números
  function animateNumber(element) {
    const finalNumber = element.getAttribute("data-target")
    const numericValue = Number.parseInt(finalNumber)
    const duration = 2000
    const increment = numericValue / (duration / 16)
    let current = 0

    const timer = setInterval(() => {
      current += increment
      if (current >= numericValue) {
        current = numericValue
        clearInterval(timer)
      }

      element.textContent = Math.floor(current).toLocaleString()
    }, 16)
  }

  // Efecto parallax suave en el hero
  window.addEventListener("scroll", () => {
    const scrolled = window.pageYOffset
    const hero = document.querySelector(".hero-mision")
    if (hero) {
      hero.style.transform = `translateY(${scrolled * 0.3}px)`
    }
  })

  // Animación de aparición de elementos
  const fadeInObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = "1"
          entry.target.style.transform = "translateY(0)"
        }
      })
    },
    {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px",
    },
  )

  // Aplicar animación de fade-in a elementos
  document.querySelectorAll(".valor-card, .estrategia-card, .story-card").forEach((el) => {
    el.style.opacity = "0"
    el.style.transform = "translateY(30px)"
    el.style.transition = "opacity 0.6s ease, transform 0.6s ease"
    fadeInObserver.observe(el)
  })
})
