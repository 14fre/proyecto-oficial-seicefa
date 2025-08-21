<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de Gestión | Mesa de Ayuda</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
  <!-- OverlayScrollbars -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    /* Estilos personalizados */
    .main-sidebar {
      background-color: #172b4d;
    }

    .brand-link .nav-icon {
      color: #fff;
    }

    .user-panel .image i {
      color: #007bff;
      font-size: 2rem;
    }

    /* Reemplazando estilos de tarjetas por carousel SENA profesional */
    .sena-carousel {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 0;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      border: 1px solid #e9ecef;
    }

    .sena-card {
      padding: 2rem 1.5rem;
      text-align: center;
      color: #495057;
      min-height: 140px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
    }

    .sena-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(108,117,125,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
      opacity: 0.5;
    }

    .sena-card-content {
      position: relative;
      z-index: 2;
    }

    .sena-icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .sena-title {
      font-size: 1.4rem;
      font-weight: 600;
      margin-bottom: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #343a40;
    }

    .sena-description {
      font-size: 0.9rem;
      opacity: 0.8;
      line-height: 1.4;
      margin-bottom: 1rem;
      color: #6c757d;
    }

    .carousel-control-prev,
    .carousel-control-next {
      width: 5%;
      color: #6c757d;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      background-color: rgba(108, 117, 125, 0.8);
      border-radius: 50%;
      padding: 15px;
      transition: all 0.3s ease;
    }

    .carousel-control-prev-icon:hover,
    .carousel-control-next-icon:hover {
      background-color: #6c757d;
      transform: scale(1.05);
    }

    .carousel-indicators {
      bottom: 10px;
    }

    .carousel-indicators li {
      background-color: rgba(108, 117, 125, 0.5);
      border-radius: 50%;
      width: 10px;
      height: 10px;
      margin: 0 4px;
    }

    .carousel-indicators .active {
      background-color: #007bff;
    }

    /* Colores sutiles y profesionales para cada slide */
    .slide-aprendices {
      background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
      border-left: 4px solid #28a745;
    }

    .slide-programas {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-left: 4px solid #007bff;
    }

    .slide-instructores {
      background: linear-gradient(135deg, #ffffff 0%, #f1f3f4 100%);
      border-left: 4px solid #17a2b8;
    }

    .slide-centros {
      background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
      border-left: 4px solid #28a745;
    }

    .slide-certificaciones {
      background: linear-gradient(135deg, #f1f3f4 0%, #f8f9fa 100%);
      border-left: 4px solid #6c757d;
    }

    /* Iconos con colores específicos por slide */
    .slide-aprendices .sena-icon {
      color: #28a745;
    }

    .slide-programas .sena-icon {
      color: #007bff;
    }

    .slide-instructores .sena-icon {
      color: #17a2b8;
    }

    .slide-centros .sena-icon {
      color: #28a745;
    }

    .slide-certificaciones .sena-icon {
      color: #6c757d;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sena-card {
        padding: 1.5rem 1rem;
        min-height: 120px;
      }

      .sena-icon {
        font-size: 2rem;
      }

      .sena-title {
        font-size: 1.2rem;
      }

      .carousel-control-prev,
      .carousel-control-next {
        gap: 1rem;
      }

      .sena-stat-number {
        font-size: 1.5rem;
      }
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('cefa.sibaf.index') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Mesa de Ayuda</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Pantalla Completa">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-headset"></i>
            <span class="badge badge-danger navbar-badge">1</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">5 Notificaciones</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-desktop mr-2"></i> Nuevo reporte de equipo
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
          </div>
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
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <i class="nav-icon fas fa-headset mr-2"></i>
        <span class="brand-text font-weight-light">MESA DE AYUDA</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <i class="fas fa-headset"></i>
          </div>
          <div class="info">
            <a href="#" class="d-block">Usuario de Ejemplo</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Panel Principal</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>Configuración</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Panel Soporte</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </div>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Sección carousel SENA profesional reemplazando las tarjetas múltiples -->
          <div class="sena-carousel">
            <div id="senaCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">
              <ol class="carousel-indicators">
                <li data-target="#senaCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#senaCarousel" data-slide-to="1"></li>
                <li data-target="#senaCarousel" data-slide-to="2"></li>
                <li data-target="#senaCarousel" data-slide-to="3"></li>
                <li data-target="#senaCarousel" data-slide-to="4"></li>
              </ol>

              <div class="carousel-inner">
                <!-- Slide 1: Reportes Activos -->
                <div class="carousel-item active">
                  <div class="sena-card slide-aprendices">
                    <div class="carousel-item-content">
                      <i class="fas fa-clipboard-list sena-icon"></i>
                      <h4 class="sena-title">Reportes Activos</h4>
                      <p class="sena-description">Gestión y seguimiento de todos los reportes del sistema</p>
                    </div>
                  </div>
                </div>

                <!-- Slide 2: Inventario de Equipos -->
                <div class="carousel-item">
                  <div class="sena-card slide-programas">
                    <div class="carousel-item-content">
                      <i class="fas fa-boxes sena-icon"></i>
                      <h4 class="sena-title">Inventario de Equipos</h4>
                      <p class="sena-description">Control y seguimiento del inventario de equipos tecnológicos y recursos del sistema.</p>
                    </div>
                  </div>
                </div>

                <!-- Slide 3: Tickets de Soporte -->
                <div class="carousel-item">
                  <div class="sena-card slide-instructores">
                    <div class="carousel-item-content">
                      <i class="fas fa-headset sena-icon"></i>
                      <h4 class="sena-title">Tickets de Soporte</h4>
                      <p class="sena-description">Administración de tickets de soporte técnico y atención al usuario final.</p>
                    </div>
                  </div>
                </div>

                <!-- Slide 4: Panel de Control -->
                <div class="carousel-item">
                  <div class="sena-card slide-centros">
                    <div class="carousel-item-content">
                      <i class="fas fa-tachometer-alt sena-icon"></i>
                      <h4 class="sena-title">Panel de Control</h4>
                      <p class="sena-description">Monitoreo y control centralizado de todos los procesos del sistema de soporte.</p>
                    </div>
                  </div>
                </div>

                <!-- Slide 5: Reportes Generados -->
                <div class="carousel-item">
                  <div class="sena-card slide-certificaciones">
                    <div class="carousel-item-content">
                      <i class="fas fa-chart-bar sena-icon"></i>
                      <h4 class="sena-title">Reportes Generados</h4>
                      <p class="sena-description">Generación y análisis de reportes detallados del sistema de gestión de soporte.</p>
                    </div>
                  </div>
                </div>
              </div>

              <a class="carousel-control-prev" href="#senaCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
              </a>
              <a class="carousel-control-next" href="#senaCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
              </a>
            </div>
          </div>

          @yield('content')
        </div>
      </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Versión</b> 1.0.0
      </div>
      <strong>Copyright &copy; 2025 <a href="#">Sistema de Gestión</a>.</strong> Todos los derechos reservados.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- jQuery UI -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <!-- Bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <!-- ChartJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.3.0/sweetalert2.all.min.js"></script>
  <!-- OverlayScrollbars -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/OverlayScrollbars.min.js"></script>

  <script>
    $(document).ready(function() {
      // Inicializar carousel con configuración personalizada
      $('#senaCarousel').carousel({
        interval: 4000,
        pause: 'hover',
        wrap: true
      });

      // Efectos de hover para los controles
      $('.carousel-control-prev, .carousel-control-next').hover(
        function() {
          $(this).find('.carousel-control-prev-icon, .carousel-control-next-icon').css('transform', 'scale(1.2)');
        },
        function() {
          $(this).find('.carousel-control-prev-icon, .carousel-control-next-icon').css('transform', 'scale(1)');
        }
      );

      // Pausar carousel al hacer hover sobre el contenido
      $('.sena-card').hover(
        function() {
          $('#senaCarousel').carousel('pause');
        },
        function() {
          $('#senaCarousel').carousel('cycle');
        }
      );
    });

    // Notificación interactiva al hacer clic en el ícono de soporte
    document.querySelector('.nav-link[data-toggle="dropdown"]').addEventListener('click', () => {
      Swal.fire({
        icon: 'info',
        title: 'Notificaciones de Soporte',
        html: `
        <ul class="list-group list-group-flush">
          <li class="list-group-item text-white">Nuevo reporte de equipo <span class="float-right text-muted">3 mins</span></li>
          <li class="list-group-item text-white">Reporte resuelto <span class="float-right text-muted">10 mins</span></li>
        </ul>
      `,
        showConfirmButton: false,
        timer: 3000,
        customClass: {
          popup: 'bg-dark',
          title: 'text-white'
        }
      });
    });
  </script>
</body>

</html>