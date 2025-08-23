<?php

namespace Modules\SIBAF\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ManualController extends Controller
{
    /**
     * Descargar el manual de usuario
     */
    public function download(Request $request, $role = 'general')
    {
        // Ruta del archivo PDF del manual
        $filePath = "manuals/sibaf-manual-general.pdf";

        // Verificar si existe el archivo
        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'Manual no encontrado. Contacte al administrador.');
        }

        // Obtener la ruta completa del archivo
        $fullPath = Storage::disk('public')->path($filePath);
        
        // Nombre del archivo para la descarga
        $fileName = "Manual_SIBAF_" . date('Y-m-d') . ".pdf";

        // Verificar que el archivo existe físicamente
        if (!file_exists($fullPath)) {
            return redirect()->back()->with('error', 'Archivo no encontrado en el servidor.');
        }

        // Forzar la descarga con headers apropiados
        return response()->download($fullPath, $fileName, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }
}
