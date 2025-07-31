<?php

namespace Modules\SIBAF\Services;

use Illuminate\Support\Facades\Mail;
use Modules\SIBAF\Emails\NewDamageReportMail;
use App\Models\User;

class SupportNotificationService
{
    public static function notifySupportNewDamageReport($report)
    {
        $supportEmail = config('sibaf.support_email');
        $admin = User::whereHas('roles', function($q){ $q->where('name', 'admin'); })->first();
        $soporte = User::whereHas('roles', function($q){ $q->where('name', 'soporte'); })->first();

        $destinatarios = [];
        if ($supportEmail) {
            $destinatarios[] = $supportEmail;
        }
        if ($admin && $admin->email) {
            $destinatarios[] = $admin->email;
        }
        if ($soporte && $soporte->email && $soporte->email !== $supportEmail) {
            $destinatarios[] = $soporte->email;
        }
        if (count($destinatarios) > 0) {
            Mail::to($destinatarios)->send(new NewDamageReportMail($report));
        }
    }
} 