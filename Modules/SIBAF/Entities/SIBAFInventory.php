<?php
// File: Modules/SIBAF/Entities/SIBAFInventory.php

namespace Modules\SIBAF\Entities;

use Modules\SICA\Entities\Inventory as BaseInventory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\SICA\Entities\Element;
use Modules\SICA\Entities\ProductiveUnitWarehouse;
use Modules\SICA\Entities\Person;

class SIBAFInventory extends BaseInventory
{
    use SoftDeletes;

    protected $table = 'inventories';

    protected $fillable = [
        'person_id',
        'element_id',
        'productive_unit_warehouse_id',
        'environment_id',
        'amount',
        'stock',
        'state'
    ];

    // Relaciones
    public function element()
    {
        return $this->belongsTo(Element::class, 'element_id');
    }

    public function productive_unit_warehouse()
    {
        return $this->belongsTo(ProductiveUnitWarehouse::class, 'productive_unit_warehouse_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function computer()
    {
        return $this->hasOne(\Modules\GPES\Entities\Computer::class, 'element_id', 'element_id');
    }

    public function damageReports()
    {
        return $this->hasMany(\Modules\SIBAF\Entities\DamageReport::class, 'inventory_id');
    }

    /**
     * Filtro personalizado: solo computadores
     */
    public function scopeOnlyComputers($query)
    {
        return $query->whereHas('element', function ($q) {
            $q->where('name', 'like', '%computador%');
        });
    }

    /**
     * Filtro por bodega (si se selecciona una)
     */
    public function scopeFilterByWarehouse($query, $warehouse_id)
    {
        if (!empty($warehouse_id)) {
            return $query->where('productive_unit_warehouse_id', $warehouse_id);
        }
        return $query;
    }

    /**
     * Array simplificado para mostrar en SIBAF
     */
    public function toSIBAFArray()
    {
        return [
            'id' => $this->id,
            'element_name' => optional($this->element)->name ?? 'N/A',
            'category' => optional($this->element->category)->name ?? 'N/A',
            'responsible' => optional($this->person)->fullName ?? 'N/A',
            'warehouse' => optional($this->productive_unit_warehouse)->name ?? 'N/A',
            'amount' => $this->amount,
            'state' => $this->state,
        ];
    }
}