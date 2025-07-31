@extends('gpes::layouts.master')

@section("content")


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

    @if(session("assignments"))

        @php

            $assignments = session("assignments")
    
        @endphp
    @endif

    
<h1>Historial de un Usuario</h1>

<form action="{{ route('gpes.cuentadante.Search.person.Search') }}" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="document_number" class="form-control" placeholder="Ingrese la cedula del usuario" required>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
</form>
  <!-- Details Modal -->
    <div class="gpes-modal" id="gpesDetailsModal" style="display: none;">
        <div class="gpes-modal-content-index">
            <div class="gpes-modal-header">
                <h2>Detalles de la asignación</h2>
                <button class="gpes-close-btn" onclick="closeGpesModal('gpesDetailsModal')">×</button>
            </div>
            <div class="gpes-modal-body">
                <h5>Información del usuario</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>ID Persona</th>
                        <td><span id="detail-user-person_id">-</span></td>
                    </tr>
                    <tr>
                        <th>Tipo de documento</th>
                        <td><span id="detail-user-document_type">-</span></td>
                    </tr>
                    <tr>
                        <th>Número de documento</th>
                        <td><span id="detail-user-document_number">-</span></td>
                    </tr>
                    <tr>
                        <th>Nombre completo</th>
                        <td><span id="detail-user-full_name">-</span></td>
                    </tr>
                    <tr>
                        <th>Email personal</th>
                        <td><span id="detail-user-personal_email">-</span></td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td><span id="detail-user-telephone1">-</span></td>
                    </tr>
                </table>
                <h5>Información del computador</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>ID Computador</th>
                        <td><span id="detail-computer-id">-</span></td>
                    </tr>
                    <tr>
                        <th>Procesador</th>
                        <td><span id="detail-computer-processor">-</span></td>
                    </tr>
                    <tr>
                        <th>RAM</th>
                        <td><span id="detail-computer-ram">-</span></td>
                    </tr>
                    <tr>
                        <th>Sistema Operativo</th>
                        <td><span id="detail-computer-operating_system">-</span></td>
                    </tr>
                    <tr>
                        <th>Estado Asignación Día</th>
                        <td><span id="detail-computer-status_assignment_day">-</span></td>
                    </tr>
                    <tr>
                        <th>Estado Asignación Formación</th>
                        <td><span id="detail-computer-status_assignment_formation">-</span></td>
                    </tr>
                    <tr>
                        <th>Creado</th>
                        <td><span id="detail-computer-created_at">-</span></td>
                    </tr>
                    <tr>
                        <th>Actualizado</th>
                        <td><span id="detail-computer-updated_at">-</span></td>
                    </tr>
                </table>
            </div>
            <div class="gpes-modal-footer">
                <button class="gpes-btn-modal" onclick="closeGpesModal('gpesDetailsModal')">Cerrar</button>
            </div>
        </div>
    </div>


    @forelse ($assignments as $assignment)
        <div class="assignment-container">
            <h3>Asignación #{{ $assignment['id'] ?? '-' }}</h3>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th colspan="2">Información general</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Usuario</th>
                        <td>{{ $assignment['user']['nickname'] ?? '-' }} ({{ $assignment['user']['email'] ?? '-' }})</td>
                    </tr>
                    <tr>
                        <th>Computador</th>
                        <td>{{ $assignment['computer']['name'] ?? '-' }} ({{ $assignment['computer']['brand'] ?? '-' }} {{ $assignment['computer']['model'] ?? '-' }}, Nº Serie: {{ $assignment['computer']['serial_number'] ?? '-' }})</td>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <td>{{ $assignment['type'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ubicación</th>
                        <td>{{ $assignment['location'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Observación</th>
                        <td>{{ $assignment['observation'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Fechas</th>
                        <td>
                            Asignado: {{ isset($assignment['assigned_at']) ? \Carbon\Carbon::parse($assignment['assigned_at'])->format('d/m/Y H:i') : '-' }}<br>
                            Devuelto: {{ isset($assignment['returned_at']) ? \Carbon\Carbon::parse($assignment['returned_at'])->format('d/m/Y H:i') : 'No devuelto' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            @if (isset($assignment['returned']) && $assignment['returned'] === 1)
                                <span class="badge bg-success">Devuelto</span>
                            @else
                                <span class="badge bg-warning">No devuelto</span>
                            @endif
                            @if (isset($assignment['late']) && $assignment['late'] === 1)
                                <span class="badge bg-danger">Tarde</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Acciones</th>
                        <td>
                            <button class="btn btn-primary" onclick="showDetails(<?php echo htmlspecialchars(json_encode($assignment), ENT_QUOTES, 'UTF-8'); ?>)">Ver detalles</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @empty
        <div class="alert alert-info text-center">
            No hay asignaciones disponibles
        </div>
    @endforelse

    <style>
    .assignment-container {
        margin-bottom: 60px;
        padding: 20px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-left: 5px solid #28a745;
    }

    .table-dark {
        background: #28a745;
        color: #ffffff;
    }

    .table-bordered {
        border: 1px solid #e9ecef;
        margin-bottom: 0;
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #e9ecef;
        padding: 12px;
        vertical-align: middle;
    }

    .table-bordered th {
        width: 25%;
        background: #f8f9fa;
        font-weight: 600;
    }

    .table-bordered td {
        background: #ffffff;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.9rem;
        margin-right: 5px;
        display: inline-block;
    }

    .bg-success {
        background: #28a745 !important;
        color: #ffffff;
    }

    .bg-warning {
        background: #ffc107 !important;
        color: #333333;
    }

    .bg-danger {
        background: #dc3545 !important;
        color: #ffffff;
    }

    h3 {
        color: #333333;
        margin-bottom: 20px;
    }

    .alert-info {
        background: #e9ecef;
        color: #333333;
        border: none;
        border-radius: 8px;
        padding: 15px;
    }

    .btn-primary {
        background: #28a745;
        border: none;
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .btn-primary:hover {
        background: #218838;
    }

    .gpes-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
      
        background: rgba(0, 0, 0, 0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .gpes-modal-content-index {
        background: #ffffff;
        border-radius: 8px;
        width: 90%;
        height: 70%;
        max-width: 600px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
          overflow: scroll;
    }

    .gpes-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #28a745;
        color: #ffffff;
    }

    .gpes-modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
    }

    .gpes-close-btn {
        background: none;
        border: none;
        color: #ffffff;
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s;
    }

    .gpes-close-btn:hover {
        color: #e6f4ea;
    }

    .gpes-modal-body {
        padding: 20px;
        font-size: 1rem;
        color: #333333;
    }

    .gpes-modal-body h5 {
        margin-top: 0;
        margin-bottom: 10px;
        color: #333333;
    }

    .gpes-modal-body .table {
        margin-bottom: 20px;
    }

    .gpes-modal-footer {
        padding: 15px 20px;
        text-align: right;
        border-top: 1px solid #e9ecef;
    }

    .gpes-btn-modal {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        background: #28a745;
        color: #ffffff;
        transition: background 0.2s;
    }

    .gpes-btn-modal:hover {
        background: #218838;
    }
    </style>

    <script>
    function closeGpesModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    function showDetails(assignment) {
        if (!assignment || typeof assignment !== 'object') {
            alert('Error: Datos de la asignación no disponibles.');
            return;
        }
        document.getElementById('detail-user-person_id').textContent = assignment.user && assignment.user.person && assignment.user.person.person_id ? assignment.user.person.person_id : '-';
        document.getElementById('detail-user-document_type').textContent = assignment.user && assignment.user.person && assignment.user.person.document_type ? assignment.user.person.document_type : '-';
        document.getElementById('detail-user-document_number').textContent = assignment.user && assignment.user.person && assignment.user.person.document_number ? assignment.user.person.document_number : '-';
        document.getElementById('detail-user-full_name').textContent = assignment.user && assignment.user.person ? 
            `${assignment.user.person.first_name || '-'} ${assignment.user.person.first_last_name || '-'} ${assignment.user.person.second_last_name || ''}`.trim() : '-';
        document.getElementById('detail-user-personal_email').textContent = assignment.user && assignment.user.person && assignment.user.person.personal_email ? assignment.user.person.personal_email : '-';
        document.getElementById('detail-user-telephone1').textContent = assignment.user && assignment.user.person && assignment.user.person.telephone1 ? assignment.user.person.telephone1 : '-';
        document.getElementById('detail-computer-id').textContent = assignment.computer && assignment.computer.id ? assignment.computer.id : '-';
        document.getElementById('detail-computer-processor').textContent = assignment.computer && assignment.computer.processor ? assignment.computer.processor : '-';
        document.getElementById('detail-computer-ram').textContent = assignment.computer && assignment.computer.ram ? assignment.computer.ram : '-';
        document.getElementById('detail-computer-operating_system').textContent = assignment.computer && assignment.computer.operating_system ? assignment.computer.operating_system : '-';
        document.getElementById('detail-computer-status_assignment_day').textContent = assignment.computer && assignment.computer.status_assignment_day ? assignment.computer.status_assignment_day : '-';
        document.getElementById('detail-computer-status_assignment_formation').textContent = assignment.computer && assignment.computer.status_assignment_formation ? assignment.computer.status_assignment_formation : '-';
        document.getElementById('detail-computer-created_at').textContent = assignment.computer && assignment.computer.created_at ? new Date(assignment.computer.created_at).toLocaleString('es-CO', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-';
        document.getElementById('detail-computer-updated_at').textContent = assignment.computer && assignment.computer.updated_at ? new Date(assignment.computer.updated_at).toLocaleString('es-CO', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-';

        var modal = document.getElementById('gpesDetailsModal');
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeGpesModal('gpesDetailsModal');
        }
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('gpes-modal')) {
            closeGpesModal('gpesDetailsModal');
        }
    });
    </script>


@endsection