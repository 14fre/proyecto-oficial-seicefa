<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/Favicon2.png') }}" type="image/x-icon">
    <title>SIBAF - Sistema de Gestión SENA</title>

    <!-- Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #dbeafe;
            --very-light-blue: #f0f9ff;
            --dark-blue: #1e40af;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --shadow-soft: 0 4px 20px rgba(37, 99, 235, 0.1);
            --shadow-card: 0 2px 15px rgba(0, 0, 0, 0.08);
            --border-radius: 16px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            line-height: 1.6;
            color: var(--gray-700);
            background: var(--white);
            overflow-x: hidden;
        }

        /* Navbar Simplificado */
        .navbar-clean {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--gray-100);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .navbar-brand-clean {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-clean {
            width: 40px;
            height: 40px;
            background: var(--primary-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.2rem;
        }

        .brand-text-clean h4 {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 0;
        }

        .brand-text-clean small {
            color: var(--gray-600);
            font-size: 0.85rem;
        }

        .nav-link-clean {
            color: var(--gray-600) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 10px;
            transition: var(--transition);
            margin: 0 0.2rem;
        }

        .nav-link-clean:hover {
            color: var(--primary-blue) !important;
            background: var(--very-light-blue);
        }

        .btn-login {
            background: var(--primary-blue);
            color: var(--white);
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            border: none;
            font-weight: 500;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-login:hover {
            background: var(--dark-blue);
            color: var(--white);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Hero Simplificado */
        .hero-clean {
            padding: 140px 0 80px;
            background: linear-gradient(135deg, var(--very-light-blue) 0%, var(--white) 100%);
            position: relative;
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.6rem 1.2rem;
            background: var(--white);
            border: 1px solid var(--light-blue);
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--primary-blue);
            margin-bottom: 2rem;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--gray-800);
            line-height: 1.2;
        }

        .hero-highlight {
            color: var(--primary-blue);
        }

        .hero-description {
            font-size: 1.2rem;
            color: var(--gray-600);
            margin-bottom: 3rem;
            line-height: 1.5;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary-clean {
            background: var(--primary-blue);
            color: var(--white);
            padding: 0.9rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-clean:hover {
            background: var(--dark-blue);
            color: var(--white);
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: var(--shadow-soft);
        }

        .btn-secondary-clean {
            background: transparent;
            color: var(--primary-blue);
            padding: 0.9rem 2rem;
            border: 2px solid var(--primary-blue);
            border-radius: 12px;
            font-weight: 600;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary-clean:hover {
            background: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
        }

        /* Sección de Funcionalidades Simplificada */
        .features-clean {
            padding: 80px 0;
            background: var(--white);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card-clean {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-100);
            transition: var(--transition);
            text-align: center;
        }

        .feature-card-clean:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-card);
            border-color: var(--light-blue);
        }

        .feature-icon-clean {
            width: 60px;
            height: 60px;
            background: var(--very-light-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            font-size: 1.5rem;
            margin: 0 auto 1.5rem;
            transition: var(--transition);
        }

        .feature-card-clean:hover .feature-icon-clean {
            background: var(--primary-blue);
            color: var(--white);
            transform: scale(1.1);
        }

        .feature-title-clean {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .feature-desc-clean {
            color: var(--gray-600);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Stats Minimalistas */
        .stats-clean {
            padding: 60px 0;
            background: var(--very-light-blue);
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem;
        }

        .stat-number-clean {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
            display: block;
        }

        .stat-label-clean {
            color: var(--gray-600);
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Footer Limpio */
        .footer-clean {
            background: var(--gray-50);
            padding: 4rem 0 2rem;
            border-top: 1px solid var(--gray-100);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
        }

        .footer-logo {
            width: 48px;
            height: 48px;
            background: var(--primary-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.3rem;
        }

        .footer-text h5 {
            font-weight: 600;
            color: var(--gray-800);
            margin: 0;
        }

        .footer-text small {
            color: var(--gray-600);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: var(--gray-600);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .footer-links a:hover {
            color: var(--primary-blue);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid var(--gray-200);
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-description {
                font-size: 1.1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-primary-clean,
            .btn-secondary-clean {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }

        /* Animaciones suaves */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>

<body>
    <!-- Navbar Simplificado -->
    <nav class="navbar navbar-expand-lg navbar-clean">
        <div class="container">
            <a class="navbar-brand-clean" href="{{ route('login') }}">
                <div class="logo-clean">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="brand-text-clean">
                    <h4>SIBAF</h4>
                    <small>Sistema SENA</small>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav">
                <i class="fas fa-bars text-primary"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link nav-link-clean">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    @auth
                        @if (checkRol('sibaf.admin'))
                            <li class="nav-item">
                                <a href="{{ route('sibaf.admin.welcome') }}"
                                    class="nav-link nav-link-clean @if (Route::is('sibaf.admin.*')) active @endif">
                                    <i class="fas fa-user-shield"></i> Admin
                                </a>
                            </li>
                        @endif
                        @if (checkRol('sibaf.soporte'))
                            <li class="nav-item">
                                <a href="{{ route('sibaf.soporte.welcomesoporte') }}"
                                    class="nav-link nav-link-clean @if (Route::is('sibaf.soporte.*')) active @endif">
                                    <i class="fas fa-headset"></i> Soporte
                                </a>
                            </li>
                        @endif
                        @if (checkRol('sibaf.instructor'))
                            <li class="nav-item">
                                <a href="{{ route('sibaf.instructor.masterinstructor') }}"
                                    class="nav-link nav-link-clean @if (Route::is('sibaf.instructor.*')) active @endif">
                                    <i class="fas fa-chalkboard-teacher"></i> Instructor
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <div class="ml-3">
                    @guest
                        <a href="{{ route('login') }}" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i> Acceder
                        </a>
                    @else
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-login" style="background: transparent; color: var(--primary-blue); border: 1px solid var(--primary-blue);">
                                <i class="fas fa-sign-out-alt"></i> Salir
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Simplificado y Relajante -->
    <section class="hero-clean">
        <div class="container">
            <div class="hero-content fade-in">
                <div class="welcome-badge">
                    <i class="fas fa-graduation-cap"></i>
                    <span>SENA - Formación de Calidad</span>
                </div>

                <h1 class="hero-title">
                    Bienvenido a <span class="hero-highlight">SIBAF</span>
                </h1>

                <p class="hero-description">
                    Tu plataforma integral para la gestión de ambientes formativos.
                    Simple, eficiente y diseñada para facilitar tu trabajo diario.
                </p>

                <div class="cta-buttons">
                    <a href="{{ route('login') }}" class="btn-primary-clean">
                        <i class="fas fa-play"></i> Comenzar
                    </a>
                    <a href="#features" class="btn-secondary-clean">
                        <i class="fas fa-info-circle"></i> Conocer más
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Minimalistas -->
    <section class="stats-clean">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-item">
                        <span class="stat-number-clean" data-target="95">0</span>
                        <span class="stat-label-clean"><i class="fas fa-chart-line"></i></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <span class="stat-number-clean" data-target="24">0</span>
                        <span class="stat-label-clean"><i class="fas fa-clock"></i></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <span class="stat-number-clean" data-target="1200">0</span>
                        <span class="stat-label-clean"><i class="fas fa-users"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Funcionalidades Principales -->
    <section class="features-clean" id="features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="font-size: 2.2rem; font-weight: 600; color: var(--gray-800); margin-bottom: 1rem;">
                    ¿Qué puedes hacer?
                </h2>
                <p style="font-size: 1.1rem; color: var(--gray-600); max-width: 600px; margin: 0 auto;">
                    Herramientas diseñadas para simplificar tu gestión educativa
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-card-clean">
                    <div class="feature-icon-clean">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="feature-title-clean">Gestión de Reportes</h3>
                    <p class="feature-desc-clean">
                        Registra y da seguimiento a incidencias de manera rápida y organizada.
                    </p>
                </div>

                <div class="feature-card-clean">
                    <div class="feature-icon-clean">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3 class="feature-title-clean">Control de Equipos</h3>
                    <p class="feature-desc-clean">
                        Administra el inventario y mantenimiento de equipos tecnológicos.
                    </p>
                </div>

                <div class="feature-card-clean">
                    <div class="feature-icon-clean">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="feature-title-clean">Ambientes Formativos</h3>
                    <p class="feature-desc-clean">
                        Gestiona espacios, horarios y programación de manera eficiente.
                    </p>
                </div>

                <div class="feature-card-clean">
                    <div class="feature-icon-clean">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title-clean">Reportes y Analytics</h3>
                    <p class="feature-desc-clean">
                        Visualiza datos importantes para tomar mejores decisiones.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modales de Información -->
    <div id="modalOverlay" class="modal-overlay" onclick="closeModal()">
        <div class="modal-content-custom" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
            <div id="modalContent">
                <!-- El contenido se carga dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Footer Limpio -->
    <footer class="footer-clean">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="footer-brand">
                        <div class="footer-logo">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="footer-text">
                            <h5>SIBAF</h5>
                            <small>Sistema Integral de Gestión SENA</small>
                        </div>
                    </div>
                    <p style="color: var(--gray-600); margin-top: 1rem; max-width: 400px;">
                        Innovación tecnológica al servicio de la educación colombiana.
                        Facilitando la gestión para una formación de calidad.
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 style="font-weight: 600; color: var(--gray-800); margin-bottom: 1rem;">Enlaces</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                        <li><a href="#features">Funcionalidades</a></li>
                        <li><a href="https://www.sena.edu.co" target="_blank">Portal SENA</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 style="font-weight: 600; color: var(--gray-800); margin-bottom: 1rem;">Contacto</h6>
                    <div style="color: var(--gray-600); font-size: 0.9rem;">
                        <div style="margin-bottom: 0.5rem;">
                            <i class="fas fa-envelope" style="color: var(--primary-blue); margin-right: 8px;"></i>
                            soporte@sena.edu.co
                        </div>
                        <div style="margin-bottom: 0.5rem;">
                            <i class="fas fa-phone" style="color: var(--primary-blue); margin-right: 8px;"></i>
                            +57 1 5461500
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2023-2025 SENA. Sistema desarrollado con dedicación para la comunidad educativa.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🌟 SIBAF Clean System Loading...');

            // Navbar scroll effect suave
            const navbar = document.querySelector('.navbar-clean');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 30) {
                    navbar.style.boxShadow = 'var(--shadow-card)';
                } else {
                    navbar.style.boxShadow = 'none';
                }
            });

            // Contadores animados más suaves
            const counters = document.querySelectorAll('.stat-number-clean[data-target]');
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        counterObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.8 });

            counters.forEach(counter => {
                counterObserver.observe(counter);
            });

            function animateCounter(element) {
                const target = parseInt(element.getAttribute('data-target'));
                const duration = 1500;
                const increment = target / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        element.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        element.textContent = target;
                    }
                };

                updateCounter();
            }

            // Scroll suave para enlaces ancla
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Animaciones de entrada
            const observeElements = document.querySelectorAll('.feature-card-clean');
            const fadeObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('fade-in');
                        }, index * 100);
                    }
                });
            }, { threshold: 0.2 });

            observeElements.forEach(el => {
                fadeObserver.observe(el);
            });

            console.log('✨ SIBAF Clean System Ready!');
        });

        // Funciones para los modales de información
        function showInfoModal(type) {
            const modalOverlay = document.getElementById('modalOverlay');
            const modalContent = document.getElementById('modalContent');
            
            let content = '';
            
            switch(type) {
                case 'ambientes':
                    content = `
                        <div class="modal-header-custom">
                            <div class="modal-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h3 class="modal-title-custom">Gestión de Ambientes Formativos</h3>
                        </div>
                        <p class="modal-text">
                            SIBAF revoluciona la administración de espacios educativos en el SENA, 
                            ofreciendo un control total sobre la programación, mantenimiento y 
                            optimización de ambientes formativos.
                        </p>
                        <ul class="feature-list">
                            <li>
                                <i class="fas fa-calendar-check"></i>
                                <span><strong>Programación Inteligente:</strong> Asignación automática de horarios y espacios</span>
                            </li>
                            <li>
                                <i class="fas fa-tools"></i>
                                <span><strong>Control de Mantenimiento:</strong> Seguimiento preventivo y correctivo</span>
                            </li>
                            <li>
                                <i class="fas fa-users"></i>
                                <span><strong>Gestión de Ocupación:</strong> Optimización del uso de espacios</span>
                            </li>
                            <li>
                                <i class="fas fa-clipboard-check"></i>
                                <span><strong>Reportes de Estado:</strong> Monitoreo continuo de condiciones</span>
                            </li>
                        </ul>
                        <div class="modal-stats">
                            <div class="modal-stat">
                                <span class="modal-stat-number">45</span>
                                <span class="modal-stat-label">Ambientes</span>
                            </div>
                            <div class="modal-stat">
                                <span class="modal-stat-number">85%</span>
                                <span class="modal-stat-label">Ocupación</span>
                            </div>
                            <div class="modal-stat">
                                <span class="modal-stat-number">98%</span>
                                <span class="modal-stat-label">Disponibilidad</span>
                            </div>
                        </div>
                    `;
                    break;
                    
                case 'equipos':
                    content = `
                        <div class="modal-header-custom">
                            <div class="modal-icon">
                                <i class="fas fa-laptop"></i>
                            </div>
                            <h3 class="modal-title-custom">Control de Equipos Tecnológicos</h3>
                        </div>
                        <p class="modal-text">
                            Sistema integral para la administración del inventario tecnológico del SENA, 
                            garantizando el óptimo funcionamiento de todos los equipos formativos mediante 
                            un control exhaustivo y mantenimiento preventivo.
                        </p>
                        <ul class="feature-list">
                            <li>
                                <i class="fas fa-barcode"></i>
                                <span><strong>Inventario Digital:</strong> Registro completo con códigos únicos</span>
                            </li>
                            <li>
                                <i class="fas fa-wrench"></i>
                                <span><strong>Mantenimiento Programado:</strong> Alertas automáticas de servicios</span>
                            </li>
                            <li>
                                <i class="fas fa-shield-alt"></i>
                                <span><strong>Control de Garantías:</strong> Seguimiento de coberturas y vencimientos</span>
                            </li>
                            <li>
                                <i class="fas fa-chart-line"></i>
                                <span><strong>Análisis de Rendimiento:</strong> Evaluación de vida útil y eficiencia</span>
                            </li>
                        </ul>
                        <div class="modal-stats">
                            <div class="modal-stat">
                                <span class="modal-stat-number">1.2K</span>
                                <span class="modal-stat-label">Equipos</span>
                            </div>
                            <div class="modal-stat">
                                <span class="modal-stat-number">95%</span>
                                <span class="modal-stat-label">Operativos</span>
                            </div>
                            <div class="modal-stat">
                                <span class="modal-stat-number">24h</span>
                                <span class="modal-stat-label">Soporte</span>
                            </div>
                        </div>
                    `;
                    break;
                    
                case 'reportes':
                    content = `
                        <div class="modal-header-custom">
                            <div class="modal-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3 class="modal-title-custom">Sistema de Reportes y Analytics</h3>
                        </div>
                        <p class="modal-text">
                            Plataforma avanzada de análisis de datos que transforma la información 
                            del SENA en insights valiosos para la toma de decisiones estratégicas 
                            y el mejoramiento continuo de los procesos formativos.
                        </p>
                        <ul class="feature-list">
                            <li>
                                <i class="fas fa-chart-bar"></i>
                                <span><strong>Dashboards Interactivos:</strong> Visualización de datos en tiempo real</span>
                            </li>
                            <li>
                                <i class="fas fa-download"></i>
                                <span><strong>Reportes Automáticos:</strong> Generación programada de informes</span>
                            </li>
                            <li>
                                <i class="fas fa-filter"></i>
                                <span><strong>Filtros Avanzados:</strong> Análisis personalizado por criterios</span>
                            </li>
                            <li>
                                <i class="fas fa-bell"></i>
                                <span><strong>Alertas Inteligentes:</strong> Notificaciones de eventos importantes</span>
                            </li>
                        </ul>
                        <div class="modal-stats">
                            <div class="modal-stat">
                                <span class="modal-stat-number">50+</span>
                                <span class="modal-stat-label">Reportes</span>
                            </div>
                            <div class="modal-stat">
                                <span class="modal-stat-number">100%</span>
                                <span class="modal-stat-label">Tiempo Real</span>
                            </div>
                            <div class="modal-stat">
                                <span class="modal-stat-number">24/7</span>
                                <span class="modal-stat-label">Monitoreo</span>
                            </div>
                        </div>
                    `;
                    break;
            }
            
            modalContent.innerHTML = content;
            modalOverlay.style.display = 'flex';
            
            // Trigger animation
            setTimeout(() => {
                modalOverlay.classList.add('show');
            }, 10);
        }

        function closeModal() {
            const modalOverlay = document.getElementById('modalOverlay');
            modalOverlay.classList.remove('show');
            
            setTimeout(() => {
                modalOverlay.style.display = 'none';
            }, 300);
        }

        // Cerrar modal con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>

</html>
