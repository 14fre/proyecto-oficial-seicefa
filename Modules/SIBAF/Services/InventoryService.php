<?php

namespace Modules\SIBAF\Services;

use Modules\SIBAF\Entities\SIBAFInventory;

class InventoryService
{
    public function getFilteredInventories($serialNumber = null, $warehouseId = null)
    {
        $query = SIBAFInventory::query();

        $query->with([
            'element', 
            'productive_unit_warehouse.warehouse',
            'computer'
        ]);

        $query->whereHas('computer');

        if ($serialNumber) {
            $query->whereHas('computer', function ($q) use ($serialNumber) {
                $q->where('serial_number', 'like', "%{$serialNumber}%");
            });
        }

        if ($warehouseId) {
            $query->whereHas('productive_unit_warehouse.warehouse', function ($q) use ($warehouseId) {
                $q->where('id', $warehouseId);
            });
        }

        return $query->paginate(10);
    }

    public function getTrackedEquipments($serialNumber = null, $warehouseId = null)
    {
        $query = SIBAFInventory::query();

        $query->with([
            'element', 
            'productive_unit_warehouse.warehouse',
            'computer'
        ]);

        $query->whereHas('computer', function ($q) {
            $q->whereIn('status_assignment_formation', ['Arreglado', 'Rechazado', 'Disponible', 'Solicitado', 'En arreglo']);
        });

        if ($serialNumber) {
            $query->whereHas('computer', function ($q) use ($serialNumber) {
                $q->where('serial_number', 'like', "%{$serialNumber}%");
            });
        }

        if ($warehouseId) {
            $query->whereHas('productive_unit_warehouse.warehouse', function ($q) use ($warehouseId) {
                $q->where('id', $warehouseId);
            });
        }

        return $query->paginate(10);
    }
}