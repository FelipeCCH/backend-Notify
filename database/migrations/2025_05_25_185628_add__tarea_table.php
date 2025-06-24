<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tarea', function(Blueprint $table) {
            $table->id('id_tarea');
            $table->unsignedBigInteger('id_usuario');
            $table->string('titulo', 100);
            $table->text('descripcion')->nullable();
            $table->string('categoria', 100)->nullable();
            $table->date('fecha_limite')->nullable();
            $table->time('hora_limite')->nullable();
            $table->boolean('completada')->default(false);
            $table->dateTime('fecha_creacion')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('id_usuario')
                  ->references('id_usuario')->on('usuario')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea');
    }
};
