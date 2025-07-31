@extends('sibaf::layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard SIBAF</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('sibaf.admin.welcome') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Tarjetas de estadísticas -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalPendingReports ?? 0 }}</h3>
                <p>Reportes Pendientes</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalApprovedDowngrades ?? 0 }}</h3>
                <p>Bajas Aprobadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalReports ?? 0 }}</h3>
                <p>Total Reportes</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $notificationsCount ?? 0 }}</h3>
                <p>Notificaciones</p>
            </div>
            <div class="icon">
                <i class="fas fa-bell"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Notificaciones -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bell"></i> Notificaciones Recientes
                </h3>
                <div class="card-tools">
                    <a href="{{ route('sibaf.admin.notifications') }}" class="btn btn-sm btn-primary">Ver todas</a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($notifications) && $notifications->count() > 0)
                    @foreach($notifications->take(5) as $notification)
                        <div class="notification-item border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between">
                                <strong>Baja de Computador Aprobada</strong>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">
                                Se ha aprobado la baja del computador 
                                @if($notification->responsibleAllocation && $notification->responsibleAllocation->inventory)
                                    <strong>{{ $notification->responsibleAllocation->inventory->element->name ?? 'No especificado' }}</strong>
                                @else
                                    <strong>No especificado</strong>
                                @endif
                            </p>
                            <small class="text-muted">
                                Usuario: 
                                @if($notification->user)
                                    {{ $notification->user->name ?? 'No especificado' }}
                                @else
                                    No especificado
                                @endif
                            </small>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No hay notificaciones nuevas</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Reportes Pendientes -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle"></i> Reportes Pendientes
                </h3>
            </div>
            <div class="card-body">
                @if(isset($pendingReports) && $pendingReports->count() > 0)
                    @foreach($pendingReports->take(5) as $report)
                        <div class="report-item border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $report->inventory->element->name ?? 'Equipo no especificado' }}</strong>
                                <small class="text-muted">{{ $report->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($report->description, 100) }}</p>
                            <small class="text-muted">Reportado por: {{ $report->user->person->full_name ?? 'Usuario no especificado' }}</small>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No hay reportes pendientes</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Bajas Recientes -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-laptop"></i> Bajas Recientes
                </h3>
                <div class="card-tools">
                    <a href="{{ route('sibaf.admin.downgrades') }}" class="btn btn-sm btn-primary">Ver todas</a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($recentDowngrades) && $recentDowngrades->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Equipo</th>
                                    <th>Usuario</th>
                                    <th>Fecha de Aprobación</th>
                                    <th>Documentos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentDowngrades as $downgrade)
                                    <tr>
                                        <td>{{ $downgrade->inventory->element->name ?? 'No especificado' }}</td>
                                        <td>{{ $downgrade->user->person->full_name ?? 'No especificado' }}</td>
                                        <td>{{ $downgrade->fecha_aprobacion ? $downgrade->fecha_aprobacion->format('d/m/Y H:i') : 'No especificada' }}</td>
                                        <td>
                                            @if($downgrade->excel1_path)
                                                <a href="{{ route('sibaf.admin.downgrades.download', ['downgrade' => $downgrade->id, 'fileType' => 'excel1']) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download"></i> Excel 1
                                                </a>
                                            @endif
                                            @if($downgrade->excel2_path)
                                                <a href="{{ route('sibaf.admin.downgrades.download', ['downgrade' => $downgrade->id, 'fileType' => 'excel2']) }}" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-download"></i> Excel 2
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No hay bajas recientes</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.notification-item, .report-item {
    transition: background-color 0.3s;
}

.notification-item:hover, .report-item:hover {
    background-color: #f8f9fc;
    border-radius: 5px;
    padding: 10px;
    margin: -10px;
}
</style>
@endsection