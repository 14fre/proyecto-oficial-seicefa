<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComputerUserAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computer_user_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('computer_id')->constrained('computers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['diario', 'formacion']); // tipo de asignación
            $table->dateTime('assigned_at');     // fecha de asignación
            $table->dateTime('returned_at')->nullable(); // si se devolvió
            $table->text('observation')->nullable(); // notas
            $table->string('location'); // notas del usuario que recibe el computador
            $table->boolean("returned")->default(false); // indica si el computador ha sido devuelto
            $table->boolean("late")->default(false); // indica si la devolución fue tardía
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('computer_user_assignments');
    }
}
