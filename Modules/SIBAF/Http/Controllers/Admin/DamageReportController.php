<?php

namespace Modules\SIBAF\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SIBAF\Entities\DamageReport;
use Modules\SIBAF\Entities\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User; // Asegúrate de que este namespace es correcto para tu modelo de usuario
use Modules\SICA\Entities\Movement;
use Modules\SICA\Entities\MovementType;
use Modules\SICA\Entities\MovementDetail;
use Modules\SIBAF\Entities\ComputerDowngrade;
use Modules\SIBAF\Services\SupportNotificationService;
use Modules\SIBAF\Notifications\ComputerDowngradeApprovedNotification;

class DamageReportController extends Controller
{
    /**
     * Busca el usuario con el rol de 'admin'
     * @return User|null
     */
    protected function getAdmin()
    {
        // Asumiendo que tu modelo de usuario tiene un método 'roles' y que los roles tienen un nombre.
        // Si no es el caso, deberás adaptar esta lógica.
        return User::whereHas('roles', function($q) { 
            $q->where('name', 'admin'); 
        })->first();
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'description' => 'required|string',
            'state' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('damage_reports', 'public');
        }

        $movementType = MovementType::where('name', 'Reporte de daño')->first();
        if (!$movementType) {
            return redirect()->back()->with('error', 'No existe el tipo de movimiento "Reporte de daño".');
        }

        $movement = Movement::create([
            'registration_date' => now(),
            'movement_type_id' => $movementType->id,
            'voucher_number' => 0,
            'price' => 0,
            'observation' => $request->description,
            'state' => 'Solicitado',
        ]);

        MovementDetail::create([
            'movement_id' => $movement->id,
            'inventory_id' => $request->inventory_id,
            'amount' => 1,
            'price' => 0,
        ]);

        $damageReport = DamageReport::create([
            'inventory_id' => $request->inventory_id,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'state' => $request->state,
            'movement_id' => $movement->id,
            'photo_path' => $photoPath,
        ]);

        $damageReport->load('user.person');

        $admin = $this->getAdmin();

        if ($admin) {
            $usuario = $damageReport->user->person->full_name ?? ($damageReport->user->nickname ?? ($damageReport->user->name ?? 'N/A'));
            Notification::create([
                'user_id' => $admin->id, // <-- CORREGIDO: La notificación es para el admin
                'notifiable_type' => DamageReport::class,
                'notifiable_id' => $damageReport->id,
                'data' => [
                    'type' => 'reporte',
                    'equipo' => $damageReport->inventory->element->name ?? 'N/A',
                    'usuario' => $usuario,
                    'message' => "Se ha creado un nuevo reporte de daño para el equipo {$damageReport->inventory->element->name}."
                ],
                'statusNotification' => 'pending'
            ]);
        }
        
        SupportNotificationService::notifySupportNewDamageReport($damageReport);

