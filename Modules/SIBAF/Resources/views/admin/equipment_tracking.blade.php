@extends(request()->is('instructor/*') ? 'sibaf::layouts.masterinstructor' : 'sibaf::layouts.master')

@section('title', 'Seguimiento de Reportes de Daño')

@section('content')
<style>
    :root {
        --primary-dark: #2c3e50;
        --primary-light: #34495e;
        --text-muted: #6c757d;
        --border-color: #dee2e6;
        --bg-light: #f8f9fa;
        --white: #ffffff;
    }

    .table {
        table-layout: auto;
        width: 100%;
    }

    .table th,
    .table td {
        padding: 0.5rem;
        font-size: 0.9rem;
        vertical-align: middle;
        border: 1px solid var(--border-color);
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        background-color: var(--white);
    }

    .table th {
        background-color: var(--primary-dark);
        color: var(--white);
        border: none;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: var(--bg-light);
    }

    .description-cell {
        max-width: 300px;
        min-width: 100px;
        word-wrap: break-word;
    }

    .action-detail-cell {
        max-width: 100px;
        min-width: 100px;
        word-wrap: break-word;
        max-height: 100px;
        overflow-y: auto;
        box-sizing: border-box;
        padding: 0.25rem;
        margin: 0;
        vertical-align: top;
        /* Alinea el contenido desde la parte superior */
    }

    .card {
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: var(--primary-dark);
        color: var(--white);
        border-bottom: none;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .stat-card {
        background-color: var(--white);
        border: 1px solid var(--border-color);
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-card h4 {
        color: var(--primary-dark);
        font-weight: 600;
    }

    .stat-card p {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .btn-outline-primary {
        border-color: var(--primary-dark);
        color: var(--primary-dark);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-dark);
        color: var(--white);
    }

    .modal-content {
        border-radius: 0.5rem;
    }

    .modal-header {
        background-color: var(--primary-dark);
        color: var(--white);
        border-bottom: none;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.6em;
    }

    .alert {
        border-radius: 0.5rem;
    }
</style>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4" style="color: var(--primary-dark);"><i class="fas fa-clipboard-list"></i> Seguimiento de Reportes de Daño</h2>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(isset($error))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(isset($damageReportsWithRelations) && $damageReportsWithRelations->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Seguimiento de Equipos ({{ $damageReportsWithRelations->count() }} equipos con reportes)</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 8%;">ID</th>
                                    <th style="width: 20%;">Equipo</th>
                                    <th style="width: 10%; text-align: center;">Total Reportes</th>
                                    <th style="width: 12%;">Usuario</th>
                                    <th style="width: 15%;" class="description-cell">Descripción</th>
                                    <th style="width: 10%;">Estado</th>
                                    <th style="width: 10%;">Fecha Reporte</th>
                                    <th style="width: 10%;">Fecha Acción</th>
                                    <th style="width: 15%;" class="action-detail-cell">Detalle de Acción</th>
                                    <th style="width: 10%; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($damageReportsWithRelations as $report)
                                <tr>
                                    <td>{{ $report->id }}</td>
                                    <td>
                                        @if($report->inventory && $report->inventory->element)
                                        <strong>{{ $report->inventory->element->name ?? 'N/A' }}</strong>
                                        @if($report->inventory->computer)
                                        <br><small class="text-muted">{{ $report->inventory->computer->serial_number ?? 'Sin serie' }}</small>
                                        @endif
                                        @else
                                        <span class="text-danger">Sin inventario</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($report->total_reports_for_equipment > 1)
                                        <span class="badge bg-primary">{{ $report->total_reports_for_equipment }} reportes</span>
                                        @else
                                        <span class="badge bg-secondary">1 reporte</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($report->user)
                                        {{ $report->user->person->full_name ?? ($report->user->nickname ?? ($report->user->name ?? 'N/A')) }}
                                        @else
                                        <span class="text-danger">Sin usuario</span>
                                        @endif
                                    </td>
                                    <td class="description-cell">
                                        <span title="{{ $report->description }}">
                                            {{ Str::limit($report->description, 40) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($report->state === 'Arreglado')
                                        <span class="badge bg-success"><i class="fas fa-wrench"></i> Arreglado</span>
                                        @elseif($report->state === 'Rechazado')
                                        <span class="badge bg-danger"><i class="fas fa-times"></i> Rechazado</span>
                                        @elseif($report->state === 'Baja')
                                        <span class="badge bg-secondary"><i class="fas fa-trash"></i> Baja</span>
                                        @elseif($report->state === 'Aprobado')
                                        <span class="badge bg-primary"><i class="fas fa-check"></i> Aprobado</span>
                                        @elseif($report->state === 'Solicitado')
                                        <span class="badge bg-warning"><i class="fas fa-clock"></i> Solicitado</span>
                                        @elseif($report->state === 'En arreglo')
                                        <span class="badge bg-info"><i class="fas fa-tools"></i> En arreglo</span>
                                        @else
                                        <span class="badge bg-light text-dark">{{ $report->state ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $report->created_at ? $report->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>{{ $report->updated_at ? $report->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td class="action-detail-cell">
                                        @if($report->action_detail)
                                        <span title="{{ $report->action_detail }}">
                                            <i class="fas fa-info-circle"></i> {{ Str::limit($report->action_detail, 40) }}
                                        </span>
                                        @else
                                        <span class="text-muted">Sin detalle</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @if($report->total_reports_for_equipment > 1)
                                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#historyModal{{ $report->inventory_id }}" title="Ver historial completo">
                                                <i class="fas fa-history"></i>
                                            </button>
                                            @endif
                                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#detailModal{{ $report->id }}" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-3 mb-3">
                    <div class="card stat-card">
                        <div class="card-body text-center">
                            <h4>{{ $damageReportsWithRelations->where('state', 'Arreglado')->count() }}</h4>
                            <p class="mb-0">Equipos Arreglados</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card">
                        <div class="card-body text-center">
                            <h4>{{ $damageReportsWithRelations->where('state', 'Rechazado')->count() }}</h4>
                            <p class="mb-0">Equipos Rechazados</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card">
                        <div class="card-body text-center">
                            <h4>{{ $damageReportsWithRelations->where('state', 'Baja')->count() }}</h4>
                            <p class="mb-0">Equipos Dados de Baja</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card">
                        <div class="card-body text-center">
                            <h4>{{ $damageReportsWithRelations->whereIn('state', ['Solicitado', 'En arreglo'])->count() }}</h4>
                            <p class="mb-0">Equipos Pendientes</p>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($damageReportsWithRelations as $report)
            @if($report->total_reports_for_equipment > 1)
            <div class="modal fade" id="historyModal{{ $report->inventory_id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $report->inventory_id }}" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="historyModalLabel{{ $report->inventory_id }}">
                                <i class="fas fa-history"></i> Historial Completo - {{ $report->inventory->element->name ?? 'N/A' }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Equipo:</strong> {{ $report->inventory->element->name ?? 'N/A' }}
                                <br>
                                <strong>Total de reportes:</strong> {{ $report->total_reports_for_equipment }}
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Usuario</th>
                                            <th class="description-cell">Descripción</th>
                                            <th>Estado</th>
                                            <th>Fecha Reporte</th>
                                            <th>Fecha Acción</th>
                                            <th class="action-detail-cell">Detalle de Acción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($report->all_reports_for_equipment->sortByDesc('created_at') as $historyReport)
                                        <tr>
                                            <td>{{ $historyReport->id }}</td>
                                            <td>{{ $historyReport->user->person->full_name ?? ($historyReport->user->nickname ?? ($historyReport->user->name ?? 'N/A')) }}</td>
                                            <td class="description-cell">
                                                <span title="{{ $historyReport->description }}">
                                                    {{ Str::limit($historyReport->description, 50) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($historyReport->state === 'Arreglado')
                                                <span class="badge bg-success"><i class="fas fa-wrench"></i> Arreglado</span>
                                                @elseif($historyReport->state === 'Rechazado')
                                                <span class="badge bg-danger"><i class="fas fa-times"></i> Rechazado</span>
                                                @elseif($historyReport->state === 'Baja')
                                                <span class="badge bg-secondary"><i class="fas fa-trash"></i> Baja</span>
                                                @elseif($historyReport->state === 'Aprobado')
                                                <span class="badge bg-primary"><i class="fas fa-check"></i> Aprobado</span>
                                                @elseif($historyReport->state === 'Solicitado')
                                                <span class="badge bg-warning"><i class="fas fa-clock"></i> Solicitado</span>
                                                @elseif($historyReport->state === 'En arreglo')
                                                <span class="badge bg-info"><i class="fas fa-tools"></i> En arreglo</span>
                                                @else
                                                <span class="badge bg-light text-dark">{{ $historyReport->state ?? 'N/A' }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $historyReport->created_at ? $historyReport->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                            <td>{{ $historyReport->updated_at ? $historyReport->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                            <td class="action-detail-cell">
                                                @if($historyReport->action_detail)
                                                <span title="{{ $historyReport->action_detail }}">
                                                    <i class="fas fa-info-circle"></i> {{ Str::limit($historyReport->action_detail, 40) }}
                                                </span>
                                                @else
                                                <span class="text-muted">Sin detalle</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#historyDetailModal{{ $historyReport->id }}" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Modales para ver detalles de cada reporte del historial -->
            @foreach($report->all_reports_for_equipment as $historyReport)
            <div class="modal fade" id="historyDetailModal{{ $historyReport->id }}" tabindex="-1" role="dialog" aria-labelledby="historyDetailModalLabel{{ $historyReport->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="historyDetailModalLabel{{ $historyReport->id }}">
                                <i class="fas fa-eye"></i> Detalles del Reporte #{{ $historyReport->id }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary border-bottom border-primary pb-1"><i class="fas fa-file-alt"></i> Información del Reporte</h6>
                                    <p><strong>ID:</strong> {{ $historyReport->id }}</p>
                                    <p><strong>Usuario:</strong> {{ $historyReport->user->person->full_name ?? ($historyReport->user->nickname ?? ($historyReport->user->name ?? 'N/A')) }}</p>
                                    <p><strong>Estado:</strong>
                                        @if($historyReport->state === 'Arreglado')
                                        <span class="badge bg-success"><i class="fas fa-wrench"></i> Arreglado</span>
                                        @elseif($historyReport->state === 'Rechazado')
                                        <span class="badge bg-danger"><i class="fas fa-times"></i> Rechazado</span>
                                        @elseif($historyReport->state === 'Baja')
                                        <span class="badge bg-secondary"><i class="fas fa-trash"></i> Baja</span>
                                        @elseif($historyReport->state === 'Aprobado')
                                        <span class="badge bg-primary"><i class="fas fa-check"></i> Aprobado</span>
                                        @elseif($historyReport->state === 'Solicitado')
                                        <span class="badge bg-warning"><i class="fas fa-clock"></i> Solicitado</span>
                                        @elseif($historyReport->state === 'En arreglo')
                                        <span class="badge bg-info"><i class="fas fa-tools"></i> En arreglo</span>
                                        @else
                                        <span class="badge bg-light text-dark">{{ $historyReport->state ?? 'N/A' }}</span>
                                        @endif
                                    </p>
                                    <p><strong>Fecha Reporte:</strong> {{ $historyReport->created_at ? $historyReport->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                    <p><strong>Fecha Acción:</strong> {{ $historyReport->updated_at ? $historyReport->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                    <p><strong>Descripción:</strong> {{ $historyReport->description }}</p>
                                    @if($historyReport->action_detail)
                                    <p><strong>Detalle de Acción:</strong> {{ $historyReport->action_detail }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary border-bottom border-primary pb-1"><i class="fas fa-desktop"></i> Información del Equipo</h6>
                                    @if($historyReport->inventory && $historyReport->inventory->element)
                                    <p><strong>Nombre:</strong> {{ $historyReport->inventory->element->name ?? 'N/A' }}</p>
                                    @if($historyReport->inventory->computer)
                                    <p><strong>Serie:</strong> {{ $historyReport->inventory->computer->serial_number ?? 'N/A' }}</p>
                                    <p><strong>Marca:</strong> {{ $historyReport->inventory->computer->brand ?? 'N/A' }}</p>
                                    <p><strong>Modelo:</strong> {{ $historyReport->inventory->computer->model ?? 'N/A' }}</p>
                                    @endif
                                    @else
                                    <p class="text-danger">Sin información de inventario</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach

            @foreach($damageReportsWithRelations as $report)
            <div class="modal fade" id="detailModal{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $report->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel{{ $report->id }}">
                                <i class="fas fa-eye"></i> Detalles del Reporte #{{ $report->id }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary border-bottom border-primary pb-1"><i class="fas fa-file-alt"></i> Información del Reporte</h6>
                                    <p><strong>ID:</strong> {{ $report->id }}</p>
                                    <p><strong>Usuario:</strong> {{ $report->user->person->full_name ?? ($report->user->nickname ?? ($report->user->name ?? 'N/A')) }}</p>
                                    <p><strong>Estado:</strong>
                                        @if($report->state === 'Arreglado')
                                        <span class="badge bg-success"><i class="fas fa-wrench"></i> Arreglado</span>
                                        @elseif($report->state === 'Rechazado')
                                        <span class="badge bg-danger"><i class="fas fa-times"></i> Rechazado</span>
                                        @elseif($report->state === 'Baja')
                                        <span class="badge bg-secondary"><i class="fas fa-trash"></i> Baja</span>
                                        @elseif($report->state === 'Aprobado')
                                        <span class="badge bg-primary"><i class="fas fa-check"></i> Aprobado</span>
                                        @elseif($report->state === 'Solicitado')
                                        <span class="badge bg-warning"><i class="fas fa-clock"></i> Solicitado</span>
                                        @elseif($report->state === 'En arreglo')
                                        <span class="badge bg-info"><i class="fas fa-tools"></i> En arreglo</span>
                                        @else
                                        <span class="badge bg-light text-dark">{{ $report->state ?? 'N/A' }}</span>
                                        @endif
                                    </p>
                                    <p><strong>Fecha Reporte:</strong> {{ $report->created_at ? $report->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                    <p><strong>Fecha Acción:</strong> {{ $report->updated_at ? $report->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                    <p><strong>Descripción:</strong> {{ $report->description }}</p>
                                    @if($report->action_detail)
                                    <p><strong>Detalle de Acción:</strong> {{ $report->action_detail }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary border-bottom border-primary pb-1"><i class="fas fa-desktop"></i> Información del Equipo</h6>
                                    @if($report->inventory && $report->inventory->element)
                                    <p><strong>Nombre:</strong> {{ $report->inventory->element->name ?? 'N/A' }}</p>
                                    @if($report->inventory->computer)
                                    <p><strong>Serie:</strong> {{ $report->inventory->computer->serial_number ?? 'N/A' }}</p>
                                    <p><strong>Marca:</strong> {{ $report->inventory->computer->brand ?? 'N/A' }}</p>
                                    <p><strong>Modelo:</strong> {{ $report->inventory->computer->model ?? 'N/A' }}</p>
                                    @endif
                                    @else
                                    <p class="text-danger">Sin información de inventario</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="card">
                <div class="card-body text-center text-muted">
                    <p>No hay reportes de daño en seguimiento.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection