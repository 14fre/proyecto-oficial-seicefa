<?php

namespace Modules\GPES\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ["responsible_allocation_id", "user_id", "statusNotification"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function responsible_allocation()
    {
        return $this->belongsTo(ComputerUserAssignment::class, 'responsible_allocation_id'); // Verifica este nombre también
    }
}
