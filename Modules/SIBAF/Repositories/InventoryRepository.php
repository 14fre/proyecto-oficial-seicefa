<?php

namespace Modules\SIBAF\Repositories;

use Modules\SIBAF\Entities\SIBAFInventory;
use Modules\SIBAF\Entities\Environment;
use Modules\GPES\Entities\Computer;
use Modules\SICA\Entities\Element;
use Modules\SICA\Entities\Category;
use Modules\SICA\Entities\Environment as SICAEnvironment;
use Modules\SICA\Entities\ClassEnvironment;
use Modules\SICA\Entities\ProductiveUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class InventoryRepository
{
    public function getFiltered(array $filters)
    {
        // Debug: Verificar si hay elementos con categoría Computers
        $totalElements = Element::whereHas('category', function ($query) {
            $query->where('name', 'Computers');
        })->count();
        
        \Log::info("Total elementos con categoría Computers: " . $totalElements);
        
        // Debug: Verificar si hay computadores
        $totalComputers = Computer::count();
        \Log::info("Total computadores en tabla computers: " . $totalComputers);
        
        // Usar la misma lógica que GPES: consultar Element con relación Computers
        $query = Element::with(['category', 'measurement_unit', 'computers', 'inventories.productive_unit_warehouse.warehouse'])
            ->whereHas('category', function ($query) {
                $query->where('name', 'Computers');
            });

        // Aplicar filtros
        if (isset($filters['category_id'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('id', $filters['category_id']);
            });
        }

        if (isset($filters['element_name'])) {
            $query->where('name', 'like', '%' . $filters['element_name'] . '%');
        }

        // Filtro específico para "Equipos de Cómputo"
        if (isset($filters['is_computer_equipment']) && $filters['is_computer_equipment']) {
            $query->whereHas('category', function ($q) {
                $q->where('name', 'Computers');
            });
        }

        if (isset($filters['productive_unit_id'])) {
            $query->whereHas('inventories.productive_unit_warehouse.productive_unit', function ($q) use ($filters) {
                $q->where('id', $filters['productive_unit_id']);
            });
        }

        $result = $query->orderBy('name', 'ASC')->paginate(15);
        
        // Debug: Verificar resultado
        \Log::info("Resultado de la consulta: " . $result->total() . " registros encontrados");
        
        return $result;
    }
}