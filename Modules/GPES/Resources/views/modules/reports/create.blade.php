@extends('gpes::layouts.master')

@section("content")
    <!-- Mensajes Flash -->
    @if (session('success'))
        <div class="container py-3">
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container py-3">
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Contenedor Principal -->
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                    <!-- Encabezado con fondo negro y texto blanco -->
                    <div class="card-header bg-dark text-white border-bottom py-3 text-center">
                        <h3 class="mb-0 fw-bold text-white">
                            <i class="bi bi-journal-plus me-2"></i>Crear Reporte
                        </h3>
                    </div>

                    <div class="card-body p-4 bg-light">
                        <form action="{{ route('gpes.cuentadante.reports.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <!-- Campo: Título -->
                            <div class="mb-3">
                                <label for="title" class="form-label fw-semibold">Título</label>
                                <input type="text" name="title" id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" required>
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Campo: Descripción -->
                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Descripción</label>
                                <textarea name="description" id="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="2">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Campo: Serial del Computador -->
                            <div class="mb-3">
                                <label for="serial_number" class="form-label fw-semibold">Serial del Computador</label>
                                <input type="text" name="serial_number" id="serial_number"
                                       class="form-control @error('serial_number') is-invalid @enderror"
                                       value="{{ old('serial_number') }}" required>
                                @error('serial_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Campo: Cédula del Acusado -->
                            <div class="mb-3">
                                <label for="accused_document_number" class="form-label fw-semibold">Cédula del Acusado (opcional)</label>
                                <input type="number" name="accused_document_number" id="accused_document_number"
                                       class="form-control @error('accused_document_number') is-invalid @enderror"
                                       value="{{ old('accused_document_number') }}">
                                @error('accused_document_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Botones -->
                            <div class="d-flex gap-3 mt-4">
                                <a href="{{ route('gpes.cuentadante.reports.index') }}" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-arrow-left me-1"></i>Volver
                                </a>
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-save me-1"></i>Guardar Reporte
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection