<?php

namespace Modules\GPES\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SICA\Entities\Element;

class Computer extends Model
{
    use HasFactory;

    protected $table = 'computers';
    protected $fillable = [
        'name',
        'element_id',
        'serial_number',
        'model',
        'brand',
        'processor',
        'ram',
        'storage',
        'operating_system',
        'status_assignment_formation',
        'status_assignment_day',
    ];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }


    public function assignments()
{
    return $this->hasMany(ComputerUserAssignment::class);
}

public function currentUser()
{
    return $this->hasOne(ComputerUserAssignment::class)->whereNull('returned_at');
}


    public function reports()
    {
        return $this->hasMany(Report::class, 'computer_id');
    }


   
}
