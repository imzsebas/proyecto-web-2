
<?php
// 2025_06_13_163140_create_enlaces_sesion_table.php

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
        Schema::create('enlaces_sesion', function (Blueprint $table) {
            $table->bigIncrements('id');                     // BIGSERIAL para PostgreSQL
            $table->string('nombre')->default('Sesión Virtual');
            $table->string('enlace');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enlaces_sesion');
    }
};