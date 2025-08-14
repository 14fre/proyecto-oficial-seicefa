<?php

namespace Modules\SIBAF\Entities;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    
    // ASEGÚRATE DE QUE 'data' ESTÁ EN ESTA LISTA
    protected $fillable = [
        'responsible_allocation_id', 
        'user_id', 
        'statusNotification', 
        'notifiable_type', 
        'notifiable_id', 
        'data'
    ];

    // ASEGÚRATE DE QUE 'data' ESTÁ EN ESTA LISTA DE CASTS
    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function responsibleAllocation()
    {
        return $this->belongsTo(\Modules\SIBAF\Entities\ComputerDowngrade::class, 'responsible_allocation_id');
    }

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function scopeUnread($query)
    {
        return $query->where('statusNotification', 'pending');
    }

    public function scopeRead($query)
    {
        return $query->where('statusNotification', 'seen');
    }

    public function markAsRead()
    {
        $this->update(['statusNotification' => 'seen']);
    }

    public function markAsUnread()
    {
        $this->update(['statusNotification' => 'pending']);
    }

    public function read()
    {
        return $this->statusNotification === 'seen';
    }

    public function unread()
    {
        return $this->statusNotification === 'pending';
    }
}