        return redirect()->back()->with('success', 'Reporte de daño registrado correctamente.');
    }

    public function approve($id, Request $request)
    {
        $report = DamageReport::with(['movement', 'inventory', 'user.person'])->findOrFail($id);
        $inventory = $report->inventory;
        $computer = $inventory ? $inventory->computer : null;
        $action = $request->input('action');
        
        $admin = $this->getAdmin();

        if ($action === 'arreglo') {
            if ($report->movement) {
                $newState = 'Arreglado';
                if (!in_array($newState, ['Solicitado', 'Aprobado', 'Anulado', 'Baja', 'Arreglado'])) {
                    throw new \Exception("Estado '$newState' no permitido para movements.");
                }
                $report->movement->state = $newState;
                $report->movement->save();
            }
            if ($inventory) {
                $inventory->state = 'Arreglado';
                $inventory->save();
            }
            if ($computer) {
                $computer->status_assignment_formation = 'Arreglado';
                $computer->status_assignment_day = 'Arreglado';
                $computer->save();
            }
            $report->state = 'Arreglado';
            $report->save();

            if ($admin) {
                $usuario = $report->user->person->full_name ?? ($report->user->nickname ?? ($report->user->name ?? 'N/A'));
                Notification::create([
                    'user_id' => $admin->id, // <-- CORREGIDO: La notificación es para el admin
                    'notifiable_type' => DamageReport::class,
                    'notifiable_id' => $report->id,
                    'data' => [
                        'type' => 'arreglo',
                        'equipo' => $inventory->element->name ?? 'N/A',
                        'usuario' => $usuario,
                        'message' => "El reporte de daño para el equipo {$inventory->element->name} ha sido aprobado para arreglo."
                    ],
                    'statusNotification' => 'pending'
                ]);
            }
            return redirect()->back()->with('success', 'Reporte aprobado para arreglo. El equipo está arreglado.');
        }

        if ($action === 'baja') {
            $request->validate([
                'excel1' => 'required|file|mimes:xlsx,xls',
                'excel2' => 'required|file|mimes:xlsx,xls',
            ]);
            $excel1Path = $request->file('excel1')->store('bajas/excel1', 'public');
            $excel2Path = $request->file('excel2')->store('bajas/excel2', 'public');
            if ($report->movement) {
                $report->movement->state = 'Baja';
                $report->movement->save();
            }
            if ($inventory) {
                $inventory->state = 'No disponible';
                $inventory->save();
            }
            if ($computer) {
                $currentFormation = $computer->status_assignment_formation ?: 'disponible';
                $currentDay = $computer->status_assignment_day ?: 'disponible';
                $computer->status_assignment_formation = $currentFormation;
                $computer->status_assignment_day = $currentDay;
                $computer->save();
            }
            $report->state = 'Baja';
            $report->save();
            $downgrade = ComputerDowngrade::create([
                'inventory_id' => $inventory ? $inventory->id : null,
                'user_id' => $report->user_id,
                'movement_id' => $report->movement_id,
                'excel1_path' => $excel1Path,
                'excel2_path' => $excel2Path,
                'estado' => 'Baja',
                'fecha_aprobacion' => now(),
            ]);

            if ($admin) {
                $usuario = $report->user->person->full_name ?? ($report->user->nickname ?? ($report->user->name ?? 'N/A'));
                Notification::create([
                    'user_id' => $admin->id, // <-- CORREGIDO: La notificación es para el admin
                    'notifiable_type' => DamageReport::class,
                    'notifiable_id' => $report->id,
                    'responsible_allocation_id' => $downgrade->id,
                    'data' => [
                        'type' => 'baja',
                        'equipo' => $inventory->element->name ?? 'N/A',
                        'usuario' => $usuario,
                        'message' => "El reporte de daño para el equipo {$inventory->element->name} ha sido aprobado para baja."
                    ],
                    'statusNotification' => 'pending'
                ]);
            }
            if ($admin) {
                $admin->notify(new ComputerDowngradeApprovedNotification($downgrade));
            }

            return redirect()->back()->with('success', 'Reporte aprobado para baja. Archivos subidos, equipo dado de baja, registro creado y admin notificado.');
        }

        if ($report->movement) {
            $report->movement->state = 'Aprobado';
            $report->movement->save();
        }
        if ($inventory) {
            $inventory->state = 'No disponible';
            $inventory->save();
        }
        $report->state = 'Aprobado';
        $report->save();

        if ($admin) {
            $usuario = $report->user->person->full_name ?? ($report->user->nickname ?? ($report->user->name ?? 'N/A'));
            Notification::create([
                'user_id' => $admin->id, // <-- CORREGIDO: La notificación es para el admin
                'notifiable_type' => DamageReport::class,
                'notifiable_id' => $report->id,
                'data' => [
                    'type' => 'aprobado',
                    'equipo' => $inventory->element->name ?? 'N/A',
                    'usuario' => $usuario,
                    'message' => "El reporte de daño para el equipo {$inventory->element->name} ha sido aprobado."
                ],
                'statusNotification' => 'pending'
            ]);
        }
        return redirect()->back()->with('success', 'Reporte aprobado y equipo dado de baja.');
    }

    public function reject($id)
    {
        $report = DamageReport::with(['movement', 'user.person'])->findOrFail($id);

        if ($report->movement) {
            $report->movement->delete();
        }
        
        $admin = $this->getAdmin();

        if ($admin) {
            $usuario = $report->user->person->full_name ?? ($report->user->nickname ?? ($report->user->name ?? 'N/A'));
            Notification::create([
                'user_id' => $admin->id, // <-- CORREGIDO: La notificación es para el admin
                'notifiable_type' => DamageReport::class,
                'notifiable_id' => $report->id,
                'data' => [
                    'type' => 'rechazo',
                    'equipo' => $report->inventory->element->name ?? 'N/A',
                    'usuario' => $usuario,
                    'message' => "El reporte de daño para el equipo {$report->inventory->element->name} ha sido rechazado."
                ],
                'statusNotification' => 'pending'
            ]);
        }
        $report->delete();

        return redirect()->back()->with('success', 'Reporte rechazado y eliminado correctamente.');
    }

    public function markAsAvailable($id)
    {
        $report = DamageReport::with(['movement', 'inventory', 'user.person'])->findOrFail($id);
        $inventory = $report->inventory;
        $computer = $inventory ? $inventory->computer : null;

        if ($inventory) {
            $inventory->state = 'Disponible';
            $inventory->save();
        }
        if ($computer) {
            $computer->status_assignment_formation = 'disponible';
            $computer->status_assignment_day = 'disponible';
            $computer->save();
        }
        $report->state = 'Disponible';
        $report->save();

        $admin = $this->getAdmin();
        if ($admin) {
            $usuario = $report->user->person->full_name ?? ($report->user->nickname ?? ($report->user->name ?? 'N/A'));
            Notification::create([
                'user_id' => $admin->id, // <-- CORREGIDO: La notificación es para el admin
                'notifiable_type' => DamageReport::class,
                'notifiable_id' => $report->id,
                'data' => [
                    'type' => 'disponible',
                    'equipo' => $inventory->element->name ?? 'N/A',
                    'usuario' => $usuario,
                    'message' => "El equipo {$inventory->element->name} ha sido marcado como disponible."
                ],
                'statusNotification' => 'pending'
            ]);
        }
        return redirect()->back()->with('success', 'El equipo ha sido marcado como disponible.');
    }
}