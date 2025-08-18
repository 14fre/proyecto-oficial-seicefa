<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/Favicon2.png')}}" type="image/x-icon">
    <title>Gestión de Baja de Equipos</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .card-dashboard {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 15px;
            text-align: center;
        }
        .card-dashboard h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .card-dashboard p {
            color: #6c757d;
            margin-bottom: 0;
        }
        .action-buttons .btn {
            margin: 0 3px;
        }
        .badge-pendiente {
            background-color: #ffc107;
            color: #000;
        }
        .badge-enviado {
            background-color: #17a2b8;
            color: #fff;
        }
        .badge-aprobada {
            background-color: #28a745;
            color: #fff;
        }
        .badge-rechazada {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-action {
            padding: 5px 10px;
            font-size: 14px;
        }
        .header-button {
            border-radius: 5px;
            padding: 10px 15px;
            margin-bottom: 20px;
            font-weight: 600;
            color: white;
        }
        .main-sidebar {
            background-color: #0d2042 !important;
        }
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .nav-icon {
            margin-right: 10px;
        }
        .admin-panel-header {
            background-color: #0d2042;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }
        .dropdown-menu-lg {
            max-height: 300px;
            overflow-y: auto;
            min-width: 400px;
        }
        .dropdown-item-notification {
            padding: 10px 15px;
            border-bottom: 1px solid #e9ecef;
            cursor: pointer;
        }
        .dropdown-item-notification:hover {
            background-color: #f8f9fc;
        }
        .notification-unread {
            border-left: 3px solid #007bff;
            background-color: #f1f8ff;
        }
        .modal-content {
            border-radius: 10px;
        }
        .modal-header {
            background-color: #0d2042;
            color: white;
        }
    </style>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('images/images.png') }}" alt="AdminLTELogo" height="100" width="150">
        </div>

        <nav class="main-header navbar navbar-expand navbar-dark">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Home</a>
                </li>
                @if(Auth::check())
                @if(checkRol('sibaf.admin'))
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('sibaf.admin.welcome') }}" id="an" class="nav-link @if (Route::is('sibaf.admin.*')) active @endif">Administrador</a>
                </li>
                @endif
                @endif
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
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

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" id="notificationDropdown">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge" id="unreadCount">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header" id="notificationHeader">Notificaciones</span>
                        <div class="dropdown-divider"></div>
                        <div id="notificationList">
                            <div class="text-center py-3">
                                <i class="fas fa-bell fa-2x text-gray-300"></i>
                                <p class="text-gray-500 mt-2">No hay notificaciones recientes</p>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('sibaf.admin.notifications.mark-all-read') }}" method="POST" class="dropdown-item dropdown-footer">
                            @csrf
                            <button type="submit" class="btn btn-link text-primary" id="markAllRead">Marcar todas como leídas</button>
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light ml-4">Admin Panel</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('sibaf.admin.welcome') }}" class="nav-link {{ Route::is('sibaf.admin.welcome') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sibaf.admin.downgrades') }}" class="nav-link {{ Route::is('sibaf.admin.downgrades*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-laptop"></i>
                                <p>Bajas Aprobadas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sibaf.inventory.index') }}" class="nav-link {{ Route::is('admin.sibaf.inventory.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-desktop"></i>
                                <p>Inventario de Equipos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sibaf.damage_reports_tracking.index') }}" class="nav-link {{ Route::is('admin.sibaf.damage_reports_tracking.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Seguimientos</p>
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
                    @if(Route::is('sibaf.admin.welcome'))
                    <div class="row mt-4">
                        <div class="col-md-12">
                        </div>
                    </div>
                    @endif
                </div>
            </section>
        </div>

        <aside class="control-sidebar control-sidebar-dark"></aside>

        <footer class="main-footer">
            <strong>Copyright © 2023-2025 <a href="#">GDF</a>.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>

    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Detalles de la Notificación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Tipo:</strong> <span id="modalType"></span></p>
                    <p><strong>Equipo:</strong> <span id="modalEquipo"></span></p>
                    <p><strong>Creado por ID:</strong> <span id="modalCreadoPor"></span></p>
                    <p><strong>Aprobado por ID:</strong> <span id="modalAprobadoPor"></span></p>
                    <p><strong>Mensaje:</strong> <span id="modalMessage"></span></p>
                    <p><strong>Fecha:</strong> <span id="modalFecha"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Array para almacenar notificaciones en el cliente
            let notifications = [];

            // Función para actualizar el dropdown
            function updateNotificationDropdown() {
                let notificationList = $('#notificationList');
                notificationList.empty();
                if (notifications.length > 0) {
                    notifications.forEach((notification, index) => {
                        let icon = notification.type === 'baja' ? 'fas fa-trash-alt' : 'fas fa-exclamation-circle';
                        let timeAgo = new Date(notification.created_at).toLocaleString();
                        let notificationClass = notification.status === 'pending' ? 'notification-unread' : '';
                        let html = `
                            <div class="dropdown-item-notification ${notificationClass}" data-index="${index}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <i class="${icon} mr-2"></i>
                                        ${notification.message}
                                        <br>
                                        <small class="text-muted">${timeAgo}</small>
                                    </div>
                                    <div class="text-right">
                                        <div>
                                            ${notification.status === 'seen' ? 
                                                '<span class="text-success"><i class="fas fa-check-circle"></i> Leída</span>' : 
                                                '<button class="btn btn-sm btn-outline-primary mark-as-read" data-index="${index}"><i class="fas fa-check"></i> Marcar como leída</button>'}
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        notificationList.append(html);
                    });
                    $('#unreadCount').text(notifications.filter(n => n.status === 'pending').length);
                    $('#notificationHeader').text(notifications.length > 0 ? `${notifications.length} Notificaciones` : 'Notificaciones');
                } else {
                    notificationList.html(`
                        <div class="text-center py-3">
                            <i class="fas fa-bell fa-2x text-gray-300"></i>
                            <p class="text-gray-500 mt-2">No hay notificaciones recientes</p>
                        </div>
                    `);
                    $('#unreadCount').text('0');
                    $('#notificationHeader').text('Notificaciones');
                }
            }

            // Escuchar respuesta del formulario de reporte
            $(document).on('submit', '.damage-report-form', function(e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            if (response.notification) {
                                notifications.unshift(response.notification); // Agregar al inicio
                                updateNotificationDropdown();
                            }
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Intenta de nuevo',
                            showConfirmButton: true
                        });
                    }
                });
            });

            // Manejar clic en el dropdown para mostrar modal
            $(document).on('click', '.dropdown-item-notification', function() {
                let index = $(this).data('index');
                let notification = notifications[index];
                $('#modalType').text(notification.type);
                $('#modalEquipo').text(notification.equipo);
                $('#modalCreadoPor').text(notification.usuario);
                $('#modalAprobadoPor').text(notification.usuario); // Ajusta si tienes un campo diferente
                $('#modalMessage').text(notification.message);
                $('#modalFecha').text(new Date(notification.created_at).toLocaleString());
                $('#notificationModal').modal('show');
                if (notification.status === 'pending') {
                    notification.status = 'seen';
                    updateNotificationDropdown();
                }
            });

            // Manejar "Marcar como leída" manualmente
            $(document).on('click', '.mark-as-read', function(e) {
                e.preventDefault();
                let index = $(this).data('index');
                notifications[index].status = 'seen';
                updateNotificationDropdown();
                Swal.fire({
                    icon: 'success',
                    title: 'Notificación marcada como leída',
                    showConfirmButton: false,
                    timer: 1500
                });
            });

            // Obtener conteo de notificaciones no leídas (desactivado ya que no usamos tabla)
            function updateUnreadCount() {
                $('#unreadCount').text(notifications.filter(n => n.status === 'pending').length);
                $('#notificationHeader').text(notifications.length > 0 ? `${notifications.length} Notificaciones` : 'Notificaciones');
            }

            // Obtener notificaciones recientes (reemplazado por el array)
            function loadRecentNotifications() {
                updateNotificationDropdown();
            }

            // Actualizar notificaciones y conteo al cargar la página
            updateUnreadCount();
            loadRecentNotifications();

            // Manejar "Marcar como leída" con depuración (desactivado ya que usamos el botón)
            /* $(document).on('submit', '.mark-read-form', function(e) {
                e.preventDefault();
                let form = $(this);
                let notificationId = form.data('id');
                let url = form.attr('action').replace(':id', notificationId);
                console.log('Enviando solicitud a:', url);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        console.log('Respuesta del servidor:', response);
                        if (response.success) {
                            updateUnreadCount();
                            loadRecentNotifications();
                            Swal.fire({
                                icon: 'success',
                                title: 'Notificación marcada como leída',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al marcar como leída',
                                text: response.message || 'Intenta de nuevo',
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log('Error AJAX:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al marcar como leída',
                            text: xhr.responseJSON?.message || 'Revisa la conexión o permisos',
                            showConfirmButton: true
                        });
                    }
                });
            }); */

            // Manejar "Marcar todas como leídas" (desactivado ya que usamos el array)
            /* $('#markAllRead').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            updateUnreadCount();
                            loadRecentNotifications();
                            Swal.fire({
                                icon: 'success',
                                title: 'Todas las notificaciones marcadas como leídas',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al marcar todas como leídas',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }); */

            // Actualizar notificaciones cada 60 segundos (desactivado ya que se manejan en tiempo real)
            /* setInterval(() => {
                updateUnreadCount();
                loadRecentNotifications();
            }, 60000); */
        });
    </script>
</body>

</html>