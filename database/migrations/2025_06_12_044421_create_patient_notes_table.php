<?php
// 2025_06_12_044421_create_patient_notes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patient_notes', function (Blueprint $table) {
            $table->bigIncrements('id');                     // BIGSERIAL para PostgreSQL
            $table->unsignedBigInteger('patient_id');        // Cambio a unsignedBigInteger
            $table->unsignedBigInteger('created_by');        // Cambio a unsignedBigInteger
            $table->text('content');
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_notes');
    }
};
