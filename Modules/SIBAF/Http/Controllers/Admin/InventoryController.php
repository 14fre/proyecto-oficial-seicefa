<?php

namespace Modules\SIBAF\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SIBAF\Services\InventoryService;
use Modules\SICA\Entities\Warehouse as SICAWarehouse;

class InventoryController extends Controller
{
    // Propiedad para almacenar la instancia del servicio InventoryService
    protected $inventoryService;

    // Constructor que inyecta el servicio InventoryService mediante inyección de dependencias
    public function __construct(InventoryService $inventoryService)
    {
        // Asigna el servicio a la propiedad para usarlo en los métodos
        $this->inventoryService = $inventoryService;
    }

    /**
     * Vista principal de inventarios
     */
    // Método para mostrar la vista principal de inventarios con filtros
    public function index(Request $request)
    {
        // Obtiene el número de serie desde los parámetros de la petición (si existe)
        $serialNumber = $request->input('serial_number');
        // Obtiene el ID del almacén desde los parámetros de la petición (si existe)
        $warehouseId = $request->input('warehouse_id');

        // Llama al método del servicio para obtener inventarios filtrados por número de serie y almacén
        $inventories = $this->inventoryService->getFilteredInventories(
            $serialNumber,
            $warehouseId
        );

        // Obtiene todos los almacenes desde el modelo SICAWarehouse
        $warehouses = SICAWarehouse::all();

        // Devuelve la vista 'inventories' con los datos compactados para su renderizado
        return view('sibaf::inventories', compact(
            'inventories',
            'warehouses',
            'serialNumber',
            'warehouseId'
        ));
    }

    /**
     * Nueva vista para el seguimiento de equipos
     */
    // Método para mostrar la vista de seguimiento de equipos con filtros
    public function equipmentTracking(Request $request)
    {
        // Obtiene el número de serie desde los parámetros de la petición (si existe)
        $serialNumber = $request->input('serial_number');
        // Obtiene el ID del almacén desde los parámetros de la petición (si existe)
        $warehouseId = $request->input('warehouse_id');

        // Llama al método del servicio para obtener equipos rastreados por número de serie y almacén
        $equipos = $this->inventoryService->getTrackedEquipments(
            $serialNumber,
            $warehouseId
        );

        // Obtiene todos los almacenes desde el modelo SICAWarehouse
        $warehouses = SICAWarehouse::all();

        // Obtiene la razón de aprobación desde la sesión, si existe
        $approvalReason = $request->session()->get('approval_reason');
        // Obtiene la razón de rechazo desde la sesión, si existe
        $rejectionReason = $request->session()->get('rejection_reason');

        // Devuelve la vista 'equipment_tracking' con los datos compactados para su renderizado
        return view('sibaf::equipment_tracking', compact(
            'equipos',
            'warehouses',
            'serialNumber',
            'warehouseId',
            'approvalReason',
            'rejectionReason'
        ));
    }
}