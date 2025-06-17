<?php
// 2025_06_12_025905_create_citas_table.php

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
        Schema::create('citas', function (Blueprint $table) {
            $table->bigIncrements('id');                     // BIGSERIAL para PostgreSQL
            $table->string('paciente');
            $table->date('fecha');
            $table->time('hora');
            $table->string('psicologo');
            $table->integer('duracion')->default(45);       // duración en minutos
            $table->string('estado')->default('programada'); // Cambio de enum a string con check constraint
            $table->text('notas')->nullable();
            $table->timestamps();
            
            // Check constraint para PostgreSQL en lugar de enum
            $table->index('estado');
        });
        
        // Agregar constraint para el estado después de crear la tabla
        DB::statement("ALTER TABLE citas ADD CONSTRAINT citas_estado_check CHECK (estado IN ('programada', 'confirmada', 'completada', 'cancelada'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
