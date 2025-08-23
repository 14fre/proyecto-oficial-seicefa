@extends('sibaf::layouts.mastersoporte')

@section('content')
<link rel="stylesheet" href="{{ asset('modules/sibaf/css/Soporte/tablereports.css') }}">
<script src="{{ asset('modules/sibaf/js/Soporte/tablereports.js') }}" defer></script>
<style>
    :root {
        --primary-dark: #2c3e50;
        --primary-light: #34495e;
        --text-muted: #6c757d;
        --border-color: #dee2e6;
        --bg-light: #f8f9fa;
        --white: #ffffff;
    }

    .table th, .table td {
        padding: 0.5rem;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .table th {
        background-color: var(--primary-dark);
        color: var(--white);
        border: none;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: var(--bg-light);
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
        background-color: var(--white);
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

    .nav-tabs .nav-link {
        color: var(--primary-dark);
        border-radius: 0.25rem 0.25rem 0 0;
    }

    .nav-tabs .nav-link.active {
        background-color: var(--primary-dark);
        color: var(--white);
        border-color: var(--primary-dark);
    }

    .form-control {
        border-radius: 0.25rem;
        border: 1px solid var(--border-color);
    }

    .form-control:focus {
        border-color: var(--primary-dark);
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
    }

    .btn-action {
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4" style="color: var(--primary-dark);"><i class="fas fa-tools"></i> Reportes de Daño</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(isset($damageReports) && $damageReports->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Lista de Reportes</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 8%;">ID</th>
                                        <th style="width: 15%;">Equipo</th>
                                        <th style="width: 15%;">Usuario</th>
                                        <th style="width: 20%;">Descripción</th>
                                        <th style="width: 10%;">Estado</th>
                                        <th style="width: 12%;">Fecha</th>
                                        <th style="width: 10%;">Foto</th>
                                        <th style="width: 20%; text-align: center;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($damageReports as $report)
                                        @php
                                            $estado = $report->movement->state ?? $report->state;
                                        @endphp
                                        @if(in_array($estado, ['Solicitado', 'En arreglo']))
                                            <tr>
                                                <td class="align-middle">{{ $report->id }}</td>
                                                <td class="align-middle">{{ $report->inventory->element->name ?? 'N/A' }}</td>
                                                <td class="align-middle">{{ $report->user->person->full_name ?? 'N/A' }}</td>
                                                <td class="align-middle">{{ Str::limit($report->description, 40) }}</td>
                                                <td class="align-middle">
                                                    @if($estado === 'Solicitado')
                                                        <span class="badge bg-warning"><i class="fas fa-clock"></i> {{ $estado }}</span>
                                                    @elseif($estado === 'En arreglo')
                                                        <span class="badge bg-info"><i class="fas fa-wrench"></i> {{ $estado }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{ $report->movement->registration_date ?? 'N/A' }}</td>
                                                <td class="align-middle">
                                                    @if($report->photo_path && file_exists(public_path('storage/' . $report->photo_path)))
                                                        <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#imageModal{{ $report->id }}" title="Ver imagen">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>
                                                    @elseif($report->photo_path)
                                                        <span class="text-danger">Imagen no encontrada</span>
                                                    @else
                                                        <span class="text-muted">No disponible</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="btn-group" role="group">
                                                        <!-- Botón Ver Detalles -->
                                                        <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#viewModal{{ $report->id }}" title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        @if(isset($report->movement))
                                                            @if($estado === 'Solicitado')
                                                                <!-- Botón Procesar Reporte -->
                                                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#approveModal{{ $report->id }}" title="Procesar Reporte">
                                                                    <i class="fas fa-cogs"></i>
                                                                </button>
                                                            @elseif($estado === 'En arreglo')
                                                                <!-- Botón Marcar como Reparado -->
                                                                <form id="completeForm{{ $report->id }}" action="{{ route('sibaf.support.damage_reports.complete', $report->id) }}" method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="confirmComplete({{ $report->id }})" title="Marcar como Reparado">
                                                                        <i class="fas fa-wrench"></i>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span class="text-muted">Sin acciones</span>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">Sin acciones</span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal de Visualización -->
                                            <div class="modal fade" id="viewModal{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $report->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewModalLabel{{ $report->id }}">
                                                                <i class="fas fa-desktop"></i> Detalles del Reporte y Equipo
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6 style="color: var(--primary-dark);"><i class="fas fa-file-alt"></i> Información del Reporte</h6>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">ID del Reporte:</span>
                                                                    <span class="ml-2">{{ $report->id }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Usuario:</span>
                                                                    <span class="ml-2">{{ $report->user->person->full_name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Estado:</span>
                                                                    <span class="ml-2">{{ $estado }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Fecha:</span>
                                                                    <span class="ml-2">{{ $report->movement->registration_date ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <span class="font-weight-bold">Descripción:</span>
                                                                    <span class="ml-2">{{ $report->description }}</span>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <span class="font-weight-bold">Foto del Daño:</span>
                                                                    @if($report->photo_path && file_exists(public_path('storage/' . $report->photo_path)))
                                                                        <img src="{{ asset('storage/' . $report->photo_path) }}" alt="Foto del daño" class="img-fluid rounded shadow-sm" style="max-width: 250px;">
                                                                    @else
                                                                        <span class="ml-2 text-muted">No disponible</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <h6 style="color: var(--primary-dark);"><i class="fas fa-desktop"></i> Información del Equipo</h6>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Nombre:</span>
                                                                    <span class="ml-2">{{ $report->inventory->computer->name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Serie:</span>
                                                                    <span class="ml-2">{{ $report->inventory->computer->serial_number ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Marca:</span>
                                                                    <span class="ml-2">{{ $report->inventory->computer->brand ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Modelo:</span>
                                                                    <span class="ml-2">{{ $report->inventory->computer->model ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Procesador:</span>
                                                                    <span class="ml-2">{{ $report->inventory->computer->processor ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">RAM:</span>
                                                                    <span class="ml-2">{{ $report->inventory->computer->ram ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Sistema Operativo:</span>
                                                                    <span class="ml-2">{{ $report->inventory->computer->operating_system ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Categoría:</span>
                                                                    <span class="ml-2">{{ $report->inventory->element->category->name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Bodega:</span>
                                                                    <span class="ml-2">{{ $report->inventory->productive_unit_warehouse->warehouse->name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <span class="font-weight-bold">Estado:</span>
                                                                    <span class="ml-2">
                                                                        @if($report->inventory->state == 'Disponible')
                                                                            <span class="badge bg-success"><i class="fas fa-check"></i> Disponible</span>
                                                                        @elseif($report->inventory->state == 'Arreglado')
                                                                            <span class="badge bg-info"><i class="fas fa-wrench"></i> Arreglado</span>
                                                                        @else
                                                                            <span class="badge bg-danger"><i class="fas fa-times"></i> No disponible</span>
                                                                        @endif
                                                                    </span>
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

                                            <!-- Modal de Imagen -->
                                            <div class="modal fade" id="imageModal{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $report->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel{{ $report->id }}">
                                                                <i class="fas fa-image"></i> Foto del Daño
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            @if($report->photo_path && file_exists(public_path('storage/' . $report->photo_path)))
                                                                <img src="{{ asset('storage/' . $report->photo_path) }}" alt="Foto del daño" class="img-fluid rounded shadow-sm" style="max-width: 100%;">
                                                            @else
                                                                <span class="text-muted">Imagen no disponible</span>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                                                                <i class="fas fa-times"></i> Cerrar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal de Procesamiento de Reporte -->
                                            <div class="modal fade" id="approveModal{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $report->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="approveModalLabel{{ $report->id }}">
                                                                <i class="fas fa-cogs"></i> Procesar Reporte #{{ $report->id }}
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-info">
                                                                <i class="fas fa-info-circle"></i>
                                                                <strong>Equipo:</strong> {{ $report->inventory->element->name ?? 'N/A' }}
                                                            </div>

                                                            <!-- Tabbed Interface -->
                                                            <ul class="nav nav-tabs mb-3" id="actionTabs{{ $report->id }}" role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" id="arreglo-tab{{ $report->id }}" data-toggle="tab" href="#arreglo{{ $report->id }}" role="tab" aria-controls="arreglo{{ $report->id }}" aria-selected="true">Arreglo</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="rechazo-tab{{ $report->id }}" data-toggle="tab" href="#rechazo{{ $report->id }}" role="tab" aria-controls="rechazo{{ $report->id }}" aria-selected="false">Rechazo</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="baja-tab{{ $report->id }}" data-toggle="tab" href="#baja{{ $report->id }}" role="tab" aria-controls="baja{{ $report->id }}" aria-selected="false">Baja</a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content" id="actionTabContent{{ $report->id }}">
                                                                <!-- Formulario de Arreglo -->
                                                                <div class="tab-pane fade show active" id="arreglo{{ $report->id }}" role="tabpanel" aria-labelledby="arreglo-tab{{ $report->id }}">
                                                                    <form id="arregloForm{{ $report->id }}" action="{{ route('sibaf.support.damage_reports.approve', $report->id) }}" method="POST" class="mb-3">
                                                                        @csrf
                                                                        <input type="hidden" name="action" value="arreglo">
                                                                        <div class="form-group">
                                                                            <label for="arregloReason{{ $report->id }}" class="font-weight-bold">
                                                                                <i class="fas fa-wrench"></i> Detalle del Arreglo:
                                                                            </label>
                                                                            <textarea name="arreglo_reason" id="arregloReason{{ $report->id }}" class="form-control" rows="4" placeholder="Describa el trabajo realizado: reparación, actualización, etc..." required></textarea>
                                                                        </div>
                                                                        <button type="button" class="btn btn-primary btn-block btn-action" onclick="submitForm('arreglo', {{ $report->id }})">
                                                                            <i class="fas fa-check"></i> Confirmar Arreglo
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <!-- Formulario de Rechazo -->
                                                                <div class="tab-pane fade" id="rechazo{{ $report->id }}" role="tabpanel" aria-labelledby="rechazo-tab{{ $report->id }}">
                                                                    <form id="rechazoForm{{ $report->id }}" action="{{ route('sibaf.support.damage_reports.reject', $report->id) }}" method="POST" class="mb-3">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for="rechazoReason{{ $report->id }}" class="font-weight-bold">
                                                                                <i class="fas fa-times"></i> Razón del Rechazo:
                                                                            </label>
                                                                            <textarea name="rechazo_reason" id="rechazoReason{{ $report->id }}" class="form-control" rows="4" placeholder="Explique por qué se rechaza el reporte..." required></textarea>
                                                                        </div>
                                                                        <button type="button" class="btn btn-secondary btn-block btn-action" onclick="submitForm('rechazo', {{ $report->id }})">
                                                                            <i class="fas fa-times"></i> Confirmar Rechazo
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <!-- Formulario de Baja -->
                                                                <div class="tab-pane fade" id="baja{{ $report->id }}" role="tabpanel" aria-labelledby="baja-tab{{ $report->id }}">
                                                                    <form id="bajaForm{{ $report->id }}" action="{{ route('sibaf.support.damage_reports.approve', $report->id) }}" method="POST" enctype="multipart/form-data" class="mb-3">
                                                                        @csrf
                                                                        <input type="hidden" name="action" value="baja">
                                                                        <div class="form-group">
                                                                            <label for="excel1_{{ $report->id }}" class="font-weight-bold">
                                                                                <i class="fas fa-file-excel"></i> Formato de Baja:
                                                                            </label>
                                                                            <input type="file" name="excel1" id="excel1_{{ $report->id }}" class="form-control" accept=".xlsx,.xls" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="excel2_{{ $report->id }}" class="font-weight-bold">
                                                                                <i class="fas fa-file-excel"></i> Acta de Baja:
                                                                            </label>
                                                                            <input type="file" name="excel2" id="excel2_{{ $report->id }}" class="form-control" accept=".xlsx,.xls" required>
                                                                        </div>
                                                                        <button type="button" class="btn btn-primary btn-block btn-action" onclick="submitForm('baja', {{ $report->id }})">
                                                                            <i class="fas fa-trash-alt"></i> Confirmar Baja
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                                                                <i class="fas fa-times"></i> Cancelar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center text-muted">
                        <p>No hay reportes de daño.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function showForm(action, reportId) {
        // No longer needed with tabbed interface, but kept for compatibility
        document.getElementById('arregloForm' + reportId).style.display = 'none';
        document.getElementById('rechazoForm' + reportId).style.display = 'none';
        document.getElementById('bajaForm' + reportId).style.display = 'none';

        if (action === 'arreglo') {
            document.getElementById('arregloForm' + reportId).style.display = 'block';
        } else if (action === 'rechazo') {
            document.getElementById('rechazoForm' + reportId).style.display = 'block';
        } else if (action === 'baja') {
            document.getElementById('bajaForm' + reportId).style.display = 'block';
        }
    }

    function submitForm(action, reportId) {
        let title = '';
        let text = '';
        let formId = action + 'Form' + reportId;

        if (action === 'arreglo') {
            if (document.getElementById('arregloReason' + reportId).value.trim() === '') {
                Swal.fire('Error', 'Por favor, ingrese la razón o detalle del arreglo.', 'error');
                return;
            }
            title = 'Confirmar Arreglo';
            text = '¿Está seguro de aprobar este reporte para arreglo?';
        } else if (action === 'rechazo') {
            if (document.getElementById('rechazoReason' + reportId).value.trim() === '') {
                Swal.fire('Error', 'Por favor, ingrese la razón del rechazo.', 'error');
                return;
            }
            title = 'Confirmar Rechazo';
            text = '¿Está seguro de rechazar este reporte?';
        } else if (action === 'baja') {
            if (!document.getElementById('excel1_' + reportId).files.length || !document.getElementById('excel2_' + reportId).files.length) {
                Swal.fire('Error', 'Por favor, suba ambos archivos de baja.', 'error');
                return;
            }
            title = 'Confirmar Baja';
            text = '¿Está seguro de aprobar este reporte para baja?';
        }

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    function confirmComplete(reportId) {
        Swal.fire({
            title: 'Confirmar Reparación',
            text: '¿Marcar este equipo como reparado?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, marcar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('completeForm' + reportId).submit();
            }
        });
    }
</script>
@endsection