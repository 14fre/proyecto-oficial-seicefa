<?php

namespace Modules\GPES\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//   $table->id();
//             $table->string('title');
//             $table->text('description')->nullable();
//             $table->text('answer')->nullable();
//             $table->enum('status_reports',["pending","in_progress","resolved",])->default('pending'); // pending, in_progress, resolved
//             $table->foreignId('computer_id')->constrained('computers')->onDelete('cascade'); // computador involucrado
//             $table->foreignId('involved_id')->constrained('users')->onDelete('cascade'); // la persona que hizo el reporte
//             $table->foreignId("accused")->constrained('users')->onDelete('cascade')->nullable(); // la persona acusada, puede ser null si no hay acusados
//             $table->foreignId("responsible_allocation")->constrained('computer_user_assignments')->onDelete('cascade')->nullable(); // la persona responsable del computador, puede ser null si no hay responsable
//             $table->dateTime('reported_at')->nullable();
//             $table->dateTime('resolved_at')->nullable();
//             $table->timestamps();
class report extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'answer',
        'status_reports', // pending, in_progress, resolved
        'computer_id',
        'involved_id',
        'accused_id',
        'responsible_allocation_id', // la persona responsable del computador, puede ser null si no hay responsable
        'reported_at',
        'resolved_at'
    ];

public function computer()
{
    return $this->belongsTo(Computer::class, 'computer_id');
}

public function involved()
{
    return $this->belongsTo(User::class, 'involved_id');
}

public function accused()
{
    return $this->belongsTo(User::class, 'accused_id'); // Usa el nombre correcto de la clave
}

public function responsible_allocation()
{
    return $this->belongsTo(ComputerUserAssignment::class, 'responsible_allocation_id'); // Verifica este nombre también
}


 
    
}
