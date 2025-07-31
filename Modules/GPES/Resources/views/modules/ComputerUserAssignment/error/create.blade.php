@extends('gpes::layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Crear Asignación</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('gpes.cuentadante.assignmentsUserComputer.searchUser') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="document_number" class="form-label">Cédula del Usuario</label>
                    <input type="text" class="form-control @error('document_number') is-invalid @enderror" id="document_number" name="document_number" value="{{ old('document_number') }}" placeholder="Ingrese Cédula" required>
                    @error('document_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Buscar Usuario</button>
            </form>

            @if(isset($person) && $person)
                <h2 class="mt-4">Usuario encontrado</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $person->document_number }}</td>
                            <td>{{ $person->first_name }}</td>
                            <td>{{ $person->first_last_name }} {{ $person->second_last_name }}</td>
                            <td>{{ $person->personal_email }}</td>
                        </tr>
                    </tbody>
                </table>

                <form action="{{ route('gpes.cuentadante.assignmentsUserComputer.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $person->users[0]->id ?? '' }}" required>
                    
                    <div class="mb-3">
                        <label for="computer_id" class="form-label">Seleccione un computador</label>
                        <select name="computer_id" class="form-control @error('computer_id') is-invalid @enderror" required>
                            <option value="">-- Seleccione un computador --</option>
                            @foreach($computers as $computer)
                                <option value="{{ $computer->id }}" {{ old('computer_id') == $computer->id ? 'selected' : '' }}>
                                    {{ $computer->name }} - {{ $computer->serial_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('computer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Tipo de Asignación</label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="diario" {{ old('type') == 'diario' ? 'selected' : '' }}>Diario (1 día)</option>
                            <option value="formacion" {{ old('type') == 'formacion' ? 'selected' : '' }}>Formación (personalizado)</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="assigned_at" class="form-label">Fecha de Asignación</label>
                        <input type="datetime-local" class="form-control @error('assigned_at') is-invalid @enderror" id="assigned_at" name="assigned_at" value="{{ old('assigned_at', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('assigned_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="returned_at" class="form-label">Fecha de Devolución</label>
                        <input type="datetime-local" class="form-control @error('returned_at') is-invalid @enderror" id="returned_at" name="returned_at" value="{{ old('returned_at', now()->addDay()->endOfDay()->format('Y-m-d\TH:i')) }}">
                        @error('returned_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="observation" class="form-label">Observaciones</label>
                        <textarea class="form-control @error('observation') is-invalid @enderror" id="observation" name="observation" rows="4">{{ old('observation') }}</textarea>
                        @error('observation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Asignar Computador</button>
                    <a href="{{ route('gpes.cuentadante.assignmentsUserComputer.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
                </form>
            @endif
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const returnedAtInput = document.getElementById('returned_at');
        const assignedAtInput = document.getElementById('assigned_at');

        function updateReturnedAt() {
            const type = typeSelect.value;
            const assignedAt = new Date(assignedAtInput.value);

            if (type === 'diario') {
                if (!isNaN(assignedAt)) {
                    const nextDay = new Date(assignedAt);
                    nextDay.setDate(assignedAt.getDate() + 1);
                    returnedAtInput.value = nextDay.toISOString().slice(0, 16);
                }
                returnedAtInput.disabled = true;
            } else if (type === 'formacion') {
                returnedAtInput.disabled = false;
                if (!returnedAtInput.value || returnedAtInput.value === '') {
                    if (!isNaN(assignedAt)) {
                        const defaultReturn = new Date(assignedAt);
                        defaultReturn.setDate(assignedAt.getDate() + 30);
                        returnedAtInput.value = defaultReturn.toISOString().slice(0, 16);
                    }
                }
            }
        }

        if (typeSelect) {
            updateReturnedAt();
            typeSelect.addEventListener('change', updateReturnedAt);
            assignedAtInput.addEventListener('change', updateReturnedAt);
        }
    });
</script>
@endsection