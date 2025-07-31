@extends('sibaf::layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Bajas de Computadores</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('sibaf.admin.welcome') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Bajas</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Todas las Bajas Aprobadas</h3>
            </div>
            <div class="card-body">
                @if($downgrades->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Equipo</th>
                                    <th>Usuario Solicitante</th>
                                    <th>Estado</th>
                                    <th>Fecha de Aprobación</th>
                                    <th>Documentos</th>
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
                                                @php
                                                    $fecha = is_string($downgrade->fecha_aprobacion) 
                                                        ? \Carbon\Carbon::parse($downgrade->fecha_aprobacion) 
                                                        : $downgrade->fecha_aprobacion;
                                                @endphp
                                                {{ $fecha->format('d/m/Y H:i') }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $fecha->diffForHumans() }}
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $downgrades->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-laptop fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-500">No hay bajas registradas</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.table th {
    background-color: #f8f9fc;
    border-top: none;
}

.btn-group .btn {
    margin-right: 2px;
}

.badge {
    font-size: 0.8em;
}
</style>
@endsection 