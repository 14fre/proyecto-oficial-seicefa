@extends('gpes::layouts.master')

@section('content')
    <div class="container py-4">
        <!-- Título y Botón Crear -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-laptop me-2"></i>Asignaciones de Computadores por Formación
            </h2>
            <a href="{{ route('gpes.cuentadante.assignmentsUserComputer.formation.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i>Crear Asignación
            </a>
        </div>

        <!-- Mensajes Flash -->
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

        <!-- Tabla de Asignaciones -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Usuario</th>
                                <th>Computador</th>
                                <th>Fecha Asignación</th>
                                <th>Fecha Devolución</th>
                                <th>Observaciones</th>
                                <th>Ubicación</th>
                                <th>Entregado a tiempo</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignments as $assignment)
                                <tr>
                                    <td>
                                        {{ $assignment->user->person->first_name }}
                                        {{ $assignment->user->person->first_last_name }}
                                        {{ $assignment->user->person->second_last_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $assignment->computer->name }}
                                        <span class="text-muted">({{ $assignment->computer->serial_number }})</span>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($assignment->assigned_at)->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        {{ $assignment->returned_at ? \Carbon\Carbon::parse($assignment->returned_at)->format('d/m/Y H:i') : 'No devuelto' }}
                                    </td>
                                    <td>{{ $assignment->observation ?? '-' }}</td>
                                    <td>{{ $assignment->location ?? '-' }}</td>
                                    <td>
                                        @if ($assignment->late === null)
                                            -
                                        @elseif ($assignment->late)
                                            <span class="badge bg-danger">Tarde</span>
                                        @else
                                            <span class="badge bg-success">A tiempo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $assignment->returned ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $assignment->returned ? 'Devuelto' : 'Pendiente' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <!-- Botón Marcar como Devuelto -->
                                            @if (!$assignment->returned)
                                                <button type="button"
                                                        class="btn btn-outline-warning btn-sm"
                                                        title="Marcar como devuelto"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#returnModal{{ $assignment->id }}">
                                                    <i class="bi bi-arrow-bar-left fs-5"></i>
                                                </button>
                                            @endif

                                            <!-- Botón Editar -->
                                            <a href="{{ route('gpes.cuentadante.assignmentsUserComputer.formation.edit', $assignment->id) }}"
                                               class="btn btn-outline-info btn-sm"
                                               title="Editar">
                                                <i class="bi bi-pencil-square fs-5"></i>
                                            </a>

                                            <!-- Botón Eliminar -->
                                            <button type="button"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Eliminar"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $assignment->id }}">
                                                <i class="bi bi-trash-fill fs-5"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal: Confirmar Devolución -->
                                <div class="modal fade" id="returnModal{{ $assignment->id }}" tabindex="-1"
                                     aria-labelledby="returnModalLabel{{ $assignment->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-sm rounded-3">
                                            <div class="modal-header bg-success text-white border-0">
                                                <h5 class="modal-title" id="returnModalLabel{{ $assignment->id }}">Confirmar Devolución</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de marcar la asignación de
                                                <strong>{{ $assignment->computer->name }} ({{ $assignment->computer->serial_number }})</strong>
                                                a
                                                <strong>{{ $assignment->user->person->first_name }} {{ $assignment->user->person->first_last_name }}</strong>
                                                como devuelta? Esto actualizará el estado del computador a disponible.
                                            </div>
                                            <div class="modal-footer border-0">
                                                <form action="{{ route('gpes.cuentadante.assignmentsUserComputer.formation.return', $assignment->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success px-3">Confirmar Devolución</button>
                                                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal: Eliminar Asignación -->
                                <div class="modal fade" id="deleteModal{{ $assignment->id }}" tabindex="-1"
                                     aria-labelledby="deleteModalLabel{{ $assignment->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-sm rounded-3">
                                            <div class="modal-header bg-danger text-white border-0">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $assignment->id }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar la asignación de
                                                <strong>{{ $assignment->computer->name }} ({{ $assignment->computer->serial_number }})</strong>
                                                a
                                                <strong>{{ $assignment->user->person->first_name }} {{ $assignment->user->person->first_last_name }}</strong>?
                                                Esta acción no se puede deshacer.
                                            </div>
                                            <div class="modal-footer border-0">
                                                <form action="{{ route('gpes.cuentadante.assignmentsUserComputer.formation.destroy', $assignment->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-3">Eliminar</button>
                                                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        No hay asignaciones registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection