@extends('gpes::layouts.master')

@section("content")

    <!-- Success and Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="welcome-container">
        <h1 class="text-center text-success fw-bold mb-4">Bienvenido a GPES</h1>
        <p class="lead text-center text-dark mb-5">Gestión de Equipos del SENA</p>

        <div class="row g-4">
            <!-- Welcome Card -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h3 class="card-title text-success fw-bold">¡Explora la Plataforma!</h3>
                        <p class="card-text text-dark">
                            GPES te permite gestionar asignaciones, reportes y notificaciones de equipos del SENA de manera eficiente y organizada. Optimiza el control de recursos con nuestra interfaz intuitiva.
                        </p>
                        
                    </div>
                </div>
            </div>
            <!-- Features Card -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="card-title text-success fw-bold">Funcionalidades</h3>
                        <ul class="list-unstyled text-dark">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Gestión de asignaciones de computadores</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Seguimiento de reportes y notificaciones</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Control de inventario en tiempo real</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Interfaz amigable y personalizada</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h4 class="card-title text-success">Asignaciones Activas</h4>
                        <p class="display-6 text-dark">{{$countAssignment}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h4 class="card-title text-success">Reportes Pendientes</h4>
                        <p class="display-6 text-dark">{{$countReports}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h4 class="card-title text-success">Equipos Disponibles</h4>
                        <p class="display-6 text-dark">{{$countComputers}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .welcome-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .card {
        background: #ffffff;
        border-radius: 8px;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .btn-primary {
        background: #28a745;
        border: none;
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .btn-primary:hover {
        background: #218838;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-dark {
        color: #333333 !important;
    }

    .list-unstyled i {
        font-size: 1.2rem;
    }

    .card-title {
        margin-bottom: 15px;
    }

    .card-text {
        font-size: 1rem;
        line-height: 1.5;
    }

    .display-6 {
        font-size: 2.5rem;
        font-weight: 700;
    }
    </style>

@endsection