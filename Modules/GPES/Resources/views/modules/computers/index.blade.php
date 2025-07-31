@extends('gpes::layouts.master')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-pc me-2"></i>Lista de Computadores
            </h2>
            <a href="{{ route('gpes.cuentadante.computers.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i>Agregar Computador
            </a>
        </div>

        {{-- Mostrar mensajes flash --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Verificar si hay elementos --}}
        @if ($elements->isEmpty())
            <div class="text-center py-5 bg-light rounded-3">
                <i class="bi bi-pc-display-horizontal text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No hay computadores registrados</h5>
            </div>
        @else
            <div class="table-responsive shadow-sm rounded-3 overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Número de Serie</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Bodega</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($elements as $element)
                            <tr>
                                <td>{{ $element->computers->name ?? 'Computador eliminado' }}</td>
                                <td>{{ $element->computers->serial_number ?? '-' }}</td>
                                <td>{{ $element->computers->brand ?? '-' }}</td>
                                <td>{{ $element->computers->model ?? '-' }}</td>
                                <td>
                                    @php
                                        $inventory = \Modules\SICA\Entities\Inventory::where('element_id', $element->id)->first();
                                        $warehouse = $inventory ? ($inventory->productive_unit_warehouse->warehouse->name ?? '-') : '-';
                                    @endphp
                                    {{ $warehouse }}
                                </td>
                                <td class="text-end">
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('gpes.cuentadante.computers.edit', $element->id) }}" 
                                       class="btn btn-sm btn-outline-warning me-1" 
                                       title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Botón Eliminar --}}
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="showDeleteModal('{{ route('gpes.cuentadante.computers.destroy', $element->id) }}')"
                                            title="Eliminar">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Modal de Confirmación de Eliminación --}}
    <div class="modal" id="deleteModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header-delete">
                <h2>Confirmar Eliminación</h2>
                <button class="close-btn" onclick="closeModal('deleteModal')">×</button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de eliminar este computador?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-white-delete" onclick="closeModal('deleteModal')">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary-delete">Eliminar</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Estilos personalizados del modal --}}
    <style>
        .modal {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1050;
        }

        .modal-content {
            background: #fff;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-header-delete {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #dc3545;
            color: #fff;
        }

        .modal-header-delete h2 {
            margin: 0;
            font-size: 1.25rem;
        }

        .close-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .modal-body {
            padding: 20px;
            font-size: 1rem;
            color: #333;
        }

        .modal-footer {
            padding: 15px 20px;
            text-align: right;
            border-top: 1px solid #e9ecef;
        }

        .btn-white-delete {
            background: #fff;
            color: #dc3545;
            border: 1px solid #dc3545;
            padding: 6px 12px;
            border-radius: 4px;
            margin-right: 8px;
        }

        .btn-white-delete:hover {
            background: #f8f9fa;
            color: #c82333;
            border-color: #c82333;
        }

        .btn-primary-delete {
            background: #dc3545;
            color: #fff;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
        }

        .btn-primary-delete:hover {
            background: #c82333;
        }

        .bi {
            visibility: visible !important;
            opacity: 1 !important;
        }
    </style>

    {{-- Scripts funcionales --}}
    <script>
        function showDeleteModal(deleteUrl) {
            const form = document.getElementById('deleteForm');
            form.action = deleteUrl;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal('deleteModal');
            }
        });
    </script>
@endsection
