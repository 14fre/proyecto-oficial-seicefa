@extends('gpes::layouts.master')

@section('content')
    <div class="container py-4">
        <!-- Título -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-laptop me-2"></i>Editar Asignación de Computador por Día
            </h2>
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

        <!-- Card del Formulario -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-body p-4">
                <form action="{{ route('gpes.cuentadante.assignmentsUserComputer.day.update', $assignment->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <!-- Fila: Cédula + Computador -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="document_number" class="form-label fw-semibold">Cédula del Usuario</label>
                            <input type="text"
                                   name="document_number"
                                   id="document_number"
                                   class="form-control @error('document_number') is-invalid @enderror"
                                   value="{{ old('document_number', $assignment->user->person->document_number) }}"
                                   required>
                            @error('document_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="computer_id" class="form-label fw-semibold">Computador</label>
                            <select name="computer_id" id="computer_id"
                                    class="form-select @error('computer_id') is-invalid @enderror"
                                    required>
                                <option value="">Seleccione un computador</option>
                                @foreach ($computers as $computer)
                                    <option value="{{ $computer->id }}"
                                        {{ old('computer_id', $assignment->computer_id) == $computer->id ? 'selected' : '' }}>
                                        {{ $computer->name }} ({{ $computer->serial_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('computer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Fila: Fecha y Ubicación -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="assigned_at" class="form-label fw-semibold">Fecha y Hora de Asignación</label>
                            <input type="datetime-local"
                                   name="assigned_at"
                                   id="assigned_at"
                                   class="form-control @error('assigned_at') is-invalid @enderror"
                                   value="{{ old('assigned_at', \Carbon\Carbon::parse($assignment->assigned_at)->format('Y-m-d\TH:i')) }}"
                                   required>
                            @error('assigned_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="location" class="form-label fw-semibold">Ubicación</label>
                            <input type="text"
                                   name="location"
                                   id="location"
                                   class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location', $assignment->location) }}"
                                   placeholder="Ej: Aula 101"
                                   required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Campo: Observaciones -->
                    <div class="mb-4">
                        <label for="observation" class="form-label fw-semibold">Observaciones</label>
                        <textarea name="observation"
                                  id="observation"
                                  rows="4"
                                  class="form-control @error('observation') is-invalid @enderror"
                                  placeholder="Notas adicionales (opcional)">{{ old('observation', $assignment->observation) }}</textarea>
                        @error('observation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                            <i class="bi bi-save me-1"></i>Actualizar Asignación
                        </button>
                        <a href="{{ route('gpes.cuentadante.assignmentsUserComputer.day.index') }}" class="btn btn-secondary px-4 py-2 shadow-sm">
                            <i class="bi bi-x-circle me-1"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection