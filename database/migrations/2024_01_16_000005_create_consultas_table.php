<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('personal')->onDelete('cascade');
            $table->dateTime('fecha_hora');
            $table->text('motivo');
            $table->text('diagnostico')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['Pendiente', 'En Proceso', 'Concluida', 'Cancelada'])->default('Pendiente');
            $table->decimal('costo', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
