<?php

namespace Modules\SIBAF\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DamageReport extends Model
{
    use HasFactory;

    protected $table = 'damage_reports';

    protected $fillable = [
        'inventory_id',
        'user_id',
        'description',
        'state',
        'movement_id',
        'photo_path',
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

    public function damageReports()
{
    return $this->hasMany(DamageReport::class, 'inventory_id');
}

    
} 