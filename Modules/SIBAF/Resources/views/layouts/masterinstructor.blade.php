<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .admin-blue {
            background-color: #0A2E5C;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 50;
        }
        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 admin-blue text-white h-screen p-6">
            <div class="flex items-center mb-10">
                <img src="/api/placeholder/50/50" alt="Logo" class="w-12 h-12 mr-3 rounded-full">
                <h2 class="text-xl font-bold">Sistema de Gestión</h2>
            </div>
            
            <nav>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="flex items-center p-3 hover:bg-blue-700 rounded-lg">
                            <i class="ri-dashboard-line mr-3"></i>
                            Panel Principal
                        </a>
                    </li>
                    <a href="{{ route('admin.sibaf.inventory.index') }}" class="nav-link {{ Route::is('admin.sibaf.inventory.index') ? 'active' : '' }}">
                        <i class="ri-archive-line mr-3"></i>
                        Ver Inventario
                    </a>
                    
                    <li>
                        <a href="#" class="flex items-center p-3 hover:bg-blue-700 rounded-lg">
                            <i class="ri-error-warning-line mr-3"></i>
                            Reportar Daño
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-3 hover:bg-blue-700 rounded-lg">
                            <i class="ri-tools-line mr-3"></i>
                            Solicitar Reparación
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-3 hover:bg-blue-700 rounded-lg">
                            <i class="ri-history-line mr-3"></i>
                            Historial de Reportes
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Bar -->
            <div class="admin-blue text-white p-4 flex justify-between items-center">
                <div class="flex items-center">
                    <select class="bg-transparent border-white border rounded-lg p-2 mr-4">
                        <option>🇪🇸 Español</option>
                        <option>🇬🇧 English</option>
                        <option>🇫🇷 Français</option>
                        <option>🇩🇪 Deutsch</option>
                    </select>
                    <input type="text" placeholder="Buscar..." class="p-2 rounded-lg text-black">
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Notificaciones -->
                    <div class="relative">
                        <button class="p-2 hover:bg-blue-700 rounded-lg">
                            <i class="ri-notification-line text-2xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                        </button>
                    </div>

                    <!-- Perfil de Usuario -->
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center space-x-2 hover:bg-blue-700 p-2 rounded-lg">
                            <img src="/api/placeholder/40/40" alt="Usuario" class="w-10 h-10 rounded-full">
                            <div class="text-left">
                                <p class="font-semibold">Juan Pérez</p>
                                <p class="text-sm">Técnico</p>
                            </div>
                            <i class="ri-arrow-down-s-line"></i>
                        </button>

                        <!-- Menú Desplegable -->
                        <div id="userDropdown" class="dropdown-menu w-48 mt-2">
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="ri-user-line mr-2"></i>Mi Perfil
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="ri-settings-line mr-2"></i>Configuración
                            </a>
                            <div class="border-t border-gray-200"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    <i class="ri-logout-box-line mr-2"></i>Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="p-6">
                @yield('content')
            </div>

        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Cerrar el dropdown cuando se hace clic fuera
        window.onclick = function(event) {
            if (!event.target.matches('button')) {
                const dropdowns = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>