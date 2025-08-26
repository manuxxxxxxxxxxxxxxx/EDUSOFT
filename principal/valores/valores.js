// Funcionalidad de la página de valores
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

  // ===== ANIMACIÓN DE NÚMEROS EN ESTADÍSTICAS =====
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

  // Observar estadísticas en intro
  document.querySelectorAll(".stat-item").forEach((item) => {
    observer.observe(item)
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

      if (numericValue >= 1000000) {
        element.textContent = (Math.floor(current) / 1000000).toFixed(1) + "M"
      } else if (numericValue >= 1000) {
        element.textContent = (Math.floor(current) / 1000).toFixed(1) + "K"
      } else {
        element.textContent = Math.floor(current)
      }
    }, 16)
  }

  // ===== CAROUSEL DE TESTIMONIOS =====
  const slides = document.querySelectorAll(".testimonio-slide")
  const indicators = document.querySelectorAll(".indicator")
  const prevBtn = document.querySelector(".prev-btn")
  const nextBtn = document.querySelector(".next-btn")
  let currentSlide = 0

  function showSlide(index) {
    // Ocultar todas las slides
    slides.forEach((slide) => slide.classList.remove("active"))
    indicators.forEach((indicator) => indicator.classList.remove("active"))

    // Mostrar slide actual
    if (slides[index]) {
      slides[index].classList.add("active")
    }
    if (indicators[index]) {
      indicators[index].classList.add("active")
    }

    currentSlide = index
  }

  function nextSlide() {
    const next = (currentSlide + 1) % slides.length
    showSlide(next)
  }

  function prevSlide() {
    const prev = currentSlide === 0 ? slides.length - 1 : currentSlide - 1
    showSlide(prev)
  }

  // Event listeners para controles
  if (nextBtn) {
    nextBtn.addEventListener("click", nextSlide)
  }

  if (prevBtn) {
    prevBtn.addEventListener("click", prevSlide)
  }

  // Event listeners para indicadores
  indicators.forEach((indicator, index) => {
    indicator.addEventListener("click", () => showSlide(index))
  })

  // Auto-play del carousel
  let carouselInterval = setInterval(nextSlide, 6000)

  // Pausar auto-play al hacer hover
  const carousel = document.querySelector(".testimonios-carousel")
  if (carousel) {
    carousel.addEventListener("mouseenter", () => {
      clearInterval(carouselInterval)
    })

    carousel.addEventListener("mouseleave", () => {
      carouselInterval = setInterval(nextSlide, 6000)
    })
  }

  // ===== EFECTOS DE HOVER EN TARJETAS DE VALORES =====
  document.querySelectorAll(".valor-card").forEach((card) => {
    card.addEventListener("mouseenter", () => {
      // Efecto de elevación y sombra
      card.style.transform = "translateY(-15px) scale(1.02)"

      // Animar el icono
      const icon = card.querySelector(".valor-icon")
      if (icon) {
        icon.style.transform = "scale(1.15) rotate(10deg)"
      }

      // Animar el número
      const number = card.querySelector(".valor-number")
      if (number) {
        number.style.color = "#9fc7e8"
        number.style.opacity = "0.8"
      }
    })

    card.addEventListener("mouseleave", () => {
      card.style.transform = "translateY(0) scale(1)"

      const icon = card.querySelector(".valor-icon")
      if (icon) {
        icon.style.transform = "scale(1) rotate(0deg)"
      }

      const number = card.querySelector(".valor-number")
      if (number) {
        number.style.color = "#e2e8f0"
        number.style.opacity = "0.5"
      }
    })
  })

  // ===== ANIMACIONES DE SCROLL =====
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
  document.querySelectorAll(".valor-card, .timeline-item, .promesa-item").forEach((el) => {
    el.style.opacity = "0"
    el.style.transform = "translateY(30px)"
    el.style.transition = "opacity 0.6s ease, transform 0.6s ease"
    fadeInObserver.observe(el)
  })

  // ===== EFECTOS PARALLAX =====
  window.addEventListener("scroll", () => {
    const scrolled = window.pageYOffset
    const rate = scrolled * -0.5

    // Parallax en hero
    const hero = document.querySelector(".hero-valores")
    if (hero) {
      hero.style.transform = `translateY(${rate}px)`
    }

    // Parallax en constellation
    const constellation = document.querySelector(".valores-constellation")
    if (constellation) {
      constellation.style.transform = `translateY(${scrolled * 0.1}px) rotate(${scrolled * 0.05}deg)`
    }
  })

  // ===== INTERACTIVIDAD EN CONSTELACIÓN DE VALORES =====
  document.querySelectorAll(".valor-point").forEach((point, index) => {
    point.addEventListener("mouseenter", () => {
      // Destacar el punto
      point.style.background = "rgba(255, 255, 255, 0.3)"
      point.style.transform = "scale(1.2)"
      point.style.boxShadow = "0 0 20px rgba(255, 255, 255, 0.5)"

      // Crear efecto de ondas
      createRippleEffect(point)
    })

    point.addEventListener("mouseleave", () => {
      point.style.background = "rgba(255, 255, 255, 0.15)"
      point.style.transform = "scale(1)"
      point.style.boxShadow = "none"
    })

    // Click para scroll a la sección correspondiente
    point.addEventListener("click", () => {
      const valorName = point.querySelector("span").textContent.toLowerCase()
      const targetCard = document.querySelector(`[data-valor*="${valorName}"]`)
      if (targetCard) {
        targetCard.scrollIntoView({
          behavior: "smooth",
          block: "center",
        })
        // Destacar temporalmente la tarjeta
        targetCard.style.boxShadow = "0 0 30px rgba(159, 199, 232, 0.5)"
        setTimeout(() => {
          targetCard.style.boxShadow = ""
        }, 2000)
      }
    })
  })

  // Función para crear efecto de ondas
  function createRippleEffect(element) {
    const ripple = document.createElement("div")
    ripple.style.position = "absolute"
    ripple.style.borderRadius = "50%"
    ripple.style.background = "rgba(255, 255, 255, 0.3)"
    ripple.style.transform = "scale(0)"
    ripple.style.animation = "ripple 0.6s linear"
    ripple.style.left = "50%"
    ripple.style.top = "50%"
    ripple.style.width = "100px"
    ripple.style.height = "100px"
    ripple.style.marginLeft = "-50px"
    ripple.style.marginTop = "-50px"
    ripple.style.pointerEvents = "none"

    element.appendChild(ripple)

    setTimeout(() => {
      ripple.remove()
    }, 600)
  }

  // ===== EFECTOS EN TIMELINE =====
  document.querySelectorAll(".timeline-item").forEach((item, index) => {
    const marker = item.querySelector(".timeline-marker")
    const content = item.querySelector(".timeline-content")

    // Animación al hacer scroll
    const timelineObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            marker.style.transform = "translateX(-50%) scale(1.2)"
            marker.style.boxShadow = "0 0 25px rgba(159, 199, 232, 0.6)"
            content.style.transform = "translateX(0) scale(1.02)"

            setTimeout(() => {
              marker.style.transform = "translateX(-50%) scale(1)"
              marker.style.boxShadow = "0 8px 25px rgba(159, 199, 232, 0.4)"
              content.style.transform = "translateX(0) scale(1)"
            }, 1000)
          }
        })
      },
      { threshold: 0.5 },
    )

    timelineObserver.observe(item)
  })

  // ===== EFECTOS EN PROMESAS =====
  document.querySelectorAll(".promesa-item").forEach((item, index) => {
    item.style.animationDelay = `${index * 0.1}s`

    item.addEventListener("mouseenter", () => {
      item.style.background = "rgba(255, 255, 255, 0.2)"
      item.style.transform = "translateX(12px) scale(1.02)"
    })

    item.addEventListener("mouseleave", () => {
      item.style.background = "rgba(255, 255, 255, 0.1)"
      item.style.transform = "translateX(0) scale(1)"
    })
  })

  // ===== EFECTOS EN CTA OPTIONS =====
  document.querySelectorAll(".cta-option").forEach((option) => {
    option.addEventListener("mouseenter", () => {
      option.style.background = "rgba(255, 255, 255, 0.2)"
      option.style.transform = "translateY(-12px) scale(1.03)"

      const icon = option.querySelector(".option-icon")
      if (icon) {
        icon.style.transform = "scale(1.1) rotate(5deg)"
      }
    })

    option.addEventListener("mouseleave", () => {
      option.style.background = "rgba(255, 255, 255, 0.1)"
      option.style.transform = "translateY(0) scale(1)"

      const icon = option.querySelector(".option-icon")
      if (icon) {
        icon.style.transform = "scale(1) rotate(0deg)"
      }
    })
  })

  // ===== EFECTOS DE TYPING EN HERO =====
  const heroStatement = document.querySelector(".hero-statement")
  if (heroStatement) {
    const text = heroStatement.textContent
    heroStatement.textContent = ""
    heroStatement.style.borderRight = "2px solid rgba(255, 255, 255, 0.7)"

    let i = 0
    const typeWriter = () => {
      if (i < text.length) {
        heroStatement.textContent += text.charAt(i)
        i++
        setTimeout(typeWriter, 30)
      } else {
        // Efecto de cursor parpadeante
        setInterval(() => {
          heroStatement.style.borderRight =
            heroStatement.style.borderRight === "2px solid transparent"
              ? "2px solid rgba(255, 255, 255, 0.7)"
              : "2px solid transparent"
        }, 500)
      }
    }

    // Iniciar efecto después de un delay
    setTimeout(typeWriter, 1000)
  }

  // ===== CONTADOR DE IMPACTO EN TIEMPO REAL =====
  document.querySelectorAll(".impact-number").forEach((number) => {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting && !number.classList.contains("counted")) {
            number.classList.add("counted")
            const finalValue = number.textContent
            const numericValue = Number.parseInt(finalValue.replace(/[^\d]/g, ""))
            const suffix = finalValue.replace(/[\d]/g, "")

            let current = 0
            const increment = numericValue / 100
            const timer = setInterval(() => {
              current += increment
              if (current >= numericValue) {
                current = numericValue
                clearInterval(timer)
              }
              number.textContent = Math.floor(current) + suffix
            }, 20)
          }
        })
      },
      { threshold: 0.5 },
    )

    observer.observe(number)
  })

  // ===== EFECTOS DE SONIDO (OPCIONAL) =====
  function playClickSound() {
    // Crear un sonido sutil para interacciones importantes
    const audioContext = new (window.AudioContext || window.webkitAudioContext)()
    const oscillator = audioContext.createOscillator()
    const gainNode = audioContext.createGain()

    oscillator.connect(gainNode)
    gainNode.connect(audioContext.destination)

    oscillator.frequency.value = 800
    oscillator.type = "sine"
    gainNode.gain.setValueAtTime(0.1, audioContext.currentTime)
    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1)

    oscillator.start(audioContext.currentTime)
    oscillator.stop(audioContext.currentTime + 0.1)
  }

  // Agregar sonido a botones importantes
  document.querySelectorAll(".btn-primary, .btn-final, .option-btn").forEach((btn) => {
    btn.addEventListener("click", playClickSound)
  })
})

// ===== CSS DINÁMICO PARA ANIMACIONES =====
const style = document.createElement("style")
style.textContent = `
  @keyframes ripple {
    to {
      transform: scale(4);
      opacity: 0;
    }
  }
  
  @keyframes glow {
    0%, 100% {
      box-shadow: 0 0 5px rgba(159, 199, 232, 0.5);
    }
    50% {
      box-shadow: 0 0 20px rgba(159, 199, 232, 0.8);
    }
  }
  
  .valor-card:hover {
    animation: glow 2s ease-in-out infinite;
  }
`
document.head.appendChild(style)

