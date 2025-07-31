<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComputersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // este name se creo con tal de no usar el name de elements ya que ese es unico y se puede colocar el mimos nombre a 2 computadores distintos
            $table->foreignId('element_id')->unique()->constrained('elements')->onDelete('cascade');
            $table->string('serial_number')->unique()->nullable();
            $table->string('model')->nullable();
            $table->string('brand')->nullable();
            $table->string('processor')->nullable();
            $table->string('ram')->nullable();
            $table->string('operating_system')->nullable();
            $table->enum('status_assignment_formation', ['disponible', 'asignado'])->default('disponible'); // esta columna es para indicar si el computador esta siendo ocupado en el dia
            $table->enum('status_assignment_day',["disponible","asignado"])->default('disponible'); // ocupado a largo plazo
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
        Schema::dropIfExists('computers');
    }
}
