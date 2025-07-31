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
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css">

  <style>
    :root {
      --sidebar-bg: #172b4d;
      --primary-color: #3498db;
      --secondary-color: #2ecc71;
      --warning-color: #f39c12;
      --danger-color: #e74c3c;
      --light-gray: #f8f9fa;
    }
    
    body {
      font-family: 'Source Sans Pro', sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
    
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      width: 240px;
      background-color: var(--sidebar-bg);
      color: white;
      z-index: 100;
      transition: all 0.3s;
    }
    
    .sidebar-header {
      padding: 20px;
      text-align: center;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .sidebar-brand {
      color: white;
      font-size: 1.5rem;
      font-weight: 700;
      text-decoration: none;
    }
    
    .sidebar-menu {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .sidebar-menu li {
      margin: 0;
      padding: 0;
    }
    
    .sidebar-menu li a {
      padding: 15px 20px;
      display: flex;
      align-items: center;
      color: rgba(255,255,255,0.8);
      text-decoration: none;
      transition: all 0.3s;
    }
    
    .sidebar-menu li a:hover,
    .sidebar-menu li a.active {
      color: white;
      background-color: rgba(255,255,255,0.1);
    }
    
    .sidebar-menu li a i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }
    
    .content-wrapper {
      margin-left: 240px;
      padding: 20px;
      min-height: 100vh;
    }
    
    .top-navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      background-color: white;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    
    .search-form {
      flex-grow: 1;
      max-width: 400px;
    }
    
    .search-form .form-control {
      border-radius: 50px;
      padding-left: 15px;
    }
    
    .user-panel {
      display: flex;
      align-items: center;
    }
    
    .user-panel .notifications {
      margin-right: 20px;
      position: relative;
    }
    
    .user-panel .notifications .badge {
      position: absolute;
      top: -5px;
      right: -5px;
      font-size: 0.6rem;
    }
    
    .user-info {
      display: flex;
      align-items: center;
    }
    
    .user-info img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      margin-right: 10px;
    }
    
    .stat-card {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 20px;
      transition: transform 0.3s;
    }
    
    .stat-card:hover {
      transform: translateY(-5px);
    }
    
    .stat-card .stat-title {
      color: #6c757d;
      font-size: 0.9rem;
      margin-bottom: 10px;
    }
    
    .stat-card .stat-value {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0;
    }
    
    .content-card {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 20px;
    }
    
    .content-card .content-title {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }
    
    .placeholder-content {
      background-color: #f8f9fa;
      border-radius: 4px;
      height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #6c757d;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar Menu -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="sidebar-brand">MESA DE AYUDA</a>
      </div>
      
      <ul class="sidebar-menu">
        <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Panel Principal</a></li>
        <li><a href="#"><i class="fas fa-ticket-alt"></i> Tickets</a></li>
        <li><a href="#"><i class="fas fa-desktop"></i> Gestión Equipos</a></li>
        <li><a href="#"><i class="fas fa-chart-bar"></i> Reportes</a></li>
        <li><a href="#"><i class="fas fa-users"></i> Usuarios</a></li>
        <li><a href="#"><i class="fas fa-cog"></i> Configuración</a></li>
      </ul>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <!-- Top Navbar -->
      <nav class="top-navbar">
        <div class="search-form">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Buscar ticket...">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
        
        <div class="user-panel">
          <div class="notifications">
            <a href="#" class="text-dark">
              <i class="fas fa-bell"></i>
              <span class="badge badge-danger">5</span>
            </a>
          </div>
          
          <div class="user-info">
            <img src="/api/placeholder/80/80" alt="User">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Admin <i class="fas fa-user-circle"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
          </div>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="container-fluid">
        <!-- Stat Cards -->
        <div class="row">
          <div class="col-lg-4">
            <div class="stat-card">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="stat-title">Tickets Pendientes</div>
                  <div class="stat-value text-primary">18</div>
                </div>
                <div class="text-primary">
                  <i class="fas fa-clipboard-list fa-3x"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="stat-card">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="stat-title">En Proceso</div>
                  <div class="stat-value text-warning">7</div>
                </div>
                <div class="text-warning">
                  <i class="fas fa-spinner fa-3x"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="stat-card">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="stat-title">Resueltos Hoy</div>
                  <div class="stat-value text-success">12</div>
                </div>
                <div class="text-success">
                  <i class="fas fa-check-circle fa-3x"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        @yield('content')
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- jQuery UI -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap 5 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.3.0/sweetalert2.all.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/OverlayScrollbars.min.js"></script>
</body>
</html>