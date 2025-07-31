<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPES - Gestión de Inventarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&family=Orbitron:wght@400;500;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #2E7D32;
            /* Original green */
            --secondary: #A5D6A7;
            /* Original light green */
            --text-dark: #071013;
            /* Darker slate for contrast */
            --text-light: #FFFFFF;
            /* Pure white for better contrast */
            --accent: #4CAF50;
            /* Original vibrant green */
            --background: #F4F6F9;
            /* Softer off-white background */
            --gradient-dark: #1B5E20;
            /* Darker green for gradients */
            --neon-glow: #4CAF50;
            /* Neon green for tech aesthetic */
        }

        body {
            font-family: 'Roboto Mono', monospace;
            background: var(--background);
            color: var(--text-dark);
            overflow-x: hidden;
            scroll-behavior: smooth;
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" opacity="0.08"%3E%3Cpath d="M0 0h50v50H0zM50 50h50v50H50zM100 100h50v50h-50zM150 150h50v50h-50zM25 75h150M75 25v150" stroke="%232E7D32" stroke-width="1.5"/%3E%3C/svg%3E');
            z-index: -1;
        }

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--gradient-dark));
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            transition: opacity 0.8s ease;
        }


        #preloader .loader {
            border: 6px solid var(--secondary);
            border-top: 6px solid var(--text-light);
            border-radius: 50%;
            width: 48px;
            height: 48px;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                visibility: hidden;
            }
        }

        section {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 1.3s ease, transform 1.3s ease;
        }

        section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: url('https://source.unsplash.com/random/1920x1080?circuit,tech') no-repeat center/cover;
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(46, 125, 50, 0.95), rgba(76, 175, 80, 0.8));
        }

        .hero-content {
            transform: translateY(0);
            transition: transform 0.9s ease, opacity 1s ease;
            opacity: 0;
        }

        .hero-content.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .holo-text {
            position: relative;
            color: var(--text-light);
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            text-shadow: 0 0 12px rgba(76, 175, 80, 0.7), 0 4px 12px rgba(0, 0, 0, 0.4);
            letter-spacing: -0.03em;
        }

        .holo-text::after {
            content: '';
            position: absolute;
            bottom: -14px;
            left: 50%;
            width: 0;
            height: 5px;
            background: linear-gradient(to right, var(--secondary), var(--neon-glow));
            box-shadow: 0 0 12px rgba(76, 175, 80, 0.7);
            animation: underlineGlow 1.8s ease-out forwards;
        }

        @keyframes underlineGlow {
            0% {
                width: 0;
                left: 50%;
                opacity: 0.3;
            }

            50% {
                width: 50%;
                left: 25%;
                opacity: 0.7;
            }

            100% {
                width: 100%;
                left: 0;
                opacity: 1;
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--gradient-dark));
            border: 2px solid var(--secondary);
            color: var(--text-light);
            padding: 1rem 3rem;
            border-radius: 50px;
            font-family: 'Orbitron', sans-serif;
            font-weight: 500;
            transition: all 0.35s ease;
            position: relative;
            overflow: hidden;
            animation: pulse 2.5s infinite;
        }



        .btn-primary::before {

            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(76, 175, 80, 0.3), transparent);

        }



        .btn-primary:hover {


            box-shadow: 0 0 12px rgba(76, 175, 80, 0.5), 0 10px 20px rgba(46, 125, 50, 0.4);
            animation: none;
        }

        .carousel-box {
            background: linear-gradient(145deg, #FFFFFF, #F7F9FB);
            border: 1px solid #DDE4EE;
            border-radius: 18px;
            padding: 2.5rem;
            width: 100%;
            max-width: 360px;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.4s ease;
            box-shadow: 0 10px 32px rgba(0, 0, 0, 0.12);
            position: relative;
            overflow: hidden;
        }

        .carousel-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top left, rgba(76, 175, 80, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .carousel-box:hover::before {
            opacity: 1;
        }

        .carousel-box:hover {
            border-color: var(--neon-glow);
            box-shadow: 0 0 12px rgba(76, 175, 80, 0.5), 0 14px 36px rgba(46, 125, 50, 0.3);
            transform: translateY(-0, 20px) scale(1.02);
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--secondary), var(--neon-glow));
            margin: 0 auto 1.75rem;
            transition: all 0.4s ease;
        }

        .carousel-box:hover .icon-circle {
            background: linear-gradient(135deg, var(--neon-glow), var(--gradient-dark));
            transform: scale(1.15);
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.7);
        }

        .carousel-box i {
            font-size: 3rem;
            color: var(--text-light);
        }

        .category-card {
            background: linear-gradient(145deg, #FFFFFF, #F7F9FB);
            border: 1px solid #DDE4EE;
            border-radius: 18px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.4s ease;
            box-shadow: 0 10px 32px rgba(0, 0, 0, 0.12);
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at bottom right, rgba(76, 175, 80, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .category-card:hover::before {
            opacity: 1;
        }

        .category-card:hover {
            transform: scale(1.08);
            border-color: var(--neon-glow);
            box-shadow: 0 0 12px rgba(76, 175, 80, 0.5), 0 14px 36px rgba(46, 125, 50, 0.3);
        }

        .category-card i {
            color: var(--primary);
            transition: all 0.4s ease;
        }

        .category-card:hover i {
            transform: scale(1.2);
            color: var(--neon-glow);
            text-shadow: 0 0 8px rgba(76, 175, 80, 0.7);
        }

        footer {
            background: linear-gradient(135deg, var(--primary), var(--gradient-dark));
            color: var(--text-light);
        }

        .footer-text a:hover {
            color: var(--neon-glow);
            text-shadow: 0 0 8px rgba(76, 175, 80, 0.7);
            text-decoration: none;
        }

        .social-links a {
            color: var(--text-light);
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            color: var(--neon-glow);
            transform: scale(1.3);
            text-shadow: 0 0 8px rgba(76, 175, 80, 0.7);
        }

        .swiper-pagination-bullet {
            background: var(--secondary);
            opacity: 0.8;
            width: 11px;
            height: 11px;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background: var(--neon-glow);
            width: 13px;
            height: 13px;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.7);
        }

        .swiper-button-prev,
        .swiper-button-next {
            color: var(--neon-glow);
            background: rgba(255, 255, 255, 0.98);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .swiper-button-prev:hover,
        .swiper-button-next:hover {
            color: var(--text-light);
            background: var(--neon-glow);
            transform: scale(1.2);
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.7);
        }

        #particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background: #000000;
            /* Black background for tech aesthetic */
        }

        .navbar-custom {
            background: linear-gradient(135deg, var(--primary), var(--gradient-dark));
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
        }

        .navbar-custom .nav-link {
            color: var(--text-light);
            font-family: 'Orbitron', sans-serif;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: var(--neon-glow);
            text-decoration: underline;
            text-underline-offset: 5px;
            text-shadow: 0 0 8px rgba(76, 175, 80, 0.7);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.97)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        .contact-form {
            background: linear-gradient(145deg, #FFFFFF, #F7F9FB);
            border-radius: 18px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.25), 0 0 12px rgba(76, 175, 80, 0.3);
            padding: 3rem;
            width: 100%;
            max-width: 520px;
            transform: translateY(20px);
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        .contact-form.visible {
            transform: translateY(0);
            opacity: 1;
        }

        .contact-form input,
        .contact-form textarea {
            background: #FAFBFC;
            border: 1px solid #CED4DA;
            border-radius: 12px;
            padding: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            font-family: 'Roboto Mono', monospace;
            font-size: 0.95rem;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: var(--neon-glow);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.2), 0 0 8px rgba(76, 175, 80, 0.5);
            outline: none;
        }

        .contact-form button {
            background: linear-gradient(135deg, var(--neon-glow), var(--gradient-dark));
            color: var(--text-light);
            padding: 1rem 2.25rem;
            border-radius: 12px;
            font-family: 'Orbitron', sans-serif;
            font-weight: 500;
            transition: all 0.3s ease;
            animation: pulse 2.5s infinite;
        }

        .contact-form button:hover {
            background: linear-gradient(135deg, var(--secondary), var(--neon-glow));
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.7);
            animation: none;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding-top: 60px;
            }

            .holo-text {
                font-size: 2.5rem;
            }

            .carousel-box {
                max-width: 320px;
            }

            .contact-form {
                padding: 2.25rem;
                max-width: 90%;
            }
        }

        @media (max-width: 640px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }

            .holo-text {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar-custom fixed top-0 w-full z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a class="flex items-center space-x-2" href="">
                    <img src="{{ asset('modules/gpes/images/logo.png') }}" alt="GPES Logo" class="h-12">
                    <span class="text-white font-bold text-2xl font-['Orbitron']">GPES</span>
                </a>
                <button class="md:hidden text-white" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="hidden md:flex md:items-center md:space-x-8" id="navbarNav">
                    <ul class="flex space-x-8">
                        <li>
                            <a href="{{ route('descargar.gpes.pdf') }}" class="btn btn-primary">
    Descargar PDF
                            </a>
                        </li>
                        @auth
                            @if (checkRol('gpes.admin'))
                                <li>
                                    <a class="nav-link "
                                        href="{{ route('gpes.admin.dashboard') }}">
                                        Administrador
                                    </a>
                                </li>
                            @endif
                             @if (checkRol('gpes.vigilant'))
                                <li>
                                    <a class="nav-link"
                                        href="{{ route('gpes.admin.dashboard') }}">
                                        Vigilante 
                                    </a>
                                </li>
                            @endif
                            @if (checkRol('gpes.apprentice'))
                               <li>
                                    <a class="nav-link"
                                        href="{{ route('gpes.admin.dashboard') }}">
                                        Aprendiz 
                                    </a>
                                </li>
                            @endif
                            @if (checkRol('gpes.instructor'))
                               <li>
                                    <a class="nav-link"
                                        href="{{ route('gpes.admin.dashboard') }}">
                                        Instructor 
                                    </a>
                                </li>
                            @endif
                            @if (checkRol('gpes.pasante'))
                                <li>
                                    <a class="nav-link"
                                        href="{{ route('gpes.admin.dashboard') }}">
                                        Pasante
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <canvas id="particles"></canvas>
        <div class="container mx-auto px-4 text-center relative z-10 hero-content">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 holo-text">Bienvenido a GPES</h1>
            <p class="text-xl md:text-2xl mb-12 max-w-3xl mx-auto text-white font-['Roboto Mono']">
                Optimiza la gestión de inventarios con una plataforma intuitiva y moderna. Administra equipos, muebles,
                ambientes y préstamos con la máxima eficiencia.
            </p>
            <a href="#features" class="btn-primary text-lg" aria-label="Explora las características de GPES">Explora
                Ahora</a>
        </div>
    </section>

    <!-- Features Section (Carousel) -->
    <section class="features-section py-24" id="features">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-16 font-['Orbitron']">Características Principales
            </h2>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide flex items-center justify-center">
                        <div class="carousel-box text-center">
                            <div class="icon-circle mb-6">
                                <i class="fas fa-box-open fa-2.5x"></i>
                            </div>
                            <h5 class="text-2xl font-semibold mb-3 font-['Orbitron']">Gestión Centralizada</h5>
                            <p class="text-gray-600 text-base font-['Roboto Mono']">Controla todos tus recursos desde
                                una plataforma unificada y eficiente.</p>
                        </div>
                    </div>
                    <div class="swiper-slide flex items-center justify-center">
                        <div class="carousel-box text-center">
                            <div class="icon-circle mb-6">
                                <i class="fas fa-tachometer-alt fa-2.5x"></i>
                            </div>
                            <h5 class="text-2xl font-semibold mb-3 font-['Orbitron']">Rendimiento Ultrarrápido</h5>
                            <p class="text-gray-600 text-base font-['Roboto Mono']">Interfaz optimizada para operaciones
                                fluidas y rápidas.</p>
                        </div>
                    </div>
                    <div class="swiper-slide flex items-center justify-center">
                        <div class="carousel-box text-center">
                            <div class="icon-circle mb-6">
                                <i class="fas fa-user-check fa-2.5x"></i>
                            </div>
                            <h5 class="text-2xl font-semibold mb-3 font-['Orbitron']">Seguimiento en Tiempo Real</h5>
                            <p class="text-gray-600 text-base font-['Roboto Mono']">Monitorea préstamos y responsables
                                con datos actualizados al instante.</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination mt-10"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-16 font-['Orbitron']">Nuestras Categorías</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 justify-items-center">
                <div class="category-card" role="button" aria-label="Equipos">
                    <i class="fas fa-laptop fa-5x mb-6"></i>
                    <p class="text-gray-600 text-xl font-medium font-['Roboto Mono']">Equipos</p>
                </div>
                <div class="category-card" role="button" aria-label="Muebles">
                    <i class="fas fa-chair fa-5x mb-6"></i>
                    <p class="text-gray-600 text-xl font-medium font-['Roboto Mono']">Muebles</p>
                </div>
                <div class="category-card" role="button" aria-label="Ambientes">
                    <i class="fas fa-building fa-5x mb-6"></i>
                    <p class="text-gray-600 text-xl font-medium font-['Roboto Mono']">Ambientes</p>
                </div>
                <div class="category-card" role="button" aria-label="Préstamos">
                    <i class="fas fa-exchange-alt fa-5x mb-6"></i>
                    <p class="text-gray-600 text-xl font-medium font-['Roboto Mono']">Préstamos</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-6 px-4 text-center mt-12">
        <p class="text-lg font-semibold mb-4">Desarrollado por:</p>
        <div class="flex justify-center space-x-8 text-3xl">
            <button onclick="openModal('dev1Modal')">
                <i class="fas fa-user-circle hover:text-green-400"></i>
            </button>
            <button onclick="openModal('dev2Modal')">
                <i class="fas fa-user-circle hover:text-green-400"></i>
            </button>
        </div>
    </footer>

    <!-- Modal Desarrollador 1 -->
    <div id="dev1Modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl p-6 w-80 text-center shadow-lg relative">
            <button onclick="closeModal('dev1Modal')" class="absolute top-2 right-3 text-black text-2xl">×</button>
            <img src="{{ asset('modules/gpes/images/gif-anime-2.gif') }}" alt="GPES Logo" class="h-12">
            <h2 class="text-xl font-bold">xxxxxx</h2>
            <p class="text-gray-700">Desarrollador Frontend <br> pasante SENA</p>
        </div>
    </div>

    <!-- Modal Desarrollador 2 -->
    <div id="dev2Modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl p-6 w-80 text-center shadow-lg relative">
            <button onclick="closeModal('dev2Modal')" class="absolute top-2 right-3 text-black text-2xl">×</button>
            <img src="https://via.placeholder.com/120" alt="Dev 2" class="mx-auto rounded-full mb-4">
            <h2 class="text-xl font-bold">xxxxxxx</h2>
            <p class="text-gray-700">Desarrolladora Backend <br> pasante SENA</p>
        </div>
    </div>
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Opcional: cerrar al hacer clic fuera del modal
        window.addEventListener('click', function(e) {
            const modals = ['dev1Modal', 'dev2Modal'];
            modals.forEach(id => {
                const modal = document.getElementById(id);
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script>
        // Preloader
        function hidePreloader() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.animation = 'fadeOut 0.7s forwards';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 700);
            }
        }

        // Ensure preloader hides on load or after timeout
        window.addEventListener('load', () => {
            setTimeout(hidePreloader, 100);
        });

        // Fallback to hide preloader after 3 seconds
        setTimeout(hidePreloader, 3000);

        // Initialize Swiper
        try {
            const swiper = new Swiper(".mySwiper", {
                slidesPerView: 1,
                spaceBetween: 32,
                loop: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-prev",
                    prevEl: ".swiper-button-next",
                },
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });
        } catch (e) {
            console.error('Swiper initialization failed:', e);
        }

        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            try {
                const heroContent = document.querySelector('.hero-content');
                const scrollPosition = window.scrollY;
                heroContent.style.transform = `translateY(${scrollPosition * 0.18}px)`;
            } catch (e) {
                console.error('Parallax effect failed:', e);
            }
        });

        // Section fade-in on scroll
        try {
            const sections = document.querySelectorAll('section');
            const observerOptions = {
                threshold: 0.25
            };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        if (entry.target.classList.contains('hero-section')) {
                            const heroContent = entry.target.querySelector('.hero-content');
                            if (heroContent) {
                                heroContent.classList.add('visible');
                            }
                        }
                    }
                });
            }, observerOptions);
            sections.forEach(section => observer.observe(section));
        } catch (e) {
            console.error('Section observer failed:', e);
        }

        // Navbar toggle
        try {
            const toggleButton = document.querySelector('[data-toggle="collapse"]');
            if (toggleButton) {
                toggleButton.addEventListener('click', () => {
                    const navbar = document.getElementById('navbarNav');
                    navbar.classList.toggle('hidden');
                });
            }
        } catch (e) {
            console.error('Navbar toggle failed:', e);
        }

        // Subtle Digital Snowflake Animation without Trails
        try {
            const canvas = document.getElementById('particles');
            const ctx = canvas.getContext('2d');

            function resizeCanvas() {
                try {
                    const heroSection = document.querySelector('.hero-section');
                    if (heroSection) {
                        canvas.width = heroSection.offsetWidth;
                        canvas.height = heroSection.offsetHeight;
                    }
                } catch (e) {
                    console.error('Canvas resize failed:', e);
                }
            }

            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            const snowflakes = [];
            const numberOfSnowflakes = 50; // Subtle density

            class Snowflake {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * -canvas.height;
                    this.size = Math.random() * 6 + 3; // Small size
                    this.speedY = (Math.random() * 0.6 + 0.3) / 2; // Slower falling
                    this.speedX = Math.random() * 0.3 - 0.15; // Minimal drift
                    this.rotation = Math.random() * 360;
                    this.rotationSpeed = Math.random() * 0.01 - 0.005; // Slow rotation
                    this.opacity = Math.random() * 0.3 + 0.2; // Subtle opacity
                }
                update() {
                    this.y += this.speedY;
                    this.x += this.speedX;
                    this.rotation += this.rotationSpeed;
                    if (this.y > canvas.height) {
                        this.y = -this.size;
                        this.x = Math.random() * canvas.width;
                        this.opacity = Math.random() * 0.3 + 0.2;
                    }
                }
                draw() {
                    try {
                        ctx.save();
                        ctx.translate(this.x, this.y);
                        ctx.rotate(this.rotation);
                        const gradient = ctx.createRadialGradient(0, 0, 0, 0, 0, this.size);
                        gradient.addColorStop(0, `rgba(76, 175, 80, ${this.opacity})`);
                        gradient.addColorStop(1, `rgba(46, 125, 50, ${this.opacity * 0.5})`);
                        ctx.fillStyle = gradient;
                        ctx.shadowColor = `rgba(76, 175, 80, ${this.opacity})`;
                        ctx.shadowBlur = 8; // Soft glow
                        // Draw pixelated hexagon
                        ctx.beginPath();
                        for (let i = 0; i < 6; i++) {
                            const angle = (Math.PI / 3) * i;
                            const px = Math.cos(angle) * this.size;
                            const py = Math.sin(angle) * this.size;
                            ctx.lineTo(px, py);
                        }
                        ctx.closePath();
                        ctx.fill();
                        ctx.shadowBlur = 0;
                        ctx.restore();
                    } catch (e) {
                        console.error('Snowflake draw failed:', e);
                    }
                }
            }

            function initSnowflakes() {
                try {
                    for (let i = 0; i < numberOfSnowflakes; i++) {
                        snowflakes.push(new Snowflake());
                    }
                } catch (e) {
                    console.error('Snowflake initialization failed:', e);
                }
            }

            function animateSnowflakes() {
                try {
                    ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear canvas completely
                    snowflakes.forEach(snowflake => {
                        snowflake.update();
                        snowflake.draw();
                    });
                    requestAnimationFrame(animateSnowflakes);
                } catch (e) {
                    console.error('Snowflake animation failed:', e);
                }
            }

            initSnowflakes();
            animateSnowflakes();
        } catch (e) {
            console.error('Snowflake effect failed:', e);
        }

        // Contact Form
        function openContactForm() {
            try {
                const contactForm = document.getElementById('contactForm');
                if (contactForm) {
                    contactForm.classList.remove('hidden');
                    setTimeout(() => {
                        contactForm.querySelector('.contact-form').classList.add('visible');
                    }, 10);
                }
            } catch (e) {
                console.error('Open contact form failed:', e);
            }
        }

        function closeContactForm() {
            try {
                const contactForm = document.getElementById('contactForm');
                if (contactForm) {
                    contactForm.querySelector('.contact-form').classList.remove('visible');
                    setTimeout(() => {
                        contactForm.classList.add('hidden');
                    }, 500);
                }
            } catch (e) {
                console.error('Close contact form failed:', e);
            }
        }
    </script>
</body>

</html>
