<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" href="{{ asset('images/Favicon2.png') }}" type="image/x-icon">
        <title>SIBAF - Sistema de Gestión SENA</title>
        
        <!-- Google Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- OverlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/sibaf-styles.css') }}">
        <link rel="stylesheet" href="{{ asset('modules/sibaf/css/styles.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('modules/sibaf/js/script.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

        <style>
            /* SIBAF Dashboard - Estilos Profesionales con Azul Oscuro */
            :root {
                --primary-color: #1e3a8a;
                --primary-light: #3b82f6;
                --primary-dark: #1e40af;
                --secondary-color: #ff6b35;
                --accent-color: #06b6d4;
                --white: #ffffff;
                --light-gray: #f8f9fa;
                --medium-gray: #e9ecef;
                --dark-gray: #6c757d;
                --text-dark: #212529;
                --text-light: #6c757d;
                --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.1);
                --shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.15);
                --shadow-heavy: 0 8px 30px rgba(0, 0, 0, 0.2);
                --border-radius: 12px;
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Reset y Base */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                line-height: 1.6;
                color: var(--text-dark);
                background: var(--white);
                overflow-x: hidden;
            }

            /* Imagen en hero-section */
            .hero-section {
                position: relative;
                padding: 120px 0;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                overflow: hidden;
            }

            .hero-background {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: -1;
            }

            .hero-background img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                position: absolute;
                top: 0;
                left: 0;
            }

            .hero-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(30, 58, 138, 0.1), rgba(255, 255, 255, 0.9));
            }

            .hero-pattern {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: radial-gradient(circle at 25% 25%, rgba(30, 58, 138, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 75% 75%, rgba(255, 107, 53, 0.1) 0%, transparent 50%);
            }

            .hero-content {
                text-align: center;
                max-width: 800px;
                margin: 0 auto;
                position: relative;
                z-index: 1;
            }

            /* Navbar Profesional */
            .navbar-professional {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-bottom: 1px solid var(--medium-gray);
                padding: 0.5rem 0;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                transition: var(--transition);
            }

            .navbar-professional .container-fluid {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .navbar-brand {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .brand-logo {
                width: 40px;
                height: 40px;
                background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
                border-radius: var(--border-radius);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--white);
                font-size: 1.2rem;
            }

            .brand-text {
                display: flex;
                flex-direction: column;
            }

            .brand-name {
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--text-dark);
                line-height: 1;
            }

            .brand-subtitle {
                font-size: 0.75rem;
                color: var(--text-light);
                font-weight: 400;
            }

            .navbar-nav {
                display: flex;
                list-style: none;
                gap: 1rem;
                margin: 0;
            }

            .nav-item {
                position: relative;
            }

            .nav-link {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 8px 16px;
                color: var(--text-dark);
                text-decoration: none;
                font-weight: 500;
                font-size: 0.875rem;
                border-radius: var(--border-radius);
                transition: var(--transition);
                background: var(--white);
                border: 1px solid transparent;
            }

            .nav-link:hover,
            .nav-link.active {
                background: var(--primary-color);
                color: var(--white);
                transform: translateY(-2px);
                box-shadow: var(--shadow-medium);
            }

            .navbar-actions {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .btn-login,
            .btn-logout {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 8px 16px;
                background: var(--white);
                color: var(--primary-color);
                text-decoration: none;
                border: 2px solid var(--primary-color);
                border-radius: var(--border-radius);
                font-weight: 600;
                font-size: 0.875rem;
                transition: var(--transition);
                cursor: pointer;
            }

            .btn-login:hover,
            .btn-logout:hover {
                background: var(--primary-color);
                color: var(--white);
                transform: translateY(-2px);
                box-shadow: var(--shadow-medium);
            }

            /* Main Wrapper */
            .main-wrapper {
                margin-top: 70px;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(5px);
                min-height: calc(100vh - 70px);
            }

            /* Container */
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }

            .container-fluid {
                width: 100%;
                padding: 0 20px;
            }

            .hero-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 12px 24px;
                background: var(--white);
                border: 1px solid var(--medium-gray);
                border-radius: 50px;
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--text-dark);
                margin-bottom: 2rem;
                box-shadow: var(--shadow-light);
            }

            .hero-title {
                font-size: 4rem;
                font-weight: 800;
                margin-bottom: 1.5rem;
                line-height: 1.1;
            }

            .title-main {
                display: block;
                color: var(--text-dark);
            }

            .title-gradient {
                display: block;
                background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .hero-subtitle {
                font-size: 1.25rem;
                color: var(--text-light);
                margin-bottom: 3rem;
                line-height: 1.6;
            }

            .hero-stats {
                display: flex;
                justify-content: center;
                gap: 3rem;
                margin-bottom: 3rem;
            }

            .stat-item {
                text-align: center;
                padding: 1.5rem;
                background: var(--white);
                border-radius: var(--border-radius);
                box-shadow: var(--shadow-light);
                border: 1px solid var(--medium-gray);
            }

            .stat-number {
                display: block;
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--primary-color);
                line-height: 1;
            }

            .stat-label {
                font-size: 0.875rem;
                color: var(--text-light);
                font-weight: 500;
                margin-top: 0.5rem;
            }

            .hero-actions {
                display: flex;
                justify-content: center;
                gap: 1.5rem;
                flex-wrap: wrap;
            }

            .btn-primary,
            .btn-secondary {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                padding: 16px 32px;
                border-radius: var(--border-radius);
                font-weight: 600;
                text-decoration: none;
                transition: var(--transition);
                font-size: 1.1rem;
            }

            .btn-primary {
                background: var(--primary-color);
                color: var(--white);
                border: 2px solid var(--primary-color);
            }

            .btn-primary:hover {
                background: var(--primary-dark);
                transform: translateY(-3px);
                box-shadow: var(--shadow-heavy);
            }

            .btn-secondary {
                background: var(--white);
                color: var(--primary-color);
                border: 2px solid var(--primary-color);
            }

            .btn-secondary:hover {
                background: var(--primary-color);
                color: var(--white);
                transform: translateY(-3px);
                box-shadow: var(--shadow-heavy);
            }

            /* Features Section */
            .features-section {
                padding: 120px 0;
                background: var(--white);
                position: relative;
                overflow: hidden;
            }

            /* Agregando imagen de fondo fija */
            .features-background {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                z-index: -1;
                opacity: 0.1;
            }

            .features-background img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .section-header {
                text-align: center;
                margin-bottom: 4rem;
                position: relative;
                z-index: 2;
            }

            .section-title {
                font-size: 3rem;
                font-weight: 700;
                color: var(--text-dark);
                margin-bottom: 1rem;
            }

            .section-subtitle {
                font-size: 1.25rem;
                color: var(--text-light);
                max-width: 600px;
                margin: 0 auto;
            }

            /* Modificando grid para una sola fila horizontal */
            .features-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1.5rem;
                position: relative;
                z-index: 2;
            }

            /* Ajustando tamaño de las tarjetas para que sean más pequeñas */
            .feature-card {
                background: rgba(255, 255, 255, 0.95);
                padding: 1.5rem;
                border-radius: var(--border-radius);
                box-shadow: var(--shadow-light);
                border: 1px solid var(--medium-gray);
                transition: var(--transition);
                position: relative;
                overflow: hidden;
                backdrop-filter: blur(10px);
            }

            .feature-card:hover {
                transform: translateY(-8px);
                box-shadow: var(--shadow-heavy);
                border-color: var(--primary-color);
                background: rgba(255, 255, 255, 0.98);
            }

            /* Reduciendo tamaño del icono */
            .feature-icon {
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
                border-radius: var(--border-radius);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--white);
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            /* Ajustando tamaño de título */
            .feature-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--text-dark);
                margin-bottom: 0.75rem;
            }

            /* Reduciendo tamaño de descripción */
            .feature-description {
                color: var(--text-light);
                margin-bottom: 1rem;
                line-height: 1.5;
                font-size: 0.9rem;
            }

            .feature-metrics {
                display: flex;
                gap: 1rem;
            }

            /* Ajustando métricas para tarjetas más pequeñas */
            .metric {
                text-align: center;
                padding: 0.75rem;
                background: var(--light-gray);
                border-radius: var(--border-radius);
                flex: 1;
            }

            .metric-value {
                display: block;
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--primary-color);
            }

            .metric-label {
                font-size: 0.75rem;
                color: var(--text-light);
                margin-top: 0.25rem;
            }

            /* Agregando responsive para pantallas más pequeñas */
            @media (max-width: 1200px) {
                .features-grid {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 1.5rem;
                }
            }

            @media (max-width: 768px) {
                .features-grid {
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
                }
                
                .feature-card {
                    padding: 2rem;
                }
                
                .feature-icon {
                    width: 70px;
                    height: 70px;
                    font-size: 1.75rem;
                }
                
                .feature-title {
                    font-size: 1.5rem;
                }
                
                .feature-description {
                    font-size: 1rem;
                }
            }

            /* Technology Section */
            .technology-section {
                padding: 120px 0;
                background: var(--light-gray);
            }

            .tech-content {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
                align-items: center;
            }

            .tech-title {
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--text-dark);
                margin-bottom: 1.5rem;
            }

            .tech-description {
                font-size: 1.125rem;
                color: var(--text-light);
                margin-bottom: 2rem;
                line-height: 1.6;
            }

            .tech-features {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            .tech-feature {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1.5rem;
                background: var(--white);
                border-radius: var(--border-radius);
                box-shadow: var(--shadow-light);
            }

            .tech-feature i {
                font-size: 1.5rem;
                color: var(--primary-color);
                margin-top: 0.25rem;
            }

            .tech-feature h4 {
                font-size: 1.125rem;
                font-weight: 600;
                color: var(--text-dark);
                margin-bottom: 0.5rem;
            }

            .tech-feature p {
                color: var(--text-light);
                font-size: 0.875rem;
            }

            .tech-visual {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .tech-circle {
                position: relative;
                width: 300px;
                height: 300px;
            }

            .circle-layer {
                position: absolute;
                border-radius: 50%;
                border: 2px solid;
            }

            .layer-1 {
                width: 100%;
                height: 100%;
                border-color: var(--primary-color);
                opacity: 0.3;
                animation: rotate 20s linear infinite;
            }

            .layer-2 {
                width: 80%;
                height: 80%;
                top: 10%;
                left: 10%;
                border-color: var(--secondary-color);
                opacity: 0.5;
                animation: rotate 15s linear infinite reverse;
            }

            .layer-3 {
                width: 60%;
                height: 60%;
                top: 20%;
                left: 20%;
                border-color: var(--accent-color);
                opacity: 0.7;
                animation: rotate 10s linear infinite;
            }

            .tech-logo {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 80px;
                height: 80px;
                background: var(--white);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                color: var(--primary-color);
                box-shadow: var(--shadow-medium);
            }

            @keyframes rotate {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            /* SENA Section */
            .sena-section {
                padding: 120px 0;
                background: var(--white);
                text-align: center;
            }

            .sena-logo {
                width: 100px;
                height: 100px;
                background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--white);
                font-size: 3rem;
                margin: 0 auto 2rem;
            }

            .sena-title {
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--text-dark);
                margin-bottom: 1.5rem;
            }

            .sena-description {
                font-size: 1.125rem;
                color: var(--text-light);
                max-width: 800px;
                margin: 0 auto 3rem;
                line-height: 1.6;
            }

            .sena-stats {
                display: flex;
                justify-content: center;
                gap: 3rem;
                flex-wrap: wrap;
            }

            .sena-stat {
                text-align: center;
                padding: 2rem;
                background: var(--light-gray);
                border-radius: var(--border-radius);
                min-width: 200px;
            }

            .sena-stat .stat-number {
                display: block;
                font-size: 3rem;
                font-weight: 700;
                color: var(--primary-color);
                line-height: 1;
            }

            .sena-stat .stat-text {
                font-size: 1rem;
                color: var(--text-light);
                margin-top: 0.5rem;
            }

            /* CTA Section */
            .cta-section {
                padding: 120px 0;
                background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
                text-align: center;
                color: var(--white);
            }

            .cta-title {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .cta-description {
                font-size: 1.25rem;
                margin-bottom: 2rem;
                opacity: 0.9;
            }

            .cta-button {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                padding: 18px 36px;
                background: var(--white);
                color: var(--primary-color);
                text-decoration: none;
                border-radius: var(--border-radius);
                font-weight: 600;
                font-size: 1.125rem;
                transition: var(--transition);
            }

            .cta-button:hover {
                transform: translateY(-3px);
                box-shadow: var(--shadow-heavy);
            }

            /* Footer */
            .footer-professional {
                background: var(--white);
                border-top: 1px solid var(--medium-gray);
                padding: 4rem 0 2rem;
            }

            .footer-content {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 2rem;
                margin-bottom: 2rem;
            }

            .footer-logo {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 1rem;
            }

            .footer-logo i {
                font-size: 2rem;
                color: var(--primary-color);
            }

            .footer-logo span {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--text-dark);
            }

            .footer-description {
                color: var(--text-light);
                line-height: 1.6;
            }

            .footer-title {
                font-size: 1.125rem;
                font-weight: 600;
                color: var(--text-dark);
                margin-bottom: 1rem;
            }

            .footer-links {
                list-style: none;
            }

            .footer-links li {
                margin-bottom: 0.5rem;
            }

            .footer-links a {
                color: var(--text-light);
                text-decoration: none;
                transition: var(--transition);
            }

            .footer-links a:hover {
                color: var(--primary-color);
            }

            .footer-contact {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .contact-item {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                color: var(--text-light);
            }

            .contact-item i {
                color: var(--primary-color);
                width: 16px;
            }

            .footer-social {
                display: flex;
                gap: 1rem;
            }

            .social-link {
                width: 40px;
                height: 40px;
                background: var(--light-gray);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--text-light);
                text-decoration: none;
                transition: var(--transition);
            }

            .social-link:hover {
                background: var(--primary-color);
                color: var(--white);
                transform: translateY(-2px);
            }

            .footer-bottom {
                border-top: 1px solid var(--medium-gray);
                padding-top: 2rem;
                text-align: center;
            }

            .footer-copyright {
                color: var(--text-light);
                font-size: 0.875rem;
            }

            .footer-copyright p {
                margin-bottom: 0.5rem;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .navbar-nav {
                    display: none;
                }

                .brand-logo {
                    width: 35px;
                    height: 35px;
                    font-size: 1rem;
                }

                .brand-name {
                    font-size: 1.1rem;
                }

                .brand-subtitle {
                    font-size: 0.7rem;
                }

                .hero-title {
                    font-size: 2.5rem;
                }

                .hero-stats {
                    flex-direction: column;
                    gap: 1rem;
                }

                .hero-actions {
                    flex-direction: column;
                }

                .tech-content {
                    grid-template-columns: 1fr;
                    gap: 2rem;
                }

                .sena-stats {
                    flex-direction: column;
                    gap: 1rem;
                }

                .section-title {
                    font-size: 2rem;
                }

                .cta-title {
                    font-size: 2rem;
                }
            }

            @media (max-width: 480px) {
                .container {
                    padding: 0 15px;
                }

                .hero-section {
                    padding: 80px 0;
                }

                .features-section,
                .technology-section,
                .sena-section,
                .cta-section {
                    padding: 80px 0;
                }

                .hero-title {
                    font-size: 2rem;
                }

                .section-title {
                    font-size: 1.75rem;
                }
            }

            /* Animaciones adicionales */
            .feature-card,
            .tech-feature,
            .stat-item {
                animation: fadeInUp 0.6s ease-out;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Efectos de hover mejorados */
            .feature-card:hover .feature-icon {
                transform: scale(1.1);
                transition: var(--transition);
            }

            .tech-feature:hover {
                transform: translateX(10px);
                box-shadow: var(--shadow-medium);
            }

            /* Scrollbar personalizado */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: var(--light-gray);
            }

            ::-webkit-scrollbar-thumb {
                background: var(--primary-color);
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: var(--primary-dark);
            }

            /* Estilos para la sección de imagen fija */
            /* Agregando estilos para la imagen fija entre secciones */
            .fixed-image-section {
                height: 100vh;
                position: relative;
                overflow: hidden;
            }

            .fixed-image-container {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                z-index: -1;
            }

            .fixed-background-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }

            .fixed-image-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.3);
            }

            /* Ajustando responsive para pantallas más pequeñas */
        </style>
    </head>
    <body class="professional-layout">

        <!-- Navbar Profesional -->
        <nav class="navbar-professional" id="mainNavbar">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <div class="brand-logo">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="brand-text">
                        <span class="brand-name">SIBAF</span>
                        <span class="brand-subtitle">Sistema de Gestión SENA</span>
                    </div>
                </div>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    @auth
                        @if(checkRol('sibaf.admin'))
                            <li class="nav-item">
                                <a href="{{ route('sibaf.admin.welcome') }}"
                                    class="nav-link @if(Route::is('sibaf.admin.*')) active @endif">
                                    <i class="fas fa-user-shield"></i>
                                    <span>Administrador</span>
                                </a>
                            </li>
                        @endif
                        @if(checkRol('sibaf.soporte'))
                            <li class="nav-item">
                                <a href="{{ route('sibaf.soporte.welcomesoporte') }}"
                                    class="nav-link @if(Route::is('sibaf.soporte.*')) active @endif">
                                    <i class="fas fa-headset"></i>
                                    <span>Mesa de Ayuda</span>
                                </a>
                            </li>
                        @endif
                        @if(checkRol('sibaf.instructor'))
                            <li class="nav-item">
                                <a href="{{ route('sibaf.instructor.masterinstructor') }}"
                                    class="nav-link @if(Route::is('sibaf.instructor.*')) active @endif">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <span>Instructor</span>
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <div class="navbar-actions">
                    @guest
                        <a href="{{ route('login') }}" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Iniciar Sesión</span>
                        </a>
                    @else
                        <div class="user-menu">
                            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                @csrf
                                <button type="submit" class="btn-logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <!-- Contenido Principal -->
        <div class="main-wrapper">
            
            <!-- Hero Section Profesional -->
            <section class="hero-section">
                <div class="hero-background">
                    <img src="{{ asset('modules/sibaf/images/imagen.png') }}" class="d-block w-100" alt="SIBAF Hero Image">
                    <div class="hero-overlay"></div>
                    <div class="hero-pattern"></div>
                </div>
                
                <div class="container">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <i class="fas fa-award"></i>
                            <span>SENA - Servicio Nacional de Aprendizaje</span>
                        </div>
                        
                        <h1 class="hero-title">
                            <span class="title-main">SIBAF</span>
                            <span class="title-gradient">Sistema Integral</span>
                        </h1>
                        
                        <p class="hero-subtitle">
                            Plataforma avanzada para la gestión de bajas de ambiente y formación,
                            optimizando los procesos educativos del SENA con tecnología de vanguardia.
                        </p>
                        
                        <div class="hero-stats">
                            <div class="stat-item">
                                <div class="stat-number" data-target="95">0</div>
                                <div class="stat-label">% Eficiencia</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number" data-target="24">0</div>
                                <div class="stat-label">Horas Disponible</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number" data-target="100">0</div>
                                <div class="stat-label">% Confiable</div>
                            </div>
                        </div>
                        
                        <div class="hero-actions">
                            <a href="#features" class="btn-primary">
                                <span>Explorar Sistema</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="{{ route('login') }}" class="btn-secondary">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Acceder</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección de Características -->
            <section class="features-section" id="features">

                
                
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Funcionalidades del Sistema</h2>
                        <p class="section-subtitle">
                            Herramientas profesionales diseñadas para optimizar la gestión 
                            de ambientes y recursos formativos
                        </p>
                    </div>
                    
                    <!-- Las 4 tarjetas ahora están en una sola fila horizontal -->
                    <div class="features-grid">
                        <!-- Feature 1 -->
                        <div class="feature-card" data-feature="reportes">
                            <div class="feature-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h3 class="feature-title">Gestión de Reportes</h3>
                            <p class="feature-description">
                                Sistema integral para el registro, seguimiento y resolución 
                                de incidencias en ambientes formativos.
                            </p>
                            <div class="feature-metrics">
                                <div class="metric">
                                    <span class="metric-value">98%</span>
                                    <span class="metric-label">Resueltos</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-value">24h</span>
                                    <span class="metric-label">Promedio</span>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="feature-card" data-feature="equipos">
                            <div class="feature-icon">
                                <i class="fas fa-laptop"></i>
                            </div>
                            <h3 class="feature-title">Control de Equipos</h3>
                            <p class="feature-description">
                                Inventario digital y control de mantenimiento para 
                                equipos tecnológicos y recursos educativos.
                            </p>
                            <div class="feature-metrics">
                                <div class="metric">
                                    <span class="metric-value">1.2K</span>
                                    <span class="metric-label">Equipos</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-value">95%</span>
                                    <span class="metric-label">Operativos</span>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="feature-card" data-feature="estadisticas">
                            <div class="feature-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h3 class="feature-title">Analytics & Reportes</h3>
                            <p class="feature-description">
                                Análisis avanzado de datos con dashboards interactivos 
                                para la toma de decisiones estratégicas.
                            </p>
                            <div class="feature-metrics">
                                <div class="metric">
                                    <span class="metric-value">50+</span>
                                    <span class="metric-label">Reportes</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-value">100%</span>
                                    <span class="metric-label">Tiempo Real</span>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 4 -->
                        <div class="feature-card" data-feature="ambientes">
                            <div class="feature-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h3 class="feature-title">Gestión de Ambientes</h3>
                            <p class="feature-description">
                                Administración completa de espacios formativos, 
                                programación de horarios y control de ocupación.
                            </p>
                            <div class="feature-metrics">
                                <div class="metric">
                                    <span class="metric-value">45</span>
                                    <span class="metric-label">Ambientes</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-value">85%</span>
                                    <span class="metric-label">Ocupación</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección Tecnología -->
            <section class="technology-section">
                <div class="container">
                    <div class="tech-content">
                        <div class="tech-text">
                            <h2 class="tech-title">Tecnología de Vanguardia</h2>
                            <p class="tech-description">
                                SIBAF utiliza las últimas tecnologías para ofrecer una experiencia 
                                de usuario excepcional y garantizar la máxima eficiencia en la 
                                gestión de recursos educativos.
                            </p>
                            
                            <div class="tech-features">
                                <div class="tech-feature">
                                    <i class="fas fa-cloud"></i>
                                    <div>
                                        <h4>Cloud Computing</h4>
                                        <p>Acceso desde cualquier lugar con máxima seguridad</p>
                                    </div>
                                </div>
                                <div class="tech-feature">
                                    <i class="fas fa-mobile-alt"></i>
                                    <div>
                                        <h4>Responsive Design</h4>
                                        <p>Optimizado para todos los dispositivos</p>
                                    </div>
                                </div>
                                <div class="tech-feature">
                                    <i class="fas fa-shield-alt"></i>
                                    <div>
                                        <h4>Seguridad Avanzada</h4>
                                        <p>Protección de datos con estándares internacionales</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tech-visual">
                            <div class="tech-circle">
                                <div class="circle-layer layer-1"></div>
                                <div class="circle-layer layer-2"></div>
                                <div class="circle-layer layer-3"></div>
                                <div class="tech-logo">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección SENA -->
            <section class="sena-section">
                <div class="container">
                    <div class="sena-content">
                        <div class="sena-logo">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h2 class="sena-title">Formación para el Trabajo</h2>
                        <p class="sena-description">
                            El SENA ofrece formación gratuita a millones de colombianos del sector productivo, 
                            fortaleciendo las competencias laborales y promoviendo el desarrollo tecnológico 
                            y la innovación en todos los sectores económicos del país.
                        </p>
                        <div class="sena-stats">
                            <div class="sena-stat">
                                <span class="stat-number">9M+</span>
                                <span class="stat-text">Colombianos formados</span>
                            </div>
                            <div class="sena-stat">
                                <span class="stat-number">117</span>
                                <span class="stat-text">Centros de formación</span>
                            </div>
                            <div class="sena-stat">
                                <span class="stat-number">100%</span>
                                <span class="stat-text">Gratuito</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="cta-section">
                <div class="container">
                    <div class="cta-content">
                        <h2 class="cta-title">¿Listo para optimizar tu gestión educativa?</h2>
                        <p class="cta-description">
                            Únete a los cientos de instructores y administradores que ya confían en SIBAF
                        </p>
                        <a href="{{ route('login') }}" class="cta-button">
                            <span>Iniciar Ahora</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer Profesional -->
        <footer class="footer-professional">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <div class="footer-logo">
                            <i class="fas fa-graduation-cap"></i>
                            <span>SIBAF</span>
                        </div>
                        <p class="footer-description">
                            Sistema Integral de Bajas de Ambiente y Formación. 
                            Innovación tecnológica para la educación del futuro.
                        </p>
                    </div>
                    
                    <div class="footer-section">
                        <h4 class="footer-title">Accesos Rápidos</h4>
                        <ul class="footer-links">
                            <li><a href="{{ route('login') }}">Inicio</a></li>
                            @auth
                                @if(checkRol('sibaf.admin'))
                                    <li><a href="{{ route('sibaf.admin.welcome') }}">Panel Admin</a></li>
                                @endif
                                @if(checkRol('sibaf.soporte'))
                                    <li><a href="{{ route('sibaf.soporte.welcomesoporte') }}">Mesa de Ayuda</a></li>
                                @endif
                                @if(checkRol('sibaf.instructor'))
                                    <li><a href="{{ route('sibaf.instructor.masterinstructor') }}">Portal Instructor</a></li>
                                @endif
                            @endauth
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h4 class="footer-title">Contacto</h4>
                        <div class="footer-contact">
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span>soporte@sena.edu.co</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <span>+57 1 5461500</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Bogotá D.C., Colombia</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="footer-section">
                        <h4 class="footer-title">Síguenos</h4>
                        <div class="footer-social">
                            <a href="#" class="social-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <div class="footer-copyright">
                        <p>&copy; 2023-2025 SENA - Todos los derechos reservados</p>
                        <p>SIBAF v3.2.0 - Sistema desarrollado para la excelencia educativa</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/dist/js/adminlte.js') }}"></script>
        <script>
            // ===== SIBAF PROFESSIONAL SCRIPTS =====
            document.addEventListener('DOMContentLoaded', function() {
                console.log('🚀 SIBAF Professional System Loading...');
                
                // ===== INICIALIZACIÓN PRINCIPAL =====
                initializeSystem();
                
                function initializeSystem() {
                    initializeNavbar();
                    initializeHeroAnimations();
                    initializeCounters();
                    initializeFeatureCards();
                    initializeSmoothScroll();
                    initializeScrollAnimations();
                    initializeParallax();
                    initializeLazyLoading();
                    
                    console.log('✅ SIBAF System Initialized Successfully!');
                }
                
                // ===== NAVBAR PROFESIONAL =====
                function initializeNavbar() {
                    const navbar = document.getElementById('mainNavbar');
                    let scrolled = false;
                    
                    function updateNavbar() {
                        const scrollTop = window.pageYOffset;
                        
                        if (scrollTop > 50 && !scrolled) {
                            navbar.style.background = 'rgba(30, 41, 59, 0.98)';
                            navbar.style.backdropFilter = 'blur(20px)';
                            navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.15)';
                            scrolled = true;
                        } else if (scrollTop <= 50 && scrolled) {
                            navbar.style.background = 'rgba(30, 41, 59, 0.95)';
                            navbar.style.backdropFilter = 'blur(20px)';
                            navbar.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
                            scrolled = false;
                        }
                    }
                    
                    // Throttled scroll handler
                    let ticking = false;
                    window.addEventListener('scroll', function() {
                        if (!ticking) {
                            requestAnimationFrame(function() {
                                updateNavbar();
                                ticking = false;
                            });
                            ticking = true;
                        }
                    });
                    
                    // Active link highlighting
                    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
                    const sections = document.querySelectorAll('section[id]');
                    
                    function highlightActiveSection() {
                        const scrollPosition = window.pageYOffset + 100;
                        
                        sections.forEach(section => {
                            const sectionTop = section.offsetTop;
                            const sectionHeight = section.offsetHeight;
                            const sectionId = section.getAttribute('id');
                            
                            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                                navLinks.forEach(link => {
                                    link.classList.remove('active');
                                    if (link.getAttribute('href') === `#${sectionId}`) {
                                        link.classList.add('active');
                                    }
                                });
                            }
                        });
                    }
                    
                    window.addEventListener('scroll', highlightActiveSection);
                }
                
                // ===== ANIMACIONES DEL HERO =====
                function initializeHeroAnimations() {
                    const heroElements = [
                        '.hero-badge',
                        '.hero-title',
                        '.hero-subtitle',
                        '.hero-stats',
                        '.hero-actions'
                    ];
                    
                    // Trigger animations on load
                    setTimeout(() => {
                        heroElements.forEach((selector, index) => {
                            const element = document.querySelector(selector);
                            if (element) {
                                element.style.animationDelay = `${0.2 + index * 0.2}s`;
                                element.classList.add('animate-fade-in');
                            }
                        });
                    }, 100);
                    
                    // Typing effect for title
                    const titleMain = document.querySelector('.title-main');
                    if (titleMain) {
                        const text = titleMain.textContent;
                        titleMain.textContent = '';
                        titleMain.style.borderRight = '2px solid #3b82f6';
                        
                        let i = 0;
                        const typeWriter = () => {
                            if (i < text.length) {
                                titleMain.textContent += text.charAt(i);
                                i++;
                                setTimeout(typeWriter, 150);
                            } else {
                                setTimeout(() => {
                                    titleMain.style.borderRight = 'none';
                                }, 500);
                            }
                        };
                        
                        setTimeout(typeWriter, 800);
                    }
                }
                
                // ===== CONTADORES ANIMADOS =====
                function initializeCounters() {
                    const counters = document.querySelectorAll('.stat-number[data-target]');
                    const observerOptions = {
                        threshold: 0.7,
                        rootMargin: '0px 0px -50px 0px'
                    };
                    
                    const counterObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                animateCounter(entry.target);
                                counterObserver.unobserve(entry.target);
                            }
                        });
                    }, observerOptions);
                    
                    counters.forEach(counter => {
                        counterObserver.observe(counter);
                    });
                    
                    function animateCounter(element) {
                        const target = parseInt(element.getAttribute('data-target'));
                        const duration = 2000;
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
                }
                
                // ===== TARJETAS DE CARACTERÍSTICAS INTERACTIVAS =====
                function initializeFeatureCards() {
                    const featureCards = document.querySelectorAll('.feature-card');
                    
                    featureCards.forEach(card => {
                        // Hover effect with 3D transform
                        card.addEventListener('mouseenter', function() {
                            this.style.transform = 'translateY(-8px) rotateX(2deg) rotateY(2deg)';
                            this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                            
                            // Icon animation
                            const icon = this.querySelector('.feature-icon');
                            if (icon) {
                                icon.style.transform = 'scale(1.1) rotate(5deg)';
                                icon.style.transition = 'all 0.3s ease';
                            }
                            
                            // Metric animation
                            const metrics = this.querySelectorAll('.metric-value');
                            metrics.forEach((metric, index) => {
                                setTimeout(() => {
                                    metric.style.transform = 'scale(1.1)';
                                    metric.style.color = '#3b82f6';
                                }, index * 100);
                            });
                        });
                        
                        card.addEventListener('mouseleave', function() {
                            this.style.transform = 'translateY(0) rotateX(0) rotateY(0)';
                            
                            const icon = this.querySelector('.feature-icon');
                            if (icon) {
                                icon.style.transform = 'scale(1) rotate(0deg)';
                            }
                            
                            const metrics = this.querySelectorAll('.metric-value');
                            metrics.forEach(metric => {
                                metric.style.transform = 'scale(1)';
                                metric.style.color = '#3b82f6';
                            });
                        });
                        
                        // Click effect
                        card.addEventListener('click', function() {
                            this.style.transform = 'scale(0.98)';
                            setTimeout(() => {
                                this.style.transform = 'translateY(-8px)';
                            }, 150);
                            
                            // Show feature details (could be expanded)
                            showFeatureDetails(this.getAttribute('data-feature'));
                        });
                    });
                    
                    function showFeatureDetails(featureType) {
                        const featureData = {
                            reportes: {
                                title: 'Gestión Avanzada de Reportes',
                                description: 'Sistema completo para el manejo de incidencias con seguimiento en tiempo real.',
                                features: ['Reportes automáticos', 'Seguimiento en tiempo real', 'Notificaciones push']
                            },
                            equipos: {
                                title: 'Control Inteligente de Equipos',
                                description: 'Inventario digital con predicción de mantenimiento basada en IA.',
                                features: ['Inventario automatizado', 'Mantenimiento predictivo', 'QR Code tracking']
                            },
                            estadisticas: {
                                title: 'Analytics Empresarial',
                                description: 'Dashboards interactivos con inteligencia de negocios integrada.',
                                features: ['Dashboards en tiempo real', 'Exportación automática', 'Análisis predictivo']
                            },
                            ambientes: {
                                title: 'Gestión Inteligente de Espacios',
                                description: 'Optimización de espacios formativos con algoritmos de eficiencia.',
                                features: ['Programación automática', 'Optimización de recursos', 'Control de aforo']
                            }
                        };
                        
                        const data = featureData[featureType];
                        if (data && typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: data.title,
                                html: `
                                    <div style="text-align: left; margin: 20px 0;">
                                        <p style="color: #64748b; margin-bottom: 15px;">${data.description}</p>
                                        <h4 style="color: #1e293b; margin-bottom: 10px;">Características principales:</h4>
                                        <ul style="color: #475569;">
                                            ${data.features.map(feature => `<li style="margin-bottom: 5px;">${feature}</li>`).join('')}
                                        </ul>
                                    </div>
                                `,
                                icon: 'info',
                                confirmButtonText: 'Entendido',
                                confirmButtonColor: '#3b82f6',
                                customClass: {
                                    popup: 'feature-modal'
                                }
                            });
                        }
                    }
                }
                
                // ===== SCROLL SUAVE Y NAVEGACIÓN =====
                function initializeSmoothScroll() {
                    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                        anchor.addEventListener('click', function (e) {
                            e.preventDefault();
                            const targetId = this.getAttribute('href');
                            const targetElement = document.querySelector(targetId);
                            
                            if (targetElement) {
                                const headerOffset = 80;
                                const elementPosition = targetElement.offsetTop;
                                const offsetPosition = elementPosition - headerOffset;
                                
                                window.scrollTo({
                                    top: offsetPosition,
                                    behavior: 'smooth'
                                });
                                
                                // Update URL without jumping
                                history.pushState(null, null, targetId);
                            }
                        });
                    });
                }
                
                // ===== ANIMACIONES DE SCROLL =====
                function initializeScrollAnimations() {
                    const observerOptions = {
                        threshold: 0.1,
                        rootMargin: '0px 0px -50px 0px'
                    };
                    
                    const scrollObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('animate-fade-in');
                                
                                // Staggered animation for child elements
                                const children = entry.target.querySelectorAll('.feature-card, .tech-feature, .sena-stat');
                                children.forEach((child, index) => {
                                    setTimeout(() => {
                                        child.style.opacity = '1';
                                        child.style.transform = 'translateY(0)';
                                    }, index * 100);
                                });
                            }
                        });
                    }, observerOptions);
                    
                    // Observe sections for animations
                    document.querySelectorAll('section, .feature-card, .tech-feature').forEach(el => {
                        scrollObserver.observe(el);
                    });
                    
                    // Prepare elements for animation
                    document.querySelectorAll('.feature-card, .tech-feature').forEach(el => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(30px)';
                        el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    });
                }
                
                // ===== EFECTO PARALLAX SUTIL =====
                function initializeParallax() {
                    const parallaxElements = document.querySelectorAll('.hero-pattern, .tech-circle');
                    
                    let ticking = false;
                    
                    function updateParallax() {
                        const scrolled = window.pageYOffset;
                        const rate = scrolled * -0.3;
                        const rateRotate = scrolled * 0.1;
                        
                        parallaxElements.forEach((element, index) => {
                            if (element.classList.contains('hero-pattern')) {
                                element.style.transform = `translateY(${rate}px) rotate(${rateRotate}deg)`;
                            } else if (element.classList.contains('tech-circle')) {
                                element.style.transform = `translateY(${rate * 0.5}px)`;
                            }
                        });
                        
                        ticking = false;
                    }
                    
                    window.addEventListener('scroll', function() {
                        if (!ticking) {
                            requestAnimationFrame(updateParallax);
                            ticking = true;
                        }
                    });
                }
                
                // ===== LAZY LOADING DE IMÁGENES =====
                function initializeLazyLoading() {
                    if ('IntersectionObserver' in window) {
                        const imageObserver = new IntersectionObserver((entries, observer) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    const img = entry.target;
                                    img.src = img.dataset.src;
                                    img.classList.remove('lazy');
                                    imageObserver.unobserve(img);
                                }
                            });
                        });
                        
                        document.querySelectorAll('img[data-src]').forEach(img => {
                            imageObserver.observe(img);
                        });
                    }
                }
                
                // ===== MANEJO DE FORMULARIOS =====
                function initializeForms() {
                    const forms = document.querySelectorAll('form');
                    
                    forms.forEach(form => {
                        form.addEventListener('submit', function(e) {
                            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                            
                            if (submitBtn) {
                                const originalText = submitBtn.innerHTML;
                                submitBtn.disabled = true;
                                submitBtn.innerHTML = `
                                    <i class="fas fa-spinner fa-spin" style="margin-right: 0.5rem;"></i>
                                    Procesando...
                                `;
                                
                                // Restore button after 3 seconds (fallback)
                                setTimeout(() => {
                                    if (submitBtn.disabled) {
                                        submitBtn.disabled = false;
                                        submitBtn.innerHTML = originalText;
                                    }
                                }, 3000);
                            }
                        });
                    });
                }
                
                // ===== NOTIFICACIONES Y ALERTAS =====
                function initializeNotifications() {
                    // Global notification system
                    window.SIBAF = window.SIBAF || {};
                    
                    window.SIBAF.notify = function(message, type = 'success', duration = 4000) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: duration,
                                timerProgressBar: true,
                                icon: type,
                                title: message,
                                background: type === 'success' ? '#f0f9ff' : '#fef2f2',
                                color: type === 'success' ? '#1e40af' : '#dc2626',
                                customClass: {
                                    popup: 'professional-toast'
                                }
                            });
                        } else {
                            // Fallback notification
                            createFallbackNotification(message, type, duration);
                        }
                    };
                    
                    window.SIBAF.confirm = function(title, message, callback) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: title,
                                text: message,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3b82f6',
                                cancelButtonColor: '#ef4444',
                                confirmButtonText: 'Confirmar',
                                cancelButtonText: 'Cancelar',
                                customClass: {
                                    popup: 'professional-confirm'
                                }
                            }).then((result) => {
                                if (result.isConfirmed && callback) {
                                    callback();
                                }
                            });
                        }
                    };
                    
                    function createFallbackNotification(message, type, duration) {
                        const notification = document.createElement('div');
                        notification.className = `notification notification-${type}`;
                        notification.style.cssText = `
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            background: ${type === 'success' ? '#3b82f6' : '#ef4444'};
                            color: white;
                            padding: 1rem 1.5rem;
                            border-radius: 0.5rem;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                            z-index: 10000;
                            font-family: inherit;
                            font-weight: 500;
                            transform: translateX(100%);
                            transition: transform 0.3s ease;
                        `;
                        notification.textContent = message;
                        
                        document.body.appendChild(notification);
                        
                        setTimeout(() => {
                            notification.style.transform = 'translateX(0)';
                        }, 100);
                        
                        setTimeout(() => {
                            notification.style.transform = 'translateX(100%)';
                            setTimeout(() => {
                                document.body.removeChild(notification);
                            }, 300);
                        }, duration);
                    }
                }
                
                // ===== PERFORMANCE OPTIMIZATION =====
                function initializePerformance() {
                    // Prefetch important routes
                    const importantLinks = document.querySelectorAll('a[href*="login"], a[href*="admin"], a[href*="soporte"], a[href*="instructor"]');
                    importantLinks.forEach(link => {
                        link.addEventListener('mouseenter', function() {
                            const linkEl = document.createElement('link');
                            linkEl.rel = 'prefetch';
                            linkEl.href = this.href;
                            document.head.appendChild(linkEl);
                        });
                    });
                    
                    // Lazy load non-critical CSS
                    const nonCriticalCSS = document.querySelectorAll('link[rel="stylesheet"][data-lazy]');
                    nonCriticalCSS.forEach(css => {
                        const media = css.getAttribute('media');
                        css.setAttribute('media', 'none');
                        css.onload = function() {
                            this.setAttribute('media', media || 'all');
                        };
                    });
                }
                
                // ===== ACCESSIBILITY ENHANCEMENTS =====
                function initializeAccessibility() {
                    // Skip to main content
                    const skipLink = document.createElement('a');
                    skipLink.href = '#main-content';
                    skipLink.textContent = 'Saltar al contenido principal';
                    skipLink.className = 'skip-link';
                    skipLink.style.cssText = `
                        position: absolute;
                        top: -40px;
                        left: 6px;
                        background: #000;
                        color: white;
                        padding: 8px;
                        text-decoration: none;
                        z-index: 100000;
                        border-radius: 4px;
                    `;
                    skipLink.addEventListener('focus', function() {
                        this.style.top = '6px';
                    });
                    skipLink.addEventListener('blur', function() {
                        this.style.top = '-40px';
                    });
                    
                    document.body.insertBefore(skipLink, document.body.firstChild);
                    
                    // Enhanced keyboard navigation
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Tab') {
                            document.body.classList.add('keyboard-navigation');
                        }
                    });
                    
                    document.addEventListener('mousedown', function() {
                        document.body.classList.remove('keyboard-navigation');
                    });
                }
                
                // ===== INICIALIZAR MÓDULOS ADICIONALES =====
                initializeForms();
                initializeNotifications();
                initializePerformance();
                initializeAccessibility();
                
                // ===== DEBUG MODE (Solo desarrollo) =====
                if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                    console.log('🔧 Debug mode enabled');
                    window.SIBAF.debug = true;
                    
                    // Performance metrics
                    window.addEventListener('load', function() {
                        setTimeout(() => {
                            const navTiming = performance.getEntriesByType('navigation')[0];
                            console.log(`📊 Page load time: ${Math.round(navTiming.loadEventEnd - navTiming.fetchStart)}ms`);
                        }, 0);
                    });
                }
                
                // ===== CLEANUP ON UNLOAD =====
                window.addEventListener('beforeunload', function() {
                    // Remove event listeners
                    window.removeEventListener('scroll', updateNavbar);
                    window.removeEventListener('scroll', highlightActiveSection);
                    
                    console.log('🧹 SIBAF System cleaned up');
                });
                
                // ===== SYSTEM READY =====
                setTimeout(() => {
                    document.body.classList.add('system-ready');
                    console.log('🎉 SIBAF Professional System Ready!');
                    
                    // Optional: Show welcome message
                    if (window.SIBAF && window.SIBAF.debug) {
                        window.SIBAF.notify('Sistema SIBAF cargado correctamente', 'success', 2000);
                    }
                }, 500);
            });
        </script>
    </body>
    </html>
