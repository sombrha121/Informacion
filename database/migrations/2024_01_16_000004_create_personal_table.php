<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('dni')->unique();
            $table->enum('tipo', ['Doctor', 'Enfermero', 'Administrativo', 'Laboratorio']);
            $table->string('especialidad')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->unique();
            $table->date('fecha_contratacion');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal');
    }
};
