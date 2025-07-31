@extends('gpes::layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Asignación de Computadores a Usuarios</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="mb-3">
                <a href="{{ route('gpes.cuentadante.assignmentsUserComputer.create') }}" class="btn btn-primary">Asignar equipo</a>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Computador</th>
                        <th>Tipo de Asignación</th>
                        <th>Fecha de Asignación</th>
                        <th>Fecha de Devolución</th>
                        <th>Observaciones</th>
                        <th>Estado</th>
                        <th>Estado Devolución</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->user->person->first_name }} {{ $assignment->user->person->first_last_name }} {{ $assignment->user->person->second_last_name }}</td>
                            <td>{{ $assignment->computer->name }} ({{ $assignment->computer->serial_number }})</td>
                            <td>{{ $assignment->type === 'diario' ? 'Diario' : 'Formación' }}</td>
                            <td>{{ $assignment->assigned_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $assignment->returned_at ? $assignment->returned_at->format('Y-m-d H:i') : 'No devuelto' }}</td>
                            <td>{{ $assignment->observation ?? '-' }}</td>
                            <td>{{ $assignment->returned ? 'Devuelto' : 'Pendiente' }}</td>
                            <td>{{ $assignment->returned ? ($assignment->late ? 'Tardío' : 'A tiempo') : '-' }}</td>
                            <td>
                                <a href="{{ route('gpes.cuentadante.assignmentsUserComputer.edit', $assignment->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                <form action="{{ route('gpes.cuentadante.assignmentsUserComputer.destroy', $assignment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta asignación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                                @if(!$assignment->returned)
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal{{ $assignment->id }}">Marcar como Devuelto</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="returnModal{{ $assignment->id }}" tabindex="-1" aria-labelledby="returnModalLabel{{ $assignment->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="returnModalLabel{{ $assignment->id }}">Confirmar Devolución</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de marcar la asignación de <strong>{{ $assignment->computer->name }} ({{ $assignment->computer->serial_number }})</strong> a <strong>{{ $assignment->user->person->first_name }} {{ $assignment->user->person->first_last_name }}</strong> como devuelta? Esto actualizará el estado del computador a disponible.
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('gpes.cuentadante.assignmentsUserComputer.return', $assignment->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-warning">Confirmar Devolución</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay asignaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection