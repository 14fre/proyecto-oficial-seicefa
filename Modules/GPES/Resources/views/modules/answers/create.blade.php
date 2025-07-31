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

    <!-- Modal de Detalles -->
    <div class="modal" id="detailsModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title" id="detail-title">Detalles del Reporte</h5>
                <button class="close-btn" onclick="closeModal('detailsModal')">✖</button>
            </div>
            <div class="modal-body p-3">
                <p><strong>ID:</strong> <span id="detail-id">-</span></p>
                <p><strong>Título:</strong> <span id="detail-title">-</span></p>
                <p><strong>Descripción:</strong> <span id="detail-description">-</span></p>
                <p><strong>Estado:</strong> <span id="detail-status">-</span></p>
                <p><strong>Respuesta:</strong> <span id="detail-answer">-</span></p>
                <p><strong>Fecha Reporte:</strong> <span id="detail-reported_at">-</span></p>
                <p><strong>Fecha Resolución:</strong> <span id="detail-resolved_at">-</span></p>
                <p><strong>Computador:</strong> <span id="detail-computer">-</span></p>
                <p><strong>Involucrado:</strong> <span id="detail-involved">-</span></p>
                <p><strong>Acusado:</strong> <span id="detail-accused">-</span></p>
                <p><strong>Asignación:</strong> <span id="detail-assigned_at">-</span></p>
                <p><strong>Devolución:</strong> <span id="detail-returned_at">-</span></p>
                <p><strong>Observación:</strong> <span id="detail-observation">-</span></p>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-success px-3 py-2" onclick="closeModal('detailsModal')">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal" id="deleteModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header-delete">
                <h5 class="modal-title">Confirmar Eliminación</h5>
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

    <!-- Título -->
    <div class="container py-4">
        <h2 class="fw-bold text-primary mb-4">
            <i class="bi bi-chat-left-text me-2"></i>Responder a un Reporte
        </h2>

        <!-- Tabla: Información del Reporte -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-light fw-semibold">
                <i class="bi bi-journal me-2"></i>Reporte
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-bordered mb-0">
                    <tr>
                        <th>ID</th>
                        <td>{{ $reportRespons && isset($reportRespons['id']) ? $reportRespons['id'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Título</th>
                        <td>{{ $reportRespons && isset($reportRespons['title']) ? $reportRespons['title'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td>{{ $reportRespons && isset($reportRespons['description']) ? $reportRespons['description'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Respuesta</th>
                        <td>{{ $reportRespons && isset($reportRespons['answer']) ? $reportRespons['answer'] : 'Sin respuesta' }}</td>
                    </tr>
                    <tr>
                        <th>Estatus</th>
                        <td>{{ $reportRespons && isset($reportRespons['status_reports']) ? $reportRespons['status_reports'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Reporte</th>
                        <td>{{ $reportRespons && isset($reportRespons['reported_at']) ? \Carbon\Carbon::parse($reportRespons['reported_at'])->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Resolución</th>
                        <td>{{ $reportRespons && isset($reportRespons['resolved_at']) ? \Carbon\Carbon::parse($reportRespons['resolved_at'])->format('d/m/Y H:i') : 'Sin resolver' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tabla: Computadora -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-light fw-semibold">
                <i class="bi bi-laptop me-2"></i>Computadora
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-bordered mb-0">
                    <tr>
                        <th>ID</th>
                        <td>{{ $reportRespons && isset($reportRespons['computer']['id']) ? $reportRespons['computer']['id'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <td>{{ $reportRespons && isset($reportRespons['computer']['name']) ? $reportRespons['computer']['name'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Marca</th>
                        <td>{{ $reportRespons && isset($reportRespons['computer']['brand']) ? $reportRespons['computer']['brand'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Modelo</th>
                        <td>{{ $reportRespons && isset($reportRespons['computer']['model']) ? $reportRespons['computer']['model'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Número de Serie</th>
                        <td>{{ $reportRespons && isset($reportRespons['computer']['serial_number']) ? $reportRespons['computer']['serial_number'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Sistema Operativo</th>
                        <td>{{ $reportRespons && isset($reportRespons['computer']['operating_system']) ? $reportRespons['computer']['operating_system'] : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tabla: Involucrado -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-light fw-semibold">
                <i class="bi bi-person me-2"></i>Involucrado
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-bordered mb-0">
                    <tr>
                        <th>ID</th>
                        <td>{{ $reportRespons && isset($reportRespons['involved']['id']) ? $reportRespons['involved']['id'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nickname</th>
                        <td>{{ $reportRespons && isset($reportRespons['involved']['nickname']) ? $reportRespons['involved']['nickname'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $reportRespons && isset($reportRespons['involved']['email']) ? $reportRespons['involved']['email'] : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tabla: Acusado -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-light fw-semibold">
                <i class="bi bi-person-x me-2"></i>Acusado
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-bordered mb-0">
                    <tr>
                        <th>ID</th>
                        <td>{{ $reportRespons && isset($reportRespons['accused']['id']) ? $reportRespons['accused']['id'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nickname</th>
                        <td>{{ $reportRespons && isset($reportRespons['accused']['nickname']) ? $reportRespons['accused']['nickname'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $reportRespons && isset($reportRespons['accused']['email']) ? $reportRespons['accused']['email'] : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tabla: Asignación Responsable -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-light fw-semibold">
                <i class="bi bi-person-check me-2"></i>Asignación Responsable
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-bordered mb-0">
                    <tr>
                        <th>ID</th>
                        <td>{{ $reportRespons && isset($reportRespons['responsible_allocation']['id']) ? $reportRespons['responsible_allocation']['id'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nombre del usuario</th>
                        <td>{{ $reportRespons && isset($reportRespons['responsible_allocation']['user']['nickname']) ? $reportRespons['responsible_allocation']['user']['nickname'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <td>{{ $reportRespons && isset($reportRespons['responsible_allocation']['type']) ? $reportRespons['responsible_allocation']['type'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ubicación</th>
                        <td>{{ $reportRespons && isset($reportRespons['responsible_allocation']['location']) ? $reportRespons['responsible_allocation']['location'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Observación</th>
                        <td>{{ $reportRespons && isset($reportRespons['responsible_allocation']['observation']) ? $reportRespons['responsible_allocation']['observation'] : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Asignado en</th>
                        <td>{{ $reportRespons && isset($reportRespons['responsible_allocation']['assigned_at']) ? \Carbon\Carbon::parse($reportRespons['responsible_allocation']['assigned_at'])->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Devuelto en</th>
                        <td>{{ $reportRespons && isset($reportRespons['responsible_allocation']['returned_at']) ? \Carbon\Carbon::parse($reportRespons['responsible_allocation']['returned_at'])->format('d/m/Y H:i') : 'No devuelto' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Formulario de Respuesta -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-header bg-light fw-semibold">
                <i class="bi bi-chat-dots me-2"></i>Formulario de Respuesta
            </div>
            <div class="card-body p-4 bg-white">
                <form action="{{ route('gpes.cuentadante.answers.store', $reportRespons && isset($reportRespons['id']) ? $reportRespons['id'] : 0) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="answer" class="form-label fw-semibold">Escribe tu Respuesta</label>
                        <textarea name="answer" id="answer"
                                  class="form-control @error('answer') is-invalid @enderror"
                                  rows="4"
                                  required>{{ old('answer', $reportRespons && isset($reportRespons['answer']) ? $reportRespons['answer'] : '') }}</textarea>
                        @error('answer')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <input type="hidden" name="report_id" value="{{ $reportRespons->id ?? '' }}">
                    </div>
                    <div class="d-flex gap-3">
                        <a href="{{ route('gpes.cuentadante.answers.index') }}" class="btn btn-outline-danger flex-grow-1">
                            <i class="bi bi-arrow-left me-1"></i>Volver
                        </a>
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-save me-1"></i>Enviar Respuesta
                        </button>
                    </div>
                </form>
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
            width: 90%;
            max-width: 380px; /* Modal más pequeña */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #28a745;
            color: #ffffff;
        }

        .modal-header h5 {
            margin: 0;
            font-size: 1.1rem;
        }

        .modal-header-delete {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #a72828;
            color: #ffffff;
        }

        .close-btn {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .close-btn:hover {
            opacity: 0.8;
        }

        .modal-body {
            padding: 16px;
            font-size: 0.95rem;
            color: #333;
        }

        .modal-footer {
            padding: 12px 16px;
            border-top: 1px solid #e9ecef;
            text-align: right;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            color: #ffffff;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-primary-delete {
            background-color: #a72828;
        }

        .btn-primary-delete:hover {
            background-color: #922b2b;
        }

        .btn-white-delete {
            background: #ffffff;
            color: #a72828;
            border: 1px solid #a72828;
        }

        .btn-white-delete:hover {
            background: #f8f9fa;
            color: #922b2b;
        }

        .table {
            margin-bottom: 0;
        }

        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: 500;
        }

        .card-header {
            font-size: 1rem;
        }

        .card-body {
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.3);
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            border: 1px solid #ced4da;
        }

        .btn-outline-info {
            color: #17a2b8;
            background: transparent;
            border: 1px solid #17a2b8;
        }

        .btn-outline-info:hover {
            background: #17a2b8;
            color: white !important;
        }

        .btn-outline-success {
            color: #28a745;
            border: 1px solid #28a745;
            background: transparent;
        }

        .btn-outline-success:hover {
            background: #28a745;
            color: white !important;
        }

        .btn-outline-danger {
            color: #dc3545;
            border: 1px solid #dc3545;
            background: transparent;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            color: white !important;
        }

        .form-control {
            transition: all 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
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
            if (!report || typeof report !== 'object') {
                alert('Error: Datos del reporte no disponibles.');
                return;
            }

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
                `${report.computer.name} (Serial: ${report.computer.serial_number}, Modelo: ${report.computer.model}, Marca: ${report.computer.brand})` : '-';

            document.getElementById('detail-involved').textContent = report.involved ?
                `${report.involved.nickname} (${report.involved.email})` : '-';

            document.getElementById('detail-accused').textContent = report.accused ?
                `${report.accused.nickname} (${report.accused.email})` : '-';

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

        // Cerrar con tecla Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal('detailsModal');
                closeModal('deleteModal');
            }
        });
    </script>
@endsection