<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notificacion', function (Blueprint $table) {
            $table->id('id_notificacion');
            $table->unsignedBigInteger('id_tarea')->unique();
            $table->string('correo_destino', 100)->nullable();
            $table->integer('horas_anticipacion')->default(24);
            $table->boolean('enviada')->default(false);
            $table->dateTime('fecha_envio')->nullable();

            $table->foreign('id_tarea')
                  ->references('id_tarea')->on('tarea')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacion');
    }
};
