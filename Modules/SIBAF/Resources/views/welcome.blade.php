@extends('sibaf::layouts.master')
@section('content')
<link rel="stylesheet" href="{{ asset('modules/sibaf/css/welcome.css') }}">
<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="dashboard-title">Panel De Administrador</h1>
                    <p class="dashboard-subtitle">Sistema de Información de Bienes y Activos Fijos</p>
                </div>
                <div class="col-sm-6">
                    <nav class="dashboard-breadcrumb">
                        <a href="{{ route('sibaf.admin.welcome') }}" class="breadcrumb-link">Inicio</a>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-current">Dashboard</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-card-warning">
            <div class="stat-content">
                <div class="stat-number">{{ $totalPendingReports ?? 0 }}</div>
                <div class="stat-label">Reportes Pendientes</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
        
        <div class="stat-card stat-card-success">
            <div class="stat-content">
                <div class="stat-number">{{ $totalApprovedDowngrades ?? 0 }}</div>
                <div class="stat-label">Bajas Aprobadas</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        
        <div class="stat-card stat-card-info">
            <div class="stat-content">
                <div class="stat-number">{{ $totalReports ?? 0 }}</div>
                <div class="stat-label">Total Reportes</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
        
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        <!-- Notifications Section -->
        <div class="content-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-bell"></i>
                    <span>Notificaciones Recientes</span>
                </div>
                <a href="{{ route('sibaf.admin.notifications') }}" class="btn-primary-small">Ver todas</a>
            </div>
            <div class="card-body">
                @if(isset($notifications) && $notifications->count() > 0)
                    @foreach($notifications->take(5) as $notification)
                        <div class="notification-item">
                            <div class="notification-header">
                                <strong class="notification-title">Baja de Computador Aprobada</strong>
                                <small class="notification-time">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="notification-description">
                                Se ha aprobado la baja del computador 
                                @if($notification->responsibleAllocation && $notification->responsibleAllocation->inventory)
                                    <strong>{{ $notification->responsibleAllocation->inventory->element->name ?? 'No especificado' }}</strong>
                                @else
                                    <strong>No especificado</strong>
                                @endif
                            </p>
                            <small class="notification-user">
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
                    <div class="empty-state">
                        <i class="fas fa-bell-slash"></i>
                        <p>No hay notificaciones nuevas</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pending Reports Section -->
        <div class="content-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Reportes Pendientes</span>
                </div>
            </div>
            <div class="card-body">
                @if(isset($pendingReports) && $pendingReports->count() > 0)
                    @foreach($pendingReports->take(5) as $report)
                        <div class="report-item">
                            <div class="report-header">
                                <strong class="report-title">{{ $report->inventory->element->name ?? 'Equipo no especificado' }}</strong>
                                <small class="report-time">{{ $report->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="report-description">{{ Str::limit($report->description, 100) }}</p>
                            <small class="report-user">Reportado por: {{ $report->user->person->full_name ?? 'Usuario no especificado' }}</small>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-clipboard"></i>
                        <p>No hay reportes pendientes</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Downgrades Table -->
    <div class="content-card full-width">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-laptop"></i>
                <span>Bajas Recientes</span>
            </div>
            <a href="{{ route('sibaf.admin.downgrades') }}" class="btn-primary-small">Ver todas</a>
        </div>
        <div class="card-body">
            @if(isset($recentDowngrades) && $recentDowngrades->count() > 0)
                <div class="table-container">
                    <table class="data-table">
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
                                    <td class="equipment-name">{{ $downgrade->inventory->element->name ?? 'No especificado' }}</td>
                                    <td class="user-name">{{ $downgrade->user->person->full_name ?? 'No especificado' }}</td>
                                    <td class="approval-date">{{ $downgrade->fecha_aprobacion ? $downgrade->fecha_aprobacion->format('d/m/Y H:i') : 'No especificada' }}</td>
                                    <td class="documents">
                                        @if($downgrade->excel1_path)
                                            <a href="{{ route('sibaf.admin.downgrades.download', ['downgrade' => $downgrade->id, 'fileType' => 'excel1']) }}" 
                                               class="btn-download btn-download-primary">
                                                <i class="fas fa-download"></i> Excel 1
                                            </a>
                                        @endif
                                        @if($downgrade->excel2_path)
                                            <a href="{{ route('sibaf.admin.downgrades.download', ['downgrade' => $downgrade->id, 'fileType' => 'excel2']) }}" 
                                               class="btn-download btn-download-success">
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
                <div class="empty-state">
                    <i class="fas fa-laptop"></i>
                    <p>No hay bajas recientes</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
