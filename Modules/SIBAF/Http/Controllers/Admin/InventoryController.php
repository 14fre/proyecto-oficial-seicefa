<?php

namespace Modules\SIBAF\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SIBAF\Services\InventoryService;
use Modules\SICA\Entities\ProductiveUnit;
use Modules\SICA\Entities\Warehouse as SICAWarehouse;

class InventoryController extends Controller
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

        return view('sibaf::inventories', compact(
            'inventories',
            'warehouses',
            'serialNumber',
            'warehouseId'
        ));
    }
}
