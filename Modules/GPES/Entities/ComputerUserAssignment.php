<?php

namespace Modules\GPES\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComputerUserAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'computer_id',
        'user_id',
        'type',
        'assigned_at',
        'returned_at',
        'observation',
        'returned',
        'late',
        'location',
    ];

    protected $dates = ['assigned_at', 'returned_at'];

    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
