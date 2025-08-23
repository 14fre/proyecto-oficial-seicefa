<?php

namespace Modules\SIBAF\Http\Controllers\Instructor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SIBAF\Services\InventoryService;
use Modules\SICA\Entities\Warehouse as SICAWarehouse;

class InstructorInventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        $serialNumber = $request->input('serial_number');
        $warehouseId = $request->input('warehouse_id');

        $inventories = $this->inventoryService->getFilteredInventories(
            $serialNumber,
            $warehouseId
        );

        $warehouses = SICAWarehouse::all();

        return view('sibaf::admin.inventories', compact(
            'inventories',
            'warehouses',
            'serialNumber',
            'warehouseId'
        ));
    }
}