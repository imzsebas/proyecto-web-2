<?php
// 2025_06_04_235854_create_messages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');                     // BIGSERIAL para PostgreSQL
            $table->unsignedBigInteger('conversation_id');   // Cambio a unsignedBigInteger
            $table->unsignedBigInteger('user_id');           // Cambio a unsignedBigInteger
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Índices para mejorar rendimiento
            $table->index(['conversation_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('is_read');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};