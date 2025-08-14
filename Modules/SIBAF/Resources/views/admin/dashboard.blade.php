{{-- @extends('sibaf::layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Panel de Administración SIBAF</h1>
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Reportes Pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPendingReports }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Bajas Aprobadas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalApprovedDowngrades }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Reportes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalReports }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Notificaciones</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $notifications->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bell fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Notificaciones -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Notificaciones Recientes</h6>
                    <a href="{{ route('sibaf.admin.notifications') }}" class="btn btn-sm btn-primary">Ver todas</a>
                </div>
                <div class="card-body">
                    @if($notifications->count() > 0)
                        @foreach($notifications->take(5) as $notification)
                            <div class="notification-item border-bottom pb-2 mb-2">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $notification->data['equipo'] ?? 'Equipo no especificado' }}</strong>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">{{ $notification->data['message'] ?? 'Notificación' }}</p>
                                <small class="text-muted">Usuario: {{ $notification->data['usuario'] ?? 'No especificado' }}</small>
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reportes Pendientes</h6>
                </div>
                <div class="card-body">
                    @if($pendingReports->count() > 0)
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
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Bajas Recientes</h6>
                    <a href="{{ route('sibaf.admin.downgrades') }}" class="btn btn-sm btn-primary">Ver todas</a>
                </div>
                <div class="card-body">
                    @if($recentDowngrades->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
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
@endsection  --}}