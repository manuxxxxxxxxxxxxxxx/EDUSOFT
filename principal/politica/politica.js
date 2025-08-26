// ===== POLÍTICA JAVASCRIPT =====

document.addEventListener("DOMContentLoaded", () => {
  // Initialize all functionality
  initScrollEffects()
  initPolicyNavigation()
  initAnimatedCounters()
  initFormHandling()
  initSmoothScrolling()
  initIntersectionObserver()
})

// Scroll effects for navbar and hero
function initScrollEffects() {
  const navbar = document.getElementById("navbar")
  const scrollIndicator = document.querySelector(".scroll-indicator")

  window.addEventListener("scroll", () => {
    const scrolled = window.pageYOffset

    // Navbar scroll effect
    if (scrolled > 100) {
      navbar.classList.add("scrolled")
    } else {
      navbar.classList.remove("scrolled")
    }

    // Hide scroll indicator when scrolling
    if (scrollIndicator) {
      if (scrolled > 200) {
        scrollIndicator.style.opacity = "0"
      } else {
        scrollIndicator.style.opacity = "1"
      }
    }

    // Parallax effect for floating icons
    const floatingIcons = document.querySelectorAll(".floating-icons i")
    floatingIcons.forEach((icon, index) => {
      const speed = 0.5 + index * 0.1
      const yPos = -(scrolled * speed)
      icon.style.transform = `translateY(${yPos}px) rotate(${scrolled * 0.1}deg)`
    })
  })
}

// Policy navigation highlighting
function initPolicyNavigation() {
  const navCards = document.querySelectorAll(".nav-card")
  const sections = document.querySelectorAll(".policy-section")

  // Add click handlers for navigation cards
  navCards.forEach((card) => {
    card.addEventListener("click", function (e) {
      e.preventDefault()

      // Remove active class from all cards
      navCards.forEach((c) => c.classList.remove("active"))

      // Add active class to clicked card
      this.classList.add("active")

      // Get target section
      const targetId = this.getAttribute("href").substring(1)
      const targetSection = document.getElementById(targetId)

      if (targetSection) {
        // Smooth scroll to section
        const offsetTop = targetSection.offsetTop - 120
        window.scrollTo({
          top: offsetTop,
          behavior: "smooth",
        })
      }
    })
  })

  // Highlight active section on scroll
  window.addEventListener("scroll", () => {
    let current = ""

    sections.forEach((section) => {
      const sectionTop = section.offsetTop - 150
      const sectionHeight = section.offsetHeight

      if (window.pageYOffset >= sectionTop && window.pageYOffset < sectionTop + sectionHeight) {
        current = section.getAttribute("id")
      }
    })

    // Update active navigation card
    navCards.forEach((card) => {
      card.classList.remove("active")
      if (card.getAttribute("href") === `#${current}`) {
        card.classList.add("active")
      }
    })
  })
}

// Animated counters for statistics
function initAnimatedCounters() {
  const counters = document.querySelectorAll("[data-target]")

  const animateCounter = (counter) => {
    const target = Number.parseInt(counter.getAttribute("data-target"))
    const duration = 2000 // 2 seconds
    const increment = target / (duration / 16) // 60fps
    let current = 0

    const updateCounter = () => {
      current += increment

      if (current < target) {
        counter.textContent = Math.floor(current)
        requestAnimationFrame(updateCounter)
      } else {
        counter.textContent = target
      }
    }

    updateCounter()
  }

  // Intersection Observer for counters
  const counterObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !entry.target.classList.contains("animated")) {
          entry.target.classList.add("animated")
          animateCounter(entry.target)
        }
      })
    },
    { threshold: 0.5 },
  )

  counters.forEach((counter) => {
    counterObserver.observe(counter)
  })
}

// Form handling
function initFormHandling() {
  const form = document.querySelector(".policy-form")
  const submitBtn = document.querySelector(".submit-btn")

  if (form) {
    form.addEventListener("submit", (e) => {
      e.preventDefault()

      // Get form data
      const formData = new FormData(form)
      const policyType = formData.get("policy-type") || document.getElementById("policy-type").value
      const email = formData.get("user-email") || document.getElementById("user-email").value
      const message = formData.get("message") || document.getElementById("message").value

      // Validate form
      if (!policyType || !email || !message) {
        showNotification("Por favor, completa todos los campos.", "error")
        return
      }

      // Show loading state
      const originalText = submitBtn.innerHTML
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...'
      submitBtn.disabled = true

      // Simulate form submission
      setTimeout(() => {
        showNotification("¡Consulta enviada exitosamente! Te responderemos pronto.", "success")
        form.reset()

        // Reset button
        submitBtn.innerHTML = originalText
        submitBtn.disabled = false
      }, 2000)
    })
  }
}

// Smooth scrolling for anchor links
function initSmoothScrolling() {
  const links = document.querySelectorAll('a[href^="#"]')

  links.forEach((link) => {
    link.addEventListener("click", function (e) {
      const href = this.getAttribute("href")

      if (href === "#") return

      e.preventDefault()

      const target = document.querySelector(href)
      if (target) {
        const offsetTop = target.offsetTop - 120
        window.scrollTo({
          top: offsetTop,
          behavior: "smooth",
        })
      }
    })
  })
}

