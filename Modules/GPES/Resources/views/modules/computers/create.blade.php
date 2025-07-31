@extends('gpes::layouts.master')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-pc me-2"></i>Agregar Computador
            </h2>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('gpes.cuentadante.computers.store') }}" class="needs-validation bg-white p-4 rounded shadow-sm border-top border-3 border-primary" novalidate>
            @csrf

            <!-- Sección General -->
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="serial_number" class="form-label fw-semibold">Número de Serie</label>
                    <input type="text" name="serial_number" id="serial_number"
                           class="form-control @error('serial_number') is-invalid @enderror"
                           value="{{ old('serial_number') }}" required>
                    @error('serial_number')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            <!-- Sección Detalles Técnicos -->
            <h5 class="mb-3 text-secondary"><i class="bi bi-cpu me-1"></i>Detalles Técnicos</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="model" class="form-label fw-semibold">Modelo</label>
                    <input type="text" name="model" id="model"
                           class="form-control @error('model') is-invalid @enderror"
                           value="{{ old('model') }}">
                    @error('model')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="brand" class="form-label fw-semibold">Marca</label>
                    <input type="text" name="brand" id="brand"
                           class="form-control @error('brand') is-invalid @enderror"
                           value="{{ old('brand') }}">
                    @error('brand')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="processor" class="form-label fw-semibold">Procesador</label>
                    <input type="text" name="processor" id="processor"
                           class="form-control @error('processor') is-invalid @enderror"
                           value="{{ old('processor') }}">
                    @error('processor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="ram" class="form-label fw-semibold">RAM</label>
                    <input type="text" name="ram" id="ram"
                           class="form-control @error('ram') is-invalid @enderror"
                           value="{{ old('ram') }}">
                    @error('ram')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="operating_system" class="form-label fw-semibold">Sistema Operativo</label>
                    <input type="text" name="operating_system" id="operating_system"
                           class="form-control @error('operating_system') is-invalid @enderror"
                           value="{{ old('operating_system') }}">
                    @error('operating_system')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            <!-- Sección Información Adicional -->
            <h5 class="mb-3 text-secondary"><i class="bi bi-info-circle me-1"></i>Información Adicional</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="measurement_unit_id" class="form-label fw-semibold">Unidad de Medida</label>
                    <select name="measurement_unit_id" id="measurement_unit_id"
                            class="form-select @error('measurement_unit_id') is-invalid @enderror" required>
                        <option value="{{ $measurement_units->id }}" selected>{{ $measurement_units->name }}</option>
                    </select>
                    @error('measurement_unit_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="kind_of_purchase_id" class="form-label fw-semibold">Tipo de Compra</label>
                    <select name="kind_of_purchase_id" id="kind_of_purchase_id"
                            class="form-select @error('kind_of_purchase_id') is-invalid @enderror" required>
                        <option value="{{ $kind_of_purchases->id }}" selected>{{ $kind_of_purchases->name }}</option>
                    </select>
                    @error('kind_of_purchase_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="category_id" class="form-label fw-semibold">Categoría</label>
                    <select name="category_id" id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    </select>
                    @error('category_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="warehouse_id" class="form-label fw-semibold">Bodega (Trazabilidad de Bienes)</label>
                    <select name="warehouse_id" id="warehouse_id"
                            class="form-select @error('warehouse_id') is-invalid @enderror" required>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse['pivot_id'] }}">{{ $warehouse['name'] }}</option>
                        @endforeach
                    </select>
                    @error('warehouse_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="price" class="form-label fw-semibold">Precio</label>
                    <input type="number" name="price" id="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price') }}" step="0.01" min="0">
                    @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-8">
                    <label for="description" class="form-label fw-semibold">Descripción</label>
                    <textarea name="description" id="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                    <i class="bi bi-save me-1"></i>Guardar Computador
                </button>
            </div>
        </form>
    </div>
@endsection