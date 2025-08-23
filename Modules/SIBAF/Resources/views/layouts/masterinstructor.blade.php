<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Instructor | Sistema de Gestión @yield('title')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active, .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
            background-color: rgba(255,255,255,.1);
            color: #fff;
        }

        /* Color de fondo del sidebar */
        .main-sidebar.sidebar-dark-primary {
            background-color: #0d2042 !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('cefa.sibaf.index') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Panel de Instructor</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Buscar..." aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">3 Notificaciones</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> Nuevo mensaje
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-user-circle"></i>
                    <span class="d-none d-md-inline">{{ Auth::user()->nickname ?? 'Usuario' }}</span>
                </a>
                <!-- Simplificado el menú de cerrar sesión, quitado color azul y hecho más pequeño -->
                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
         
                    <li class="user-footer text-center py-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <a href="#" onclick="this.closest('form').submit(); return false;" class="text-muted" style="text-decoration: none; font-size: 0.9rem;">
                                <i class="fas fa-sign-out-alt mr-1"></i> Cerrar Sesión
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Agregué icono de sistema de gestión (teléfono) -->
        <a href="#" class="brand-link">
            <i class="fas fa-phone-alt brand-image img-circle elevation-3" style="opacity: .8; margin-left: 10px; margin-right: 10px;"></i>
            <span class="brand-text font-weight-light">Sistema de Gestión</span>
        </a>

        <div class="sidebar">
            <!-- Cambié la imagen por un icono de panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-tie img-circle elevation-2" style="font-size: 2.1rem; color: #fff; background: #007bff; padding: 0.5rem; border-radius: 50%; width: 2.1rem; height: 2.1rem; display: flex; align-items: center; justify-content: center;"></i>
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->nickname ?? 'Usuario' }}</a>
                </div>
            </div>

            <!-- Solo dejé las 3 opciones solicitadas con iconos apropiados para instructor -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('sibaf.instructor.masterinstructor') }}" class="nav-link {{ Route::is('sibaf.instructor.masterinstructor') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>Panel Principal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sibaf.instructor.inventory.index') }}" class="nav-link {{ Route::is('sibaf.instructor.inventory.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Inventario de Equipos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="modal" data-target="#configModal">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Configuración</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @yield('content')
                
                <!-- Dashboard Simple del Instructor - Solo se muestra en Panel Principal -->
                @if(Route::is('sibaf.instructor.masterinstructor'))
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-sm">
                            <div class="card-body text-center py-4">
                                <div class="mb-3">
                                    <i class="fas fa-chalkboard-teacher fa-3x" style="color: #1a365d;"></i>
                                </div>
                                <h2 class="text-dark mb-2">Bienvenido al Sistema SIBAF</h2>
                                <p class="text-muted mb-4" style="font-size: 1.1rem;">
                                    Sistema de Inventario y Baja de Equipos de Formación
                                </p>
                                
                                <!-- Información del Sistema -->
                                <div class="row mt-4">
                                     <div class="col-md-4">
                                         <div class="text-center p-3">
                                             <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                                             <h4 class="text-dark">Reportes</h4>
                                             <p class="text-muted">Registro de reportes</p>
                                         </div>
                                     </div>
                                    <div class="col-md-4">
                                        <div class="text-center p-3">
                                            <i class="fas fa-user-tie fa-2x text-success mb-2"></i>
                                                                                         <h4 class="text-dark">Usuario</h4>
                                             <p class="text-muted">{{ Auth::user()->nickname ?? 'Instructor' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center p-3">
                                            <i class="fas fa-calendar-alt fa-2x text-info mb-2"></i>
                                                                                         <h4 class="text-dark">Fecha</h4>
                                             <p class="text-muted">{{ date('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Información del Equipo -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="alert alert-light border">
                                                                                         <h5 class="text-dark mb-2">
                                                 <i class="fas fa-info-circle text-info mr-2"></i>
                                                 Información del Proyecto
                                             </h5>
                                             <p class="text-muted mb-0">
                                                Este sistema permite gestionar el inventario de equipos tecnológicos, 
                                                realizar reportes de daños y controlar el proceso de bajas de equipos 
                                                en el centro de formación.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>Sistema de Gestión &copy; 2023.</strong>
        Todos los derechos reservados.
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- Incluir el modal de configuración -->
@include('sibaf::config.modal')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/jquery.overlayScrollbars.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
