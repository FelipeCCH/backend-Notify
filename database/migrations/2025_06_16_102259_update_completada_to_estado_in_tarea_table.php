<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tarea', function (Blueprint $table) {
            $table->dropColumn('completada');
            $table->enum('estado', ['Pendiente', 'Completado', 'Vencido'])->default('Pendiente');
        });
    }


    public function down()
    {
        Schema::table('tarea', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->boolean('completada')->default(false);
        });
    }

};