// Intersection Observer for animations
function initIntersectionObserver() {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate-in")
      }
    })
  }, observerOptions)

  // Observe elements for animation
  const elementsToAnimate = document.querySelectorAll(`
        .policy-card,
        .nav-card,
        .timeline-item,
        .principle-card,
        .metric-card,
        .measure-item,
        .compliance-item,
        .tech-item
    `)

  elementsToAnimate.forEach((element) => {
    observer.observe(element)
  })
}

// Notification system
function showNotification(message, type = "info") {
  // Remove existing notifications
  const existingNotifications = document.querySelectorAll(".notification")
  existingNotifications.forEach((notification) => notification.remove())

  // Create notification element
  const notification = document.createElement("div")
  notification.className = `notification notification-${type}`
  notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${getNotificationIcon(type)}"></i>
            <span>${message}</span>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `

  // Add styles
  notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        background: ${getNotificationColor(type)};
        color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transform: translateX(400px);
        transition: transform 0.3s ease;
        max-width: 400px;
    `

  // Add to page
  document.body.appendChild(notification)

  // Animate in
  setTimeout(() => {
    notification.style.transform = "translateX(0)"
  }, 100)

  // Add close handler
  const closeBtn = notification.querySelector(".notification-close")
  closeBtn.addEventListener("click", () => {
    notification.style.transform = "translateX(400px)"
    setTimeout(() => notification.remove(), 300)
  })

  // Auto remove after 5 seconds
  setTimeout(() => {
    if (notification.parentNode) {
      notification.style.transform = "translateX(400px)"
      setTimeout(() => notification.remove(), 300)
    }
  }, 5000)
}

function getNotificationIcon(type) {
  const icons = {
    success: "fa-check-circle",
    error: "fa-exclamation-circle",
    warning: "fa-exclamation-triangle",
    info: "fa-info-circle",
  }
  return icons[type] || icons.info
}

function getNotificationColor(type) {
  const colors = {
    success: "linear-gradient(135deg, #28a745, #20c997)",
    error: "linear-gradient(135deg, #dc3545, #e74c3c)",
    warning: "linear-gradient(135deg, #ffc107, #fd7e14)",
    info: "linear-gradient(135deg, #17a2b8, #6f42c1)",
  }
  return colors[type] || colors.info
}

// Keyboard navigation support
document.addEventListener("keydown", (e) => {
  // ESC key to close notifications
  if (e.key === "Escape") {
    const notifications = document.querySelectorAll(".notification")
    notifications.forEach((notification) => {
      notification.style.transform = "translateX(400px)"
      setTimeout(() => notification.remove(), 300)
    })
  }

  // Tab navigation enhancement
  if (e.key === "Tab") {
    const focusableElements = document.querySelectorAll(`
            a[href], button, input, select, textarea, 
            [tabindex]:not([tabindex="-1"])
        `)

    // Add focus indicators
    focusableElements.forEach((element) => {
      element.addEventListener("focus", function () {
        this.style.outline = "3px solid rgba(159, 199, 232, 0.5)"
        this.style.outlineOffset = "2px"
      })

      element.addEventListener("blur", function () {
        this.style.outline = ""
        this.style.outlineOffset = ""
      })
    })
  }
})

// Add CSS animations
const style = document.createElement("style")
style.textContent = `
    .animate-in {
        animation: slideInUp 0.6s ease-out forwards;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .notification-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 5px;
        border-radius: 50%;
        transition: background 0.3s ease;
        margin-left: auto;
    }
    
    .notification-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }
`
document.head.appendChild(style)

// Performance optimization
function debounce(func, wait) {
  let timeout
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout)
      func(...args)
    }
    clearTimeout(timeout)
    timeout = setTimeout(later, wait)
  }
}

// Debounced scroll handler
const debouncedScrollHandler = debounce(() => {
  // Additional scroll-based functionality can be added here
}, 10)

window.addEventListener("scroll", debouncedScrollHandler)

// Accessibility enhancements
function enhanceAccessibility() {
  // Add ARIA labels to interactive elements
  const navCards = document.querySelectorAll(".nav-card")
  navCards.forEach((card, index) => {
    card.setAttribute("role", "button")
    card.setAttribute("aria-label", `Navegar a sección ${card.querySelector("h3").textContent}`)
    card.setAttribute("tabindex", "0")

    // Add keyboard support
    card.addEventListener("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault()
        this.click()
      }
    })
  })

  // Add skip links
  const skipLink = document.createElement("a")
  skipLink.href = "#main-content"
  skipLink.textContent = "Saltar al contenido principal"
  skipLink.className = "skip-link"
  skipLink.style.cssText = `
        position: absolute;
        top: -40px;
        left: 6px;
        background: #000;
        color: white;
        padding: 8px;
        text-decoration: none;
        border-radius: 4px;
        z-index: 10001;
        transition: top 0.3s ease;
    `

  skipLink.addEventListener("focus", function () {
    this.style.top = "6px"
  })

  skipLink.addEventListener("blur", function () {
    this.style.top = "-40px"
  })

  document.body.insertBefore(skipLink, document.body.firstChild)

  // Add main content landmark
  const mainContent = document.querySelector(".policy-nav")
  if (mainContent) {
    mainContent.id = "main-content"
    mainContent.setAttribute("role", "main")
  }
}

// Initialize accessibility enhancements
enhanceAccessibility()

// Console message for developers
console.log(`
🛡️ EDUSOFT - Política de Privacidad y Términos
📋 Página cargada exitosamente
🔒 Todas las políticas están actualizadas
✅ Cumplimiento GDPR, COPPA, FERPA
🌐 Accesibilidad WCAG 2.1 AA
`)
