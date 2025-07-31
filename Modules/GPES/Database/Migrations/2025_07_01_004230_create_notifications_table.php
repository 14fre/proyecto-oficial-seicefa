<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $table->foreignId('computer_id')->constrained('computers')->onDelete('cascade');
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsible_allocation_id')->nullable()->constrained('computer_user_assignments')->onDelete('cascade'); // 
            // Usuario al que va dirigida la notificación
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->enum("statusNotification", ["seen", "pending"])->default("pending");
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
        Schema::dropIfExists('notifications');
    }
}
