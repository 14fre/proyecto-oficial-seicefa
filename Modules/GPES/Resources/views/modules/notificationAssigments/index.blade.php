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

    <h1>Notificaciones</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID Notificación</th>
                    <th>Estado Notificación</th>
                    <th>ID Asignación</th>
                    <th>Usuario</th>
                    <th>Computador</th>
                    <th>Tipo</th>
                    <th>Ubicación</th>
                    <th>Observación</th>
                    <th>Fechas</th>
                    <th>Estado Asignación</th>
                    <td>
                        Acciones
                    </td>
                </tr>
            </thead>
            <tbody>
                @forelse ($notifications as $notification)
                    <tr>
                        <td>{{ $notification['id'] ?? '-' }}</td>
                        <td>
                            @if (isset($notification['statusNotification']))
                                <span class="badge {{ $notification['statusNotification'] === 'pending' ? 'bg-warning' : 'bg-success' }}">
                                    {{ $notification['statusNotification'] }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $notification['responsible_allocation']['id'] ?? '-' }}</td>
                        <td>
                            @if (isset($notification['responsible_allocation']['user']))
                                {{ $notification['responsible_allocation']['user']['nickname'] ?? '-' }} ({{ $notification['responsible_allocation']['user']['email'] ?? '-' }})
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if (isset($notification['responsible_allocation']['computer']))
                                {{ $notification['responsible_allocation']['computer']['name'] ?? '-' }} ({{ $notification['responsible_allocation']['computer']['brand'] ?? '-' }} {{ $notification['responsible_allocation']['computer']['model'] ?? '-' }}, Nº Serie: {{ $notification['responsible_allocation']['computer']['serial_number'] ?? '-' }})
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $notification['responsible_allocation']['type'] ?? '-' }}</td>
                        <td>{{ $notification['responsible_allocation']['location'] ?? '-' }}</td>
                        <td>{{ $notification['responsible_allocation']['observation'] ?? '-' }}</td>
                        <td>
                            @if (isset($notification['responsible_allocation']['assigned_at']))
                                Asignado: {{ \Carbon\Carbon::parse($notification['responsible_allocation']['assigned_at'])->format('d/m/Y H:i') }}<br>
                            @else
                                Asignado: -<br>
                            @endif
                            @if (isset($notification['responsible_allocation']['returned_at']))
                                Devuelto: {{ \Carbon\Carbon::parse($notification['responsible_allocation']['returned_at'])->format('d/m/Y H:i') }}
                            @else
                                Devuelto: No devuelto
                            @endif
                        </td>
                        <td>
                            @if (isset($notification['responsible_allocation']['returned']) && $notification['responsible_allocation']['returned'] === 1)
                                <span class="badge bg-success">Devuelto</span>
                            @else
                                <span class="badge bg-warning">No devuelto</span>
                            @endif
                            @if (isset($notification['responsible_allocation']['late']) && $notification['responsible_allocation']['late'] === 1)
                                <span class="badge bg-danger">Tarde</span>
                            @endif
                        </td>
                        <td>
                        <a href="{{ route('gpes.cuentadante.notificationAssigments.showNotification', ['id' => $notification['id']]) }}" class="btn btn-primary btn-sm">
                           Marcar como visto
                        </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No hay notificaciones disponibles</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <style>
    .table-dark {
        background: #28a745;
        color: #ffffff;
    }

    .table-bordered {
        border: 1px solid #e9ecef;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background: #f8f9fa;
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

    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        text-align: left;
        vertical-align: middle;
    }

    th {
        font-weight: 600;
    }

    .table-bordered td, .table-bordered th {
        border: 1px solid #e9ecef;
    }
    </style>

@endsection