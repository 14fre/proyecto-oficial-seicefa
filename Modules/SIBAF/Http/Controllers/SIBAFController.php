<?php

namespace Modules\SIBAF\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SIBAFController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('sibaf::index');
        return view('sibaf::inventories');
        
    }

    public function welcome()
    {
        return view('sibaf::welcome');
    }

    public function admin()
    {
        // Obtener notificaciones no leídas del admin
        $notifications = \Modules\SIBAF\Entities\Notification::with(['user', 'responsibleAllocation'])
            ->where('statusNotification', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Obtener reportes de daño pendientes
        $pendingReports = \Modules\SIBAF\Entities\DamageReport::with(['inventory.element', 'user.person'])
            ->where('state', 'Solicitado')
            ->get();
            
        // Obtener bajas aprobadas recientes
        $recentDowngrades = \Modules\SIBAF\Entities\ComputerDowngrade::with(['inventory.element', 'user.person'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        // Contadores
        $totalPendingReports = \Modules\SIBAF\Entities\DamageReport::where('state', 'Solicitado')->count();
        $totalApprovedDowngrades = \Modules\SIBAF\Entities\ComputerDowngrade::count();
        $totalReports = \Modules\SIBAF\Entities\DamageReport::count();
        $notificationsCount = \Modules\SIBAF\Entities\Notification::where('statusNotification', 'pending')->count();
        
        return view('sibaf::welcome', compact(
            'notifications',
            'pendingReports',
            'recentDowngrades',
            'totalPendingReports',
            'totalApprovedDowngrades',
            'totalReports',
            'notificationsCount'
        ));
    }
    public function soporte()
    {
        return view('sibaf::welcomesoporte');
    }

    public function supportPanel()
    {
        $damageReports = \Modules\SIBAF\Entities\DamageReport::with(['inventory', 'user', 'movement'])
            ->whereHas('movement', function($q) {
                $q->where('state', 'Solicitado');
            })
            ->get();
        return view('sibaf::welcomesoporte', compact('damageReports'));
    }

    public function instructor()
    {
        return view('sibaf::masterinstructor');
        return view('sibaf::inventoriesINS');
    }
    

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sibaf::create');
    }

    

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sibaf::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sibaf::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
    
    public function downloadExcel($downgradeId, $fileType)
    {
        $downgrade = \Modules\SIBAF\Entities\ComputerDowngrade::findOrFail($downgradeId);
        
        $filePath = null;
        $fileName = null;
        
        if ($fileType === 'excel1') {
            $filePath = $downgrade->excel1_path;
            $fileName = 'excel1_baja_' . $downgrade->id . '.xlsx';
        } elseif ($fileType === 'excel2') {
            $filePath = $downgrade->excel2_path;
            $fileName = 'excel2_baja_' . $downgrade->id . '.xlsx';
        }
        
        if (!$filePath || !\Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'Archivo no encontrado');
        }
        
        return \Illuminate\Support\Facades\Storage::disk('public')->download($filePath, $fileName);
    }
    
    public function downgrades()
    {
        $downgrades = \Modules\SIBAF\Entities\ComputerDowngrade::with(['inventory.element', 'user.person'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('sibaf::downgrades', compact('downgrades'));
    }
}
