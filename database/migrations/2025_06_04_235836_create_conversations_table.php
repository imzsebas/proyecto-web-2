<?php
// 2025_06_04_235836_create_conversations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->bigIncrements('id');                     // BIGSERIAL para PostgreSQL
            $table->unsignedBigInteger('user_id');           // Cambio a unsignedBigInteger
            $table->unsignedBigInteger('psychologist_id');   // Cambio a unsignedBigInteger
            $table->string('status')->default('active');    // active, closed, etc.
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('psychologist_id')->references('id')->on('users')->onDelete('cascade');
            
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