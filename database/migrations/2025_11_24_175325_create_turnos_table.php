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
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // C01, A01...
            $table->string('nombre');
            $table->string('dni');
            $table->enum('tipo', ['caja','asesoria'])->default('caja');
            $table->string('corresponde')->nullable(); // "Caja 01", "Box 02"
            $table->enum('estado', ['pendiente','en_curso','finalizado'])->default('pendiente');
            $table->string('email')->nullable();
            $table->unsignedBigInteger('operador_id')->nullable();
            $table->timestamp('llamado_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};
