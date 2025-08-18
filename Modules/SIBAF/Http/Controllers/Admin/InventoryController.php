<?php

namespace Modules\SIBAF\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SIBAF\Services\InventoryService;
use Modules\SICA\Entities\Warehouse as SICAWarehouse;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Vista principal de inventarios
     */
    public function index(Request $request)
    {
        $serialNumber = $request->input('serial_number');
        $warehouseId = $request->input('warehouse_id');

        $inventories = $this->inventoryService->getFilteredInventories(
            $serialNumber,
            $warehouseId
        );

        $warehouses = SICAWarehouse::all();

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
    public function equipmentTracking(Request $request)
    {
        $serialNumber = $request->input('serial_number');
        $warehouseId = $request->input('warehouse_id');

        $equipos = $this->inventoryService->getTrackedEquipments(
            $serialNumber,
            $warehouseId
        );

        $warehouses = SICAWarehouse::all();

        // Obtener las razones desde la sesión si existen
        $approvalReason = $request->session()->get('approval_reason');
        $rejectionReason = $request->session()->get('rejection_reason');

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