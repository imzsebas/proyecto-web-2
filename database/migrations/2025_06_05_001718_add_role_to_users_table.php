<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('user'); // 'user' será el valor por defecto
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
};
//User::create(['name' => 'Usuario1','email' => 'admin.u@gmail.com','password' => bcrypt('12345678'),'role' => 'paciente','phone' => '3128971230','occupation' => 'Estudiante','age' => 20]);