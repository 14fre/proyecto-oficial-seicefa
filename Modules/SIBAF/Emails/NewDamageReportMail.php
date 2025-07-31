<?php

namespace Modules\SIBAF\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\SIBAF\Entities\DamageReport;

class NewDamageReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;

    public function __construct(DamageReport $report)
    {
        $this->report = $report;
    }

    public function build()
    {
        return $this->subject('Nuevo reporte de daño registrado')
                    ->markdown('sibaf::emails.new_damage_report')
                    ->with([
                        'report' => $this->report,
                        'equipo' => optional($this->report->inventory->element)->name,
                        'usuario' => optional($this->report->user->person)->full_name,
                        'descripcion' => $this->report->description,
                    ]);
    }
}
