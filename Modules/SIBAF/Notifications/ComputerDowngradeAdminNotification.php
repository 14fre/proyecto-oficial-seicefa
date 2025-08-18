<?php

namespace Modules\SIBAF\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\SIBAF\Entities\ComputerDowngrade;

class ComputerDowngradeAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $downgrade;
    public $report;

    public function __construct(ComputerDowngrade $downgrade, $report = null)
    {
        $this->downgrade = $downgrade;
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Baja de computador aprobada - Notificación Administrativa')
            ->greeting('¡Hola, Administrador!')
            ->line('Se ha aprobado una solicitud de baja para un computador en el sistema.')
            ->line('Equipo: ' . optional($this->downgrade->inventory->element)->name)
            ->line('Usuario solicitante: ' . optional($this->downgrade->user->person)->full_name)
            ->line('Fecha de aprobación: ' . $this->downgrade->created_at->format('d/m/Y H:i'))
            ->action('Ver detalle en el panel', url('/admin/equipment_tracking'))
            ->line('Esta es una notificación automática del sistema.')
            ->line('Gracias por usar el sistema.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Se ha aprobado una baja de computador en el sistema.',
            'equipo' => optional($this->downgrade->inventory->element)->name,
            'usuario' => optional($this->downgrade->user->person)->full_name,
            'downgrade_id' => $this->downgrade->id,
            'report_id' => $this->report ? $this->report->id : null,
            'fecha_aprobacion' => $this->downgrade->created_at->format('d/m/Y H:i'),
        ];
    }
}
