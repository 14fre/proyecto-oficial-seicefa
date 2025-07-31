<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('answer')->nullable();
            $table->enum('status_reports',["pending","in_progress","resolved",])->default('pending'); // pending, in_progress, resolved
            $table->foreignId('computer_id')->constrained('computers')->onDelete('cascade'); // computador involucrado
            $table->foreignId('involved_id')->constrained('users')->onDelete('cascade'); // la persona que hizo el reporte
            $table->foreignId('accused_id')->nullable()->constrained('users')->onDelete('cascade'); // ✅ Correcto
            $table->foreignId('responsible_allocation_id')->nullable()->constrained('computer_user_assignments')->onDelete('cascade'); // ✅ Correcto

            $table->dateTime('reported_at')->nullable();
            $table->dateTime('resolved_at')->nullable();
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
        Schema::dropIfExists('reports');
    }
}
