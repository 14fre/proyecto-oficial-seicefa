@component('mail::message')
{{-- Preheader: texto oculto que algunos clientes muestran como vista previa --}}
<span style="display:none !important; visibility:hidden; opacity:0; color:transparent; height:0; width:0; overflow:hidden;">
Baja de computador aprobada. Revisa los detalles en el panel administrativo.
</span>

# Baja de Computador Aprobada

Se ha aprobado una solicitud de baja para un computador en el sistema. A continuación, un resumen con la información clave para su revisión administrativa.

{{-- Insignia/etiqueta de estado --}}
<p style="margin: 12px 0 20px;">
  <span style="
    display:inline-block;
    background:#fef3c7;
    color:#92400e;
    border:1px solid #f59e0b;
    border-radius:9999px;
    padding:6px 10px;
    font-size:12px;
    font-weight:600;
    letter-spacing:.2px;
  ">
    Baja Aprobada
  </span>
</p>

**Detalles de la baja**

@component('mail::table')
| Campo           | Valor |
|:----------------|:------|
| Equipo          | {{ $equipo ?? 'N/A' }} |
| Usuario solicitante | {{ $usuario ?? 'N/A' }} |
| ID de baja      | {{ $downgrade->id ?? 'N/A' }} |
@if($report)
| ID de reporte   | {{ $report->id ?? 'N/A' }} |
@endif
@if(!empty(optional($downgrade->inventory)->code))
| Código inventario | {{ optional($downgrade->inventory)->code }} |
@endif
@if($downgrade->inventory && $downgrade->inventory->computer)
| Serie           | {{ $downgrade->inventory->computer->serial_number ?? 'N/A' }} |
| Marca           | {{ $downgrade->inventory->computer->brand ?? 'N/A' }} |
| Modelo          | {{ $downgrade->inventory->computer->model ?? 'N/A' }} |
@endif
| Fecha de aprobación | {{ optional($downgrade->created_at)->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }} |
@endcomponent

@if($report)
**Descripción del reporte original**
@component('mail::panel')
{{ $report->description ?? 'Sin descripción provista.' }}
@endcomponent
@endif

**Archivos adjuntos**
@component('mail::panel')
- Formato de baja: {{ $downgrade->excel1_path ? 'Subido correctamente' : 'No disponible' }}
- Acta de baja: {{ $downgrade->excel2_path ? 'Subida correctamente' : 'No disponible' }}
@endcomponent

@component('mail::button', ['url' => url('/admin/equipment_tracking'), 'color' => 'warning'])
Ver en Panel Administrativo
@endcomponent

— Esta es una notificación automática del sistema.

@slot('subcopy')
Si no esperabas este mensaje o crees que se envió por error, ignora este correo.  
Para soporte, responde a este correo o contacta al administrador del sistema.
@endslot

Saludos,<br>
{{ config('app.name') }}
@endcomponent
