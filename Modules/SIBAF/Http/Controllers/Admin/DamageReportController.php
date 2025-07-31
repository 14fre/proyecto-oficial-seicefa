<?php

namespace Modules\SIBAF\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SIBAF\Entities\DamageReport;
use Illuminate\Support\Facades\Auth;

class DamageReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'description' => 'required|string',
            'state' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        // 1. Guardar la foto si se subió
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('damage_reports', 'public');
        }

        // 2. Buscar el tipo de movimiento 'Reporte de daño'
        $movementType = \Modules\SICA\Entities\MovementType::where('name', 'Reporte de daño')->first();
        if (!$movementType) {
            return redirect()->back()->with('error', 'No existe el tipo de movimiento "Reporte de daño".');
        }

        // 3. Crear el movimiento en estado 'Solicitado'
        $movement = \Modules\SICA\Entities\Movement::create([
            'registration_date' => now(),
            'movement_type_id' => $movementType->id,
            'voucher_number' => 0, // Puedes ajustar la lógica del consecutivo si es necesario
            'price' => 0,
            'observation' => $request->description,
            'state' => 'Solicitado',
        ]);

        // 4. Crear el detalle del movimiento
        \Modules\SICA\Entities\MovementDetail::create([
            'movement_id' => $movement->id,
            'inventory_id' => $request->inventory_id,
            'amount' => 1,
            'price' => 0,
        ]);

        // 5. Guardar el reporte de daño
        $damageReport = \Modules\SIBAF\Entities\DamageReport::create([
            'inventory_id' => $request->inventory_id,
            'user_id' => \Auth::id(),
            'description' => $request->description,
            'state' => $request->state,
            'movement_id' => $movement->id,
            'photo_path' => $photoPath,
        ]);

        // Notificar al soporte por correo
        \Modules\SIBAF\Services\SupportNotificationService::notifySupportNewDamageReport($damageReport);

        return redirect()->back()->with('success', 'Reporte de daño registrado correctamente.');
    }

    public function approve($id, Request $request)
    {
        $report = \Modules\SIBAF\Entities\DamageReport::with(['movement', 'inventory'])->findOrFail($id);
        $inventory = $report->inventory;
        $computer = $inventory ? $inventory->computer : null;
        $action = $request->input('action');

        if ($action === 'arreglo') {
            // Cambiar estado a 'En arreglo'
            if ($report->movement) {
                $report->movement->state = 'En arreglo';
                $report->movement->save();
            }
            if ($inventory) {
                $inventory->state = 'En arreglo';
                $inventory->save();
            }
            if ($computer) {
                $computer->status_assignment_formation = 'En arreglo';
                $computer->status_assignment_day = 'En arreglo';
                $computer->save();
            }
            $report->state = 'En arreglo';
            $report->save();
            return redirect()->back()->with('success', 'Reporte aprobado para arreglo. El equipo está en arreglo.');
        }

        if ($action === 'baja') {
            // Validar y guardar archivos Excel
            $request->validate([
                'excel1' => 'required|file|mimes:xlsx,xls',
                'excel2' => 'required|file|mimes:xlsx,xls',
            ]);
            $excel1Path = $request->file('excel1')->store('bajas/excel1', 'public');
            $excel2Path = $request->file('excel2')->store('bajas/excel2', 'public');
            // Cambiar estado a 'Baja'
            if ($report->movement) {
                $report->movement->state = 'Baja';
                $report->movement->save();
            }
            if ($inventory) {
                $inventory->state = 'Baja';
                $inventory->save();
            }
            if ($computer) {
                $computer->status_assignment_formation = 'Baja';
                $computer->status_assignment_day = 'Baja';
                $computer->save();
            }
            $report->state = 'Baja';
            $report->save();
            // Crear registro en ComputerDowngrade
            $downgrade = \Modules\SIBAF\Entities\ComputerDowngrade::create([
                'inventory_id' => $inventory ? $inventory->id : null,
                'user_id' => $report->user_id,
                'movement_id' => $report->movement_id,
                'excel1_path' => $excel1Path,
                'excel2_path' => $excel2Path,
                'estado' => 'Baja',
                'fecha_aprobacion' => now(),
            ]);
            // Notificar al admin
            $admin = \App\Models\User::whereHas('roles', function($q){ $q->where('name', 'admin'); })->first();
            if ($admin) {
                $admin->notify(new \Modules\SIBAF\Notifications\ComputerDowngradeApprovedNotification($downgrade));
            }
            return redirect()->back()->with('success', 'Reporte aprobado para baja. Archivos subidos, equipo dado de baja, registro creado y admin notificado.');
        }

        // Comportamiento anterior si no hay acción
        if ($report->movement) {
            $report->movement->state = 'Aprobado';
            $report->movement->save();
        }
        if ($inventory) {
            $inventory->state = 'No disponible'; // O 'Baja' si lo prefieres
            $inventory->save();
        }
        $report->state = 'Aprobado';
        $report->save();
        return redirect()->back()->with('success', 'Reporte aprobado y equipo dado de baja.');
    }

    public function reject($id)
    {
        $report = \Modules\SIBAF\Entities\DamageReport::with('movement')->findOrFail($id);
        // Cambiar estado del movimiento
        if ($report->movement) {
            $report->movement->state = 'Anulado';
            $report->movement->save();
        }
        return redirect()->back()->with('success', 'Reporte rechazado correctamente.');
    }
} 