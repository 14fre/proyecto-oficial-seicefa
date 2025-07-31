<?php

namespace Modules\SIBAF\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\SIBAF\Entities\DamageReport;

class NewDamageReportNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $report;

    public function __construct(DamageReport $report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nuevo reporte de daño registrado')
            ->greeting('¡Hola, Mesa de Ayuda!')
            ->line('Se ha registrado un nuevo reporte de daño en el sistema.')
            ->line('Equipo: ' . optional($this->report->inventory->element)->name)
            ->line('Usuario: ' . optional($this->report->user->person)->full_name)
            ->line('Descripción: ' . $this->report->description)
            ->action('Ver reporte', url('/'))
            ->line('Gracias por usar el sistema.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Se ha registrado un nuevo reporte de daño.',
            'equipo' => optional($this->report->inventory->element)->name,
            'usuario' => optional($this->report->user->person)->full_name,
            'reporte_id' => $this->report->id,
        ];
    }
}
