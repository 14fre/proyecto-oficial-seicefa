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

    <!-- Título -->
    <div class="container py-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-bell me-2"></i>Notificaciones de Reportes de Computadores
        </h2>

        <!-- Tabla de Notificaciones -->
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
                            @forelse ($reports as $report)
                                <tr>
                                    <td>{{ $report['id'] ?? '-' }}</td>
                                    <td>{{ Str::limit($report['title'], 25) ?? '-' }}</td>
                                    <td>{{ Str::limit($report['description'], 40) ?? '-' }}</td>
                                    <td>{{ $report['status_reports'] ?? '-' }}</td>
                                    <td>{{ $report['involved']['nickname'] ?? '-' }}</td>
                                    <td>
                                        {{ isset($report['reported_at']) ? \Carbon\Carbon::parse($report['reported_at'])->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <!-- Botón Ver Detalles -->
                                            <a href="#" class="btn btn-outline-info btn-sm"
                                               title="Ver detalles"
                                               onclick='showDetails(@json($report))'>
                                                <i class="bi bi-eye fs-5"></i>
                                            </a>

                                            <!-- Botón Responder -->
                                            <a href="{{ route('gpes.cuentadante.answers.create', ['id' => $report['id']]) }}"
                                               class="btn btn-outline-success btn-sm"
                                               title="Responder">
                                                <i class="bi bi-chat-left-text fs-5"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-bell-slash fs-3 text-muted"></i>
                                        <p class="mt-2 mb-0">No hay notificaciones disponibles.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles -->
    <div class="modal" id="detailsModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title">Detalles del Reporte</h5>
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
            <div class="modal-footer border-0">
                <button class="btn btn-success" onclick="closeModal('detailsModal')">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Estilos Modal -->
    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1050;
        }

        .modal-content {
            background: #ffffff;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            padding: 20px 15px;
            margin: 40px auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background: #28a745;
            color: white;
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .modal-body {
            padding: 15px;
            font-size: 0.85rem;
            color: #333;
            line-height: 1.5;
        }

        .modal-footer {
            padding: 10px 15px;
            border-top: 1px solid #e9ecef;
            text-align: right;
        }

        .btn-success {
            background-color: #198754;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 0.85rem;
        }

        .btn-success:hover {
            background-color: #146c43;
        }
    </style>

    <!-- Script Modal -->
    <script>
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function showDetails(report) {
            const formatDateTime = (dateStr) => {
                return dateStr ? new Date(dateStr).toLocaleString('es-CO', {
                    day: '2-digit', month: '2-digit', year: 'numeric',
                    hour: '2-digit', minute: '2-digit'
                }) : '-';
            };

            document.getElementById('detail-id').textContent = report.id ?? '-';
            document.getElementById('detail-title').textContent = report.title ?? '-';
            document.getElementById('detail-description').textContent = report.description ?? '-';
            document.getElementById('detail-status').textContent = report.status_reports ?? '-';
            document.getElementById('detail-answer').textContent = report.answer ?? 'Sin respuesta';
            document.getElementById('detail-reported_at').textContent = formatDateTime(report.reported_at);
            document.getElementById('detail-resolved_at').textContent = formatDateTime(report.resolved_at);

            document.getElementById('detail-computer').textContent = report.computer ?
                `${report.computer.name} (Serial: ${report.computer.serial_number})` : '-';

            document.getElementById('detail-involved').textContent = report.involved?.nickname ?? '-';

            const allocation = report.responsible_allocation ?? {};
            document.getElementById('detail-assigned_at').textContent = formatDateTime(allocation.assigned_at);
            document.getElementById('detail-returned_at').textContent = allocation.returned_at ? formatDateTime(allocation.returned_at) : 'No devuelto';
            document.getElementById('detail-observation').textContent = allocation.observation ?? '-';

            document.getElementById('detailsModal').style.display = 'flex';
        }

        // Cerrar con ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal('detailsModal');
            }
        });
    </script>
@endsection
