@extends('sibaf::layouts.masterinstructor')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Cambiando colores dorados por grises sutiles -->
            <div style="display: flex; justify-content: center; align-items: center; min-height: 300px;">
                <div id="welcomeCard" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); text-align: center; max-width: 350px; color: #495057; transform: scale(0); animation: professionalEntry 1s ease-out forwards; border: 1px solid #dee2e6;">
                    
                    <!-- Icono simple -->
                    <div style="margin-bottom: 20px;">
                        <i class="fas fa-user-tie" style="font-size: 50px; color: #6c757d; animation: gentlePulse 2s ease-in-out infinite;"></i>
                    </div>
                    
                    <!-- Texto elegante -->
                    <h3 style="margin: 0 0 10px 0; font-size: 1.8em; font-weight: 600; animation: fadeInUp 1s ease-out 0.3s both; color: #343a40;">
                        Bienvenido
                    </h3>
                    
                    <h4 style="margin: 0 0 15px 0; font-size: 1.2em; opacity: 0.8; animation: fadeInUp 1s ease-out 0.5s both; color: #495057;">
                        {{ Auth::user()->name ?? 'Instructor' }}
                    </h4>
                    
                    <p style="margin: 0; font-size: 0.95em; opacity: 0.7; animation: fadeInUp 1s ease-out 0.7s both; color: #6c757d;">
                        Sistema de Gestión - Sesión Activa
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Estilos profesionales más sutiles */
@keyframes professionalEntry {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes gentlePulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.8;
    }
    50% {
        transform: scale(1.05);
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        transform: translateY(15px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
@endsection
