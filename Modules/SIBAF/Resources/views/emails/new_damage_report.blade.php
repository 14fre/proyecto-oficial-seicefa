@component('mail::message')
# Nuevo Reporte de Daño Registrado

Se ha registrado un nuevo reporte de daño en el sistema.

**Detalles del reporte:**
- **Equipo:** {{ $equipo ?? 'N/A' }}
- **Usuario:** {{ $usuario ?? 'N/A' }}
- **Descripción:** {{ $descripcion }}

@component('mail::button', ['url' => url('/')])
Ver Reporte
@endcomponent

Gracias por usar el sistema.

Saludos,<br>
{{ config('app.name') }}
@endcomponent 