
<?php
// 2025_05_20_181358_create_users_table.php

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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');                     // BIGSERIAL para PostgreSQL
            $table->string('name');                          // Nombre del usuario
            $table->string('email')->unique();               // Email único
            $table->string('phone');                         // Teléfono
            $table->string('occupation')->nullable();        // Ocupación (opcional)
            $table->integer('age');                          // Edad
            $table->timestamp('email_verified_at')->nullable(); // Para verificación de email
            $table->string('password');                      // Contraseña
            $table->rememberToken();                         // Token para "recordarme"
            $table->timestamps();                            // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};