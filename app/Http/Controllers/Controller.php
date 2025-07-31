<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function notifySupportNewDamageReport($report)
    {
        $supportEmail = config('sibaf.support_email');
        if ($supportEmail) {
            Mail::to($supportEmail)->send(new \Modules\SIBAF\Emails\NewDamageReportMail($report));
        }
        // También puedes notificar a un usuario soporte si lo deseas
    }
}
