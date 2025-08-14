

@extends('sibaf::layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('modules/sibaf/css/downgrades.css') }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 text-gray-800">Bajas de Computadores</h1>
                <a href="{{ route('sibaf.admin.welcome') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Todas las Bajas Aprobadas</h6>
                </div>
                <div class="card-body">
                    @if($downgrades->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Equipo</th>
                                        <th>Usuario Solicitante</th>
                                        <th>Estado</th>
                                        <th>Fecha de Aprobación</th>
                                        <th>Documentos</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($downgrades as $downgrade)
                                        <tr>
                                            <td>{{ $downgrade->id }}</td>
                                            <td>
                                                <strong>{{ $downgrade->inventory->element->name ?? 'No especificado' }}</strong>
                                                @if($downgrade->inventory)
                                                    <br>
                                                    <small class="text-muted">
                                                        Inventario ID: {{ $downgrade->inventory_id }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $downgrade->user->person->full_name ?? 'No especificado' }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $downgrade->user->email ?? 'Email no disponible' }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">{{ $downgrade->estado }}</span>
                                            </td>
                                            <td>
                                                @if($downgrade->fecha_aprobacion)
                                                    {{ $downgrade->fecha_aprobacion->format('d/m/Y H:i') }}
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $downgrade->fecha_aprobacion->diffForHumans() }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">No especificada</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if($downgrade->excel1_path)
                                                        <a href="{{ route('sibaf.admin.downgrades.download', ['downgrade' => $downgrade->id, 'fileType' => 'excel1']) }}" 
                                                           class="btn btn-sm btn-outline-primary" title="Descargar Excel 1">
                                                            <i class="fas fa-download"></i> Excel 1
                                                        </a>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-secondary" disabled title="Archivo no disponible">
                                                            <i class="fas fa-times"></i> Excel 1
                                                        </button>
                                                    @endif
                                                    
                                                    @if($downgrade->excel2_path)
                                                        <a href="{{ route('sibaf.admin.downgrades.download', ['downgrade' => $downgrade->id, 'fileType' => 'excel2']) }}" 
                                                           class="btn btn-sm btn-outline-success" title="Descargar Excel 2">
                                                            <i class="fas fa-download"></i> Excel 2
                                                        </a>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-secondary" disabled title="Archivo no disponible">
                                                            <i class="fas fa-times"></i> Excel 2
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info" 
                                                        onclick="showDowngradeDetails({{ $downgrade->id }})"
                                                        title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $downgrades->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-laptop fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No hay bajas registradas</h5>
                            <p class="text-gray-400">Cuando se aprueben bajas de computadores, aparecerán aquí.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para detalles de la baja -->
<div class="modal fade" id="downgradeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="downgradeDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="downgradeDetailsModalLabel">Detalles de la Baja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="downgradeDetailsContent">
                <!-- El contenido se cargará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<script>
function showDowngradeDetails(downgradeId) {
    // Aquí puedes implementar la lógica para cargar los detalles
    // Por ahora solo mostraremos un mensaje
    document.getElementById('downgradeDetailsContent').innerHTML = 
        '<p class="text-center">Detalles de la baja ID: ' + downgradeId + '</p>' +
        '<p class="text-muted">Esta funcionalidad se puede expandir para mostrar más información.</p>';
    
    $('#downgradeDetailsModal').modal('show');
}
</script>
@endsection 