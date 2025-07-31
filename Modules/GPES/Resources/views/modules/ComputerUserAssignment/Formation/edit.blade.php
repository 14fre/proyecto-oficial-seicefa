@extends('gpes::layouts.master')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Editar Asignación de Computador por formacion</h1>

    <!-- Success and Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Assignment Form -->
    <div class="card border-light">
        <div class="card-body">
            <form action="{{ route('gpes.cuentadante.assignmentsUserComputer.formation.update', $assignment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="document_number" class="form-label">Cédula del Usuario</label>
                        <input type="text" name="document_number" id="document_number" class="form-control @error('document_number') is-invalid @enderror" value="{{ old('document_number', $assignment->user->person->document_number) }}" required>
                        @error('document_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="computer_id" class="form-label">Computador</label>
                        <select name="computer_id" id="computer_id" class="form-select @error('computer_id') is-invalid @enderror" required>
                            <option value="">Seleccione un computador</option>
                            @foreach($computers as $computer)
                                <option value="{{ $computer->id }}" {{ old('computer_id', $assignment->computer_id) == $computer->id ? 'selected' : '' }}>
                                    {{ $computer->name }} ({{ $computer->serial_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('computer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="assigned_at" class="form-label">Fecha y Hora de Asignación</label>
                        <input type="datetime-local" name="assigned_at" id="assigned_at" class="form-control @error('assigned_at') is-invalid @enderror" value="{{ old('assigned_at', \Carbon\Carbon::parse($assignment->assigned_at)->format('Y-m-d\TH:i')) }}" required>
                        @error('assigned_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label">Ubicación</label>
                        <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $assignment->location) }}" placeholder="Ej: Aula 101" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="observation" class="form-label">Observaciones</label>
                    <textarea name="observation" id="observation" class="form-control @error('observation') is-invalid @enderror" rows="5" placeholder="Notas adicionales (opcional)">{{ old('observation', $assignment->observation) }}</textarea>
                    @error('observation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Actualizar Asignación</button>
                    <a href="{{ route('gpes.cuentadante.assignmentsUserComputer.formation.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection