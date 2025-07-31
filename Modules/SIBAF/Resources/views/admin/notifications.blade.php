@extends('sibaf::layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 text-gray-800">Notificaciones</h1>
                <div>
                    <form action="{{ route('sibaf.admin.notifications.mark-all-read') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-double"></i> Marcar todas como leídas
                        </button>
                    </form>
                    <a href="{{ route('sibaf.admin.welcome') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Todas las Notificaciones</h6>
                </div>
                <div class="card-body">
                    @if($notifications->count() > 0)
                        @foreach($notifications as $notification)
                            <div class="notification-item border-bottom pb-3 mb-3 {{ $notification->read_at ? 'opacity-75' : 'bg-light' }}">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">
                                                    @if(!$notification->read_at)
                                                        <span class="badge badge-primary mr-2">Nueva</span>
                                                    @endif
                                                    {{ $notification->data['equipo'] ?? 'Equipo no especificado' }}
                                                </h6>
                                                <p class="mb-1">{{ $notification->data['message'] ?? 'Notificación' }}</p>
                                                <small class="text-muted">
                                                    <strong>Usuario:</strong> {{ $notification->data['usuario'] ?? 'No especificado' }}
                                                </small>
                                            </div>
                                            <div class="text-right">
                                                <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                                                <br>
                                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        @if(!$notification->read_at)
                                            <form action="{{ route('sibaf.admin.notifications.mark-read', $notification->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-check"></i> Marcar como leída
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-success">
                                                <i class="fas fa-check-circle"></i> Leída
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bell fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No hay notificaciones</h5>
                            <p class="text-gray-400">Cuando se aprueben bajas de computadores, aparecerán aquí las notificaciones.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.notification-item {
    transition: all 0.3s ease;
    border-radius: 8px;
    padding: 15px;
}

.notification-item:hover {
    background-color: #f8f9fc;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.notification-item:not(.opacity-75) {
    border-left: 4px solid #007bff;
}

.opacity-75 {
    border-left: 4px solid #6c757d;
}
</style>
@endsection 