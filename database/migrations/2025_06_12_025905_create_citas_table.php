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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->string('paciente');
            $table->date('fecha');
            $table->time('hora');
            $table->string('psicologo');
            $table->integer('duracion')->default(45); // duración en minutos
            $table->enum('estado', ['programada', 'confirmada', 'completada', 'cancelada'])->default('programada');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};