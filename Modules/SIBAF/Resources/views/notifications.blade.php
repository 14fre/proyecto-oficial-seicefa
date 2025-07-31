@extends('sibaf::layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Notificaciones</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('sibaf.admin.welcome') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Notificaciones</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Todas las Notificaciones</h3>
                <div class="card-tools">
                    <form action="{{ route('sibaf.admin.notifications.mark-all-read') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-check-double"></i> Marcar todas como leídas
                        </button>
                    </form>
                    <form action="{{ route('sibaf.admin.notifications.destroy-all-read') }}" method="POST" class="d-inline ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar todas las notificaciones leídas?')">
                            <i class="fas fa-trash"></i> Eliminar leídas
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="notification-item border-bottom pb-3 mb-3 {{ $notification->statusNotification === 'seen' ? 'opacity-75' : 'bg-light' }}">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="mb-1">
                                        @if($notification->statusNotification === 'pending')
                                            <span class="badge badge-primary mr-2">Nueva</span>
                                        @endif
                                        Baja de Computador Aprobada
                                    </h6>
                                    <p class="mb-1">
                                        Se ha aprobado la baja del computador 
                                        @if($notification->responsibleAllocation && $notification->responsibleAllocation->inventory)
                                            <strong>{{ $notification->responsibleAllocation->inventory->element->name ?? 'No especificado' }}</strong>
                                        @else
                                            <strong>No especificado</strong>
                                        @endif
                                    </p>
                                    <small class="text-muted">
                                        <strong>Usuario:</strong> 
                                        @if($notification->user)
                                            {{ $notification->user->name ?? 'No especificado' }}
                                        @else
                                            No especificado
                                        @endif
                                    </small>
                                </div>
                                <div class="col-md-4 text-right">
                                    <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                                    <br>
                                    @if($notification->statusNotification === 'pending')
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
                                    <form action="{{ route('sibaf.admin.notifications.destroy', $notification->id) }}" method="POST" class="d-inline ml-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta notificación?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-center">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bell fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-500">No hay notificaciones</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.notification-item {
    transition: all 0.3s ease;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item.opacity-75 {
    background-color: #f8f9fa;
}
</style>
@endsection 