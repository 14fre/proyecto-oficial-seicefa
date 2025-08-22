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
    // Método para mostrar el dashboard del administrador
    public function dashboard()
    {
        // Obtiene las notificaciones no leídas del usuario autenticado (admin)
        $notifications = Auth::user()->unreadNotifications;

        // Obtiene todos los reportes de daño con estado 'Solicitado', incluyendo relaciones con 'inventory.element' y 'user.person'
        $pendingReports = DamageReport::with(['inventory.element', 'user.person'])
            ->where('state', 'Solicitado')
            ->get();

        // Obtiene las 10 bajas de equipos más recientes, incluyendo relaciones con 'inventory.element' y 'user.person'
        $recentDowngrades = ComputerDowngrade::with(['inventory.element', 'user.person'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calcula el número total de reportes de daño pendientes
        $totalPendingReports = DamageReport::where('state', 'Solicitado')->count();
        // Calcula el número total de bajas aprobadas
        $totalApprovedDowngrades = ComputerDowngrade::count();
        // Calcula el número total de reportes de daño
        $totalReports = DamageReport::count();

        // Devuelve la vista 'admin.dashboard' con los datos compactados para el panel del administrador
        return view('sibaf::admin.dashboard', compact(
            'notifications',
            'pendingReports',
            'recentDowngrades',
            'totalPendingReports',
            'totalApprovedDowngrades',
            'totalReports'
        ));
    }

    // Método para mostrar la lista de notificaciones del administrador
    public function notifications()
    {
        // Obtiene todas las notificaciones del usuario autenticado con paginación (20 por página)
        $notifications = Auth::user()->notifications()->paginate(20);

        // Devuelve la vista 'admin.notifications' con la lista de notificaciones
        return view('sibaf::admin.notifications', compact('notifications'));
    }

    // Método para marcar una notificación específica como leída
    public function markNotificationAsRead($id)
    {
        // Busca la notificación por ID asociada al usuario autenticado o lanza un error 404 si no existe
        $notification = Auth::user()->notifications()->findOrFail($id);
        // Marca la notificación como leída
        $notification->markAsRead();

        // Redirige de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'Notificación marcada como leída');
    }

    // Método para marcar todas las notificaciones como leídas
    public function markAllNotificationsAsRead()
    {
        // Marca todas las notificaciones no leídas del usuario autenticado como leídas
        Auth::user()->unreadNotifications->markAsRead();

        // Redirige de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'Todas las notificaciones marcadas como leídas');
    }

    // Método para descargar archivos Excel asociados a una baja de equipo
    public function downloadExcel($downgradeId, $fileType)
    {
        // Busca la baja de equipo por ID o lanza un error 404 si no existe
        $downgrade = ComputerDowngrade::findOrFail($downgradeId);

        // Inicializa variables para la ruta y nombre del archivo
        $filePath = null;
        $fileName = null;

        // Determina qué archivo descargar según el tipo
        if ($fileType === 'excel1') {
            $filePath = $downgrade->excel1_path;
            $fileName = 'excel1_baja_' . $downgrade->id . '.xlsx';
        } elseif ($fileType === 'excel2') {
            $filePath = $downgrade->excel2_path;
            $fileName = 'excel2_baja_' . $downgrade->id . '.xlsx';
        }

        // Verifica si el archivo existe en el disco 'public'
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            // Redirige de vuelta con un mensaje de error si no se encuentra el archivo
            return redirect()->back()->with('error', 'Archivo no encontrado');
        }

        // Descarga el archivo desde el disco 'public' con el nombre especificado
        return Storage::disk('public')->download($filePath, $fileName);
    }

    // Método para mostrar la lista de bajas de equipos
    public function downgrades()
    {
        // Obtiene todas las bajas de equipos con relaciones, paginadas (20 por página)
        $downgrades = ComputerDowngrade::with(['inventory.element', 'user.person'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Devuelve la vista 'admin.downgrades' con la lista de bajas
        return view('sibaf::admin.downgrades', compact('downgrades'));
    }

    // Método para verificar el estado de un computador
    public function checkComputerStatus($inventoryId)
    {
        // Verifica si el computador ya tiene una baja aprobada
        $downgrade = ComputerDowngrade::where('inventory_id', $inventoryId)
            ->where('estado', 'Baja')
            ->first();

        if ($downgrade) {
            // Devuelve una respuesta JSON indicando que el computador tiene baja aprobada
            return response()->json([
                'status' => 'baja',
                'message' => 'Este computador ya tiene una baja aprobada',
                'downgrade_date' => $downgrade->fecha_aprobacion
            ]);
        }

        // Verifica si hay reportes de daño pendientes
        $pendingReport = DamageReport::where('inventory_id', $inventoryId)
            ->where('state', 'Solicitado')
            ->first();

        if ($pendingReport) {
            // Devuelve una respuesta JSON indicando que hay un reporte pendiente
            return response()->json([
                'status' => 'pendiente',
                'message' => 'Este computador tiene un reporte de daño pendiente'
            ]);
        }

        // Devuelve una respuesta JSON indicando que el computador está disponible
        return response()->json([
            'status' => 'disponible',
            'message' => 'Computador disponible para reportes'
        ]);
    }
}
