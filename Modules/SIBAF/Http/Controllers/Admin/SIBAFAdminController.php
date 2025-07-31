<?php

namespace Modules\SIBAF\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\SIBAF\Entities\DamageReport;
use Modules\SIBAF\Entities\ComputerDowngrade;
use Illuminate\Support\Facades\Storage;

class SIBAFAdminController extends Controller
{
    public function dashboard()
    {
        // Obtener notificaciones no leídas del admin
        $notifications = Auth::user()->unreadNotifications;
        
        // Obtener reportes de daño pendientes
        $pendingReports = DamageReport::with(['inventory.element', 'user.person'])
            ->where('state', 'Solicitado')
            ->get();
            
        // Obtener bajas aprobadas recientes
        $recentDowngrades = ComputerDowngrade::with(['inventory.element', 'user.person'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        // Contadores
        $totalPendingReports = DamageReport::where('state', 'Solicitado')->count();
        $totalApprovedDowngrades = ComputerDowngrade::count();
        $totalReports = DamageReport::count();
        
        return view('sibaf::admin.dashboard', compact(
            'notifications',
            'pendingReports',
            'recentDowngrades',
            'totalPendingReports',
            'totalApprovedDowngrades',
            'totalReports'
        ));
    }
    
    public function notifications()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        
        return view('sibaf::admin.notifications', compact('notifications'));
    }
    
    public function markNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return redirect()->back()->with('success', 'Notificación marcada como leída');
    }
    
    public function markAllNotificationsAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return redirect()->back()->with('success', 'Todas las notificaciones marcadas como leídas');
    }
    
    public function downloadExcel($downgradeId, $fileType)
    {
        $downgrade = ComputerDowngrade::findOrFail($downgradeId);
        
        $filePath = null;
        $fileName = null;
        
        if ($fileType === 'excel1') {
            $filePath = $downgrade->excel1_path;
            $fileName = 'excel1_baja_' . $downgrade->id . '.xlsx';
        } elseif ($fileType === 'excel2') {
            $filePath = $downgrade->excel2_path;
            $fileName = 'excel2_baja_' . $downgrade->id . '.xlsx';
        }
        
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'Archivo no encontrado');
        }
        
        return Storage::disk('public')->download($filePath, $fileName);
    }
    
    public function downgrades()
    {
        $downgrades = ComputerDowngrade::with(['inventory.element', 'user.person'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('sibaf::admin.downgrades', compact('downgrades'));
    }
    
    public function checkComputerStatus($inventoryId)
    {
        // Verificar si el computador ya tiene una baja aprobada
        $downgrade = ComputerDowngrade::where('inventory_id', $inventoryId)
            ->where('estado', 'Baja')
            ->first();
            
        if ($downgrade) {
            return response()->json([
                'status' => 'baja',
                'message' => 'Este computador ya tiene una baja aprobada',
                'downgrade_date' => $downgrade->fecha_aprobacion
            ]);
        }
        
        // Verificar si hay reportes de daño pendientes
        $pendingReport = DamageReport::where('inventory_id', $inventoryId)
            ->where('state', 'Solicitado')
            ->first();
            
        if ($pendingReport) {
            return response()->json([
                'status' => 'pendiente',
                'message' => 'Este computador tiene un reporte de daño pendiente'
            ]);
        }
        
        return response()->json([
            'status' => 'disponible',
            'message' => 'Computador disponible para reportes'
        ]);
    }
} 