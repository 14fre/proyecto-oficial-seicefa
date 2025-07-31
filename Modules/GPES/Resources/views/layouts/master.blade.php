{{-- Verificar que el usuario este autenticado --}}
@if(!Auth::check())
    <script>
        window.location.href = "{{ route('cefa.gpes.welcome') }}";
    </script>
@endif
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{asset('AdminlteGpes/dist/css/adminlte.css')}}" />
    <!--end::Required Plugin(AdminLTE)-->
   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('links_css_head')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
  

        <!-- End Navbar Links -->
        <ul class="navbar-nav ms-auto">
            {{-- <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-chat-text"></i>
                    <span class="navbar-badge badge text-bg-danger">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('AdminlteGpes/dist/assets/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 rounded-circle me-3" />
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">Brad Diesel</h3>
                                <p class="fs-7">Call me whenever you can...</p>
                                <p class="fs-7 text-secondary"><i class="bi bi-clock-fill me-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li> --}}

            {{-- <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i>
                    <span class="navbar-badge badge text-bg-warning">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-envelope me-2"></i> 4 new messages
                        <span class="float-end text-secondary fs-7">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li> --}}

            <!-- Fullscreen Toggle -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li> 

            <!-- User Menu Dropdown -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('AdminlteGpes/dist/assets/img/user2-160x160.png') }}" class="user-image rounded-circle shadow" alt="User Image" />
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ asset('AdminlteGpes/dist/assets/img/user2-160x160.png') }}" class="rounded-circle shadow" alt="User Image" />
                        <p>
                            {{ Auth::user()->name }} - {{ ucfirst(Auth::user()->role) }}
                            <small>Miembro desde {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        
                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

      <!--end::Header-->


      {{-- ========================================================= --}}
      {{-- ========================================================= --}}
      {{-- ========================================================= --}}
      {{-- ========================================================= --}}
      {{-- ========================================================= --}}
      {{-- ========================================================= --}}
      <!--begin::Sidebar-->
@php
$navLinks = [
    // Gestión de Equipos
    [
        'group' => 'Gestión de Equipos',
        'items' => [
            [
                'route' => 'gpes.cuentadante.computers.index',
                'icon' => 'bi bi-laptop',
                'label' => 'Computadores',
                'roles' => ['gpes.admin'],
            ],
            [
                'route' => 'gpes.cuentadante.assignmentsUserComputer.day.index',
                'icon' => 'bi bi-calendar-day',
                'label' => 'Asignaciones por Día',
                'roles' => ['gpes.admin',"gpes.instructor"],
            ],
            [
                'route' => 'gpes.cuentadante.assignmentsUserComputer.formation.index',
                'icon' => 'bi bi-calendar3',
                'label' => 'Asignaciones por Formación',
                'roles' => ['gpes.admin',"gpes.instructor"],
            ],
        ],
    ],
    // Reportes
    [
        'group' => 'Reportes',
        'items' => [
            [
                'route' => 'gpes.cuentadante.reports.index',
                'icon' => 'bi bi-exclamation-triangle',
                'label' => 'Reportar Daños',
                'roles' => ['gpes.admin', 'gpes.vigilant',"gpes.instructor","gpes.apprentice"],
            ],
            [
                'route' => 'gpes.cuentadante.answers.index',
                'icon' => 'bi bi-chat-left-text',
                'label' => 'Responder Reportes',
                'roles' => ['gpes.admin', 'gpes.vigilant'],
            ],
        ],
    ],
    // Historial y Búsquedas
    [
        'group' => 'Historial y Búsquedas',
        'items' => [
            [
                'route' => 'gpes.cuentadante.personHistory.index',
                'icon' => 'bi bi-person-lines-fill',
                'label' => 'Historial de Asignaciones Personales',
                'roles' => ['gpes.admin', 'gpes.vigilant',"gpes.instructor","gpes.apprentice"],
            ],
            [
                'route' => 'gpes.cuentadante.Search.computer.index',
                'icon' => 'bi bi-search',
                'label' => 'Historial de Computadores',
                'roles' => ['gpes.admin', 'gpes.vigilant',"gpes.instructor","gpes.apprentice"],
            ],
            [
                'route' => 'gpes.cuentadante.Search.person.index',
                'icon' => 'bi bi-search',
                'label' => 'Historial de Personas',
                'roles' => ['gpes.admin', 'gpes.vigilant',"gpes.instructor","gpes.apprentice"],
            ],
        ],
    ],
    // Notificaciones
    [
        'group' => 'Notificaciones',
        'items' => [
            [
                'route' => 'gpes.cuentadante.notificationAssigments.index',
                'icon' => 'bi bi-bell',
                'label' => 'Notificaciones de Asignaciones',
                'roles' => ['gpes.admin', 'gpes.vigilant'],
            ],
        ],
    ],
];

function hasAnyRole($roles) {
    foreach ($roles as $role) {
        if (checkRol($role)) {
            return true;
        }
    }
    return false;
}
@endphp

<!-- Sidebar -->
<aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand" style="background:green;">
        <a href="{{ route('cefa.home') }}" class="brand-link">
            <img src="{{ asset('AdminlteGpes/dist/assets/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">GPES</span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                @foreach ($navLinks as $group)
                    @if (collect($group['items'])->some(function ($link) { return Auth::check() && hasAnyRole($link['roles']); }))
                        <li class="nav-item nav-header" style="color:black;">{{ $group['group'] }}</li>
                        @foreach ($group['items'] as $link)
                            @if (Auth::check() && hasAnyRole($link['roles']))
                                <li class="nav-item">
                                    <a href="{{ route($link['route']) }}" class="nav-link {{ request()->routeIs($link['route']) ? 'active' : '' }}">
                                        <i class="nav-icon {{ $link['icon'] }} text-success"></i>
                                        <p style="color:black;   white-space: pre-line;">{{ $link['label'] }}</p>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>

<style>
.app-sidebar {
    width: 250px;
    min-height: 100vh;
    background: #f4f4f4 !important; /* fondo claro */
    overflow-y: auto;
    border-right: 1px solid #d0d0d0;
}

.sidebar-brand {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #ccc;
    background-color: #e9ecef;
}

.brand-link {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000000; /* texto negro */
    text-decoration: none;
}

.brand-image {
    max-width: 40px;
    margin-right: 10px;
}

.brand-text {
    font-size: 1.5rem;
    color: #000000; /* texto negro */
}

.nav-header {
    color: #000000; /* texto negro */
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    padding: 10px 15px;
    margin: 0;
    background: #dfe6e9;
}

.nav-link {
    color: #000000; /* texto negro */
    padding: 10px 15px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    transition: background 0.2s, color 0.2s;
}

.nav-link:hover {
    background: #cddcdd;
    color: #000000;
}

.nav-link.active {
    background: #28a745 !important; /* verde vivo */
    color: #ffffff !important;
}

.nav-icon {
    margin-right: 10px;
    font-size: 1.2rem;
    color: #000000; /* ícono negro */
}

.nav-link.active .nav-icon {
    color: #ffffff; /* ícono blanco solo si está activo */
}

.sidebar-menu {
    padding: 0;
    margin: 0;
}

.nav-item {
    margin-bottom: 5px;
}

.sidebar-wrapper {
    padding: 10px;
}
</style>


      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
      @yield('content')
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer text-center py-3">
        <div class="container">
            <strong>© 2025 Gestión de Existencias SENA. Todos los derechos reservados.</strong>
            <br>
            <small>Desarrollado por Andrés Gonzalo Barrera Cortés | Contacto: +57 316 820 9707 | andresgbarrerac@gmail.com </small>
            <br>
            <small>Desarrollado por Jorge Enrique Murcia Goméz | Contacto: +57 3106259931 | kikemurcia14@gmail.com</small>
            <br>
            
            <small>28/03/2025</small>
        </div>
    </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{asset('AdminlteGpes/dist/js/adminlte.js')}}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script
      src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
      integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
      crossorigin="anonymous"
    ></script>
    <!-- sortablejs -->
    <script>
      const connectedSortables = document.querySelectorAll('.connectedSortable');
      connectedSortables.forEach((connectedSortable) => {
        let sortable = new Sortable(connectedSortable, {
          group: 'shared',
          handle: '.card-header',
        });
      });

      const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
      cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = 'move';
      });
    </script>
   
