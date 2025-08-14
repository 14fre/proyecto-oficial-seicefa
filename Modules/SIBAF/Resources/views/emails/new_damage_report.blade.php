@component('mail::message')
{{-- Preheader: texto oculto que algunos clientes muestran como vista previa --}}
<span style="display:none !important; visibility:hidden; opacity:0; color:transparent; height:0; width:0; overflow:hidden;">
Nuevo reporte de daño registrado. Revísalo y toma acción.
</span>

# Nuevo reporte de daño

Se ha registrado un nuevo reporte de daño en el sistema. A continuación, un resumen con la información clave para su atención.

{{-- Insignia/etiqueta de estado (compatible con la mayoría de clientes) --}}
<p style="margin: 12px 0 20px;">
  <span style="
    display:inline-block;
    background:#ecfeff;
    color:#0f766e;
    border:1px solid #99f6e4;
    border-radius:9999px;
    padding:6px 10px;
    font-size:12px;
    font-weight:600;
    letter-spacing:.2px;
  ">
    Reporte registrado
  </span>
</p>

**Detalles del reporte**

@component('mail::table')
| Campo           | Valor |
|:----------------|:------|
| Equipo          | {{ $equipo ?? 'N/A' }} |
| Usuario         | {{ $usuario ?? 'N/A' }} |
| ID de reporte   | {{ $report->id ?? 'N/A' }} |
@if(!empty(optional($report->inventory)->code))
| Código inventario | {{ optional($report->inventory)->code }} |
@endif
@if(!empty($report->priority))
| Prioridad       | {{ ucfirst($report->priority) }} |
@endif
@if(!empty($report->severity))
| Severidad       | {{ ucfirst($report->severity) }} |
@endif
| Fecha           | {{ optional($report->created_at)->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }} |
@endcomponent

**Descripción**
@component('mail::panel')
{{ $descripcion ?? 'Sin descripción provista.' }}
@endcomponent

{{-- Evidencia opcional si existiese una URL en el reporte --}}
@if(isset($report->evidence_url) && $report->evidence_url)
<p style="margin: 0 0 12px; font-weight:600;">Evidencia</p>
<p style="margin: 0 0 16px; font-size: 14px; color:#334155;">
  Revisa la evidencia adjunta:
  <a href="{{ $report->evidence_url }}" style="color:#0f766e; text-decoration:underline;">Ver evidencia</a>
</p>
@endif

@component('mail::button', ['url' => isset($url) ? $url : url('/'), 'color' => 'success'])
Ver reporte
@endcomponent

— Gracias por usar el sistema.

@slot('subcopy')
Si no esperabas este mensaje o crees que se envió por error, ignora este correo.  
Para soporte, responde a este correo o contacta al administrador del sistema.
@endslot

Saludos,<br>
{{ config('app.name') }}
@endcomponent