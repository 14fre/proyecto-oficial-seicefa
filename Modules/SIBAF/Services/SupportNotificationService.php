<?php

namespace Modules\SIBAF\Services;

use Illuminate\Support\Facades\Mail;
use Modules\SIBAF\Emails\NewDamageReportMail;
use Modules\SIBAF\Emails\ComputerDowngradeApprovedMail;
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

    public static function notifyAdminComputerDowngrade($downgrade, $report = null)
    {
        // Para la notificación de baja, SOLO enviar al admin
        $adminEmail = config('sibaf.admin_email');
        
        $destinatarios = [];
        if ($adminEmail) {
            $destinatarios[] = $adminEmail; // breinerjosellanoslopez@gmail.com
        }
        
        // También intentar obtener el email del usuario admin por rol como respaldo
        if (empty($destinatarios)) {
            $admin = User::whereHas('roles', function($q){ $q->where('name', 'admin'); })->first();
            if ($admin && $admin->email) {
                $destinatarios[] = $admin->email;
            }
        }
        
        if (count($destinatarios) > 0) {
            Mail::to($destinatarios)->send(new ComputerDowngradeApprovedMail($downgrade, $report));
        }
    }
} 