@if ($errors->any() || session('error') || session('success'))
    <style>
    .gpes-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 2000;
    }

    .gpes-error-modal {
        /* Clase específica para la modal de error */
    }

    .gpes-modal-content {
        background: #ffffff;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: gpesSlideIn 0.3s ease-in-out;
    }

    .gpes-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        color: #ffffff;
        border-bottom: 1px solid #e9ecef;
    }

    .gpes-modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
    }

    .gpes-close-btn {
        background: none;
        border: none;
        color: #ffffff;
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s;
    }

    .gpes-modal-body {
        padding: 20px;
        font-size: 1rem;
        color: #333333;
    }

    .gpes-modal-body ul {
        list-style: disc;
        padding-left: 20px;
        margin: 0;
    }

    .gpes-modal-footer {
        padding: 15px 20px;
        text-align: right;
        border-top: 1px solid #e9ecef;
    }

    .gpes-btn-modal {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        color: #ffffff;
        transition: background 0.2s;
    }

    #gpesErrorModal .gpes-modal-header,
    #gpesErrorModal .gpes-btn-modal {
        background: #dc3545;
    }

    #gpesErrorModal .gpes-btn-modal:hover {
        background: #c82333;
    }

    #gpesErrorModal .gpes-close-btn:hover {
        color: #f8d7da;
    }

    #gpesSuccessModal .gpes-modal-header,
    #gpesSuccessModal .gpes-btn-modal {
        background: #28a745;
    }

    #gpesSuccessModal .gpes-btn-modal:hover {
        background: #218838;
    }

    #gpesSuccessModal .gpes-close-btn:hover {
        color: #e6f4ea;
    }

    @keyframes gpesFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes gpesSlideIn {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    </style>

    <script>
    function closeGpesModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeGpesModal('gpesErrorModal');
            closeGpesModal('gpesSuccessModal');
        }
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('gpes-modal')) {
            closeGpesModal('gpesErrorModal');
            closeGpesModal('gpesSuccessModal');
        }
    });
    </script>
    @endif

    @if ($errors->any() || session('error'))
    <div class="gpes-modal gpes-error-modal" id="gpesErrorModal" style="display: flex;">
        <div class="gpes-modal-content">
            <div class="gpes-modal-header">
                <h2>Error</h2>
                <button class="gpes-close-btn" onclick="closeGpesModal('gpesErrorModal')">×</button>
            </div>
            <div class="gpes-modal-body">
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @if (session('error'))
                    <p>{{ session('error') }}</p>
                @endif
            </div>
            <div class="gpes-modal-footer">
                <button class="gpes-btn-modal" onclick="closeGpesModal('gpesErrorModal')">Cerrar</button>
            </div>
        </div>
    </div>
    @endif

    @if (session('success'))
    <div class="gpes-modal" id="gpesSuccessModal" style="display: flex;">
        <div class="gpes-modal-content">
            <div class="gpes-modal-header">
                <h2>Éxito</h2>
                <button class="gpes-close-btn" onclick="closeGpesModal('gpesSuccessModal')">×</button>
            </div>
            <div class="gpes-modal-body">
                <p>{{ session('success') }}</p>
            </div>
            <div class="gpes-modal-footer">
                <button class="gpes-btn-modal" onclick="closeGpesModal('gpesSuccessModal')">Cerrar</button>
            </div>
        </div>
    </div>
    @endif
    
     <!--end::Script-->
    @yield('scritps_end_body')
  </body>
  <!--end::Body-->
</html>