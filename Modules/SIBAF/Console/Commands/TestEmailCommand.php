<?php

namespace Modules\SIBAF\Console\Commands;

use Illuminate\Console\Command;
use Modules\SIBAF\Services\SupportNotificationService;
use Modules\SIBAF\Entities\ComputerDowngrade;

class TestEmailCommand extends Command
{
    protected $signature = 'sibaf:test-email {type : Tipo de email (report|baja)}';
    protected $description = 'Probar el envío de emails de SIBAF';

    public function handle()
    {
        $type = $this->argument('type');
        
        if ($type === 'baja') {
            $this->info('Probando email de baja...');
            
            // Crear un downgrade de prueba
            $downgrade = new ComputerDowngrade();
            $downgrade->id = 999;
            $downgrade->created_at = now();
            
            // Simular relaciones
            $downgrade->inventory = (object) [
                'element' => (object) ['name' => 'Computador de Prueba'],
                'computer' => (object) [
                    'serial_number' => 'TEST123',
                    'brand' => 'Dell',
                    'model' => 'Latitude'
                ]
            ];
            
            $downgrade->user = (object) [
                'person' => (object) ['full_name' => 'Usuario de Prueba']
            ];
            
            try {
                SupportNotificationService::notifyAdminComputerDowngrade($downgrade);
                $this->info('✅ Email de baja enviado correctamente a: ' . config('sibaf.admin_email'));
            } catch (\Exception $e) {
                $this->error('❌ Error enviando email de baja: ' . $e->getMessage());
            }
        } else {
            $this->error('Tipo de email no válido. Use: report o baja');
        }
    }
}

