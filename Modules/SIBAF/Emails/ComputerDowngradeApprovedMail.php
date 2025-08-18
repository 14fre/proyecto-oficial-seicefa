<?php

namespace Modules\SIBAF\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\SIBAF\Entities\ComputerDowngrade;

class ComputerDowngradeApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $downgrade;
    public $report;

    public function __construct(ComputerDowngrade $downgrade, $report = null)
    {
        $this->downgrade = $downgrade;
        $this->report = $report;
    }

    public function build()
    {
        return $this->subject('Baja de computador aprobada - Notificación Administrativa')
                    ->markdown('sibaf::emails.computer_downgrade_approved')
                    ->with([
                        'downgrade' => $this->downgrade,
                        'report' => $this->report,
                        'equipo' => optional($this->downgrade->inventory->element)->name,
                        'usuario' => optional($this->downgrade->user->person)->full_name,
                    ]);
    }
}
