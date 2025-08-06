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
        Schema::create('alumnos', function (Blueprint $table) {
             $table->string('id',15)->primary();
            $table->unsignedBigInteger('user_id')->nullable(); // Relación con users
            $table->string('nombreAlumno',50);
            $table->string('apellidoPaterno',50);
            $table->string('apellidoMaterno',50)->nullable();
            $table->string('sexo',1);
            $table->string('idCarrera',15);
            $table->foreign('idCarrera')->references('id')->on('carreras');
            
    $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
