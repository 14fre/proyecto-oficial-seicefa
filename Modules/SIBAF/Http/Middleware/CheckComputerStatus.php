<?php

namespace Modules\SIBAF\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\SIBAF\Entities\ComputerDowngrade;
use Modules\SIBAF\Entities\DamageReport;

class CheckComputerStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $inventoryId = $request->input('inventory_id');
        
        if (!$inventoryId) {
            return $next($request);
        }
        
        // Verificar si el computador ya tiene una baja aprobada
        $downgrade = ComputerDowngrade::where('inventory_id', $inventoryId)
            ->where('estado', 'Baja')
            ->first();
            
        if ($downgrade) {
            return redirect()->back()
                ->with('error', 'Este computador ya tiene una baja aprobada y no puede recibir nuevos reportes de daño.')
                ->withInput();
        }
        
        // Verificar si hay reportes de daño pendientes
        $pendingReport = DamageReport::where('inventory_id', $inventoryId)
            ->where('state', 'Solicitado')
            ->first();
            
        if ($pendingReport) {
            return redirect()->back()
                ->with('error', 'Este computador ya tiene un reporte de daño pendiente. Espere a que sea procesado.')
                ->withInput();
        }
        
        return $next($request);
    }
} 