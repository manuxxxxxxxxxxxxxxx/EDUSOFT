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

  // ===== FUNCIONALIDAD DEL SLIDER MEJORADA =====
  let currentSlide = 0
  const slides = document.querySelectorAll(".contenido-slider")
  const totalSlides = slides.length
  const sliderContainer = document.querySelector(".slider-contenedor")

  function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides
    updateSlider()
  }

  function goToSlide(slideIndex) {
    currentSlide = slideIndex
    updateSlider()
  }

  function updateSlider() {
    if (sliderContainer) {
      const translateX = -currentSlide * 25
      sliderContainer.style.transform = `translateX(${translateX}%)`
    }
  }

  // Auto-play con 4 segundos de intervalo
  let sliderInterval
  setTimeout(() => {
    nextSlide()
    sliderInterval = setInterval(nextSlide, 4000)
  }, 4000)

  const contenedor = document.querySelector(".contenedor")
  if (contenedor) {
    contenedor.addEventListener("mouseenter", () => {
      clearInterval(sliderInterval)
    })

    contenedor.addEventListener("mouseleave", () => {
      sliderInterval = setInterval(nextSlide, 4000)
    })
  }

  document.addEventListener("keydown", (e) => {
    if (e.key === "ArrowLeft") {
      currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1
      updateSlider()
      clearInterval(sliderInterval)
      sliderInterval = setInterval(nextSlide, 4000)
    } else if (e.key === "ArrowRight") {
      nextSlide()
      clearInterval(sliderInterval)
      sliderInterval = setInterval(nextSlide, 4000)
    }
  })

  updateSlider()

  function createSlideIndicators() {
    const indicatorsContainer = document.createElement("div")
    indicatorsContainer.className = "slide-indicators"

    for (let i = 0; i < totalSlides; i++) {
      const indicator = document.createElement("button")
      indicator.className = `slide-indicator ${i === 0 ? "active" : ""}`
      indicator.addEventListener("click", () => {
        goToSlide(i)
        clearInterval(sliderInterval)
        sliderInterval = setInterval(nextSlide, 4000)
      })
      indicatorsContainer.appendChild(indicator)
    }

    const contenidoEstatico = document.querySelector(".contenido-estatico")
    if (contenidoEstatico) {
      contenidoEstatico.appendChild(indicatorsContainer)
    }
  }

  function updateIndicators() {
    const indicators = document.querySelectorAll(".slide-indicator")
    indicators.forEach((indicator, index) => {
      indicator.classList.toggle("active", index === currentSlide)
    })
  }

  const originalUpdateSlider = updateSlider
  updateSlider = () => {
    originalUpdateSlider()
    updateIndicators()
  }

  createSlideIndicators()

  let startX = 0
  let endX = 0

  if (contenedor) {
    contenedor.addEventListener("touchstart", (e) => {
      startX = e.touches[0].clientX
    })

    contenedor.addEventListener("touchend", (e) => {
      endX = e.changedTouches[0].clientX
      handleSwipe()
    })
  }

  function handleSwipe() {
    const swipeThreshold = 50
    const diff = startX - endX

    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        nextSlide()
      } else {
        currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1
        updateSlider()
      }

      clearInterval(sliderInterval)
      sliderInterval = setInterval(nextSlide, 4000)
    }
  }
})