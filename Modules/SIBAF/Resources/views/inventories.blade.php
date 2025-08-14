@extends(request()->is('instructor/*') ? 'sibaf::layouts.masterinstructor' : 'sibaf::layouts.master')

@section('title', 'Inventario de Equipos')

@section('content')
<link rel="stylesheet" href="{{ asset('modules/sibaf/css/inventories.css') }}">
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Inventario de Computadores</h1>
            </div>
            
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Card Principal -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Lista de Computadores</h3>
                <button class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>

            <div class="card-body">
                <!-- Filtros -->
                <form method="GET" action="{{ route('admin.sibaf.inventory.index') }}" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <input type="text" name="serial_number" value="{{ request('serial_number') }}" class="form-control" placeholder="Serial del computador">
                    </div>
                    <div class="col-md-3">
                        <select name="warehouse_id" class="form-control">
                            <option value="">Todas las bodegas</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </form>

                <!-- Tabla -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th><i class="fas fa-desktop"></i> Nombre</th>
                                <th><i class="fas fa-barcode"></i> Serie</th>
                                <th><i class="fas fa-industry"></i> Marca</th>
                                <th><i class="fas fa-cube"></i> Modelo</th>
                                <th><i class="fas fa-microchip"></i> Procesador</th>
                                <th><i class="fas fa-memory"></i> RAM</th>
                                <th><i class="fas fa-laptop-code"></i> SO</th>
                                <th><i class="fas fa-tags"></i> Categoría</th>
                                <th><i class="fas fa-warehouse"></i> Bodega</th>
                                <th><i class="fas fa-toggle-on"></i> Estado</th>
                                <th><i class="fas fa-cogs"></i> Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inventories as $inventory)
                                <tr>
                                    <td class="text-center font-weight-bold">{{ $inventory->id }}</td>
                                    <td>{{ $inventory->computer->name ?? 'N/A' }}</td>
                                    <td>{{ $inventory->computer->serial_number ?? 'N/A' }}</td>
                                    <td>{{ $inventory->computer->brand ?? 'N/A' }}</td>
                                    <td>{{ $inventory->computer->model ?? 'N/A' }}</td>
                                    <td>{{ $inventory->computer->processor ?? 'N/A' }}</td>
                                    <td>{{ $inventory->computer->ram ?? 'N/A' }}</td>
                                    <td>{{ $inventory->computer->operating_system ?? 'N/A' }}</td>
                                    <td>{{ $inventory->element->category->name ?? 'N/A' }}</td>
                                    <td>{{ $inventory->productive_unit_warehouse->warehouse->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($inventory->state == 'Disponible')
                                            <span class="badge badge-success"><i class="fas fa-check"></i> Disponible</span>
                                        @elseif($inventory->state == 'Arreglado')
                                            <span class="badge badge-warning"><i class="fas fa-wrench"></i> Arreglado</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fas fa-times"></i> No disponible</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Botón Ver -->
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalDetalle{{ $inventory->id }}" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <!-- Botón Reporte Daño (condicional) -->
                                        @if(in_array($inventory->state, ['Disponible', 'Arreglado']))
                                            @if(!$inventory->damageReports()->whereNotIn('state', ['Arreglado'])->exists())
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalReporteDanio{{ $inventory->id }}" title="Reportar daño">
                                                    <i class="fas fa-tools"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-secondary btn-sm" 
                                                    onclick="Swal.fire({
                                                        icon: 'warning',
                                                        title: 'Acción no permitida',
                                                        text: 'Ya existe un reporte de daño pendiente para este equipo. Espere a que sea marcado como arreglado.',
                                                        confirmButtonColor: '#6c757d'
                                                    });" 
                                                    title="No disponible para reporte">
                                                    <i class="fas fa-tools"></i>
                                                </button>
                                            @endif
                                        @else
                                            <button class="btn btn-secondary btn-sm" 
                                                onclick="Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Acción no permitida',
                                                    text: 'No se puede reportar daño porque el equipo está en estado No disponible.',
                                                    confirmButtonColor: '#6c757d'
                                                });" 
                                                title="No disponible para reporte">
                                                <i class="fas fa-tools"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Modal Detalle Mejorado -->
                                <div class="modal fade" id="modalDetalle{{ $inventory->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDetalleLabel{{ $inventory->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content" style="background: #23272b; color: #fff; border-radius: 12px;">
                                            <div class="modal-header" style="border-bottom: 1px solid #444;">
                                                <h5 class="modal-title" id="modalDetalleLabel{{ $inventory->id }}">
                                                    <i class="fas fa-desktop"></i> Detalles del Computador
                                                </h5>
                                                
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <span class="font-weight-bold"><i class="fas fa-desktop"></i> Nombre:</span>
                                                        <span class="ml-2">{{ $inventory->computer->name ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <span class="font-weight-bold"><i class="fas fa-barcode"></i> Serie:</span>
                                                        <span class="ml-2">{{ $inventory->computer->serial_number ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <span class="font-weight-bold"><i class="fas fa-industry"></i> Marca:</span>
                                                        <span class="ml-2">{{ $inventory->computer->brand ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <span class="font-weight-bold"><i class="fas fa-cube"></i> Modelo:</span>
                                                        <span class="ml-2">{{ $inventory->computer->model ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <span class="font-weight-bold"><i class="fas fa-microchip"></i> Procesador:</span>
                                                        <span class="ml-2">{{ $inventory->computer->processor ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <span class="font-weight-bold"><i class="fas fa-memory"></i> RAM:</span>
                                                        <span class="ml-2">{{ $inventory->computer->ram ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <span class="font-weight-bold"><i class="fas fa-laptop-code"></i> SO:</span>
                                                        <span class="ml-2">{{ $inventory->computer->operating_system ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <span class="font-weight-bold"><i class="fas fa-tags"></i> Categoría:</span>
                                                        <span class="ml-2">{{ $inventory->element->category->name ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <span class="font-weight-bold"><i class="fas fa-warehouse"></i> Bodega:</span>
                                                        <span class="ml-2">{{ $inventory->productive_unit_warehouse->warehouse->name ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <span class="font-weight-bold"><i class="fas fa-toggle-on"></i> Estado:</span>
                                                        <span class="ml-2">
                                                            @if($inventory->state == 'Disponible')
                                                                <span class="badge badge-success"><i class="fas fa-check"></i> Disponible</span>
                                                            @elseif($inventory->state == 'Arreglado')
                                                                <span class="badge badge-warning"><i class="fas fa-wrench"></i> Arreglado</span>
                                                            @else
                                                                <span class="badge badge-danger"><i class="fas fa-times"></i> No disponible</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top: 1px solid #444;">
                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                                                    <i class="fas fa-times"></i> Cerrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Reporte Daño -->
                                <div class="modal fade" id="modalReporteDanio{{ $inventory->id }}" tabindex="-1" role="dialog" aria-labelledby="modalReporteDanioLabel{{ $inventory->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content" style="background: #23272b; color: #fff; border-radius: 12px;">
                                            <form method="POST" action="{{ route('admin.sibaf.damage_reports.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                                                <div class="modal-header" style="border-bottom: 1px solid #444;">
                                                    <h5 class="modal-title" id="modalReporteDanioLabel{{ $inventory->id }}">
                                                        <i class="fas fa-tools"></i> Reportar Daño del Computador
                                                    </h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <span class="font-weight-bold"><i class="fas fa-desktop"></i> Nombre:</span>
                                                            <span class="ml-2">{{ $inventory->computer->name ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <span class="font-weight-bold"><i class="fas fa-barcode"></i> Serie:</span>
                                                            <span class="ml-2">{{ $inventory->computer->serial_number ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <span class="font-weight-bold"><i class="fas fa-user"></i> Usuario:</span>
                                                            <span class="ml-2">{{ Auth::user()->email ?? '' }}</span>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <span class="font-weight-bold"><i class="fas fa-user-tag"></i> Nombre:</span>
                                                            <span class="ml-2">{{ Auth::user()->nickname ?? '' }}</span>
                                                        </div>
                                                        
                                                        <div class="col-md-12 mb-3">
                                                            <label for="damage_description_{{ $inventory->id }}" class="font-weight-bold"><i class="fas fa-align-left"></i> Descripción del daño:</label>
                                                            <textarea name="description" id="damage_description_{{ $inventory->id }}" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="state_{{ $inventory->id }}" class="font-weight-bold"><i class="fas fa-toggle-on"></i> Estado:</label>
                                                            <input type="text" name="state" id="state_{{ $inventory->id }}" class="form-control" value="Solicitado" readonly>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label for="photo_{{ $inventory->id }}" class="font-weight-bold"><i class="fas fa-image"></i> Foto del daño:</label>
                                                            <input type="file" name="photo" id="photo_{{ $inventory->id }}" class="form-control-file" accept="image/*">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="border-top: 1px solid #444;">
                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-paper-plane"></i> Enviar Reporte
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No hay computadores disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if (method_exists($inventories, 'links'))
                    <div class="d-flex justify-content-center mt-3">
                        {{ $inventories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Bootstrap JS (para modales) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection