<?php

namespace Modules\SIBAF\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\SIBAF\Entities\DamageReport;
use Illuminate\Http\Request;

class EquipmentTrackingController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todos los reportes de daño con sus relaciones
        $allDamageReports = DamageReport::with([
            'inventory.element',
            'user.person',
            'movement'
        ])
        ->whereIn('state', ['Arreglado', 'Rechazado', 'Baja', 'Aprobado', 'Solicitado', 'En arreglo'])
        ->orderBy('created_at', 'desc')
        ->get();
        
        // Agrupar reportes por inventory_id y obtener solo el más reciente para cada equipo
        $groupedReports = $allDamageReports->groupBy('inventory_id');
        $latestReports = collect();
        
        foreach ($groupedReports as $inventoryId => $reports) {
            // Obtener el reporte más reciente de cada equipo
            $latestReport = $reports->first();
            $latestReport->total_reports_for_equipment = $reports->count();
            $latestReport->all_reports_for_equipment = $reports;
            $latestReports->push($latestReport);
        }
        
        // Ordenar por fecha de creación del reporte más reciente
        $damageReportsWithRelations = $latestReports->sortByDesc('created_at');
        
        // Obtener las razones desde la sesión si existen
        $approvalReason = $request->session()->get('approval_reason');
        $rejectionReason = $request->session()->get('rejection_reason');

        return view('sibaf::equipment_tracking', compact('damageReportsWithRelations', 'approvalReason', 'rejectionReason'));
    }
}