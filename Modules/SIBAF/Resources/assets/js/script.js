// Variables globales
let isMenuOpen = false
let isScrolled = false

// Inicialización cuando el DOM está listo
document.addEventListener("DOMContentLoaded", () => {
  initializeNavbar()
  initializeDropdowns()
  initializeSmoothScroll()
})

// Funcionalidad del navbar
function initializeNavbar() {
  const navbar = document.querySelector(".navbar")

  window.addEventListener("scroll", () => {
    const scrolled = window.scrollY > 50

    if (scrolled !== isScrolled) {
      isScrolled = scrolled

      if (isScrolled) {
        navbar.classList.add("scrolled")
      } else {
        navbar.classList.remove("scrolled")
      }
    }
  })
}

// Funcionalidad del menú móvil
function toggleMobileMenu() {
  isMenuOpen = !isMenuOpen

  const mobileMenu = document.querySelector(".mobile-menu")
  const menuIcon = document.querySelector(".menu-icon")
  const closeIcon = document.querySelector(".close-icon")

  if (isMenuOpen) {
    mobileMenu.classList.remove("hidden")
    menuIcon.classList.add("hidden")
    closeIcon.classList.remove("hidden")
  } else {
    mobileMenu.classList.add("hidden")
    menuIcon.classList.remove("hidden")
    closeIcon.classList.add("hidden")
  }
}

// Funcionalidad de dropdowns
function initializeDropdowns() {
  const dropdowns = document.querySelectorAll(".dropdown")

  dropdowns.forEach((dropdown) => {
    const button = dropdown.querySelector(".dropdown-btn")
    const menu = dropdown.querySelector(".dropdown-menu")

    // Hover para mostrar/ocultar
    dropdown.addEventListener("mouseenter", () => {
      menu.style.opacity = "1"
      menu.style.visibility = "visible"
    })

    dropdown.addEventListener("mouseleave", () => {
      menu.style.opacity = "0"
      menu.style.visibility = "hidden"
    })
  })
}

// Scroll suave para los enlaces de navegación
function initializeSmoothScroll() {
  const navLinks = document.querySelectorAll('a[href^="#"]')

  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault()

      const targetId = this.getAttribute("href")
      const targetSection = document.querySelector(targetId)

      if (targetSection) {
        const offsetTop = targetSection.offsetTop - 80 // Ajuste para el navbar fijo

        window.scrollTo({
          top: offsetTop,
          behavior: "smooth",
        })

        // Cerrar menú móvil si está abierto
        if (isMenuOpen) {
          toggleMobileMenu()
        }
      }
    })
  })
}

// Funciones adicionales para interactividad
function handleButtonClick(buttonType) {
  switch (buttonType) {
    case "comenzar":
      // Redirigir a la página de login o registro
      window.location.href = "/admin"
      break
    case "demo":
      // Mostrar demo o redirigir a página de demo
      alert("Demo próximamente disponible")
      break
    case "acceder":
      // Redirigir al sistema
      window.location.href = "/admin"
      break
    case "soporte":
      // Abrir chat de soporte o redirigir
      alert("Contactando con soporte...")
      break
    default:
      console.log("Acción no definida")
  }
}

// Agregar event listeners a los botones
document.addEventListener("DOMContentLoaded", () => {
  // Botones principales
  const buttons = document.querySelectorAll(".btn-primary, .btn-secondary")

  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      const text = this.textContent.trim().toLowerCase()

      if (text.includes("comenzar")) {
        handleButtonClick("comenzar")
      } else if (text.includes("demo")) {
        handleButtonClick("demo")
      } else if (text.includes("acceder")) {
        handleButtonClick("acceder")
      } else if (text.includes("soporte")) {
        handleButtonClick("soporte")
      }
    })
  })
})

// Efectos de animación al hacer scroll
function initializeScrollAnimations() {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate-fade-in-up")
      }
    })
  }, observerOptions)

  // Observar elementos que queremos animar
  const animatedElements = document.querySelectorAll(".feature-card, .step-item")
  animatedElements.forEach((el) => observer.observe(el))
}

// Inicializar animaciones de scroll
document.addEventListener("DOMContentLoaded", initializeScrollAnimations)
