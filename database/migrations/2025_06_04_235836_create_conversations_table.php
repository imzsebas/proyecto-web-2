<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // El paciente
            $table->foreignId('psychologist_id')->constrained('users')->onDelete('cascade'); // El psicólogo
            $table->string('status')->default('active'); // active, closed, etc.
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
            
            // Índices para mejorar rendimiento
            $table->index(['user_id', 'psychologist_id']);
            $table->index('last_message_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversations');
    }
};