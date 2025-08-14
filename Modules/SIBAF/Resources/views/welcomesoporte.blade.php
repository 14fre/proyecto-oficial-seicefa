@extends('sibaf::layouts.mastersoporte')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-primary"><i class="fas fa-tools"></i> Reportes de Daño</h2>
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
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Reportes</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>ID</th>
                                        <th>Equipo</th>
                                        <th>Usuario</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Foto</th>
                                        <th>Acciones</th>
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
                                            <td class="align-middle">{{ Str::limit($report->description, 50) }}</td>
                                            <td class="align-middle">
                                                @if($estado === 'Solicitado')
                                                    <span class="badge badge-warning"><i class="fas fa-clock"></i> {{ $estado }}</span>
                                                @elseif($estado === 'En arreglo')
                                                    <span class="badge badge-info"><i class="fas fa-wrench"></i> {{ $estado }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">{{ $report->movement->registration_date ?? 'N/A' }}</td>
                                            <td class="align-middle">
                                                @if($report->photo_path && file_exists(public_path('storage/' . $report->photo_path)))
                                                    <a href="{{ asset('storage/' . $report->photo_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </a>
                                                @elseif($report->photo_path)
                                                    <span class="text-danger">Imagen no encontrada</span>
                                                @else
                                                    <span class="text-muted">No disponible</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <!-- Botón Ver -->
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal{{ $report->id }}" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if(isset($report->movement))
                                                    @if($estado === 'Solicitado')
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveModal{{ $report->id }}" title="Aprobar">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <form action="{{ route('sibaf.support.damage_reports.reject', $report->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm reject-btn" data-report-id="{{ $report->id }}" title="Rechazar">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @elseif($estado === 'En arreglo')
                                                        <form action="{{ route('sibaf.support.damage_reports.complete', $report->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('¿Marcar este equipo como reparado?')" title="Marcar como Reparado">
                                                                <i class="fas fa-wrench"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted">Sin acciones</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Sin acciones</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Modal de visualización -->
                                        <div class="modal fade" id="viewModal{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $report->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content bg-dark text-white">
                                                    <div class="modal-header border-primary">
                                                        <h5 class="modal-title" id="viewModalLabel{{ $report->id }}">
                                                            <i class="fas fa-desktop"></i> Detalles del Reporte y Equipo
                                                        </h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6 class="text-primary"><i class="fas fa-file-alt"></i> Información del Reporte</h6>
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
                                                                    <span class="ml-2 text-warning">No disponible</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr class="bg-light">
                                                        <h6 class="text-primary"><i class="fas fa-desktop"></i> Información del Equipo</h6>
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
                                                                        <span class="badge badge-success"><i class="fas fa-check"></i> Disponible</span>
                                                                    @elseif($report->inventory->state == 'Arreglado')
                                                                        <span class="badge badge-info"><i class="fas fa-wrench"></i> Arreglado</span>
                                                                    @else
                                                                        <span class="badge badge-danger"><i class="fas fa-times"></i> No disponible</span>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-primary">
                                                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                                                            <i class="fas fa-times"></i> Cerrar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal de aprobación -->
                                        <div class="modal fade" id="approveModal{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $report->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content bg-dark text-white">
                                                    <div class="modal-header border-success">
                                                        <h5 class="modal-title" id="approveModalLabel{{ $report->id }}">
                                                            <i class="fas fa-check-circle"></i> Aprobar Reporte #{{ $report->id }}
                                                        </h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="mb-4 text-white">Seleccione la acción para el reporte del equipo <strong>{{ $report->inventory->element->name ?? 'N/A' }}</strong>:</p>
                                                        <!-- Formulario de arreglo -->
                                                        <form id="arregloForm{{ $report->id }}" action="{{ route('sibaf.support.damage_reports.approve', $report->id) }}" method="POST" class="mb-3">
                                                            @csrf
                                                            <input type="hidden" name="action" value="arreglo">
                                                            <button type="button" class="btn btn-success btn-block" onclick="confirmSubmit('arreglo', {{ $report->id }})">
                                                                <i class="fas fa-wrench"></i> Aprobar para Arreglo
                                                            </button>
                                                        </form>
                                                        <!-- Formulario de baja -->
                                                        <form id="bajaForm{{ $report->id }}" action="{{ route('sibaf.support.damage_reports.approve', $report->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="action" value="baja">
                                                            <div class="form-group">
                                                                <label for="excel1_{{ $report->id }}" class="font-weight-bold text-white"><i class="fas fa-file-excel"></i> Formato de Baja:</label>
                                                                <input type="file" name="excel1" id="excel1_{{ $report->id }}" class="form-control bg-dark text-white" accept=".xlsx,.xls" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="excel2_{{ $report->id }}" class="font-weight-bold text-white"><i class="fas fa-file-excel"></i> Acta de Baja:</label>
                                                                <input type="file" name="excel2" id="excel2_{{ $report->id }}" class="form-control bg-dark text-white" accept=".xlsx,.xls" required>
                                                            </div>
                                                            <button type="button" class="btn btn-warning btn-block" onclick="confirmSubmit('baja', {{ $report->id }})">
                                                                <i class="fas fa-trash-alt"></i> Aprobar para Baja
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer border-success">
                                                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">
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
                <div class="card card-info card-outline shadow-sm">
                    <div class="card-body text-center">
                        <p class="text-muted">No hay reportes de daño.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Estilos personalizados (mantenidos igual) -->
<style>
    .bg-dark {
        background-color: #1a202c !important;
    }
    .card-primary.card-outline {
        border-top: 3px solid #007bff;
    }
    .card-info.card-outline {
        border-top: 3px solid #17a2b8;
    }
    .table-hover tbody tr:hover {
        background-color: #2d3748;
        transition: background-color 0.3s ease;
    }
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-info {
        background-color: #17a2b8;
        color: #fff;
    }
    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }
    .modal-content {
        border: none;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }
    .modal-header, .modal-footer {
        border-color: #2d3748;
    }
    .shadow-sm {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .form-control.bg-dark {
        border-color: #4a5568;
        color: #fff;
    }
    .form-control.bg-dark:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* Estilo para SweetAlert2 (mantenido igual) */
    .swal2-popup {
        font-family: 'Source Sans Pro', sans-serif;
        border-radius: 10px;
        background-color: #1a202c;
        color: #fff;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
    }
    .swal2-title {
        font-size: 1.5rem;
        color: #fff;
    }
    .swal2-content {
        font-size: 1rem;
        color: #d1d5db;
    }
    .swal2-confirm, .swal2-cancel {
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    .swal2-confirm {
        background-color: #28a745;
        border-color: #28a745;
    }
    .swal2-cancel {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .swal2-confirm:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .swal2-cancel:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
</style>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Bootstrap JS (para modales) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmSubmit(action, id) {
        let title = action === 'arreglo' ? 'Aprobar para Arreglo' : 'Aprobar para Baja';
        let text = action === 'arreglo' 
            ? '¿Está seguro de que desea aprobar este reporte para arreglo?' 
            : '¿Está seguro de que desea aprobar este reporte para baja? Asegúrese de haber seleccionado los archivos Excel.';
        Swal.fire({
            icon: 'question',
            title: title,
            text: text,
            showCancelButton: true,
            confirmButtonColor: action === 'arreglo' ? '#28a745' : '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(action + 'Form' + id).submit();
            }
        });
    }

    // Función para el botón de rechazo con SweetAlert2
    document.querySelectorAll('.reject-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Evita el envío inmediato del formulario
            const reportId = this.getAttribute('data-report-id');
            Swal.fire({
                icon: 'warning',
                title: 'Rechazar Reporte',
                text: '¿Está seguro de que desea rechazar este reporte? Esta acción no se puede deshacer.',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Rechazar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.submit(); // Envía el formulario si se confirma
                }
            });
        });
    });
</script>
@endsection