<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/Favicon2.png') }}" type="image/x-icon">
    <title>SIBAF - Sistema de Gestión SENA</title>
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    
    <style>
        :root {
            --primary-color: #1a2332;
            --secondary-color: #2c3e50;
            --accent-color: #34495e;
            --sena-green: #39a900;
            --sena-orange: #ff8c00;
            --dark-color: #1a2332;
            --light-color: #f8f9fa;
            --text-color: #2c3e50;
            --text-light: #6c757d;
            --white: #ffffff;
            --shadow-soft: 0 2px 15px rgba(26, 35, 50, 0.08);
            --shadow-medium: 0 4px 25px rgba(26, 35, 50, 0.12);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background: var(--light-color);
            color: var(--text-color);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        /* Preloader simplificado */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.6s ease-out, visibility 0.6s;
        }
        
        .preloader.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .loader-container {
            text-align: center;
        }
        
        /* Logo SENA animado */
        .sena-logo {
            width: 120px;
            height: 120px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
            animation: pulse-logo 2s infinite;
        }
        
        .sena-logo i {
            font-size: 60px;
            color: var(--sena-green);
        }
        
        @keyframes pulse-logo {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .loader-text {
            color: var(--white);
            font-size: 24px;
            font-weight: 300;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }
        
        .loader-subtext {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            font-weight: 300;
        }
        
        .progress-bar {
            width: 200px;
            height: 3px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            margin: 20px auto 0;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            width: 0%;
            background: var(--sena-green);
            animation: fillProgress 3s forwards;
            border-radius: 2px;
        }
        
        @keyframes fillProgress {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        
        /* Navbar con ícono de teléfono */
        .navbar {
            background: rgba(26, 35, 50, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            padding: 15px 0;
        }
        
        .navbar.scrolled {
            background: var(--primary-color);
            box-shadow: var(--shadow-medium);
        }
        
        .navbar .nav-link {
            color: var(--white) !important;
            font-weight: 400;
            padding: 10px 20px !important;
            transition: color 0.3s ease;
        }
        
        .navbar .nav-link:hover {
            color: var(--sena-green) !important;
        }
        
        /* Ícono de teléfono en navbar */
        .phone-icon {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--sena-green);
            font-size: 20px;
            background: rgba(57, 169, 0, 0.1);
            padding: 10px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .phone-icon:hover {
            background: rgba(57, 169, 0, 0.2);
            transform: translateY(-50%) scale(1.1);
        }
        
        /* Hero section minimalista */
        .hero-section {
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset("images/sena-campus.jpg") }}');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            transition: all 0.3s ease;
        }
        
        /* IMÁGENES FLOTANTES DE AMBIENTES DE FORMACIÓN */
        .floating-images {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            pointer-events: none;
            z-index: 1;
        }
        
        .floating-image {
            position: absolute;
            border-radius: 12px;
            box-shadow: var(--shadow-medium);
            transition: all 0.3s ease;
            opacity: 0.9;
        }

        /* Imagen izquierda superior */
        .floating-image.left-top {
            left: -50px;
            top: 120px;
            width: 280px;
            height: 200px;
            background-image: url('{{ asset("images/aula-sistemas.jpg") }}');
            background-size: cover;
            background-position: center;
            transform: rotate(-5deg);
            animation: float-left 6s ease-in-out infinite;
        }

        /* Imagen derecha superior */
        .floating-image.right-top {
            right: -50px;
            top: 150px;
            width: 260px;
            height: 180px;
            background-image: url('{{ asset("images/laboratorio.jpg") }}');
            background-size: cover;
            background-position: center;
            transform: rotate(3deg);
            animation: float-right 7s ease-in-out infinite;
        }

        /* Imagen izquierda media */
        .floating-image.left-middle {
            left: -40px;
            top: 400px;
            width: 240px;
            height: 160px;
            background-image: url('{{ asset("images/taller-mecanica.jpg") }}');
            background-size: cover;
            background-position: center;
            transform: rotate(2deg);
            animation: float-left 8s ease-in-out infinite;
            animation-delay: -2s;
        }

        /* Imagen derecha media */
        .floating-image.right-middle {
            right: -60px;
            top: 450px;
            width: 300px;
            height: 220px;
            background-image: url('{{ asset("images/salon-clases.jpg") }}');
            background-size: cover;
            background-position: center;
            transform: rotate(-4deg);
            animation: float-right 9s ease-in-out infinite;
            animation-delay: -3s;
        }

        /* Imagen izquierda inferior */
        .floating-image.left-bottom {
            left: -30px;
            top: 650px;
            width: 220px;
            height: 150px;
            background-image: url('{{ asset("images/biblioteca.jpg") }}');
            background-size: cover;
            background-position: center;
            transform: rotate(-3deg);
            animation: float-left 7s ease-in-out infinite;
            animation-delay: -4s;
        }

        /* Imagen derecha inferior */
        .floating-image.right-bottom {
            right: -40px;
            top: 700px;
            width: 270px;
            height: 190px;
            background-image: url('{{ asset("images/cafeteria.jpg") }}');
            background-size: cover;
            background-position: center;
            transform: rotate(4deg);
            animation: float-right 6s ease-in-out infinite;
            animation-delay: -1s;
        }
        
        @keyframes float-left {
            0%, 100% { 
                transform: translateX(0) translateY(0) rotate(-5deg); 
            }
            50% { 
                transform: translateX(15px) translateY(-10px) rotate(-3deg); 
            }
        }
        
        @keyframes float-right {
            0%, 100% { 
                transform: translateX(0) translateY(0) rotate(3deg); 
            }
            50% { 
                transform: translateX(-15px) translateY(-10px) rotate(5deg); 
            }
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--white);
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .sena-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 25px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .sena-badge i {
            color: var(--sena-green);
            font-size: 20px;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 300;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 300;
            opacity: 0.9;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--sena-green);
            color: var(--white);
            padding: 15px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-soft);
        }
        
        .hero-cta:hover {
            background: #2d8a00;
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
            color: var(--white);
            text-decoration: none;
        }
        
        /* Sección de información simple - CON Z-INDEX ALTO PARA TAPAR IMÁGENES */
        .info-section {
            padding: 80px 0;
            background: var(--white);
            position: relative;
            z-index: 10;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .info-card {
            text-align: center;
            padding: 40px 30px;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(30px);
        }
        
        .info-card.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }
        
        .info-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--sena-green) 0%, #2d8a00 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .info-icon i {
            font-size: 30px;
            color: var(--white);
        }
        
        .info-card h3 {
            font-size: 1.4rem;
            font-weight: 500;
            margin-bottom: 15px;
            color: var(--text-color);
        }
        
        .info-card p {
            color: var(--text-light);
            font-size: 1rem;
            line-height: 1.6;
        }
        
        /* Sección SENA - CON Z-INDEX ALTO */
        .sena-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--white);
            text-align: center;
            position: relative;
            z-index: 10;
        }
        
        .sena-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .sena-logo-large {
            width: 100px;
            height: 100px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: var(--shadow-medium);
        }
        
        .sena-logo-large i {
            font-size: 50px;
            color: var(--sena-green);
        }
        
        .sena-section h2 {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 20px;
        }
        
        .sena-section p {
            font-size: 1.2rem;
            font-weight: 300;
            opacity: 0.9;
            line-height: 1.7;
        }
        
        /* Sección de acceso - CON Z-INDEX ALTO */
        .access-section {
            padding: 80px 0;
            background: var(--light-color);
            text-align: center;
            position: relative;
            z-index: 10;
        }
        
        .access-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 50px 40px;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
        }
        
        .access-content h2 {
            font-size: 2rem;
            font-weight: 400;
            margin-bottom: 20px;
            color: var(--text-color);
        }
        
        .access-content p {
            color: var(--text-light);
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        
        .btn-access {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--primary-color);
            color: var(--white);
            padding: 15px 35px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-soft);
        }
        
        .btn-access:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
            color: var(--white);
            text-decoration: none;
        }
        
        /* Footer simple - CON Z-INDEX ALTO */
        footer {
            background: var(--primary-color) !important;
            color: var(--white);
            padding: 30px 20px !important;
            text-align: center;
            border-top: 3px solid var(--sena-green);
            position: relative;
            z-index: 10;
        }
        
        footer a {
            color: var(--sena-green) !important;
            text-decoration: none;
            font-weight: 500;
        }
        
        footer a:hover {
            color: #2d8a00 !important;
        }
        
        /* Animaciones suaves */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .sena-section h2 {
                font-size: 2rem;
            }
            
            .access-content {
                margin: 20px;
                padding: 40px 30px;
            }
            
            /* Ocultar imágenes flotantes en móvil */
            .floating-images {
                display: none;
            }
            
            .phone-icon {
                right: 15px;
                font-size: 18px;
                padding: 8px;
            }
        }
        
        /* Efectos sutiles */
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <!-- Preloader SENA -->
    <div class="preloader">
        <div class="loader-container">
            <div class="sena-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="loader-text">SIBAF</div>
            <div class="loader-subtext">Sistema de Gestión SENA</div>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
        </div>
    </div>

    <!-- Imágenes flotantes de ambientes de formación -->
    <div class="floating-images" id="floatingImages">
        <div class="floating-image left-top"></div>
        <div class="floating-image right-top"></div>
        <div class="floating-image left-middle"></div>
        <div class="floating-image right-middle"></div>
        <div class="floating-image left-bottom"></div>
        <div class="floating-image right-bottom"></div>
    </div>

    <!-- Navbar con ícono de teléfono -->
    <nav class="navbar navbar-expand navbar-dark fixed-top" id="mainNavbar">
        <div class="container">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Inicio</a>
                </li>
                @auth
                    @if(checkRol('sibaf.admin'))
                        <li class="nav-item">
                            <a href="{{ route('sibaf.admin.welcome') }}"
                                class="nav-link @if(Route::is('sibaf.admin.*')) active @endif">
                                Administrador
                            </a>
                        </li>
                    @endif
                    @if(checkRol('sibaf.soporte'))
                        <li class="nav-item">
                            <a href="{{ route('sibaf.soporte.welcomesoporte') }}"
                                class="nav-link @if(Route::is('sibaf.soporte.*')) active @endif">
                                Mesa de Ayuda
                            </a>
                        </li>
                    @endif
                    @if(checkRol('sibaf.instructor'))
                        <li class="nav-item">
                            <a href="{{ route('sibaf.instructor.masterinstructor') }}"
                                class="nav-link @if(Route::is('sibaf.instructor.*')) active @endif">
                                Instructor
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
            <!-- Ícono de teléfono -->
            <div class="phone-icon">
                <i class="fas fa-phone"></i>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="heroSection">
        <div class="hero-background" id="heroBackground"></div>
        <div class="container">
            <div class="hero-content fade-in">
                <div class="sena-badge">
                    <i class="fas fa-graduation-cap"></i>
                    <span>SENA - Servicio Nacional de Aprendizaje</span>
                </div>
                <h1 class="hero-title">SIBAF</h1>
                <p class="hero-subtitle">
                    Sistema Integral de Bajas de Ambiente y Formación
                </p>
                <a href="#info" class="hero-cta">
                    <i class="fas fa-arrow-down"></i>
                    Conocer más
                </a>
            </div>
        </div>
    </section>

    <!-- Sección de información -->
    <section class="info-section" id="info">
        <div class="container">
            <div class="info-grid">
                <div class="info-card scroll-reveal" style="transition-delay: 0.1s;">
                    <div class="info-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3>Gestión de Reportes</h3>
                    <p>Administra reportes de incidencias de manera eficiente con seguimiento en tiempo real.</p>
                </div>
                
                <div class="info-card scroll-reveal" style="transition-delay: 0.2s;">
                    <div class="info-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3>Control de Equipos</h3>
                    <p>Sistema integral para el control y seguimiento de equipos tecnológicos del SENA.</p>
                </div>
                
                <div class="info-card scroll-reveal" style="transition-delay: 0.3s;">
                    <div class="info-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Reportes y Estadísticas</h3>
                    <p>Genera informes detallados para la toma de decisiones estratégicas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección SENA -->
    <section class="sena-section scroll-reveal">
        <div class="container">
            <div class="sena-content">
                <div class="sena-logo-large">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h2>Formación para el Trabajo</h2>
                <p>
                    El SENA ofrece formación gratuita a millones de colombianos del sector productivo, 
                    fortaleciendo las competencias laborales y promoviendo el desarrollo tecnológico 
                    y la innovación en todos los sectores económicos.
                </p>
            </div>
        </div>
    </section>

    <!-- Sección de acceso -->
    <section class="access-section">
        <div class="container">
            <div class="access-content scroll-reveal">
                <h2>Acceso al Sistema</h2>
                <p>Ingresa con tus credenciales para acceder a todas las funcionalidades del sistema.</p>
                @auth
                    <a href="{{ route('login') }}" class="btn-access">
                        <i class="fas fa-sign-in-alt"></i>
                        Ingresar al Sistema
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <strong>Copyright &copy; 2023-2025 <a href="#">SENA</a>.</strong> 
            Todos los derechos reservados.
            <div class="float-right d-none d-sm-inline-block">
                <b>SIBAF</b> v3.2.0
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/dist/js/adminlte.js') }}"></script>

    <!-- Script con efecto de tapado de imágenes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preloader
            setTimeout(function() {
                const preloader = document.querySelector('.preloader');
                preloader.classList.add('hidden');
                
                setTimeout(function() {
                    preloader.style.display = 'none';
                    initScrollAnimations();
                }, 600);
            }, 3000);

            // Animaciones de scroll suaves
            function initScrollAnimations() {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('revealed');
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });

                document.querySelectorAll('.scroll-reveal, .info-card').forEach(el => {
                    observer.observe(el);
                });
            }

            // Efecto de tapado de imágenes flotantes
            function updateFloatingImages() {
                const scrolled = window.pageYOffset;
                const floatingImages = document.getElementById('floatingImages');
                const heroHeight = window.innerHeight;
                
                if (floatingImages) {
                    // Calcular opacidad basada en el scroll
                    const scrollPercent = Math.min(scrolled / (heroHeight * 0.8), 1);
                    const opacity = Math.max(0.9 - scrollPercent, 0);
                    
                    // Aplicar opacidad y transformación
                    floatingImages.style.opacity = opacity;
                    
                    // Mover las imágenes ligeramente hacia afuera conforme se hace scroll
                    const images = floatingImages.querySelectorAll('.floating-image');
                    images.forEach((img, index) => {
                        const isLeft = img.classList.contains('left-top') || 
                                      img.classList.contains('left-middle') || 
                                      img.classList.contains('left-bottom');
                        
                        const moveDistance = scrollPercent * 50;
                        const translateX = isLeft ? -moveDistance : moveDistance;
                        
                        img.style.transform = img.style.transform.replace(/translateX$$[^)]*$$/, '') + 
                                            ` translateX(${translateX}px)`;
                    });
                }
            }

            // Efecto sutil en imagen de fondo
            function updateBackground() {
                const scrolled = window.pageYOffset;
                const heroBackground = document.getElementById('heroBackground');
                
                if (heroBackground) {
                    const scrollPercent = Math.min(scrolled / window.innerHeight, 1);
                    const opacity = 0.15 - (scrollPercent * 0.1);
                    heroBackground.style.opacity = Math.max(opacity, 0.05);
                }
            }

            // Navbar scroll effect
            function updateNavbar() {
                const navbar = document.getElementById('mainNavbar');
                if (window.pageYOffset > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }

            // Scroll listeners optimizados
            let ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(function() {
                        updateFloatingImages();
                        updateBackground();
                        updateNavbar();
                        ticking = false;
                    });
                    ticking = true;
                }
            });

            // Smooth scroll
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
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
        });
    </script>
</body>
</html>
