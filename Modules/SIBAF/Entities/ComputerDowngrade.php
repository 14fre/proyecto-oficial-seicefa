<?php

namespace Modules\SIBAF\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComputerDowngrade extends Model
{
    use HasFactory;

    protected $table = 'computer_downgrades';

    protected $fillable = [
        'inventory_id',
        'user_id',
        'movement_id',
        'excel1_path',
        'excel2_path',
        'estado',
        'observaciones',
        'fecha_aprobacion',
    ];

    public function inventory()
    {
        return $this->belongsTo(SIBAFInventory::class, 'inventory_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function movement()
    {
        return $this->belongsTo(\Modules\SICA\Entities\Movement::class, 'movement_id');
    }
} 