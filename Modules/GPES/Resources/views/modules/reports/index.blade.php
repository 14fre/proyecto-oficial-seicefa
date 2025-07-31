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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-journal-text me-2"></i>Reportes de Computadores
            </h2>
            <a href="{{ route('gpes.cuentadante.reports.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i>Crear Reporte
            </a>
        </div>

        <!-- Tabla de Reportes -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Responsable</th>
                                <th>Fecha Reporte</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($reports))
                                @foreach ($reports as $index => $report)
                                    <tr>
                                        <td>{{ $report['id'] ?? '-' }}</td>
                                        <td>{{ $report['title'] ?? '-' }}</td>
                                        <td>{{ Str::limit($report['description'], 40) ?? '-' }}</td>
                                        <td>{{ $report['status_reports'] ?? '-' }}</td>
                                        <td>{{ $report['involved']['nickname'] ?? '-' }}</td>
                                        <td>
                                            {{ isset($report['reported_at']) ? \Carbon\Carbon::parse($report['reported_at'])->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <!-- Botón Ver Detalles -->
                                                <a href="#"
                                                   class="btn btn-info btn-sm"
                                                   onclick="showDetails(<?php echo htmlspecialchars(json_encode($report), ENT_QUOTES, 'UTF-8'); ?>)">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <!-- Botón Eliminar -->
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="showDeleteModal('{{ route('gpes.cuentadante.reports.destroy', $report['id']) }}')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No hay reportes disponibles.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles -->
    <div class="modal" id="detailsModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detalles del Reporte</h2>
                <button class="close-btn" onclick="closeModal('detailsModal')">✖</button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="detail-id">-</span></p>
                <p><strong>Título:</strong> <span id="detail-title">-</span></p>
                <p><strong>Descripción:</strong> <span id="detail-description">-</span></p>
                <p><strong>Estado:</strong> <span id="detail-status">-</span></p>
                <p><strong>Respuesta:</strong> <span id="detail-answer">-</span></p>
                <p><strong>Fecha Reporte:</strong> <span id="detail-reported_at">-</span></p>
                <p><strong>Fecha Resolución:</strong> <span id="detail-resolved_at">-</span></p>
                <p><strong>Computador:</strong> <span id="detail-computer">-</span></p>
                <p><strong>Responsable:</strong> <span id="detail-involved">-</span></p>
                <p><strong>Asignación:</strong> <span id="detail-assigned_at">-</span></p>
                <p><strong>Devolución:</strong> <span id="detail-returned_at">-</span></p>
                <p><strong>Observación:</strong> <span id="detail-observation">-</span></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary px-3 py-2" onclick="closeModal('detailsModal')">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal" id="deleteModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header-delete">
                <h2>Confirmar Eliminación</h2>
                <button class="close-btn" onclick="closeModal('deleteModal')">✖</button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de eliminar este reporte?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-white-delete px-3 py-2" onclick="closeModal('deleteModal')">Cancelar</button>
                <button class="btn btn-primary-delete px-3 py-2" id="confirmDeleteBtn">Eliminar</button>
            </div>
        </div>
    </div>

    <!-- Estilos Personalizados -->
    <style>
        .modal {
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
            animation: fadeIn 0.3s ease-in-out;
        }

        .modal-content {
            background: #ffffff;
            border-radius: 8px;
            width: 80%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            margin: 20px;
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #28a745;
            color: #ffffff;
        }

        .modal-header-delete {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #a72828;
            color: #ffffff;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .close-btn {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .close-btn:hover {
            opacity: 0.8;
        }

        .modal-body {
            padding: 20px;
            font-size: 1rem;
            color: #333;
        }

        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #e9ecef;
            text-align: right;
        }

        .btn {
            padding: 6px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            color: #ffffff;
        }

        .btn-info {
            background-color: #17a2b8;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-primary {
            background: #28a745;
        }

        .btn-primary-delete {
            background: #a72828;
        }

        .btn-primary:hover {
            background: #218838;
        }

        .btn-white-delete {
            background: #ffffff;
            color: #a72828;
            border: 1px solid #a72828;
        }

        .btn-white-delete:hover {
            background: #f8f9fa;
        }

        .table-dark {
            background-color: #28a745;
            color: white;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Ensure action buttons are always visible */
        .btn-info, .btn-danger {
            opacity: 1 !important;
            visibility: visible !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
        }

        .btn-info:hover, .btn-danger:hover {
            opacity: 0.8;
        }
    </style>

    <!-- Script para controlar las modales -->
    <script>
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
            }
        }

        function showDetails(report) {
            document.getElementById('detail-id').textContent = report.id || '-';
            document.getElementById('detail-title').textContent = report.title || '-';
            document.getElementById('detail-description').textContent = report.description || '-';
            document.getElementById('detail-status').textContent = report.status_reports || '-';
            document.getElementById('detail-answer').textContent = report.answer || 'Sin respuesta';

            const formatDateTime = (dateStr) => {
                return dateStr ? new Date(dateStr).toLocaleString('es-CO', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }) : '-';
            };

            document.getElementById('detail-reported_at').textContent = formatDateTime(report.reported_at);
            document.getElementById('detail-resolved_at').textContent = formatDateTime(report.resolved_at);

            document.getElementById('detail-computer').textContent = report.computer ?
                `${report.computer.name || '-'} (Serial: ${report.computer.serial_number || '-'}, Modelo: ${report.computer.model || '-'}, Marca: ${report.computer.brand || '-'})` : '-';

            document.getElementById('detail-involved').textContent = report.involved ?
                `${report.involved.nickname || '-'} (${report.involved.email || '-'})` : '-';

            document.getElementById('detail-assigned_at').textContent = report.responsible_allocation && report.responsible_allocation.assigned_at ?
                formatDateTime(report.responsible_allocation.assigned_at) : '-';

            document.getElementById('detail-returned_at').textContent = report.responsible_allocation && report.responsible_allocation.returned_at ?
                formatDateTime(report.responsible_allocation.returned_at) : 'No devuelto';

            document.getElementById('detail-observation').textContent = report.responsible_allocation && report.responsible_allocation.observation ?
                report.responsible_allocation.observation : '-';

            var modal = document.getElementById('detailsModal');
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function showDeleteModal(deleteUrl) {
            var modal = document.getElementById('deleteModal');
            var confirmBtn = document.getElementById('confirmDeleteBtn');

            if (modal && confirmBtn) {
                confirmBtn.onclick = function () {
                    window.location.href = deleteUrl;
                };
                modal.style.display = 'flex';
            }
        }

        // Cerrar con tecla ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal('detailsModal');
                closeModal('deleteModal');
            }
        });
    </script>
@endsection