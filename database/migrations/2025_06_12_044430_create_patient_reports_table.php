<?php

// database/migrations/xxxx_xx_xx_create_patient_reports_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patient_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('type')->default('general'); // general, diagnostico, seguimiento, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_reports');
    }
};
