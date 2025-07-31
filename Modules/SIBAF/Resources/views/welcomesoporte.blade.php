@extends('sibaf::layouts.mastersoporte')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Reportes de Daño</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(isset($damageReports) && $damageReports->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
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
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->inventory->element->name ?? 'N/A' }}</td>
                            <td>{{ $report->user->person->full_name ?? 'N/A' }}</td>
                            <td>{{ $report->description }}</td>
                            <td>{{ $report->movement->state ?? $report->state }}</td>
                            <td>{{ $report->movement->registration_date ?? 'N/A' }}</td>
                            <td>
                                @if($report->photo_path && file_exists(public_path('storage/' . $report->photo_path)))
                                    <a href="{{ asset('storage/' . $report->photo_path) }}" target="_blank">Ver foto</a>
                                @elseif($report->photo_path)
                                    <span class="text-danger">Imagen no encontrada</span>
                                @else
                                    No disponible
                                @endif
                            </td>
                            <td>
                                @if(isset($report->movement) && $report->movement->state === 'Solicitado')
                                    <!-- Botón para abrir el modal de aprobación -->
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveModal{{ $report->id }}">
                                        Aprobar
                                    </button>
                                    <form action="{{ route('sibaf.support.damage_reports.reject', $report->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Rechazar este reporte?')">Rechazar</button>
                                    </form>

                                    <!-- Modal de aprobación -->
                                    <div class="modal fade" id="approveModal{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $report->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="approveModalLabel{{ $report->id }}">Aprobar reporte</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Qué acción desea realizar con este reporte?</p>
                                                    <button type="button" class="btn btn-info btn-block mb-2" onclick="handleApproveAction('arreglo', {{ $report->id }})">Aprobar para Arreglo</button>
                                                    <button type="button" class="btn btn-warning btn-block" onclick="handleApproveAction('baja', {{ $report->id }})">Aprobar para Baja</button>
                                                    <!-- Formulario de baja, oculto por defecto -->
                                                    <form id="bajaForm{{ $report->id }}" action="{{ route('sibaf.support.damage_reports.approve', $report->id) }}" method="POST" enctype="multipart/form-data" style="display:none; margin-top:20px;">
                                                        @csrf
                                                        <input type="hidden" name="action" value="baja">
                                                        <div class="form-group">
                                                            <label>Archivo Excel 1 (Formato de baja):</label>
                                                            <input type="file" name="excel1" class="form-control" accept=".xlsx,.xls" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Archivo Excel 2 (Acta de baja):</label>
                                                            <input type="file" name="excel2" class="form-control" accept=".xlsx,.xls" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-block">Subir y aprobar baja</button>
                                                    </form>
                                                    <!-- Formulario de arreglo, oculto por defecto -->
                                                    <form id="arregloForm{{ $report->id }}" action="{{ route('sibaf.support.damage_reports.approve', $report->id) }}" method="POST" style="display:none; margin-top:20px;">
                                                        @csrf
                                                        <input type="hidden" name="action" value="arreglo">
                                                        <button type="submit" class="btn btn-success btn-block">Confirmar aprobación para arreglo</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function handleApproveAction(action, id) {
                                            document.getElementById('bajaForm'+id).style.display = (action === 'baja') ? 'block' : 'none';
                                            document.getElementById('arregloForm'+id).style.display = (action === 'arreglo') ? 'block' : 'none';
                                        }
                                    </script>
                                @else
                                    <span class="text-muted">Sin acciones</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">No hay reportes de daño pendientes.</div>
    @endif
</div>
@endsection