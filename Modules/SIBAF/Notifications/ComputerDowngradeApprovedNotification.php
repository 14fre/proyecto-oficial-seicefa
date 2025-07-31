<?php

namespace Modules\SIBAF\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Modules\SIBAF\Entities\ComputerDowngrade;

class ComputerDowngradeApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $downgrade;

    public function __construct(ComputerDowngrade $downgrade)
    {
        $this->downgrade = $downgrade;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Baja de computador aprobada')
            ->greeting('¡Hola!')
            ->line('Se ha aprobado una solicitud de baja para un computador a su nombre.')
            ->line('Equipo: ' . optional($this->downgrade->inventory->element)->name)
            ->line('Usuario solicitante: ' . optional($this->downgrade->user->person)->full_name)
            ->action('Ver detalle', url('/'))
            ->line('Gracias por usar el sistema.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Se ha aprobado una baja de computador a su nombre.',
            'equipo' => optional($this->downgrade->inventory->element)->name,
            'usuario' => optional($this->downgrade->user->person)->full_name,
            'downgrade_id' => $this->downgrade->id,
        ];
    }
}
